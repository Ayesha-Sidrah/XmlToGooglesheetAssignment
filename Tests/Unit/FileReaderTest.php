<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\FilePathProvider;
use App\Service\FileReader\Exceptions\FileOpenFailedException;
use App\Service\FileReader\Exceptions\FileReaderException;
use App\Service\FileReader\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    private $filePathProvider;

    /** @test */
    public function testToCheckFileReaderException()
    {
        $this->filePathProvider = $this->createMock(FilePathProvider::class);
        $this->expectException(FileReaderException::class);
        $this->xmlReader = new FileReader($this->filePathProvider);

        $fileName = 'abc.txt';
        $this->xmlReader->readXml('local', $fileName);
    }
}
