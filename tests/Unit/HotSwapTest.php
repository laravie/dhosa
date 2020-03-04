<?php

namespace Laravie\Dhosa\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Laravie\Dhosa\Concerns\Swappable;
use Laravie\Dhosa\HotSwap;
use PHPUnit\Framework\TestCase;

class HotSwapTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        HotSwap::flush();
    }

    /** @test */
    public function it_can_register_swappable_class()
    {
        HotSwap::register(SwappableModel::class);

        $this->assertSame(SwappableModel::class, HotSwap::eloquent('Model'));
        $this->assertInstanceOf(SwappableModel::class, HotSwap::make('Model'));
    }

    /** @test */
    public function it_cant_register_none_swappable_class()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Given [Laravie\Dhosa\Tests\Unit\NotSwappableModel] doesn\'t use [Laravie\Dhosa\Concerns\Swappable] trait.');

        HotSwap::register(NotSwappableModel::class);
    }

    /** @test */
    public function it_cant_register_none_eloquent_class()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Given [Laravie\Dhosa\Tests\Unit\NotModel] is not a subclass of [Illuminate\Database\Eloquent\Model].');

        HotSwap::register(NotModel::class);
    }
}

class SwappableModel extends Model
{
    use Swappable;

    public static function hsAliasName(): string
    {
        return 'Model';
    }
}

class NotSwappableModel extends Model
{
    //
}

class NotModel
{
    //
}
