<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 18:21
 */
namespace App\Controllers;

use Sh\Router;

Router::get('/^\/$/', Index::class . '@index');

Router::get('/^\/register$/', Auth::class . '@getRegister');
Router::get('/^\/login$/', Auth::class . '@getLogin');
Router::post('/^\/register$/', Auth::class . '@postRegister');
Router::post('/^\/login$/', Auth::class . '@postLogin');
