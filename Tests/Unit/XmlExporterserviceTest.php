<?php

namespace App\Tests\Unit;

use App\Interfaces\ExporterInterface;
use App\Service\FileReader\FileReader;
use App\Service\XmlExporterservice;
use App\Transformer\XmlTransformer;
use PHPUnit\Framework\TestCase;

class XmlExporterserviceTest extends TestCase
{
    /** @test */
    public function provides_input_to_services(){
        $xmlTransformerMock = $this->createMock(XmlTransformer::class);
        $fileReaderMock = $this->createMock(FileReader::class);
        $dataExporterMock = $this->createMock(ExporterInterface::class);

        $xmlExporterService = new XmlExporterService(
            $xmlTransformerMock,
            $fileReaderMock,
            $dataExporterMock,
            );

        $exportData = $xmlExporterService->export('local', 'file');
        $this->assertTrue($exportData);
    }
}