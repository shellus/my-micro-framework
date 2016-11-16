<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:01
 */

namespace Sh;


class View
{
    static protected $path;
    static $globalVars = [];
    protected $vars = [];
    protected $view = '';

    /**
     * @param $key
     * @param $value
     * @return self
     */
    public static function globalVar($key, $value)
    {
        self::$globalVars[$key] = $value;
        return self::class;
    }


    /**
     * @param $view
     * @return $this
     */
    public function view($view)
    {
        $this->view = $view;
        return $this;
    }

    public function set($key, $value)
    {
        $this->vars[$key] = $value;
        return $this;
    }

    public function vars($vars){
        $this -> vars = $vars;
        return $this;
    }

    /**
     * @param $view
     * @return $this
     */
    static public function load($view)
    {
        return (new static())->view($view);
    }

    static public function load_config($path)
    {
//        static::$path = \Sh\Config::get('app.view_path');
        static::$path = $path;
    }

    public function render()
    {
        ob_start();
        extract($this->vars);
        extract(static::$globalVars);

        require static::$path . $this->view . '.php';

        $vars = array_diff(get_defined_vars(), array(array()));

        if (!empty($layout)) {
            unset($vars['layout']);
            return static::load($layout)->vars($vars) -> set('body', ob_get_clean())->render();
        }
        return ob_get_clean();
    }
}