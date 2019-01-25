<?php

/** @var Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->get('ddoc/readme.md', 'Wxm\DDoc\Controllers\DDocController@readme');

$router->get('ddoc/httpcode.md', 'Wxm\DDoc\Controllers\DDocController@httpCode');

$router->get('ddoc/api.md', 'Wxm\DDoc\Controllers\DDocController@apiDoc');

$router->get('ddoc/database.md', 'Wxm\DDoc\Controllers\DDocController@databaseDoc');

$router->get('ddoc', ['as' => 'ddoc', 'uses' => 'Wxm\DDoc\Controllers\DDocController@index']);
