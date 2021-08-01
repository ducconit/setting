<?php

namespace Ducnt\Modules\Setting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see
 */
class Setting extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'setting';
    }
}