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
        $this -> sql = "SELECT {$this -> column} FROM `{$this ->table}`";
        $this -> parseAppendFilter();
        return $this;
    }
    function parseDelete()
    {
        $this -> sql = "DELETE FROM {$this -> table}";
        $this -> parseAppendFilter();
        return $this;
    }
    function parseInsert($data)
    {
        $this -> sql = "INSERT INTO {$this -> table} (`" . implode('`,`', array_keys($data)) . '`) VALUES (' . rtrim(str_repeat('?,', count($data)), ',') . ')';
        $this -> parameters = array_values($data);
        return $this;
    }

    function parseUpdate($data)
    {
        $this -> sql = "UPDATE {$this -> table} SET `" . implode('` = ?,`', array_keys($data)) . '` = ?';
        $this -> parameters = array_values($data);
        $this -> parseAppendFilter();
        return $this;
    }



    function parseAppendFilter(){
        if ($this -> wheres) $this -> sql .= " WHERE {$this -> parseWhere()}";
        if ($this -> sort)  $this -> sql .= " ORDER BY {$this -> sort}";
        if ($this -> limit) $this -> sql .= " LIMIT {$this -> offset},{$this -> limit}";
    }

    function clearFilter(){
        $this -> column = '*';
        $this -> wheres = [];
        $this -> parameters = [];
        $this -> limit = 0;
        $this -> offset = 0;
        $this -> sort = null;
        $this -> sql = '';
    }

    public function parseWhere()
    {
        $s = '';
        if ($this -> wheres) {

            if (count($this -> wheres) == 1){
                $where = $this -> wheres[0];


                foreach ($where as $key => $v) {
                    $s .= "`{$v[0]}` {$v[1]} ?";

                    if(count($where) !== $key+1){
                        $s .= " {$v[3]} ";
                    }
                    $this -> parameters[] = $v[2];
                }
            }else{
                // TODO 多组where处理
            }

        }
        return $s;
    }

    function where($column, $operator = null, $value = null, $boolean = 'and', $group = 0)
    {
        if(is_array($column)){
            foreach ($column as $item){
                if (empty($item[3])){
                    $this -> where($item[0], $item[1], $item[2]);
                }else
                {
                    $this -> where($item[0], $item[1], $item[2], $item[3]);
                }

            }
            return $this;
        }


        $this -> wheres[$group][] = [
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
        $statement = $this->pdo->prepare($this -> sql);
        $statement->execute($this -> parameters);

        $this -> clearFilter();

        return $statement;
    }

    function select()
    {
        return $this -> parseSelect() -> query() -> fetchAll(PDO::FETCH_ASSOC);
    }
    function delete()
    {
        return $this -> parseDelete() -> query() -> rowCount();
    }
    function insert($data)
    {
        $this -> parseInsert($data) -> query();
        return $this -> pdo -> lastInsertId();
    }
    function update($data)
    {
        return $this -> parseUpdate($data) -> query() -> rowCount();
    }

}
