<?php

namespace Laravie\Dhosa\Tests\Feature\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\FactoryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravie\Dhosa\HotSwap;
use Laravie\Dhosa\Tests\Stubs\Role;
use Laravie\Dhosa\Tests\TestCase;

class SwappableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        HotSwap::register(Role::class);
    }

    /** @test */
    public function itCanCreateAnInstanceOfEloquent()
    {
        $role = Role::hs(['name' => 'Staff']);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame('Staff', $role->name);
        $this->assertFalse($role->exists);
    }

    /** @test */
    public function itCanCreateAnInstanceOfEloquentQueryBuilder()
    {
        $query = Role::hsQuery();

        $this->assertInstanceOf(Builder::class, $query);
        $this->assertInstanceOf(Role::class, $query->getModel());
    }

    /** @test */
    public function itCanCreateAnInstanceOfEloquentFakerBuilder()
    {
        $builder = Role::hsFaker();

        $this->assertInstanceOf(FactoryBuilder::class, $builder);

        $role = $builder->create(['name' => 'Moderator']);

        $this->assertTrue($role->exists);
        $this->assertSame('Moderator', $role->name);
        $this->assertInstanceOf(Role::class, $role);
    }

    /** @test */
    public function itCanFindTheHsModelName()
    {
        $this->assertSame(Role::class, Role::hsFinder());
    }
}
