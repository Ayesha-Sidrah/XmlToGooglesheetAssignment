<?php

declare(strict_types=1);

namespace App\Service\FileReader;

use App\Interfaces\ReaderInterface;
use App\Service\FilePathProvider;
use App\Service\FileReader\Exceptions\FileOpenFailedException;
use App\Service\FileReader\Exceptions\FileReaderException;
use Throwable;
use XMLReader;
use Generator;

class FileReader implements ReaderInterface
{
    private FilePathProvider $filePathProvider;

    public function __construct(FilePathProvider $filePathProvider)
    {
        $this->filePathProvider = $filePathProvider;
    }

    public function readXml(string $source, string $filename): Generator
    {
        try {
            $filePath = $this->filePathProvider->getFilepath($source, $filename);
            $xml = new XMLReader();
            $xml->open($filePath);

            $node = "item";
            $xml->read();

            while ($xml->read() && $xml->name != $node);

            while ($xml->name == $node) {
                if ($xml->nodeType == XMLREADER::ELEMENT) {
                    $xmlItem = ((array)simplexml_load_string($xml->readOuterXml(), "SimpleXMLElement", LIBXML_NOCDATA));
                    array_walk_recursive($xmlItem, function (&$item) {
                        $item = strval($item);
                    });
                    yield $xmlItem;
                    $xml->next($node);
                }
            }
        } catch (Throwable $exception) {
            throw new FileReaderException("Error reading XML file");
        }
    }
}
