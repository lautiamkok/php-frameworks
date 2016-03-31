<?php
namespace Spectre\Database\Query\MySQL\Delete;

use Spectre\Database\Query\AbstractQuery;

class DeleteQuery extends AbstractQuery
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
