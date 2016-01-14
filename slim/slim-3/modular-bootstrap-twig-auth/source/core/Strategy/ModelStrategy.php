<?php
namespace Barium\Strategy;

interface ModelStrategy
{
    public function setOptions(array $params);
    public function toArray();
}
