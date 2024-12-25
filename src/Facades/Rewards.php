<?php

namespace Mbsoft\Rewards\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mbsoft\Rewards\Rewards
 */
class Rewards extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mbsoft\Rewards\Rewards::class;
    }
}
