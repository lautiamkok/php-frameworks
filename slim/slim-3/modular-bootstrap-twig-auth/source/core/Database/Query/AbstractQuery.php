<?php
namespace Spectre\Database\Query;

use Spectre\Strategy\QueryStrategy;

abstract class AbstractQuery implements QueryStrategy
{
    /**
     * [$query description]
     * @var [type]
     */
    protected $query;

    /**
     * [$params description]
     * @var array
     */
    protected $params = [];

    /**
     * [$columns description]
     * @var array
     */
    protected $columns = [];

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
     * [where description]
     * @param  [type] $column   [description]
     * @param  [type] $operator [description]
     * @param  [type] $value    [description]
     * @return [type]           [description]
     */
    public function where($column, $operator, $value)
    {
        array_push($this->columns, $column);
        array_push($this->params, $value);

        if (count($this->columns) > 1) {
            $this->query .= " AND {$column} {$operator} ? ";
        } else {
            $this->query .= " WHERE {$column} {$operator} ? ";
        }

        return $this;
    }

    /**
     * [whereWithKey description]
     * @param  [type] $column   [description]
     * @param  [type] $operator [description]
     * @param  [type] $key      [description]
     * @param  [type] $value    [description]
     * @return [type]           [description]
     */
    public function whereWithKey($column, $operator, $key, $value)
    {
        // Push without a key.
        array_push($this->columns, $column);

        // Push with a key.
        $this->params[$key] = $value;

        if (count($this->columns) > 1) {
            $this->query .= " AND {$column} {$operator} {$key}";
        } else {
            $this->query .= " WHERE {$column} {$operator} {$key}";
        }

        return $this;
    }

    /**
     * [set description]
     * @param [type] $set   [description]
     * @param [type] $value [description]
     */
    public function set($set, $value)
    {
        array_push($this->sets, $set);
        array_push($this->params, $value);

        if (count($this->sets) > 1) {
            $this->query .= " , {$set}";
        } else {
            $this->query .= " SET {$set}";
        }

        return $this;
    }

    /**
     * [setWithKey description]
     * @param [type] $set   [description]
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    public function setWithKey($set, $key, $value)
    {
        // Push without a key.
        array_push($this->sets, $set);

        // Push with a key.
        $this->params[$key] = $value;

        if (count($this->sets) > 1) {
            $this->query .= " , {$set} {$key}";
        } else {
            $this->query .= " SET {$set} {$key}";
        }

        return $this;
    }
}
