<?php

namespace Spatie\GoogleTagManager\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Spatie\GoogleTagManager\DataLayer;
use Spatie\GoogleTagManager\GoogleTagManager;

#[CoversClass(GoogleTagManager::class)]
class GoogleTagManagerTest extends TestCase
{
    private GoogleTagManager $tagManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagManager = new GoogleTagManager('', '');
    }

    #[Test]
    public function it_sets_keys_and_values_to_the_data_layer()
    {
        $this->tagManager->set('key', 'value');

        self::assertEquals(['key' => 'value'], $this->tagManager->getDataLayer()->toArray());
    }

    #[Test]
    public function it_sets_arrays_to_the_data_layer()
    {
        $this->tagManager->set(['key' => 'value']);

        self::assertEquals(['key' => 'value'], $this->tagManager->getDataLayer()->toArray());
    }

    #[Test]
    public function it_sets_keys_and_values_to_the_flash_data_layer()
    {
        $this->tagManager->flash('key', 'value');

        self::assertEquals(['key' => 'value'], $this->tagManager->getFlashData());
    }

    #[Test]
    public function it_sets_arrays_to_the_flash_data_layer()
    {
        $this->tagManager->flash(['key' => 'value']);

        self::assertEquals(['key' => 'value'], $this->tagManager->getFlashData());
    }

    #[Test]
    public function it_sets_keys_and_values_to_the_push_data_layer()
    {
        $this->tagManager->push('key', 'value');

        self::assertEquals(collect([new DataLayer(['key' => 'value'])]), $this->tagManager->getPushData());
    }

    #[Test]
    public function it_sets_arrays_to_the_push_data_layer()
    {
        $this->tagManager->push(['key' => 'value']);

        self::assertEquals(collect([new DataLayer(['key' => 'value'])]), $this->tagManager->getPushData());
    }

    #[Test]
    public function it_sets_keys_and_values_to_the_flas_push_data_layer()
    {
        $this->tagManager->flashPush('key', 'value');

        self::assertEquals(collect([new DataLayer(['key' => 'value'])]), $this->tagManager->getFlashPushData());
    }

    #[Test]
    public function it_sets_arrays_to_the_flas_push_data_layer()
    {
        $this->tagManager->flashPush(['key' => 'value']);

        self::assertEquals(collect([new DataLayer(['key' => 'value'])]), $this->tagManager->getFlashPushData());
    }
}
