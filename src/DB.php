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
    function delete($table, $where = 0)
    {
        $q = "DELETE FROM $table";
        list($where, $p) = $this->where($where);
        if ($where) $q .= " WHERE $where";
        return ($s = $this->query($q, $p)) ? $s->rowCount() : 0;
    }

    /**
     * @param int $column
     * @param $table
     * @param int $where
     * @param int $limit
     * @param int $offset
     * @param int $sort
     * @return array
     */
    function select($column = 0, $table, $where = 0, $limit = 0, $offset = 0, $sort = 0)
    {
        $column = $column ?: '*';
        $q = "SELECT $column FROM \"$table\"";
        list($where, $p) = $this->where($where);
        if ($where) $q .= " WHERE $where";
        return array($q . ($sort ? " ORDER BY $sort" : '') . ($limit ? " LIMIT $offset,$limit" : ''), $p);
    }

    function count($table, $where = 0)
    {
        list($q, $p) = $this->select('COUNT(*)', $table, $where);
        return $this->column($q, $p);
    }

    function insert($table, $data)
    {
        $q = "INSERT INTO $table (\"" . implode('","', array_keys($data)) . '")VALUES(' . rtrim(str_repeat('?,', count($data)), ',') . ')';
        return $this->query($q, array_values($data)) ? $this->pdo->lastInsertId() : 0;
    }

    function update($table, $data, $where = NULL)
    {
        $q = "UPDATE $table SET \"" . implode('"=?,"', array_keys($data)) . '"=? WHERE ';
        list($a, $b) = $this->where($where);
        return (($s = $this->query($q . $a, array_merge(array_values($data), $b))) ? $s->rowCount() : NULL);
    }

    function where($where = 0)
    {
        $a = $s = array();
        if ($where) {
            foreach ($where as $c => $v) {
                if (is_int($c))
                {
                    $s[] = $v;
                }
                else
                {
                    $s[] = "\"$c\"=?";
                    $a[] = $v;
                }
            }
        }
        return array(join(' AND ', $s), $a);
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

    function column($query, $parameters = NULL, $key = 0)
    {
        return ($statement = $this->query($query, $parameters)) ? $statement->fetchColumn($key) : 0;
    }

    function row($q, $parameters = NULL)
    {
        return ($statement = $this->query($q, $parameters)) ? $statement->fetch(PDO::FETCH_OBJ) : 0;
    }

    function fetch($q, $parameters = NULL)
    {
        return ($statement = $this->query($q, $parameters)) ? $statement->fetchAll(PDO::FETCH_OBJ) : 0;
    }

    /**
     * @param $q
     * @param null|array $parameters
     * @return \PDOStatement
     */
    function query($q, $parameters = NULL)
    {
        $statement = $this->pdo->prepare(self::$q[] = str_replace('"', $this->i, $q));
        $statement->execute($parameters);
        return $statement;
    }
}
