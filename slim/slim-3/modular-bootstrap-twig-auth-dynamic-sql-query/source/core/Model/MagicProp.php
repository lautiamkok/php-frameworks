<?php
namespace Spectre\Model;

/*
 * Set the inaccesible prop magically.
 */
class MagicProp
{
    // Get the name of the inaccesible prop.
    public function __get($name)
    {
        // Set the inaccesible prop.
        isset($this->$name) === false ? $this->$name = null : $this->$name;

        // Legacy:
        //return (isset($this->$name)) ? $this->$name : null;
    }
}
