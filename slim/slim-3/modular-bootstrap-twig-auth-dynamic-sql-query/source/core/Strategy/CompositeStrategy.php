<?php
namespace Spectre\Strategy;

interface CompositeStrategy
{
    public function compose($options = []);
}
