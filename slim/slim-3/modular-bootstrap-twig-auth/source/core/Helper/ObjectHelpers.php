<?php
/*
 * Common methods.
 */
namespace Spectre\Helper;

// droplet - a small drop of liquid
// snippet - a small and often interesting piece of news, information, or conversation
// driblet - a thin stream or small drop of liquid
// flake - a small, thin piece of something, especially if it has come from a surface covered with a layer of something
trait ObjectHelpers
{
    /*
     * examine whether an object is empty or not.
     * @param object $input
     * @return boolean
     */
    function objectHasProperty($input)
    {
        return (is_object($input) && (count(get_object_vars($input)) > 0)) ? true : false;
    }

    /*
     * examine whether an object's propeties is empty or not.
     * @param object $input
     * @return boolean
     */
    function objectPropertyHasValue($input)
    {
        return (is_object($input) && count(array_filter(get_object_vars($input))) > 0) ? true : false;
    }

    /*
     * move the data up to become the part of the properties of this class.
     * @param object $input
     */
    function dataToProperty($input)
    {
        // Convert the object to an array.
        if(is_object($input))
        {
            $input = $this->objectToArray($input);
        }

        // Make sure the input is an array.
        if(is_array($input))
        {
            foreach($input as $key => $value)
            {
                $this->{$key} = $this->arrayToObject($value);
            }
        }
        else
        {
            return $input;
        }

    }

    /*
     * set property's value by using array as parameter.
     * @param array $input
     * @param array $search
     * @return object
     */
    function setObjectProperty($input = [], $search = [])
    {
        //return isset($object->$key) && $object->$key ? $object->$key : null;

        // Make sure the input is an array.
        if(!is_array($input))
            $input = self::objectToArray($input);

        // Loop the search.
        foreach ($search as $key => $value)
        {
            // Check if the value is not an array then set it as a parent.
            if(!is_array($value)) $parent = $value;
            //var_dump($parent);

            if(is_array($value))
            {
                // Make recursive if the value is an array.
                $output = (isset($input[$parent]) && $input[$parent]) ? self::setObjectProperty($input[$parent], $value) : null;
                /*
                if(isset($input[$parent]) && $input[$parent])
                        $output = setObjectProperty($input[$parent], $value);
                else
                        $output = null;
                */
            }
            else if(isset($input[$value]) && $input[$value])
            {
                $output = $input[$value];
            }
            else
            {
                $output = null;
            }
        }

        // Return the outset as an object.
        return self::arrayToObject($output);

    }

    /*
     * converting stdclass objects to multidimensional arrays.
     * @source: http://stackoverflow.com/questions/10029883/how-to-convert-the-object-back-to-an-array
     * @param object $object
     * @return array $array
     */
    public function objectToArray($object)
    {
        //return json_decode(json_encode($object), true);

        if(!is_object($object)) {
            return $object;
        }

        $array = [];

        foreach($object as $key => $value){

            $key = (string) $key ;
            $array[$key] = is_object($value) ? self::objectToArray($value) : $value;
        }

        return $array;
    }

    /*
     * converting an object into string by joining the items with ','.
     * @param object $object
     * @return string
     */
    public function objectToString($object)
    {
        if(!is_object($object))
        {
            return $object;
        }

        return implode(", ", self::objectToArray($object));
    }

    /*
     * reset/clear an object's props.
     */
    function resetObjectProperty()
    {
        foreach ($this as &$value)
        {
            $value = null;
        }
    }

    /*
     * Reset/clear an object.
     */
    function resetObject()
    {
        foreach ($this as $key => $value)
        {
            unset($this->$key);
        }
    }
}
