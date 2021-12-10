<?php

namespace App\Interfaces;

use App\MappedXml\MappedXml;

interface ExporterInterface
{
    public function exportSheet(MappedXml $mappedXml): string;
}