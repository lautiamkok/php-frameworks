<?php
namespace Spectre\Database\Query\MySQL\Update;

use Spectre\Database\Query\AbstractQuery;

class UpdateQuery extends AbstractQuery
{
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
}
