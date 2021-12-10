<?php

namespace App\Interfaces;

interface ReaderInterface
{
    public function getReader(string $source, string $filename): string;

}