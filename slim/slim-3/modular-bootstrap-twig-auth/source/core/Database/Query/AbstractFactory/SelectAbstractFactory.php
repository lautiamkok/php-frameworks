<?php
namespace Spectre\Database\Query\AbstractFactory;

use Spectre\Database\Query\AbstractQuery;

class SelectAbstractFactory extends AbstractQuery
{
    /**
     * [$selects description]
     * @var array
     */
    protected $selects = [];

    /**
     * [select description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    public function select($field)
    {
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
     * @return [type]        [description]
     */
    public function from($table)
    {
        $this->query .= " FROM {$table} ";

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
        $this->query .= " INNER JOIN {$table} ON {$table} ";

        return $this;
    }

    /**
     * [leftJoin description]
     * @param  [type] $table [description]
     * @param  [type] $on    [description]
     * @return [type]        [description]
     */
    public function leftJoin($table, $on)
    {
        $this->query .= " LEFT JOIN {$table} ON {$table} ";

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
        $this->query .= " RIGHT JOIN {$table} ON {$table} ";

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
        $this->query .= " FULL OUTER {$table} ON {$table} ";

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
     * [limit description]
     * @param  [type] $number [description]
     * @return [type]        [description]
     */
    public function limit($number)
    {
        $this->query .= " LIMIT {$number} ";

        return $this;
    }
}
