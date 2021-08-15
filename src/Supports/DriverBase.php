<?php

namespace Modules\Setting\Supports;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

abstract class DriverBase
{
    use Macroable;
    /**
     * Container application
     * @var Container
     */
    protected $container;
    /**
     * @var CacheManager
     */
    protected $cache;
    /**
     * Kiểm tra dữ liệu đã được lưu chưa
     * @var bool
     */
    protected $saved = false;

    /**
     * Dữ liệu
     */
    protected $data = [];
    /**
     * Kiểm tra xem đã load data chưa?
     * @var bool
     */
    protected $loaded = false;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->cache = $container->make('cache');
        $this->init();
    }

    protected abstract function init();

    /**
     * Lấy dữ liệu
     */
    public function get($key, $default = null)
    {
        $this->loadAllData();
        $data = $this->data;
        return Arr::get($data, $key, $default);
    }

    /**
     * Đọc dữ liệu
     */
    protected function loadAllData()
    {
        if ($this->loaded()) {
            return;
        }
        if ($this->isEnabledCache()) {
            $data = $this->loadDataFromCache();
        } else {
            $data = $this->loadData();
        }
        $this->data = $data;
        $this->loaded = true;
    }

    public function loaded(): bool
    {
        return $this->loaded;
    }

    public function isEnabledCache(): bool
    {
        return $this->container['config']['setting.cache.enabled'];
    }

    /**
     * Đọc dữ liệu từ cache
     */
    protected function loadDataFromCache()
    {
        $key = $this->getKeyCache();
        $cache = $this->cache;
        $data = $cache->get($key);
        if (!$data) {
            $data = $cache->rememberForever($key, function () {
                return $this->loadData();
            });
        }
        return $data;
    }

    public abstract function getKeyCache(): string;

    protected abstract function loadData();

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->data, $key, $value);
        }
        $this->saved = false;
        if ($this->autoSave()) {
            $this->save();
        }
    }

    public function autoSave()
    {
        return $this->container['config']['setting.auto_save'];
    }

    public function save()
    {
        if ($this->saved()) {
            return false;
        }
        $saved = $this->saveData();
        if ($this->isEnabledCache()) {
            $this->flushFromCache();
        }
        return $saved;
    }

    public function saved(): bool
    {
        return $this->saved;
    }

    protected abstract function saveData();

    protected function flushFromCache()
    {
        $key = $this->getKeyCache();
        $this->cache->forget($key);
    }

    /**
     * Xóa dữ liệu
     */
    public function forget($key)
    {
        $this->loadAllData();
        Arr::forget($this->data, $key);
        if ($this->autoSave()) {
            if ($this->isEnabledCache()) {
                $this->forgetFromCache($key);
            }
            $this->save();
        }
        return $this->data;
    }

    /**
     * Xóa dữ liệu từ bộ nhớ cache
     */
    protected function forgetFromCache($key)
    {
        $this->cache->forget($key);
    }

    /**
     * Lấy tất cả dữ liệu
     */
    public function all()
    {
        $this->loadAllData();
        return $this->data;
    }

    /**
     * Xóa tất cả giữ liệu
     */
    public function flush()
    {
        $this->data = [];
        if ($this->autoSave()) {
            $this->save();
        }
    }

    public function getBaseKeyCache(): string
    {
        return $this->container['config']['setting.cache.key'];
    }
}