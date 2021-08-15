<?php

namespace Modules\Setting\Facades;

use Modules\Setting\Supports\DriverBase;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DriverBase all()
 * @method static DriverBase get($key, $default = null)
 * @method static DriverBase set(array|string $key, $value = null)
 * @method static DriverBase forget(string $key)
 * @method static DriverBase flush()
 * @method static DriverBase save()
 * @method static DriverBase macro($name, Object|Callable $macro)
 * @method static DriverBase mixin(Object $mixin, bool $replace = true)
 * @see DriverBase
 */
class Setting extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'setting';
    }
}