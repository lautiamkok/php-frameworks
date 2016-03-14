<?php
/*
 * Common methods.
 */
namespace Spectre\Helper;

use Spectre\Model\MagicProp;

// droplet - a small drop of liquid
// snippet - a small and often interesting piece of news, information, or conversation
// driblet - a thin stream or small drop of liquid
// flake - a small, thin piece of something, especially if it has come from a surface covered with a layer of something
trait ArrayHelpers
{
    /*
     * check there is a value exists in a key in a nested array.
     * @reference: http://stackoverflow.com/questions/13372712/how-to-check-there-is-a-value-exists-in-a-key-in-a-nested-array/
     * @param array $input
     * @return boolean
     */
    public function arrayKeyHasValue($input = [], $unset = [])
    {
        // Make sure all items in $input are in arrays.
        $input = is_object($input) ? self::objectToArray($input) : $input;

        // If unset array is provided.
        if(count($unset) > 0){
            $input = self::popArrayKey($input, $unset);
        }

        // Loop the array.
        foreach($input as $key => $value){
            if($value && !is_array($value)){
                return true;
            } elseif(is_array($value)){
                if(self::arrayKeyHasValue($value)) {
                    return true;
                }
            } elseif($value) {
                return true;
            }
        }

        /*
        // Loop the array.
        foreach($input as $key => $value)
        {
                if (isset($value))
                {
                        if (is_array($value))
                        {
                                if (self::arrayKeyHasValue($value))
                                {
                                        return true;
                                }
                        }
                        elseif($value)
                        {
                                return true;
                        }
                }
        }
        */

        // Return the result.
        return false;
    }

    /*
     * check there is a value exists in a key in a nested array.
     * @reference: http://stackoverflow.com/questions/13372712/how-to-check-there-is-a-value-exists-in-a-key-in-a-nested-array/
     * @param array $input
     * @return boolean
     */
    public function popArrayKey($input = [], $unset = []){

        // Make sure all items in $input are in arrays.
        $input = is_object($input) ? self::objectToArray($input) : $input;

        // If unset array is provided.
        if(count($unset) > 0){

            // Flip the unset keys and values.
            $unset = array_flip($unset);

            // Find unique keys when comparing arrays.
            $input = array_diff_key($input, $unset);
        }

        // Return the result.
        return $input;
    }

    /*
     * process two arrays - $defaults & $options.
     * @param array $defaults
     * @param array $options
     * @return array $array
     * @return array $error
     */
    public function arrayMergeValues($defaults = [], $options = []){

        // Set empty arrays for error & items.
        $error = [];
        $items = [];

        // Make sure all items in $options are in arrays.
        $options = self::objectToArray($options);

        // If the $defaults is empty then just return everything in $options
        if(count($defaults) == 0) return $options;

        // Loop the array.
        foreach($defaults as $key => $value){

            // @note: keep line(s) below for testing purposes.
            // if(is_array($value)) echo count($value).'is an array';

            // Make sure the other developer won't use string or number, for instance, 'truex' or '2' is not acceptable.
            // Accept int 0 or 1 and boolean true or false and also null.
            // @reference: http://stackoverflow.com/questions/12461146/php-filter-var-how-to-make-sure-the-user-provides-correct-data-types-true-or
            // @reference: http://stackoverflow.com/questions/12477095/php-is-null-only-boolean-true-and-false-not-even-null/12477292//12477292
            if (is_bool($defaults[$key]) && array_key_exists($key, $options)){

                //var_dump(filter_var($options[$key], FILTER_VALIDATE_BOOLEAN));
                // Make sure that the value of the key is a boolean.
                if (!is_bool($options[$key]) && filter_var($options[$key], FILTER_VALIDATE_BOOLEAN) === false){

                    // Remove the key value with null.
                    $options[$key] = null;
                    $error[] = '"'. $key.'" can be boolean only.';
                }

                //if ($options[$key] === null) $error[] = '"'. $key.'" cannot be null.';

                // Update the array with the filtered value.
                //$options[$key] = filter_var($options[$key], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                //if ($options[$key] === null) $error[] = '"'. $key.'" can be true or false only';
            }

            // If the default key's value is not an array and this key is present in config's key.
            if(isset($options[$key]) && !is_array($value)){
                $items[$key] = $options[$key];
            } elseif(isset($options[$key]) && is_array($value) && count($value) > 0){ // If the default key's value is an array and it has at least one item in it, re-loop this method.
                $items[$key] = self::arrayMergeValues($value, $options[$key]);
            }
            /* @deprecated on 6 Oct 2012.
            elseif(isset($options[$key]) && is_array($value))
            {
                    $items[$key] = array_merge($defaults[$key], $options[$key]);
            }
            */
            // If the default key's value is an array but nothing in it, take everything from config.
            elseif(isset($options[$key]) && is_array($value) && count($value) == 0){
                $items[$key] = $options[$key];
            } else { // Else use the default key's value.
                $items[$key] = $value;
            }
        }

        // Give a key to the error array.
        $error = array("error" => $error);

        // Merge the processed array with error array.
        // Return the result.
        return array_merge($items, $error);
    }

