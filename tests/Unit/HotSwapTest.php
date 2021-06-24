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
    public function itCanRegisterSwappableClass()
    {
        HotSwap::register(SwappableModel::class);

        $this->assertSame(SwappableModel::class, HotSwap::eloquent('Model'));
        $this->assertInstanceOf(SwappableModel::class, HotSwap::make('Model'));
    }

    /** @test */
    public function itCantRegisterNoneSwappableClass()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Given [Laravie\Dhosa\Tests\Unit\NotSwappableModel] doesn\'t use [Laravie\Dhosa\Concerns\Swappable] trait.');

        HotSwap::register(NotSwappableModel::class);
    }

    /** @test */
    public function itCantRegisterNoneEloquentClass()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Given [Laravie\Dhosa\Tests\Unit\NotModel] is not a subclass of [Illuminate\Database\Eloquent\Model].');

        HotSwap::register(NotModel::class);
    }

    /** @test */
    public function itCanOverrideRegisteredAlias()
    {
        HotSwap::register(SwappableModel::class);

        $this->assertSame(SwappableModel::class, HotSwap::eloquent('Model'));

        HotSwap::override('Model', NotSwappableModel::class);

        $this->assertSame(NotSwappableModel::class, HotSwap::eloquent('Model'));
    }

    /** @test */
    public function itCanOverrideUnregisteredAlias()
    {
        HotSwap::override(SwappableReplacementModel::class);

        $this->assertSame(SwappableReplacementModel::class, HotSwap::eloquent('Model'));
    }

    /** @test */
    public function itReturnModelWhenCallingEloquentOnRegisteredAliasName()
    {
        HotSwap::register(SwappableModel::class);

        $this->assertInstanceOf(SwappableModel::class, HotSwap::make('Model'));
    }

    /** @test */
    public function itReturnNullWhenCallingEloquentOnUnregisteredAliasName()
    {
        $this->assertNull(HotSwap::make('Foobar'));
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

class SwappableReplacementModel extends SwappableModel
{
    //
}

class NotSwappableModel extends Model
{
    //
}

class NotModel
{
    //
}
