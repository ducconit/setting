<?php

namespace Ducnt\Modules\Setting\Tests;

use Ducnt\Modules\Setting\Facades\Setting;
use Ducnt\Modules\Setting\SettingServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            SettingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test_setting');
        $app['config']->set('database.connections.test_setting', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageAliases($app)
    {
        return [
            'Setting' => Setting::class
        ];
    }
}
