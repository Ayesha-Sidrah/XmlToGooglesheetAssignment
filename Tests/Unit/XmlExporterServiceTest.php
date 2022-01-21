<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Interfaces\ExporterInterface;
use App\Service\FileReader\FileReader;
use App\Service\XmlExporterService;
use App\Transformer\XmlTransformer;
use PHPUnit\Framework\TestCase;

class XmlExporterServiceTest extends TestCase
{
    /** @test */
    public function providesInputToServices()
    {
        $xmlTransformerMock = $this->createMock(XmlTransformer::class);
        $fileReaderMock = $this->createMock(FileReader::class);
        $dataExporterMock = $this->createMock(ExporterInterface::class);

        $xmlExporterService = new XmlExporterService(
            $xmlTransformerMock,
            $fileReaderMock,
            $dataExporterMock
        );

        $exportData = $xmlExporterService->export('local', 'file');
        $this->assertTrue($exportData);
    }
}
