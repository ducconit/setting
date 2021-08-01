<?php

return [
    /**
     * driver mặc định
     */
    'default' => 'file',

    /**
     * Tự động lưu dữ liệu
     */
    'auto_save' => true,

    /**
     * Danh sách driver hỗ trợ
     */
    'drivers' => [
        'file' => [
            'path' => storage_path('setting.json')
        ]
    ],

    'cache' => [
        'enabled' => false,
        'key' => 'setting'
    ]
];