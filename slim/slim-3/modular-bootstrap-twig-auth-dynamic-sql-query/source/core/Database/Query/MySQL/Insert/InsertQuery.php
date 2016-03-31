<?php
namespace Spectre\Database\Query\MySQL\Insert;

use Spectre\Database\Query\AbstractQuery;

class InsertQuery extends AbstractQuery
{
    /**
     * [insertInto description]
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
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
}
