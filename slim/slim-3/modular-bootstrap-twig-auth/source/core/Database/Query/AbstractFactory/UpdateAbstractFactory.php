<?php
namespace Spectre\Database\Query\AbstractFactory;

use Spectre\Database\Query\AbstractQuery;

class UpdateAbstractFactory extends AbstractQuery
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
