<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Exceptions\FileNotFoundException;

class FilePathProvider
{
    public const LOCAL = 'local';
    public const REMOTE = 'remote';

    private string $projectDir;
    private string $ftpPrefix;

    public function __construct(string $projectDir, string $ftpPrefix)
    {
        $this->projectDir = $projectDir;
        $this->ftpPrefix = $ftpPrefix;
    }

    public function getFilepath(string $source, string $filename): string
    {
        if ($source == self::LOCAL) {
            $filePath = $this->projectDir . $filename;
        } elseif ($source == self::REMOTE) {
            $filePath = $this->ftpPrefix . $filename;
        }

        if (false == file_exists($filePath)) {
            throw new FileNotFoundException("File does not exist in path: " . $filePath);
        }
        return $filePath;
    }
}
