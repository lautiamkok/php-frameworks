<?php
/*
 * Common methods.
 */
namespace Spectre\Helper;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

trait ViewHelpers
{
    use ArrayHelpers;
    use ObjectHelpers;

    /*
     * check if the key exists in the array.
     * @param string $key
     * @param array $array
     * @return array
     */
    public function matchHaystackColumn($options = [])
    {
        $defaults = [
            "key"       => null,
            "haystack"  => [],
            "column"    => null
        ];

        // Process and convert.
        $settings = $this->arrayMergeValues($defaults, $options);

        // Check if the input is an object, then convert it into an array.
        if(is_object($settings['haystack']))
        {
            $settings['haystack'] = $this->objectToArray($settings['haystack']);
        }

        // Return true if  key exists in the array's column.
        if(array_search($settings['key'], array_column($settings['haystack'], $settings['column'])) !== false)
        {
            return true;
        }

        // Else return false.
        return false;
    }
}
