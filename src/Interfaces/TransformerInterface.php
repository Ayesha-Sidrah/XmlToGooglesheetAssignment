<?php

declare(strict_types=1);

namespace App\Interfaces;

use Generator;

interface TransformerInterface
{
    public function transform(Generator $content): Generator;
}
