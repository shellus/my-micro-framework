<?php

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 15:08
 */

require __DIR__ . '/../vendor/autoload.php';

define('_BASE_PATH_', dirname(__DIR__));
define('_APP_PATH_', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app');

\Sh\Config::load_config(_BASE_PATH_ . '/config');

\Sh\View::setBasePath(\Sh\Config::get('app.view_path'));

function error_handler($error_level, $error_message, $file, $line)
{
    $EXIT = FALSE;
    switch ($error_level) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $error_type = 'Notice';
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $error_type = 'Warning';
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $error_type = 'Fatal Error';
            $EXIT = TRUE;
            break;
        default:
            $error_type = 'Unknown';
            break;
    }

    if ($EXIT) {
        echo view('errors/500', ['e' => new Exception($error_message, 0)]);
        die();
    }
}

set_error_handler('error_handler');


function fatalError()
{
    if ($e = error_get_last()) {
        switch ($e['type']) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                echo view('errors/500', ['e' => new Exception($e['file']. '(' .$e['line'] . ')<br>' .$e['message'])]);
                die();
                break;
        }
    }
}

register_shutdown_function('fatalError');


function appException($e)
{
    echo view('errors/500', ['e' => $e]);
    die();
}

set_exception_handler('appException');


\Sh\ORM::$db = new \Sh\DB(config('app.database'));

require _BASE_PATH_ . '/routes.php';

\Sh\Request::createFromWEB();

foreach (\Sh\Config::get('app.providers') as $provider){
    (new $provider)->boot();
}
