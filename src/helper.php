<?php

use Modules\Setting\Supports\SettingManager;

if (!function_exists('setting')) {
    /**
     * @param array|string|null $key
     * @param mixed $default
     * @return mixed|SettingManager
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        return app('setting')->get($key, $default);
    }
}