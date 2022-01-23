<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ExporterInterface
{
    public function updateValues(string $spreadsheetId, array $values): void;

    public function create(): string;
}
