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
    protected $where = [];
    protected $parameters = [];
    protected $limit = 0;
    protected $offset = 0;
    protected $sort = null;
    protected $sql = '';


    function parseSql()
    {
        $q = "SELECT {$this -> column} FROM `{$this ->table}`";

        if ($this -> where) $q .= " WHERE {$this -> where}";
        if ($this -> sort)  $q .= " ORDER BY {$this -> sort}";
        if ($this -> limit) $q .= " LIMIT {$this -> offset},{$this -> limit}";
        $this -> sql = $q;
        return $this;
    }

//
//    function delete($table, $where = 0)
//    {
//        $q = "DELETE FROM $table";
//        list($where, $p) = $this->where($where);
//        if ($where) $q .= " WHERE $where";
//        return ($s = $this->query($q, $p)) ? $s->rowCount() : 0;
//    }
//    function count($table, $where = 0)
//    {
//        list($q, $p) = $this->select('COUNT(*)', $table, $where);
//        return $this->column($q, $p);
//    }
//
//    function insert($table, $data)
//    {
//        $q = "INSERT INTO $table (\"" . implode('","', array_keys($data)) . '")VALUES(' . rtrim(str_repeat('?,', count($data)), ',') . ')';
//        return $this->query($q, array_values($data)) ? $this->pdo->lastInsertId() : 0;
//    }
//
//    function update($table, $data, $where = NULL)
//    {
//        $q = "UPDATE $table SET \"" . implode('"=?,"', array_keys($data)) . '"=? WHERE ';
//        list($a, $b) = $this->where($where);
//        return (($s = $this->query($q . $a, array_merge(array_values($data), $b))) ? $s->rowCount() : NULL);
//    }

    function where($where = [])
    {
        $a = $s = array();
        if ($where) {
            foreach ($where as $c => $v) {
                if (is_int($c)) {
                    $s[] = $v;
                } else {
                    $s[] = "`$c`=?";
                    $a[] = $v;
                }
            }
        }
        $this -> where = join(' AND ', $s);
        $this -> parameters = $a;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
}

use PDO;

class DB extends Sql
{
    public $pdo, $i = '`';
    static $q = array();

    function __construct($config)
    {
        extract($config);
        $this->pdo = new PDO($dsn, $user, $pass, $args);
    }

    function query()
    {
        $statement = $this->pdo->prepare($this -> sql);
        $statement->execute($this -> parameters);
        return $statement;
    }

    function get()
    {

        return $this -> parseSql() -> query() -> fetchAll(PDO::FETCH_OBJ);
    }
//    function first()
//    {
//        $this -> limit(1) -> parseSql() -> query() -> fetchAll();
//    }

}
