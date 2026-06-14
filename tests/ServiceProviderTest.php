<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Tests;

use PHPUnit\Framework\Attributes\Test;

class ServiceProviderTest extends TestCase
{
    #[Test]
    public function it_registers_the_tinify_service(): void
    {
        $this->assertTrue($this->app->bound('tinify'));
    }

    #[Test]
    public function it_resolves_the_same_instance(): void
    {
        $instance1 = $this->app->make('tinify');
        $instance2 = $this->app->make('tinify');

        $this->assertSame($instance1, $instance2);
    }

    #[Test]
    public function the_facade_resolves_correctly(): void
    {
        $this->assertInstanceOf(
            \yasmuru\LaravelTinify\Services\TinifyService::class,
            \yasmuru\LaravelTinify\Facades\Tinify::getFacadeRoot()
        );
    }

    #[Test]
    public function it_loads_configuration(): void
    {
        $this->assertEquals('test-api-key', config('tinify.apikey'));
    }
}
