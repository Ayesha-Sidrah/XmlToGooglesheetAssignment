<?php

namespace App\FileReader;

use App\FileReader\Exceptions\FileOpenFailedException;
use App\FileReader\Exceptions\InvalidFileReaderException;
use App\Interfaces\ReaderInterface;
use Exception;

class FileReader implements ReaderInterface
{
    public const LOCAL = 'local';
    public const REMOTE = 'remote';

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var string
     */
    private $ftpPrefix;

    public function __construct(string $projectDir, string $ftpPrefix)
    {
        $this->projectDir = $projectDir;
        $this->ftpPrefix = $ftpPrefix;
    }

    public function getReader(string $source, string $filename): string
    {
        switch ($source) {
            case self::LOCAL:
                $filePath = $this->projectDir . $filename;
                break;
            case self::REMOTE:
                $filePath = $this->ftpPrefix . $filename;
                break;

            default:
                throw new Exception('FileReader type not valid');
        }
        $fileData = "";
        foreach ($this->getData($filePath) as $line)
        {
            $fileData .= $line;
        }
        return $fileData;
    }


    private function getData($filePath)
    {
        $file  = @fopen($filePath, 'r');
        if (!$file) {
            throw new FileOpenFailedException('File open failed');
        }
        while (!feof($file)) {
            yield trim(fgets($file), "\r\n");
        }
        fclose($file);
    }

}