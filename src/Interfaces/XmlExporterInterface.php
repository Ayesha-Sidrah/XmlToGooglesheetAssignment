<?php

declare(strict_types=1);

namespace App\Interfaces;

interface XmlExporterInterface
{
    public function export(string $source, string $filename);
}
