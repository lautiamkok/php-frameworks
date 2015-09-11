<?php

use Zend\Config\Factory as ConfigFactory;

return ConfigFactory::fromFiles(
    glob('config/autoload/dependencies.{global,local}.php', GLOB_BRACE)
);
