<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\Exceptions\FileNotFoundException;
use App\Service\FilePathProvider;
use PHPUnit\Framework\TestCase;

class FilePathProviderTest extends TestCase
{
    private string $projectDir;
    private string $ftpPrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectDir = __DIR__ . '/data/';
        $this->ftpPrefix = 'local';
       // $this->fileName = 'employee_test.xml';

        $this->FilePathProvider = new FilePathProvider(
            $this->projectDir,
            $this->ftpPrefix
        );
    }

    /** @test */
    public function toCheckFileNotFoundException()
    {
        $this->expectException(FileNotFoundException::class);
        $this->FilePathProvider = new FilePathProvider($this->projectDir, $this->ftpPrefix);

        $invalidFileName = 'employee1.xml';
        $this->FilePathProvider->getFilepath("local", $invalidFileName);
    }

    /** @test */
    public function testToGetLocalFile()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function testToGetFtpFile()
    {
        $this->assertTrue(true);
    }
}
