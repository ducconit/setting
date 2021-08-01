<?php

namespace Ducnt\Modules\Setting\Drivers;


use Ducnt\Modules\Setting\Supports\DriverBase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class File extends DriverBase
{
    /**
     * @var Filesystem
     */
    protected $filesystem;
    protected $path;
    protected $filename;
    protected $extension = '.json';

    /**
     * Lấy key cache
     */
    public function getKeyCache(): string
    {
        return $this->getBaseKeyCache() . '_site';
    }

    protected function saveData()
    {
        $data = $this->data;
        $filePath = $this->path;
        try {
            $this->writeFile($filePath, $data);
        } catch (\Exception $exception) {
            return false;
        }
        $this->saved = true;
        return true;
    }

    private function writeFile($filePath, $content)
    {
        $filesystem = $this->filesystem;
        $this->checkPath($filePath);
        $content = json_encode($content);

        if (json_last_error()) {
            throw new \Exception('Dữ liệu ghi không hợp lệ');
        }
        $filesystem->put($filePath, $content);
    }

    private function checkPath($filePath)
    {
        $filesystem = $this->filesystem;
        if (!$filesystem->exists($filePath)) {
            //Tạo folder
            if (!$filesystem->exists(dirname($filePath))) {
                $filesystem->makeDirectory(storage_path('framework/modules'), 777, true);
            }
            $filesystem->put($filePath, '{}');
        }
        if (!$filesystem->isReadable($filePath)) {
            throw new \Exception("Bạn chưa cấp quyền đọc file `$filePath`");
        }
        if (!$filesystem->isWritable($filePath)) {
            throw new \Exception("Bạn chưa cấp quyền ghi file `$filePath`");
        }
    }

    protected function init()
    {
        $path = $this->path ?: $this->getDefaultPath();
        $this->setPath($path);
        $this->filesystem = $this->container->make('files');
        $this->loadAllData();
    }

    public function getDefaultPath()
    {
        return $this->container['config']['setting.drivers.file.path'];
    }

    public function setPath(string $path): File
    {
        $this->path = $path;
        return $this;
    }

    protected function loadData()
    {
        $data = $this->readFile($this->path);
        $this->loaded = true;
        return $data;
    }

    private function readFile($filePath)
    {
        $filesystem = $this->filesystem;
        $this->checkPath($filePath);
        $result = json_decode($filesystem->get($filePath), true);
        if (json_last_error()) {
            throw new \Exception('Kết quả trả về không hợp lý');
        }
        return $result;
    }
}