<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\XmlExporterservice;
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

    private LoggerInterface $logger;

    private XmlExporterservice $xmlExporterservice;


    public function __construct(
        LoggerInterface $logger,
        XmlExporterservice $xmlExporterservice
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->xmlExporterservice = $xmlExporterservice;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $filename = $input->getArgument("filename");
            $source = $input->getOption("source");

            $this->xmlExporterservice->export($source, $filename);
        } catch (Exception $exception) {
            $this->logger->error('error getting XML content', [$exception->getMessage()]);
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
