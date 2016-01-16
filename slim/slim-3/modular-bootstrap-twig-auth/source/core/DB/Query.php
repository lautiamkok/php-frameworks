<?php
namespace Foo;

class Query
{
    /**
     * [$query description]
     * @var [type]
     */
    protected $query;
    protected $params = [];
    protected $selects = [];
    protected $wheres = [];

    /**
     * [$set description]
     * @var array
     */
    protected $sets = [];


    /**
     * [getQuery description]
     * @return [type] [description]
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * [getParams description]
     * @return [type] [description]
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * [select description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function select($sql)
    {
        array_push($this->selects, $sql);

        if (count($this->selects) > 1) {
            $this->query .= ", {$sql} ";
        } else {
            $this->query .= " SELECT {$sql} ";
        }

        return $this;
    }

    /**
     * [from description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function from($sql)
    {
        $this->query .= " FROM {$sql} ";

        return $this;
    }

    /**
     * [where description]
     * @param  [type] $sql   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function where($sql, $value)
    {
        array_push($this->wheres, $sql);
        array_push($this->params, $value);

        if (count($this->wheres) > 1) {
            $this->query .= " AND {$sql}";
        } else {
            $this->query .= " WHERE {$sql}";
        }

        return $this;
    }

    /**
     * [whereWithKey description]
     * @param  [type] $sql   [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function whereWithKey($sql, $key, $value)
    {
        // Push without a key.
        array_push($this->wheres, $sql);

        // Push with a key.
        $this->params[$key] = $value;

        if (count($this->wheres) > 1) {
            $this->query .= " AND {$sql} {$key}";
        } else {
            $this->query .= " WHERE {$sql} {$key}";
        }

        return $this;
    }

    /**
     * [join description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function join($sql)
    {
        $this->query .= " JOIN {$sql} ";

        return $this;
    }

    /**
     * [leftJoin description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function leftJoin($sql)
    {
        $this->query .= " LEFT JOIN {$sql} ";

        return $this;
    }

    /**
     * [orderBy description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function orderBy($sql)
    {
        $this->query .= " ORDER BY {$sql} ";

        return $this;
    }

    /**
     * [limit description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function limit($value)
    {
        $this->query .= " LIMIT {$value} ";

        return $this;
    }

    public function insertInto($table)
    {
        $this->query .= " INSERT INTO {$table} ";

        return $this;
    }

    /**
     * [values description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function values(array $params)
    {
        $keys = [];
        $holders = [];

        foreach ($params as $key => $value) {
            array_push($this->params, $value);
            array_push($keys, $key);
            array_push($holders, '?');;
        }

        $this->query .= ' ( ' . implode(', ', $keys) .' ) ';
        $this->query .= ' VALUES ( ' . implode(', ', $holders) .' ) ';

        return $this;
    }

    /**
     * [update description]
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
    public function update($table)
    {
        $this->query .= " UPDATE {$table} ";

        return $this;
    }

    /**
     * [set description]
     * @param [type] $sql   [description]
     * @param [type] $value [description]
     */
    public function set($sql, $value)
    {
        array_push($this->sets, $sql);
        array_push($this->params, $value);

        if (count($this->sets) > 1) {
            $this->query .= " , {$sql}";
        } else {
            $this->query .= " SET {$sql}";
        }

        return $this;
    }

    /**
     * [setWithKey description]
     * @param [type] $sql   [description]
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    public function setWithKey($sql, $key, $value)
    {
        // Push without a key.
        array_push($this->sets, $sql);

        // Push with a key.
        $this->params[$key] = $value;

        if (count($this->sets) > 1) {
            $this->query .= " , {$sql} {$key}";
        } else {
            $this->query .= " SET {$sql} {$key}";
        }

        return $this;
    }

    /**
     * [deleteFrom description]
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
    public function deleteFrom($table)
    {
        $this->query .= " DELETE FROM {$table} ";

        return $this;
    }
}
