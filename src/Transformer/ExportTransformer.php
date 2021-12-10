<?php

namespace App\Transformer;

use App\Interfaces\ExporterInterface;
use App\MappedXml\MappedXml;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ExportTransformer
{

    public function transform(string $content): MappedXml
    {
        $decoder = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);

        $extractedData = $decoder->decode($content,  'xml');

        $exportData =[];

        foreach ($extractedData['row'] as $key => $datum) {
            if (0 === $key) {
                $exportData[] = array_map(
                    function ($arg) {
                        return ucfirst($arg);
                    }, array_keys($datum)
                );
            }

            $exportData[] = array_map(
                function ($arg) {
                    return is_array($arg) ? '' : trim($arg);
                }, array_values($datum)
            );
        }
        return new MappedXml($exportData);
    }
}