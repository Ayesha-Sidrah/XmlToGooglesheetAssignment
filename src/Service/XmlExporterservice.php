<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\ExporterInterface;
use App\Interfaces\XmlExporterInterface;
use App\Service\FileReader\FileReader;
use App\Transformer\XmlTransformer;

class XmlExporterservice implements XmlExporterInterface
{
    private XmlTransformer $xmlTransformer;
    private FileReader $fileReader;
    private ExporterInterface $dataExporter;

    public function __construct(
        XmlTransformer $xmlTransformer,
        FileReader $fileReader,
        ExporterInterface $dataExporter
    ) {
        $this->xmlTransformer = $xmlTransformer;
        $this->fileReader = $fileReader;
        $this->dataExporter = $dataExporter;
    }

    public function export(string $source, string $filename): bool
    {
        $content = $this->fileReader
            ->readXml($source, $filename);
        $spreadsheetId = $this->dataExporter->create();
        $transformedData = $this->xmlTransformer->transform($content);
        $exportBatchData = [];

        foreach ($transformedData as $data) {
            $exportBatchData[] = $data;
            if (count($exportBatchData) === 100) {
                $this->dataExporter->updateValues( $spreadsheetId, $exportBatchData);
                $exportBatchData = [];
            }
        }
        if (!empty($exportBatchData)) {
            $this->dataExporter->updateValues($spreadsheetId, $exportBatchData);
        }
        return true;
    }
}
