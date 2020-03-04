<?php

namespace Laravie\Dhosa\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Laravie\Dhosa\Concerns\Swappable;

class Role extends Model
{
    use Swappable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get Hot-swappable alias name.
     *
     * @return string
     */
    public static function hsAliasName(): string
    {
        return 'Role';
    }
}
