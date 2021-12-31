<?php

declare(strict_types=1);

namespace App\Interfaces;

use Generator;

interface ReaderInterface
{
    public function readXml(string $source, string $filename): Generator;
}