    /*
     * converting true and false strings to booleans in single or multiple array.
     * @source: http://stackoverflow.com/questions/10437960/how-to-parse-true-and-false-string-in-an-array-to-become-booleans/
     * @param array $array
     * @return array $array
     */
    public function arrayBoolify($array = []){

        // If $array is not an array, let's make it array with one value of former $array.
        if (!is_array($array)) return $array;
        //if (!is_array($array)) return false;

        foreach($array as $key => $value){

            // Use filter_var to convert true and false strings to booleans.
            // @important: Nested ternary operators can cause unexpected results.
            if(in_array($value, array('true', 'false')) && $value !== 0) {
                $array[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            } elseif(is_array($value)) {
                $array[$key] = self::arrayBoolify($value);
            } else {
                $array[$key] = $value;
            }

        }
        return $array;
    }

    /*
     * converting true and false strings to booleans in single or multiple array.
     * @source: http://stackoverflow.com/questions/10457883/converting-json-to-array-with-recursive-method
     * @param array $array
     * @return array $array
     */
    public function jsonmixToArray($array = []) {

        // If $array is not an array, let's make it array with one value of former $array.
        if (!is_array($array)) return $array;
        //if (!is_array($array)) return false;

        foreach($array as $key => $value){

            if(!empty($value) && is_string($value) && !is_numeric($value) && json_decode($value) != NULL) {
                $array[$key] = json_decode($value, true);
            } elseif(is_array($value)) {
                $array[$key] = self::jsonmixToArray($value);
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    /*
     * converting multiple array to object.
     * @source: http://stackoverflow.com/questions/10013143/how-to-access-the-property-value-of-an-array-which-has-been-converted-into-an-o/
     * @param array $array
     * @param boolean $property_overloading
     * @return object $object
     */
    public function arrayToObject($array = [], $property_overloading = true){

        /*
        if(!is_array($array) && !$array == null) return $array;
                elseif($array == null) $array = [];
        */

        // If $array is not an array, let's make it array with one value of former $array.
        if (!is_array($array)) return $array;
        //if (!is_array($array)) return false;

        // Convert json string inside an array into array.
        $array = self::jsonmixToArray($array);

        // Boolify true and false string.
        $array = self::arrayBoolify($array);

        // Use property overloading to handle inaccessible properties, if overloading is set to be true.
        // Else use std object.
        if($property_overloading === true) $object = new MagicProp();
            else $object = new \stdClass();

        foreach($array as $key => $value) {
            $key = (string) $key ;

            // Take 0 as a string of '0'.
            // Take other empty data as null.
            // Loop the method if it is an array.
            if(!is_array($value) && $value == '0') $object->$key = $value;
                else if(!is_array($value) && empty($value)) $object->$key = null;
                    else $object->$key = is_array($value) ? self::arrayToObject($value, $property_overloading) : $value;
        }

        return $object;
    }

    /*
     * converting an array into string by joining the items with ','.
     * @param array $array
     * @return string
     */
    public function arrayToString($array)
    {
        if(!is_array($array))
        {
            return $array;
        }

        return implode(", ", $array);
    }

    /*
     * converting stdclass objects to multidimensional arrays.
     * @source: http://stackoverflow.com/questions/10029883/how-to-convert-the-object-back-to-an-array
     * @param object $object
     * @return array $array
     */
    public function removeArrayNumbericKeys($input = []) {

        //return json_decode(json_encode($object), true);

        if(is_object($input))
        {
            // Make sure all items in $options are in arrays.
            $input = self::objectToArray($input);
        }

        if($input === false || $input === null)
        {
            return null;
        }

        $output = [];

        foreach($input as $key => $value)
        {
            if(is_int($key))
            {
                unset($input[$key]);
            }
            elseif(is_array($value)){
                $output[$key] = self::removeArrayNumbericKeys($value);
            }
            else
            {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    /*
    * sort the array in reverse order and maintain index association when the subkey is in the second level down in the array.
    * @param array $a
    * @param string $subkey
    * @return array $c
    *
    * An example of a multi-dimentional array -
    * $songs =  array(
    * 		'3' => array('artist'=>'The Smashing Pumpkins', 'songname'=>'Soma', 'date' =>1276646720),
    * 		'4' => array('artist'=>'The Decemberists', 'songname'=>'The Island', 'date' =>1276646724),
    * 		'1' => array('artist'=>'Fleetwood Mac', 'songname' =>'Second-hand News', 'date' =>1276646728),
    * 		'2' => array('artist'=>'Jack Johnson', 'songname' =>'Only the Ocean', 'date' =>1276646731)
    * 	);
    *
    * $songs = arsortArraySubValue($songs, 'date');
    * print_r($songs);
    *
    * The example of normal output of $songs multi-dimentional array -
    * 	Array
    * 	(
    * 		[3] => Array
    * 			(
    * 				[artist] => The Smashing Pumpkins
    * 				[songname] => Soma
    * 				[date] => 1276646720
    * 			)
    *
    * 		[4] => Array
    * 			(
    * 				[artist] => The Decemberists
    * 				[songname] => The Island
    * 				[date] => 1276646724
    * 			)
    *
    * 		[1] => Array
    * 			(
    * 				[artist] => Fleetwood Mac
    * 				[songname] => Second-hand News
    * 				[date] => 1276646728
    * 			)
    *
    * 		[2] => Array
    * 			(
    * 				[artist] => Jack Johnson
    * 				[songname] => Only the Ocean
    * 				[date] => 1276646731
    * 			)
    *
    * 	)
    *
    * So, this function reverses the order above into the output below -
    *
    * 	Array
    * 	(
    *    	[2] => Array
    *         	(
    *            [artist] => Jack Johnson
    *            [songname] => Only the Ocean
    *            [date] => 1276646731
    *			)
    *
    *    	[1] => Array
    *        	(
    *            [artist] => Fleetwood Mac
    *            [songname] => Second-hand News
    *            [date] => 1276646728
    *        	)
    *
    *    	[4] => Array
    *        	(
    *            [artist] => The Decemberists
    *            [songname] => The Island
    *            [date] => 1276646724
    *        	)
    *
    *    	[3] => Array
    *        	(
    *            [artist] => The Smashing Pumpkins
    *            [songname] => Soma
    *            [date] => 1276646720
    *        	)
    *	)
    *
    */
    public function sortArraySubValue($a, $subkey){

        // $a is the primary array, $k is key of the second array, $v is the array in $k.
        // [3], [4], [1], [2] are the array keys - $k.


        // Loop the $a array make a new array - $b.
        foreach($a as $k => $v) {

            //loop the new array ($b) with the subkey only and put them in a new array - $b.
            /*
            [artist] => Jack Johnson
            [songname] => Only the Ocean
            [date] => 1276646731

            is the key value - $v.
            */
            $b[$k] = $v[$subkey];
        }

        // Sort the array in reverse order and maintain index association.
        arsort($b);
        /*
        result -
        Array (
                [2] => 1276646731
                [1] => 1276646728
                [4] => 1276646724
                [3] => 1276646720
             )
        */

        // Loop the $b array and make another new array - $c.
        foreach($b as $key => $val) {

            //[3], [4], [1], [2] are the array keys - $key.
            //put the keys in array $c and array $a.
            $c[$key] = $a[$key];
        }

        // Return the new array - $c.
        return $c;
    }

    /*
     * sort the array in reverse order and maintain index association when the subkey is in the third level down in the array.
     * @param array $a
     * @return string $subkey
     */
    public function sortArrayDeep($a, $subkey){

        // Loop the $a array make a new array - $b.
        foreach($a as $k => $v) {

            // Shortern the foreach loop by shifting the array up one level.
            $v = array_shift($v);

            //loop the new array ($b) with the subkey only and put them in a new array - $b.
            $b[$k] = $v[$subkey];
        }

        // Sort the array in reverse order and maintain index association.
        arsort($b);
        /*
        result -
        Array (
                [2] => 1276646731
                [1] => 1276646728
                [4] => 1276646724
                [3] => 1276646720
             )
        */

        // Loop the $b array and make another new array - $c.
        foreach($b as $key => $val) {

            //[3], [4], [1], [2] are the array keys - $key.
            //put the keys in array $c and array $a.
            $c[$key] = $a[$key];
        }

        // Return the new array - $c.
        return $c;
    }
}
