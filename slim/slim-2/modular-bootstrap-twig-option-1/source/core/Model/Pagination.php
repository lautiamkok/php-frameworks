<?php
/*
 * The class for creating a pagination.
 */
class Pagination
{
	
	/*
	 * Set the property.
	 */
	public $content;
		
	/*
	 * receive the supplied string.
	 * @content string $content
	 * @return string
	 */
	public function __construct()
	{
		//$this->content = $content;
	}
	
	/*
	 * Make a pagination.
	 *
	 * @param integer $total_items_per_target / Grand total items in the db.
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
	 * @usage 1: echo $pagination->create_pagination($total_items_per_target, $maximum_pages_per_set, $maximun_items_per_page, $current_page, $path_page, array(' &#183; ', ' &gt; ', ' &lt; '));
	 * @usage 2: echo $pagination->create_pagination($total_items_per_target, $maximum_pages_per_set, $maximun_items_per_page, $current_page, $path_page, array('ul' => 'pagination pagination-tours'), false, false, false);
	 * @usage 3: echo $pagination->create_pagination($total_items_per_target, $maximum_pages_per_set, $maximun_items_per_page, $current_page, $path_page);
	 */
	public function create
	(
		$total_items_per_target, 
		$maximum_pages_per_set, 
		$maximun_items_per_page, 
		$current_page, 
		$path_page, 
		$classnames = [], 
		$separators = [], 
		$first_page = true, 
		$last_page = true
	)
	{
		
		# Set the variable.
		$separator_middle = null;
		$separator_next = null;
		$separator_previous = null;
		
		# Set the default value.
		$classname_ul = 'pagination';
		$classname_button_current = 'current-pagination';
		$classname_button_first_page = 'button-first-page';
		$classname_button_last_page = 'button-last-page';
		$classname_button_previous_set = 'button-previous-set';
		$classname_button_next_set = 'button-next-set';

		# Check if $separators is not null
		if($separators) 
		{	
			$separator_middle = $separators[0];
			$separator_next = $separators[1];
			$separator_previous = $separators[2];
		}
		
		# Check if the array and the array key are given.
		if($classnames && isset($classnames['ul'])) 
			$classname_ul = $classnames['ul'];
			
		if($classnames && isset($classnames['current'])) 
			$classname_button_current = $classnames['current'];
			
		if($classnames && isset($classnames['first page'])) 
			$classname_button_first_page = $classnames['first page'];
			
		if($classnames && isset($classnames['last page'])) 
			$classname_button_last_page = $classnames['last page'];
			
		if($classnames && isset($classnames['previous set'])) 
			$classname_button_previous_set = $classnames['previous set'];
			
		if($classnames && isset($classnames['next set'])) 
			$classname_button_next_set = $classnames['next set'];
		
		# Count total pages
		$total_pages = ceil($total_items_per_target/$maximun_items_per_page);
		
		# Count total sets
		$total_sets = ceil($total_pages/$maximum_pages_per_set);
		
		$firstset = 1;
		$firstpage = 1;
		$lastset = $total_sets;
		$lastpage = $total_pages;
		
		# Get the last page in a set.
		if($maximum_pages_per_set < $total_pages) $lastcurrent_pageset = $maximum_pages_per_set;
			else $lastcurrent_pageset = $total_pages;

		# Get the current set.
		if (isset($_GET['set'])) $current_set = $_GET['set'];
			else $current_set = 1;
		
		# Create the HTML list:
		# Open the HTML.
		$output = '<ul class="'.$classname_ul.'">
		';
		
		# Part 1:
		# Create the back button to go back to the previous set.
		if($current_set > 1)
		{ 
			
			if($first_page) $output .= '<li><a href="'. $path_page .'set='. $firstset .'&amp;page='. $firstpage .'"  class="'.$classname_button_first_page.'" title="First page">'.$separator_previous.'First</a></li>
			'; # A new line or "\n".
			
			# the start page in the next set
			$firstcurrent_pageset = (($current_set * $maximum_pages_per_set) - $maximum_pages_per_set) + 1;
			
			$firstpage_previousset = $firstcurrent_pageset - $maximum_pages_per_set;
			
			$output .= '<li><a href="'. $path_page .'set='. ($current_set-1) .'&amp;page='. ($firstpage_previousset) .'" class="'.$classname_button_previous_set.'" title="Previous set">'.$separator_previous.'Previous Set'.$separator_middle.'</a></li>
			'; # A new line or "\n".
		}

		# part 2:
		# Create the number of pages.
		if (isset($_GET['set']))
		{
			# Get the current set
			$current_set = $_GET['set'];
			
			# The start page in the next set
			$firstcurrent_pageset = (($current_set * $lastcurrent_pageset) - $lastcurrent_pageset) + 1;

			# The last page in this current set
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
		//echo $current_page;
		
		# Loop the pages	
		for($article_number = $firstcurrent_pageset ; $article_number <= $lastcurrent_pageset; $article_number ++)
		{ 
			# Check if array $separators is not empty and set it to null if it is at the last page current set.
			if($separators && $article_number == $lastcurrent_pageset) $separator_middle = null;
			
			# Set the variable.
			$class = null;
			
			# Check if there is a match.
			if ($current_page == $article_number) $class = ' class="'.$classname_button_current.'"';
			
			# Store the loop.
			$output .= '<li><a href="'. $path_page .'set='. $current_set .'&amp;page='. $article_number .'"'. $class .' title="Page '.$article_number.'">'. $article_number .$separator_middle.'</a></li>
			'; # A new line or "\n".
		} 
		
		# Part 3:
		# Create the next set button.
		if($total_sets > 1 && $current_set < $total_sets)
		{ 
			# Check if array $separators is not empty and get the value of $separator_middle back from it.
			if($separators) $separator_middle = $separators[0];
			
			$firstpage_nextset = ($current_set * $maximum_pages_per_set) + 1;
			
			$output .=  '<li><a href="'.$path_page.'set='.($current_set + 1).'&amp;page='.($firstpage_nextset).'" class="'.$classname_button_next_set.'" title="Next set">'.$separator_middle.'Next Set'.$separator_next.'</a></li>
			'; # A new line or "\n".
			
			if($last_page) $output .=  '<li><a href="'.$path_page.'set='.$lastset.'&amp;page='.$lastpage.'" class="'.$classname_button_last_page.'" title="Last page">Last'.$separator_next.'</a></li>
			'; # A new line or "\n".
		}

		# Closing the HTML.
		$output .=  '</ul>';	
		
		# Output the HTML.
		return $output;
	}
	
}
