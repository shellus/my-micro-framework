<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 18:21
 */

\Sh\Router::get('/^\/$/', \App\Controller\Index::class . '@index');

\Sh\Router::get('/^\/register$/', \App\Controller\Auth::class . '@getRegister');

\Sh\Router::post('/^\/register$/', \App\Controller\Auth::class . '@postRegister');