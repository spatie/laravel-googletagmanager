<?php

namespace Spatie\GoogleTagManager\Tests;

use Illuminate\Config\Repository as Cache;
use Illuminate\Http\Request;
use Illuminate\Session\Store as Session;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Spatie\GoogleTagManager\GoogleTagManager;
use Spatie\GoogleTagManager\GoogleTagManagerMiddleware;

#[CoversClass(GoogleTagManagerMiddleware::class)]
#[UsesClass(GoogleTagManager::class)]
class GoogleTagManagerMiddlewareTest extends TestCase
{
    /** @var Session&\PHPUnit\Framework\MockObject\MockObject */
    private $session;

    /** @var Cache&\PHPUnit\Framework\MockObject\MockObject */
    private $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->session = $this->createMock(Session::class);
        $this->cache = $this->createMock(Cache::class);

        $this->cache->method('get')->willReturn('key');
    }

    #[Test]
    public function it_sets_flashed_data_to_the_data_layer()
    {
        $tagManager = new GoogleTagManager('', '');
        $middleware = new GoogleTagManagerMiddleware($tagManager, $this->session, $this->cache);

        $this->session->method('has')->willReturn(true);
        $this->session->method('get')->willReturn(['key' => 'value']);

        $middleware->handle(new Request(), function () {});

        self::assertEquals([
            'key' => 'value',
        ], $tagManager->getDataLayer()->toArray());
    }

    #[Test]
    public function it_pushes_flashed_pushes_to_the_push_data_layer()
    {
        $tagManager = new GoogleTagManager('', '');
        $middleware = new GoogleTagManagerMiddleware($tagManager, $this->session, $this->cache);

        $this->session->method('has')->willReturnOnConsecutiveCalls(false, true);
        $this->session->method('get')->willReturn([['key' => 'value']]);

        $middleware->handle(new Request(), function () {});

        self::assertCount(1, $tagManager->getPushData());
        self::assertEquals([
            'key' => 'value',
        ], $tagManager->getPushData()->first()->toArray());
    }

    #[Test]
    public function it_flashes_the_flash_data_to_the_session()
    {
        $tagManager = new GoogleTagManager('', '');
        $middleware = new GoogleTagManagerMiddleware($tagManager, $this->session, $this->cache);

        $tagManager->flash('key', 'value');

        $this->session->expects($this->exactly(2))
            ->method('flash')
            ->with(
                self::callback(static function ($value) {
                    static $i = 0;

                    return (match (++$i) {
                        1 => self::equalTo('key'),
                        2 => self::stringEndsWith(':push'),
                    })->evaluate($value, returnResult: true);
                }),
            );

        $middleware->handle(new Request(), function () {});
    }

    #[Test]
    public function it_flashes_the_flash_push_data_to_the_session()
    {
        $tagManager = new GoogleTagManager('', '');
        $middleware = new GoogleTagManagerMiddleware($tagManager, $this->session, $this->cache);

        $tagManager->flashPush('key', 'value');

        $this->session->expects($this->exactly(2))
            ->method('flash')
            ->with(
                self::callback(static function ($value) {
                    static $i = 0;

                    return (match (++$i) {
                        1 => self::anything(),
                        2 => self::stringEndsWith(':push'),
                    })->evaluate($value, returnResult: true);
                }),
                self::callback(static function ($value) {
                    static $i = 0;

                    return (match (++$i) {
                        1 => self::anything(),
                        2 => self::equalTo([['key' => 'value']]),
                    })->evaluate($value, returnResult: true);
                }),
            );

        $middleware->handle(new Request(), function () {});
    }
}
