<?php

namespace App\Tests\Transformer;

use App\Tests\DataProvider\DataProvider;
use App\Transformer\ExportTransformer;
use PHPUnit\Framework\TestCase;


class exportTransformerTest extends TestCase
{
    /**
     * @var DataProvider
     */
    private $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dataProvider = new DataProvider();
    }

    /** @test */
    public function transforms_data_from_xml()
    {
        $transformer = new ExportTransformer();
        $content = file_get_contents( 'tests/DataProvider/coffeeDummy.xml');
        $result = $transformer->transform($content);
        $this->assertEquals($this->dataProvider->dataExport(), $result);

    }

}