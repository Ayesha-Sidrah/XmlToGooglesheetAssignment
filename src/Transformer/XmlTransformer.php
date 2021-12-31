<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Interfaces\TransformerInterface;
use Generator;

class XmlTransformer implements TransformerInterface
{
    public function transform($content): Generator
    {
        foreach ($content as $key => $data) {
            if ($key === 0) {
                yield array_keys($content->current());
            }
            yield array_values($content->current());
        }
    }
}
