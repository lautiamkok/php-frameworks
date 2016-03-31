<?php
namespace Spectre\Strategy;

interface ModelStrategy
{
    public function setOptions(array $params);
    public function toArray();
}
