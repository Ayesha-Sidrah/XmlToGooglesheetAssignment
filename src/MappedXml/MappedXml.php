<?php

namespace App\MappedXml;

class MappedXml
{
    /**
     * @var array
     */
    private $dataExport;

    public function __construct(array $dataExport ){
        $this->dataExport = $dataExport;
    }

    /**
     * @return array
     */
    public function getExportData(): array{
        return $this->dataExport;
    }

}