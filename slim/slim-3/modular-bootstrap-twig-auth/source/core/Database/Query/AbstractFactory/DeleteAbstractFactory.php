<?php
namespace Spectre\Database\Query\AbstractFactory;

use Spectre\Database\Query\AbstractQuery;

class DeleteAbstractFactory extends AbstractQuery
{
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
