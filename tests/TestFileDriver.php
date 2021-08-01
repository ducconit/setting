<?php

namespace Ducnt\Modules\Setting\Tests;

use Ducnt\Modules\Setting\Facades\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestFileDriver extends TestCase
{
    /**
     * Kiểm tra xem có tạo được file và
     * kết quả trả về có phải 1 mảng không
     */
    public function test_get_all_data_read_file()
    {
        $setting = $this->app->make('setting');
        $this->assertIsArray($setting->all());
    }

    /**
     * Kiểm tra ghi dữ liệu
     */
    public function test_get_data_write_file()
    {
        $setting = $this->app->make('setting');
        $setting->set(['app.locale' => 'en']);
        $this->assertEquals($setting->get('app.locale'), 'en');
    }

    /**
     * Kiểm tra xóa 1 key trong dữ liệu
     */
    public function test_forget_key_in_data()
    {
        $setting = $this->app->make('setting');
        $setting->forget('app.locale');
        $this->assertNull($setting->get('app.locale'));
    }
}
