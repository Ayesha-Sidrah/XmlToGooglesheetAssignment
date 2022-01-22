<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Tests\DataProvider\DataProvider;
use App\Transformer\XmlTransformer;
use PHPUnit\Framework\TestCase;

class XmlTransformerTest extends TestCase
{
    /** @test */
    public function itPreparesExportDataFromXmlArray()
    {
        $dataProvider = new DataProvider();
        $inputData = $dataProvider->dataToTransformer();
        $xmlDataTransformer = new XmlTransformer();

        $result = $xmlDataTransformer->transform($inputData);
        $this->assertSame(array_keys($inputData->current()), $result->current());
    }
}
