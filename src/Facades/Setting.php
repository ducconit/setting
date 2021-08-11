<?php

namespace Ducnt\Plugins\Setting\Facades;

use Ducnt\Plugins\Setting\Supports\DriverBase;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Object_;

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