<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */

return [
    'view_path' => _APP_ROOT_PATH_ . '/app/view/',
    'database' => [
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=draw',
        'user' => 'root',
        'pass' => '',
        'args' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
    ],
];