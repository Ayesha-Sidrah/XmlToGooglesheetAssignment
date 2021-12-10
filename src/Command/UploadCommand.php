<?php

declare(strict_types=1);

namespace App\Command;

use App\Interfaces\ExporterInterface;
use App\Interfaces\ReaderInterface;
use App\GoogleClient\GoogleClient;
use App\Transformer\ExportTransformer;
use Google_Service_Sheets;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UploadCommand extends Command
{
    protected static $defaultName = 'app:upload-command';

    /**
     * @var ExportTransformer
     */
    private $exportTransformer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ExporterInterface
     */
    private $xmlExporter;

    /**
     * @var ReaderInterface
     */
    private $reader;

    public const SPREADSHEET_URL = 'https://docs.google.com/spreadsheets/d/';

    public function __construct(
        GoogleClient $googleClient,
        ExportTransformer $exportTransformer,
        LoggerInterface $logger,
        ReaderInterface $reader,
        ExporterInterface $xmlExporter
    )
    {
        parent::__construct();
        $this->googleClient = $googleClient;
        $this->exportTransformer = $exportTransformer;
        $this->logger = $logger;
        $this->reader = $reader;
        $this->xmlExporter = $xmlExporter;
    }

    protected function configure()
    {
        $this->setDescription('upload records')
            ->addOption(
                'source',
                null,
                InputOption::VALUE_REQUIRED,
                'Which source do you like?',
                ['remote', 'local']

            )
            ->addArgument('filename', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument("filename");
        $source = $input->getOption("source");

        try{
            $content =$this->reader
                ->getReader($source, $filename);
        }catch (Exception $exception){
            $this->logger->error('error getting XML content', [$exception->getMessage()]);
            return Command::FAILURE;
        }


        try {
            $mappedXml = $this->exportTransformer->transform($content);
        } catch(Exception $exception) {
            $this->logger->error('error transforming content', [$exception->getMessage()]);
            return Command::FAILURE;
        }

        try{
            $spreadsheetId = $this->xmlExporter->exportSheet($mappedXml);
            $spreadsheetLink = self::SPREADSHEET_URL.$spreadsheetId;
            return Command::SUCCESS;
        } catch(Exception $exception){
            $this->logger->error('Error pushing data', [$exception->getMessage()]);
            return Command::FAILURE;
        }
    }

}