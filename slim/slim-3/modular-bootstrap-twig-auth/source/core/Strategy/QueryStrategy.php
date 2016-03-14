<?php
namespace Spectre\Strategy;

interface QueryStrategy
{
    public function getQuery();
    public function getParams();
}
