<?php

namespace Ducnt\Plugins\Setting\Tests;

use Ducnt\Plugins\Setting\Facades\Setting;

class TestMacroSetting extends TestCase
{

    public function test_create_macro_setting()
    {
        Setting::macro('test', function () {
            return 'ok';
        });

        $this->assertEquals(Setting::test(), 'ok');
    }

    public function test_create_mixin_setting()
    {
        Setting::mixin(new mixinClass);
        $this->assertEquals(Setting::testMixin(), 'success');
    }

    public function mixinMethod()
    {
        return function () {
            return 'success';
        };
    }
}


class mixinClass
{
    public function testMixin()
    {
        return function () {
            return 'success';
        };
    }
}