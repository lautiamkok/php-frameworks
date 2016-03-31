<?php

namespace Spectre\Helper;

trait StringHelpers
{
    /*
    * limit the lenght of the string
    * @return string $output
    */
    function limitStringLength($string, $limit, $text = null)
    {
        // strip all the html tags in the string
        $output = strip_tags($string);

        // count the length of the string
        $length = strlen($output);

        // check if the length of the string is more than the limit
        if ($length > $limit) {

            // limit the length of the string in the output
            $output = substr($output, 0, $limit);

            $last_space = strrpos($output, ' ');

            // add dots at the end of the output
            $output = substr($output, 0, $last_space);

            // remove any punctuation marks at the end of the out and add the periods
            if($text) {
                $output = preg_replace("/\W+$/", "", $output).'...'.$text;
            } else {
                $output = preg_replace("/\W+$/", "", $output).'...';
            }
        }

       // return the result
       return $output;

   }

}
