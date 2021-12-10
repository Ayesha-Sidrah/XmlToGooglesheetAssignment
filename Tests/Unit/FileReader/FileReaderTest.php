<?php

namespace App\Tests\Unit\FileReader;

use App\FileReader\Exceptions\FileOpenFailedException;
use App\FileReader\Exceptions\InvalidFileReaderException;
use App\Tests\DataProvider\DataProvider;
use App\FileReader\FileReader;
use Monolog\Test\TestCase;

class FileReaderTest extends TestCase
{
    /**
     * @var DataProvider
     */
    private $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dataProvider = new DataProvider();
    }

    /** @test  */
    public function file_reader_test()
    {
        $this->assertTrue(true);
    }

    /** @test  */
    public function it_throws_an_exception()
    {
        $reader = new FileReader('local', 'abc.txt');
        $source = 'local';
        $filename = file_get_contents('tests/DataProvider/abc.txt');
        $this->expectException(FileOpenFailedException::class);
        $reader->getReader("local",$filename);


    }

}