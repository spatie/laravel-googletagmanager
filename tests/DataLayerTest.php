<?php

namespace Spatie\GoogleTagManager\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Spatie\GoogleTagManager\DataLayer;
use Spatie\GoogleTagManager\GoogleTagManager;

#[CoversClass(DataLayer::class)]
class DataLayerTest extends TestCase
{
    private GoogleTagManager $tagManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagManager = new GoogleTagManager('', '');
    }

    #[Test]
    public function it_sets_from_key_and_value()
    {
        $dataLayer = new DataLayer();

        $dataLayer->set('key', 'value');

        self::assertEquals(['key' => 'value'], $dataLayer->toArray());
    }

    #[Test]
    public function it_sets_from_an_array()
    {
        $dataLayer = new DataLayer();

        $dataLayer->set(['key' => 'value']);

        self::assertEquals(['key' => 'value'], $dataLayer->toArray());
    }

    #[Test]
    public function it_clears()
    {
        $dataLayer = new DataLayer(['key' => 'value']);

        $dataLayer->clear();

        self::assertEmpty($dataLayer->toArray());
    }

    #[Test]
    public function it_encodes_data_to_json()
    {
        $dataLayer = new DataLayer(['key' => 'value']);

        $json = $dataLayer->toJson();

        self::assertEquals('{"key":"value"}', $json);
    }
}
