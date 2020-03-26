<?php

namespace Bitaac\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bitaac\Core\Bitaac
 */
class Bitaac extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bitaac';
    }
}
