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
    public function it_can_create_an_instance_of_eloquent()
    {
        $role = Role::hs(['name' => 'Staff']);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame('Staff', $role->name);
        $this->assertFalse($role->exists);
    }

    /** @test */
    public function it_can_create_an_instance_of_eloquent_query_builder()
    {
        $query = Role::hsQuery();

        $this->assertInstanceOf(Builder::class, $query);
        $this->assertInstanceOf(Role::class, $query->getModel());
    }

    /** @test */
    public function it_can_create_an_instance_of_eloquent_faker_builder()
    {
        $builder = Role::hsFaker();

        $this->assertInstanceOf(FactoryBuilder::class, $builder);

        $role = $builder->create(['name' => 'Moderator']);

        $this->assertTrue($role->exists);
        $this->assertSame('Moderator', $role->name);
        $this->assertInstanceOf(Role::class, $role);
    }

    /** @test */
    public function it_can_find_the_hs_model_name()
    {
        $this->assertSame(Role::class, Role::hsFinder());
    }
}
