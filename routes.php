<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 18:21
 */

\Sh\Router::get('/^\/$/', \App\Controller\Index::class . '@index');
\Sh\Router::get('/^\/new$/', \App\Controller\Index::class . '@new_');

\Sh\Router::get('/^\/test$/', \App\Controller\Index::class . '@test');