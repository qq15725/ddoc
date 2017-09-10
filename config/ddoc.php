<?php

$readme = <<<readme
<h1 align="center">readme.md</h1>

<a href="https://github.com/dingo/api/wiki/API-Blueprint-Documentation">
    API Blueprint Documentation
</a> for <a href="https://github.com/dingo/api">dingo/api</a>
readme;

return [

    /*
    |--------------------------------------------------------------------------
    | readme.md
    |--------------------------------------------------------------------------
    */

    'readme' => $readme,

    /*
    |--------------------------------------------------------------------------
    | 身份验证
    | - 是否开启
    | - 验证密码
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'enable' => true,
        'password' => 'root'
    ],
];