<?php
namespace Barium\Model;

use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

/*
 * The class for creating a pagination.
 */
class PagerModel
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;
    	
    /*
     * Set the property.
     */
    public $html;

    /*
     * The "create data attribute" action.
     */
    public function dataAttribute($attributes, $options = [])
    {
        // Set vars.
        $defaults = array(
            "suffix"   =>  null
     );
        $output = null;

        // Call internal method to process the array.
        $merged = $this->arrayMergeValues($defaults, $options);

        // Convert array to object.
        $property = $this->arrayToObject($merged);
        
        // Loop the attributes and add the suffix at the end of the string.
        foreach($attributes as $key => $value)
        {
            $output .= ' '.$key.'="'.$value.$property->suffix.'" ';
        }
        
        // Return the joined data attributes as a string.
        // Strip extra white space - only a single white space is allowed
        return preg_replace('/\s\s+/', ' ', $output);
    }

    /*
     * The "render html" action.
     *
     * @param integer $property->totalItems / Grand total items in the db.
     * @param integer $maximum_pages_per_set / Maximum pages per set.
     * @param integer $maximun_items_per_page / Maximum items per page.
     * @param integer $current_page / Current page.
     * @param string $path_page / Page's root path.
     * @param array $separators / Must be 3 items in the array -> $separators[0], $separators[1], $separators[3]; [0] -> middledot, [1] -> next, [2] -> previous
     * @param array $classnames / Must provide array keys -> array('ul' => 'pagination pagination-tours').
     * @param boolean first_page / Default is true.
     * @param boolean last_page / Default is true.
     *
     * @return html $output
     *
     * @usage 1: echo $pagination->create_pagination($property->totalItems, $property->maxPagePerSet, $property->maxItemPerPage, $property->currentPage, $property->buttonPath, array(' &//183; ', ' &gt; ', ' &lt; '));
     * @usage 2: echo $pagination->create_pagination($property->totalItems, $property->maxPagePerSet, $property->maxItemPerPage, $property->currentPage, $property->buttonPath, array('ul' => 'pagination pagination-tours'), false, false, false);
     * @usage 3: echo $pagination->create_pagination($property->totalItems, $property->maxPagePerSet, $property->maxItemPerPage, $property->currentPage, $property->buttonPath);
     */
    public function renderHtml($options)
    {

        // Set defaults.
        $defaults = array(
            "totalItems"                    =>  null, 
            "maxPagePerSet"                 =>  null, 
            "maxItemPerPage"                =>  null, 
            "currentPage"                   =>  null, 
            "buttonPath"                    =>  null, 
            "buttonTitleAttribute"      =>  array(
                "firstPage"             =>  "First Page", 
                "previousSet"           =>  "Previous Set", 
                "pageNumber"            =>  "Page ", 
                "pageNumber"            =>  "Page ", 
                "nextSet"               =>  "Next Set", 
                "lastPage"              =>  "Last Page"
         ), 
            "buttonDataAttributes"          =>  [], 
            "buttonDataAttributesSuffix"    =>  [], 
            "firstPage"                     =>  true, 
            "lastPage"                      =>  true, 
            "classNames"                    =>  [], 
            "separators"                    =>  [], 
     );

        // Call internal method to process the array.
        $merged = $this->arrayMergeValues($defaults, $options);

        // Convert array to object.
        $property = $this->arrayToObject($merged);

        // Set the variable.
        $separator_middle = null;
        $separator_next = null;
        $separator_previous = null;

        // Set the default value.
        $classname_ul = 'pagination';
        $classname_button_current = 'current-pagination';
        $classname_button_first_page = 'button-first-page';
        $classname_button_last_page = 'button-last-page';
        $classname_button_previous_set = 'button-previous-set';
        $classname_button_next_set = 'button-next-set';

        // Set attribute.
        $attribute_data = null;
        
        // A tester.
        if($this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false)
        {
             //print_r($property->buttonTitleAttribute->firstPage);
        }
        
        // Count total pages
        $total_pages = ceil($property->totalItems/$property->maxItemPerPage);

        // Count total sets
        $total_sets = ceil($total_pages/$property->maxPagePerSet);

        $firstset = 1;
        $firstpage = 1;
        $lastset = $total_sets;
        $lastpage = $total_pages;

        // Get the last page in a set.
        if($property->maxPagePerSet < $total_pages) $lastcurrent_pageset = $property->maxPagePerSet;
            else $lastcurrent_pageset = $total_pages;

        // Get the current set.
        if (isset($_GET['set'])) $current_set = $_GET['set'];
            else $current_set = 1;

        // Create the HTML list:
        // Open the HTML.
        $output = '<ul class="'.$classname_ul.'">
        ';

        // Part 1:
        // Create the back button to go back to the previous set.
        if($current_set > 1)
        { 
            if($property->firstPage) 
            {
                // Set data attribute.
                // Make sure 'buttonDataAttributesSuffix' has items in it.
                if($this->objectHasProperty($property->buttonDataAttributesSuffix) === true)
                {
                     //print_r($property->buttonDataAttributesSuffix);
                     $attribute_data = $this->dataAttribute($property->buttonDataAttributesSuffix, array(
                         "suffix"   =>  'set='. ($firstset) .'&amp;page='. $firstpage
                  ));
                }
                
                // Make title attribute to the button.
                $attribute_title = $this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false ? ' title="'.$property->buttonTitleAttribute->firstPage.'"' : null;
                
                // Output the first part.
                $output .= '<li><a href="'. $property->buttonPath .'set='. $firstset .'&amp;page='. $firstpage .'" class="'.$classname_button_first_page.'"'.$attribute_title.$attribute_data.'>'.$separator_previous.'First</a></li>
            '; // A new line or "\n".
            }
            
            // the start page in the next set
            $firstcurrent_pageset = (($current_set * $property->maxPagePerSet) - $property->maxPagePerSet) + 1;

            $firstpage_previousset = $firstcurrent_pageset - $property->maxPagePerSet;
            
            // Set data attribute.
            // Make sure 'buttonDataAttributesSuffix' has items in it.
            if($this->objectHasProperty($property->buttonDataAttributesSuffix) === true)
            {
                 //print_r($property->buttonDataAttributesSuffix);
                 $attribute_data = $this->dataAttribute($property->buttonDataAttributesSuffix, array(
                     "suffix"   =>  'set='. ($current_set-1) .'&amp;page='. ($firstpage_previousset)
              ));
            }
            
            // Make title attribute to the button.
            $attribute_title = $this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false ? ' title="'.$property->buttonTitleAttribute->previousSet.'"' : null;
                
            $output .= '<li><a href="'. $property->buttonPath .'set='. ($current_set-1) .'&amp;page='. ($firstpage_previousset) .'" class="'.$classname_button_previous_set.'"'.$attribute_title.$attribute_data.'>'.$separator_previous.'Previous Set'.$separator_middle.'</a></li>
            '; // A new line or "\n".
        }

        // part 2:
        // Create the number of pages.
        if (isset($_GET['set']))
        {
            // Get the current set
            $current_set = $_GET['set'];

            // The start page in the next set
            $firstcurrent_pageset = (($current_set * $lastcurrent_pageset) - $lastcurrent_pageset) + 1;

            // The last page in this current set
            $lastcurrent_pageset = ($current_set * $lastcurrent_pageset);

            if($lastcurrent_pageset < $total_pages)
            {
                $lastcurrent_pageset = $lastcurrent_pageset;
            }
            else
            {
                $lastcurrent_pageset = $total_pages;
            }
        }
        else
        {
            $firstcurrent_pageset = 1;
        }

        //echo $firstcurrent_pageset;
        //echo $lastcurrent_pageset;
        //echo $property->currentPage;

        // Loop the pages	
        for($article_number = $firstcurrent_pageset ; $article_number <= $lastcurrent_pageset; $article_number ++)
        { 
            // Check if array $property->separators is not empty and set it to null if it is at the last page current set.
            if($property->separators && $article_number == $lastcurrent_pageset) $separator_middle = null;

            // Set the variable.
            $class = null;

            // Check if there is a match.
            if ($property->currentPage == $article_number) $class = ' class="'.$classname_button_current.'"';

            // Set data attribute.
            // Make sure 'buttonDataAttributesSuffix' has items in it.
            if($this->objectHasProperty($property->buttonDataAttributesSuffix) === true)
            {
                 //print_r($property->buttonDataAttributesSuffix);
                 $attribute_data = $this->dataAttribute($property->buttonDataAttributesSuffix, array(
                     "suffix"   =>  'set='. $current_set .'&amp;page='. $article_number
              ));
            }
            
            // Make title attribute to the button.
            $attribute_title = $this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false ? ' title="'.$property->buttonTitleAttribute->pageNumber.' '.$article_number.'"' : null;

            // Store the loop.
            $output .= '<li><a href="'. $property->buttonPath .'set='. $current_set .'&amp;page='. $article_number .'"'. $class . $attribute_title . $attribute_data.'>'. $article_number .$separator_middle.'</a></li>
            '; // A new line or "\n".
        } 

        // Part 3:
        // Create the next set button.
        if($total_sets > 1 && $current_set < $total_sets)
        { 
            // Check if array $property->separators is not empty and get the value of $separator_middle back from it.
            //if($property->separators) $separator_middle = $property->separators[0];

            $firstpage_nextset = ($current_set * $property->maxPagePerSet) + 1;

            // Set data attribute.
            // Make sure 'buttonDataAttributesSuffix' has items in it.
            if($this->objectHasProperty($property->buttonDataAttributesSuffix) === true)
            {
                 //print_r($property->buttonDataAttributesSuffix);
                 $attribute_data = $this->dataAttribute($property->buttonDataAttributesSuffix, array(
                     "suffix"   =>  'set='. ($current_set + 1) .'&amp;page='. $firstpage_nextset
              ));
            }
            
            // Make title attribute to the button.
            $attribute_title = $this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false ? ' title="'.$property->buttonTitleAttribute->nextSet.'"' : null;

            $output .=  '<li><a href="'.$property->buttonPath.'set='.($current_set + 1).'&amp;page='.($firstpage_nextset).'" class="'.$classname_button_next_set.'"'.$attribute_title.$attribute_data.'>'.$separator_middle.'Next Set'.$separator_next.'</a></li>
            '; // A new line or "\n".

            if($property->lastPage) 
            {
                // Set data attribute.
                // Make sure 'buttonDataAttributesSuffix' has items in it.
                if($this->objectHasProperty($property->buttonDataAttributesSuffix) === true)
                {
                     //print_r($property->buttonDataAttributesSuffix);
                     $attribute_data = $this->dataAttribute($property->buttonDataAttributesSuffix, array(
                         "suffix"   =>  'set='. $lastset .'&amp;page='. $lastpage
                  ));
                }
                
                // Make title attribute to the button.
                $attribute_title = $this->objectHasProperty($property->buttonTitleAttribute) === true && @$options['buttonTitleAttribute'] !== false ? ' title="'.$property->buttonTitleAttribute->lastPage.'"' : null;

                $output .=  '<li><a href="'.$property->buttonPath.'set='.$lastset.'&amp;page='.$lastpage.'" class="'.$classname_button_last_page.'"'.$attribute_title.$attribute_data.'>Last'.$separator_next.'</a></li>
            '; // A new line or "\n".   
            }

        }

        // Closing the HTML.
        $output .=  '</ul>';	

        // Output the HTML.
        return $output;
    }	
}
