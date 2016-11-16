<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:26
 */

namespace Sh;

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
        if (!key_exists($k, $this->data) OR $this->data[$k] !== $v) {
            $this->data[$k] = $v;
            $this->change_data[$k] = $k;
        }
    }

    function __get($k)
    {
        return key_exists($k, $this->data) ? $this->data[$k] : NULL;
    }

    function __isset($k)
    {
        return key_exists($k, $this->data);
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
        $a = array();
        if ($this->change_data) {
            foreach ($this->change_data as $k) $a[$k] = $this->data[$k];
        }
        return $a;
    }

    public function __toString()
    {
        return json_encode($this->data);
    }
}

class ORM extends Stateful
{
    /**
     * 检查、补全、过滤
     * @param $data
     * @return array
     */
    public function check($data)
    {
        // TODO 还没想好
        return $data;
    }

    /** @var  $db DB */
    static $db, $table, $f, $relationship, $b, $master_key = 'id';
    static $r = [];

    function __construct($data = null)
    {
        foreach ($data as $key => $item) {
            $this->$key = $item;
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
            $foreign_key => $this->$local_key
        ];
        return $model::where($where) -> get();
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
        return $model::where([$local_key => $this->$foreign_key]) -> get()[0];
    }

    function save()
    {
        if ($data = $this->changes()) {
            $k = $this::$master_key;

            if ($this->load = !key_exists($k, $this->data)) {
                $this->$k = $this::$db->table(static::getTableName())->insert($data);
            } else {
                $this::$db->table(static::getTableName())->where($k, '=', $this->$k)->update($data);
            }
        }
        return $this;
    }


    function load()
    {
        // 数据已经载入
        if (!$this->load) {
            /** @var string $k */
            $k = $this::$master_key;

            if (!key_exists($k, $this->data)) {
                throw new \Exception('没有主键，不能加载数据');
            }


            if ($result = static::where([$k => $this->data[$k]])->get()) {
                $this->load = true;
                $this->change_data = [];
                $this->data = $result[0]->values();
            }
        }
        return $this;
    }

    public static function where($column, $operator = null, $value = null, $boolean = 'AND', $group = 0){
        static::$db->where($column, $operator, $value, $boolean, $group);
        return new static();
    }

    static function get()
    {
        $result = static::$db->table(static::getTableName())->select();
        foreach ($result as &$v) $v = new static((array)$v);

        return new Collection($result);
    }

    /**
     * @param $id
     * @return static
     */
    static public function find($id)
    {
        return static::where([static::$master_key, '=', $id]) -> get()->first();
    }

    static function count($where = [])
    {
        return static::$db->table(static::getTableName())->where($where)->count();
    }

    static function getTableName()
    {
        $arr = explode('\\', static::class);
        $table = strtolower(end($arr));
        return static::$table ?: $table;
    }
}