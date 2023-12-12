<?php

namespace Pardalsalcap\LinterRedirections\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pardalsalcap\LinterRedirections\LinterRedirections
 */
class LinterRedirections extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pardalsalcap\LinterRedirections\LinterRedirections::class;
    }
}
