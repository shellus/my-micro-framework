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
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=shcms_read',
        'user' => 'root',
        'pass' => 'root',
        'args' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
    ],

    'providers' => [
        App\Providers\ViewglobalVarProvider::class,
    ],
];