<?php

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 15:08
 */

require __DIR__ . '/../vendor/autoload.php';

define('_APP_ROOT_PATH_', __DIR__ . DIRECTORY_SEPARATOR . '..');

\Sh\Config::load_config(__DIR__ . '/../config');

\Sh\ORM::$db = new \Sh\DB(config('app.database'));

\Sh\View::load_config(__DIR__ . '/../view/');

\Sh\View::globalVar('navigations',  \App\Model\Navigations::get());

require __DIR__ . '/../routes.php';

\Sh\Request::createFromWEB();

