<?php

namespace Ducnt\Modules\Setting;

use Ducnt\Modules\Setting\Supports\SettingManager;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    public function register()
    {
        /**
         * Path modules
         */
        if (!defined('MODULE_SETTING_PATH')) {
            define('MODULE_SETTING_PATH', __DIR__);
        }
        /**
         * Configuration
         */
        $this->mergeConfigFrom(MODULE_SETTING_PATH . '/config/setting.php', 'setting');

        $this->app->singleton('setting', function ($app) {
            return new SettingManager($app);
        });

    }

    public function boot()
    {
        $this->publishResources();

    }

    private function publishResources()
    {
        $this->publishes([
            MODULE_SETTING_PATH . '/config/setting.php' => config_path('setting.php')
        ], 'setting');
    }
}