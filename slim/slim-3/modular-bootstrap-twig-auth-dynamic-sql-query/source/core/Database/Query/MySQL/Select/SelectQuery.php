<?php
namespace Spectre\Database\Query\MySQL\Select;

use Spectre\Database\Query\AbstractQuery;
use Spectre\Strategy\QueryStrategy;

class SelectQuery extends AbstractQuery
{
    /**
     * [$selects description]
     * @var array
     */
    protected $selects = [];

    /**
     * [select description]
     * @param  [type] $field [description]
     * @param  [type] $as    [description]
     * @return [type]        [description]
     */
    public function select($field, $as = null)
    {
        if ($as !== null) {
            $field = $field . " AS {$as} ";
        }

        array_push($this->selects, $field);

        if (count($this->selects) > 1) {
            $this->query .= ", {$field} ";
        } else {
            $this->query .= " SELECT {$field} ";
        }

        return $this;
    }

    /**
     * [from description]
     * @param  [type] $table [description]
     * @param  [type] $as    [description]
     * @return [type]        [description]
     */
    public function from($table, $as = null)
    {
        if ($as !== null) {
            $this->query .= " FROM {$table} AS {$as} ";
        } else {
            $this->query .= " FROM {$table} ";
        }

        return $this;
    }

    /**
     * [nestFrom description]
     * @param  [type] $query [description]
     * @param  [type] $as    [description]
     * @return [type]        [description]
     */
    public function nestFrom(QueryStrategy $query, $as)
    {
        $params = $query->getParams();
        $query = $query->getQuery();
        $this->query .= " FROM ({$query}) {$as} ";

        if (count($this->params) > 0) {
            $this->params = array_merge($this->params, $params);
        } else {
            $this->params = $params;
        }

        return $this;
    }

    /**
     * [innerJoin description]
     * @param  [type] $table [description]
     * @param  [type] $on    [description]
     * @return [type]        [description]
     */
    public function innerJoin($table, $on)
    {
        $this->query .= " INNER JOIN {$table} ON {$on} ";

        return $this;
    }

    /**
     * [leftJoin description]
     * @param  [type] $table [description]
     * @param  [type] $as    [description]
     * @return [type]        [description]
     */
    public function leftJoin($table, $as = null)
    {
        if ($as !== null) {
            $this->query .= " LEFT JOIN {$table} AS {$as} ";
        } else {
            $this->query .= " LEFT JOIN {$table} ";
        }

        return $this;
    }

    /**
     * [nestLeftJoin description]
     * @param  QueryStrategy $query [description]
     * @param  [type]        $as    [description]
     * @return [type]               [description]
     */
    public function nestLeftJoin(QueryStrategy $query, $as)
    {
        $params = $query->getParams();
        $query = $query->getQuery();
        $this->query .= " LEFT JOIN ({$query}) {$as} ";

        if (count($this->params) > 0) {
            $this->params = array_merge($this->params, $params);
        } else {
            $this->params = $params;
        }

        return $this;
    }

    /**
     * [rightJoin description]
     * @param  [type] $table [description]
     * @param  [type] $on    [description]
     * @return [type]        [description]
     */
    public function rightJoin($table, $on)
    {
        $this->query .= " RIGHT JOIN {$table} ON {$on} ";

        return $this;
    }

    /**
     * [fullJoin description]
     * @param  [type] $table [description]
     * @param  [type] $on    [description]
     * @return [type]        [description]
     */
    public function fullJoin($table, $on)
    {
        $this->query .= " FULL OUTER {$table} ON {$on} ";

        return $this;
    }

    /**
     * [union description]
     * @return [type] [description]
     */
    public function union()
    {
        $this->query .= " UNION ";

        return $this;
    }

    /**
     * [like description]
     * @param  [type] $pattern [description]
     * @return [type]          [description]
     */
    public function like($pattern)
    {
        $this->query .= " LIKE {$pattern} ";

        return $this;
    }

    /**
     * [in description]
     * @param  [type] $list [description]
     * @return [type]       [description]
     */
    public function in($list)
    {
        $this->query .= " IN ({$list}) ";

        return $this;
    }

    /**
     * [on description]
     * @param  [type] $column1  [description]
     * @param  [type] $operator [description]
     * @param  [type] $column2  [description]
     * @return [type]           [description]
     */
    public function on($column1, $operator, $column2)
    {
        $this->query .= " ON {$column1} {$operator} {$column2} ";

        return $this;
    }

    /**
     * [joinAnd description]
     * @note: 'and' is a php reserved keyword, so you can't use and as the function name.
     * @ref: http://php.net/manual/en/reserved.keywords.php
     * @param  [type] $column1  [description]
     * @param  [type] $operator [description]
     * @param  [type] $column2  [description]
     * @return [type]           [description]
     */
    public function joinAnd($column1, $operator, $column2)
    {
        $this->query .= " AND {$column1} {$operator} {$column2} ";

        return $this;
    }

    /**
     * An alternative for joinAnd and on methods by providing your own syntax: ON, AND.
     * @param  [type] $syntax   [description]
     * @param  [type] $column1  [description]
     * @param  [type] $operator [description]
     * @param  [type] $column2  [description]
     * @return [type]           [description]
     */
    public function join($syntax, $column1, $operator, $column2)
    {
        $this->query .= " {$syntax} {$column1} {$operator} {$column2} ";

        return $this;
    }

    /**
     * [orderBy description]
     * @param  [type] $condition [description]
     * @return [type]      [description]
     */
    public function orderBy($condition)
    {
        $this->query .= " ORDER BY {$condition} ";

        return $this;
    }

    /**
     * [groupBy description]
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function groupBy($condition)
    {
        $this->query .= " GROUP BY {$condition} ";

        return $this;
    }

    /**
     * [limit description]
     * @param  [type] $number [description]
     * @param  [type] $offset [description]
     * @return [type]         [description]
     */
    public function limit($number, $offset = null)
    {
        if ($offset !== null) {
            $this->query .= " LIMIT {$offset}, {$number} ";
        } else {
            $this->query .= " LIMIT {$number} ";
        }

        return $this;
    }
}
