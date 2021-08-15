<?php

namespace Modules\Setting;

use Modules\Setting\Supports\SettingManager;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    public function register()
    {
        /**
         * Path plugins
         */
        if (!defined('VENDOR_SETTING_PATH')) {
            define('VENDOR_SETTING_PATH', __DIR__);
        }
        /**
         * Configuration
         */
        $this->mergeConfigFrom(VENDOR_SETTING_PATH . '/Config/setting.php', 'setting');

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
            VENDOR_SETTING_PATH . '/Config/setting.php' => config_path('setting.php')
        ], 'setting');
    }
}