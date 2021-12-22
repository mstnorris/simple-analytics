<?php

namespace Mstnorris\SimpleAnalytics;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mstnorris\SimpleAnalytics\SimpleAnalytics
 */
class SimpleAnalyticsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'simple-analytics';
    }

}
