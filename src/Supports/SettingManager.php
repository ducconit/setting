<?php

namespace Ducnt\Modules\Setting\Supports;

use Ducnt\Modules\Setting\Drivers\File;
use Illuminate\Support\Manager;

/**
 * @see  DriverBase
 */
class SettingManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config['setting.default'];
    }

    public function createFileDriver()
    {
        return new File($this->container);
    }
}