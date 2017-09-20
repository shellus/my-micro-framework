<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */

return [
    'view_path' => _BASE_PATH_ . '/view/',
    'database' => [
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=taobao',
        'user' => 'root',
        'pass' => 'root',
        'args' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        )
    ],

    'providers' => [
        App\Providers\ViewglobalVarProvider::class,
    ],
];