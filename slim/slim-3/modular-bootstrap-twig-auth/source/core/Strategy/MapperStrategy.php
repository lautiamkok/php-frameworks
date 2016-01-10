<?php
namespace Barium\Strategy;

use Barium\Strategy\ModelStrategy;

interface MapperStrategy
{
    public function mapObject(ModelStrategy $model, array $row);
}
