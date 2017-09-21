<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:23
 */

namespace Sh;


class Sql
{

    protected $column = '*';
    protected $table = '';

    /** @var array $wheres 多组条件，每组中可and or */
    protected $wheres = [];
    protected $parameters = [];
    protected $limit = 0;
    protected $offset = 0;
    protected $sort = null;
    protected $sql = '';


    function parseSelect()
    {
        $this->sql = "SELECT {$this -> column} FROM `{$this ->table}`";
        $this->parseAppendFilter();
        return $this;
    }

    function parseCount()
    {
        $this->sql = "SELECT COUNT({$this -> column}) as _BBS_COUNT FROM `{$this ->table}`";

        // 取数量不能limit，不然sql报错
        $this->clearLimit();
        $this->parseAppendFilter();
        return $this;
    }

    function parseDelete()
    {
        $this->sql = "DELETE FROM {$this -> table}";
        $this->parseAppendFilter();
        return $this;
    }

    function parseInsert($data)
    {
        $this->sql = "INSERT INTO {$this -> table} (`" . implode('`,`', array_keys($data)) . '`) VALUES (' . rtrim(str_repeat('?,', count($data)), ',') . ')';
        $this->parameters = array_values($data);
        return $this;
    }

    function parseUpdate($data)
    {
        $this->sql = "UPDATE {$this -> table} SET `" . implode('` = ?,`', array_keys($data)) . '` = ?';
        $this->parameters = array_values($data);
        $this->parseAppendFilter();
        return $this;
    }


    function parseAppendFilter()
    {
        if ($this->wheres) $this->sql .= " WHERE {$this -> parseWhere()}";
        if ($this->sort) $this->sql .= " ORDER BY {$this -> sort}";
        if ($this->limit) $this->sql .= " LIMIT {$this -> offset},{$this -> limit}";
    }

    function clearFilter()
    {
        $this->column = '*';
        $this->wheres = [];
        $this->parameters = [];
        $this->offset = 0;
        $this->sort = null;
        $this->sql = '';
        $this->clearLimit();
    }

    function clearLimit()
    {
        $this->limit = 0;
    }

    public function parseWhere()
    {
        $s = '';
        $this->parameters = [];

        if ($this->wheres) {

            if (count($this->wheres) == 1) {
                $where = $this->wheres[0];


                foreach ($where as $key => $v) {

                    if ($key !== 0) {
                        $s .= " {$v[3]} ";
                    }
                    $s .= "`{$v[0]}` {$v[1]} ?";

                    $this->parameters[] = $v[2];

                }
            } else {
                // TODO 多组where处理
            }

        }
        return $s;
    }

    function where($column, $operator = null, $value = null, $boolean = 'AND', $group = 0)
    {
        if (is_array($column)) {
            foreach ($column as $item) {
                if (empty($item[3])) {
                    $this->where($item[0], $item[1], $item[2]);
                } else {
                    $this->where($item[0], $item[1], $item[2], $item[3]);
                }

            }
            return $this;
        }

        $this->wheres[$group][] = [
            $column,
            $operator,
            $value,
            $boolean,
        ];

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderBy($limit)
    {
        $this->sort = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function column($column)
    {
        $this->column = $column;
        return $this;
    }
}

use PDO;

class DB extends Sql
{
    public $pdo;

    function __construct($config)
    {
        extract($config);
        $this->pdo = new PDO($dsn, $user, $pass, $args);
    }

    function query()
    {
//        var_dump($this->sql, $this->parameters);
        $statement = $this->pdo->prepare($this->sql);
        $statement->execute($this->parameters);
        return $statement;
    }

    function select()
    {
        return $this->parseSelect()->query()->fetchAll();
    }

    function count()
    {
        $data = $this->parseCount()->query()->fetchAll();

        return !$data ? 0 : isset($data[0]->_BBS_COUNT) ? (int)$data[0]->_BBS_COUNT : 0;
    }

    function delete()
    {
        return $this->parseDelete()->query()->rowCount();
    }

    function insert($data)
    {
        $this->parseInsert($data)->query();
        return $this->pdo->lastInsertId();
    }

    function update($data)
    {
        return $this->parseUpdate($data)->query()->rowCount();
    }

    function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: isset($_GET[$pageName]) ? $_GET[$pageName] : 1;
        $perPage = $perPage ?: 20;

        $query = $this->limit($perPage)->offset(($page - 1) * $perPage);

        $data = $this->select();

        $count = $this->count();

        return new Page($data, $page, $perPage, $count);
    }
}

class Page
{
    protected $data;
    protected $page;
    protected $perPage;
    protected $count;

    public function __construct($data, $page, $perPage, $count)
    {
        $this->data = $data;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->count = $count;
    }

    public function hasPages()
    {
        return true;
    }

    public function onFirstPage()
    {
        return true;
    }

    public function hasMorePages()
    {
        return true;
    }

    public function currentPage()
    {
        return $this->page;
    }

    public function links()
    {
        $elements = array_fill(1, 10, null);

        $total = ceil($this->count / $this->perPage);
        foreach ($elements as $i => &$element) {
            $element = "?page=$i";
        }
        $elements[$total] = "?page=$total";
        return view("pagination-advanced", ['paginator' => $this, 'elements' => [$elements]]);
    }

    public function items()
    {
        return $this->data;
    }
}