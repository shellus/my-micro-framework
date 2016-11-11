<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:26
 */

namespace Sh;
use Sh\Collection;

/**
 * Class Stateful
 * @package Sh
 * 状态机
 * 用来检测变更的数据
 */
class Stateful
{
    /** @var array $change_data 变化的数据 */
    protected $change_data = [];
    /** @var array $data 原数据 */
    protected $data = [];
    /** @var bool $load 是否已经从数据库加载数据 */
    protected $load = false;

    function set($a)
    {
        foreach ($a as $k => $v) $this->$k = $v;
    }

    function __set($k, $v)
    {
        if (!array_key_exists($k, $this->data) OR $this->data[$k] !== $v) {
            $this->data[$k] = $v;
            $this->change_data[$k] = $k;
        }
    }

    function __get($k)
    {
        return array_key_exists($k, $this->data) ? $this->data[$k] : NULL;
    }

    function __isset($k)
    {
        return array_key_exists($k, $this->data);
    }

    function __unset($k)
    {
        unset($this->data[$k], $this->change_data[$k]);
    }

    function clear()
    {
        $this->data = $this->change_data = array();
    }

    function values()
    {
        return $this->data;
    }

    function changed()
    {
        return (bool)$this->change_data;
    }

    function changes()
    {
        if ($this->change_data) {
            $a = array();
            foreach ($this->change_data as $k) $a[$k] = $this->data[$k];
            return $a;
        }
    }

    public function __toString()
    {
        return json_encode($this->data);
    }
}

class ORM extends Stateful
{

    /** @var  $db DB */
    static $db, $table, $f, $relationship, $b, $master_key = 'id';
    static $r = [];

    function __construct($data = null)
    {
        if ($data) {
            if (is_numeric($data)) {
                $this->data[$this::$master_key] = $data;
            } else {
                if (empty($data[$this::$master_key])) {
                    foreach ($data as $key => $item) {
                        $this->$key = $item;
                    }
                } else {
                    $this->data = (array)$data;
                }

            }
        }
    }

    /**
     * 一对多（例如文章查评论）
     * @param $model ORM
     * @param $foreign_key
     * @param $local_key
     * @return ORM
     */
    protected function hasMany($model, $foreign_key, $local_key = 'id')
    {
        $where = [
            $foreign_key => $this -> $local_key
        ];
        return $model::get($where);
    }
    /**
     * 一对多(反向，例如评论查文章)
     * @param $model ORM
     * @param $foreign_key
     * @param $local_key
     * @return ORM
     */
    protected function belongsTo($model, $foreign_key, $local_key = 'id')
    {
        return $model::get([$local_key => $this -> $foreign_key])[0];
    }

    function save()
    {
        if ($data = $this->changes()) {
            $k = $this::$master_key;

            if ($this->load = empty($this->data[$k])) {
                $this->$k = $this::$db->insert($this::getTableName(), $data);
            } else {
                $this::$db->update($this::getTableName(), $data, array($k => $this->$k));
            }
        }
        return $this;
    }



    function load()
    {
        // 数据已经载入
        if (!$this->load) {
            $k = $this::$master_key;

            if (empty($this->data[$k])) {
                throw new \Exception('没有主键，不能加载数据');
            }

            if ($result = $this->get(array($k => $this->data[$k]))) {
                $this->load = true;
                $this->change_data = [];
                $this->data = $result[0]->values();
            }
        }
        return $this;
    }

    static function get($where = [])
    {
        $result = static::$db -> table(static::getTableName()) -> where($where) ->select();
        foreach ($result as &$v) $v = new static((array)$v);

        return new Collection($result);
    }

    /**
     * @param $id
     * @return static
     */
    static public function find($id)
    {
        return static::get([[static::$master_key, '=', $id]]) -> first();
    }

    static function count($where = 0)
    {
        return static::$db->count(static::getTableName(), $where);
    }

    static function getTableName()
    {

        $table = pathinfo(strtolower(end(explode('\\', static::class))), PATHINFO_FILENAME);

        return static::$table ?: $table;
    }
}