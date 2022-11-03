<?php

$readme = base_path('README.md');

return [
    'title' => env('APP_NAME', '') . '文档',
    'enabled' => env('APP_DEBUG', false),
    'readme' => file_exists($readme) ? file_get_contents($readme) : '# README.md',
    'asset_js_path' => 'https://unpkg.com/docute@3/dist/docute.js',
    'asset_css_path' => 'https://unpkg.com/docute@3/dist/docute.css',
    'docute' => [
        'announcement' => [
            'type' => 'success',
            'html' => 'Welcome to the documentation'
        ],
        'nav' => [
            [
                'title' => '首页',
                'path' => '/',
                'source' => '/ddoc/readme'
            ],
            [
                'title' => '接口文档',
                'path' => '/api',
                'source' => '/ddoc/api'
            ],
            [
                'title' => '数据库字典',
                'path' => '/database',
                'source' => '/ddoc/database'
            ]
        ],
        'icons' => [
            [
                'icon' => 'github',
                'label' => '给项目来个 Star 吧 !',
                'link' => 'https://github.com/qq15725/ddoc'
            ]
        ]
    ]
];
