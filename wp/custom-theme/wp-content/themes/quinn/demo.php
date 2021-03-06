<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */


add_filter( 'rwmb_meta_boxes', 'quinn_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function quinn_register_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'quinn_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'standard',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Standard Fields', 'quinn_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'post', 'page' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'Text', 'quinn_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}text",
				// Field description (optional)
				'desc'  => __( 'Text description', 'quinn_' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( 'Default text value', 'quinn_' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => true,
			),
			// CHECKBOX
			array(
				'name' => __( 'Checkbox', 'quinn_' ),
				'id'   => "{$prefix}checkbox",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),
			// RADIO BUTTONS
			array(
				'name'    => __( 'Radio', 'quinn_' ),
				'id'      => "{$prefix}radio",
				'type'    => 'radio',
				// Array of 'value' => 'Label' pairs for radio options.
				// Note: the 'value' is stored in meta field, not the 'Label'
				'options' => array(
					'value1' => __( 'Label1', 'quinn_' ),
					'value2' => __( 'Label2', 'quinn_' ),
				),
			),
			// SELECT BOX
			array(
				'name'        => __( 'Select', 'quinn_' ),
				'id'          => "{$prefix}select",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'value1' => __( 'Label1', 'quinn_' ),
					'value2' => __( 'Label2', 'quinn_' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'value2',
				'placeholder' => __( 'Select an Item', 'quinn_' ),
			),
			// HIDDEN
			array(
				'id'   => "{$prefix}hidden",
				'type' => 'hidden',
				// Hidden field must have predefined value
				'std'  => __( 'Hidden value', 'quinn_' ),
			),
			// PASSWORD
			// array(
			// 	'name' => __( 'Password', 'quinn_' ),
			// 	'id'   => "{$prefix}password",
			// 	'type' => 'password',
			// ),
			// TEXTAREA
			array(
				'name' => __( 'Textarea', 'quinn_' ),
				'desc' => __( 'Textarea description', 'quinn_' ),
				'id'   => "{$prefix}textarea",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
			),
		),
		'validation' => array(
			'rules'    => array(
				"{$prefix}password" => array(
					'required'  => true,
					'minlength' => 7,
				),
			),
			// optional override of default jquery.validate messages
			'messages' => array(
				"{$prefix}password" => array(
					'required'  => __( 'Password is required', 'quinn_' ),
					'minlength' => __( 'Password must be at least 7 characters', 'quinn_' ),
				),
			),
		),
	);

	// 2nd meta box
	$meta_boxes[] = array(
		'title' => __( 'Advanced Fields', 'quinn_' ),

		'post_types' => array( 'post', 'page' ),

		'fields' => array(
			// HEADING
			array(
				'type' => 'heading',
				'name' => __( 'Heading', 'quinn_' ),
				'id'   => 'fake_id', // Not used but needed for plugin
				'desc' => __( 'Optional description for this heading', 'quinn_' ),
			),
			// SLIDER
			array(
				'name'       => __( 'Slider', 'quinn_' ),
				'id'         => "{$prefix}slider",
				'type'       => 'slider',

				// Text labels displayed before and after value
				'prefix'     => __( '$', 'quinn_' ),
				'suffix'     => __( ' USD', 'quinn_' ),

				// jQuery UI slider options. See here http://api.jqueryui.com/slider/
				'js_options' => array(
					'min'  => 10,
					'max'  => 255,
					'step' => 5,
				),
			),
			// NUMBER
			array(
				'name' => __( 'Number', 'quinn_' ),
				'id'   => "{$prefix}number",
				'type' => 'number',

				'min'  => 0,
				'step' => 5,
			),
			// DATE
			array(
				'name'       => __( 'Date picker', 'quinn_' ),
				'id'         => "{$prefix}date",
				'type'       => 'date',

				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				'js_options' => array(
					'appendText'      => __( '(yyyy-mm-dd)', 'quinn_' ),
					'dateFormat'      => __( 'yy-mm-dd', 'quinn_' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
				),
			),
			// DATETIME
			array(
				'name'       => __( 'Datetime picker', 'quinn_' ),
				'id'         => $prefix . 'datetime',
				'type'       => 'datetime',

				// jQuery datetime picker options.
				// For date options, see here http://api.jqueryui.com/datepicker
				// For time options, see here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute'     => 15,
					'showTimepicker' => true,
				),
			),
			// TIME
			array(
				'name'       => __( 'Time picker', 'quinn_' ),
				'id'         => $prefix . 'time',
				'type'       => 'time',

				// jQuery datetime picker options.
				// For date options, see here http://api.jqueryui.com/datepicker
				// For time options, see here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute' => 5,
					'showSecond' => true,
					'stepSecond' => 10,
				),
			),
			// COLOR
			array(
				'name' => __( 'Color picker', 'quinn_' ),
				'id'   => "{$prefix}color",
				'type' => 'color',
			),
			// CHECKBOX LIST
			array(
				'name'    => __( 'Checkbox list', 'quinn_' ),
				'id'      => "{$prefix}checkbox_list",
				'type'    => 'checkbox_list',
				// Options of checkboxes, in format 'value' => 'Label'
				'options' => array(
					'value1' => __( 'Label1', 'quinn_' ),
					'value2' => __( 'Label2', 'quinn_' ),
				),
			),
			// AUTOCOMPLETE
			array(
				'name'    => __( 'Autocomplete', 'quinn_' ),
				'id'      => "{$prefix}autocomplete",
				'type'    => 'autocomplete',
				// Options of autocomplete, in format 'value' => 'Label'
				'options' => array(
					'value1' => __( 'Label1', 'quinn_' ),
					'value2' => __( 'Label2', 'quinn_' ),
				),
				// Input size
				'size'    => 30,
				// Clone?
				'clone'   => false,
			),
			// EMAIL
			array(
				'name' => __( 'Email', 'quinn_' ),
				'id'   => "{$prefix}email",
				'desc' => __( 'Email description', 'quinn_' ),
				'type' => 'email',
				'std'  => 'name@email.com',
			),
			// RANGE
			array(
				'name' => __( 'Range', 'quinn_' ),
				'id'   => "{$prefix}range",
				'desc' => __( 'Range description', 'quinn_' ),
				'type' => 'range',
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
				'std'  => 0,
			),
			// URL
			array(
				'name' => __( 'URL', 'quinn_' ),
				'id'   => "{$prefix}url",
				'desc' => __( 'URL description', 'quinn_' ),
				'type' => 'url',
				'std'  => 'http://google.com',
			),
			// OEMBED
			array(
				'name' => __( 'oEmbed', 'quinn_' ),
				'id'   => "{$prefix}oembed",
				'desc' => __( 'oEmbed description', 'quinn_' ),
				'type' => 'oembed',
			),
			// SELECT ADVANCED BOX
			array(
				'name'        => __( 'Select', 'quinn_' ),
				'id'          => "{$prefix}select_advanced",
				'type'        => 'select_advanced',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'value1' => __( 'Label1', 'quinn_' ),
					'value2' => __( 'Label2', 'quinn_' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				// 'std'         => 'value2', // Default value, optional
				'placeholder' => __( 'Select an Item', 'quinn_' ),
			),
			// TAXONOMY
			array(
				'name'       => __( 'Taxonomy', 'quinn_' ),
				'id'         => "{$prefix}taxonomy",
				'type'       => 'taxonomy',
				// Taxonomy name
				'taxonomy'   => 'category',
				// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
				'field_type' => 'checkbox_list',
				// Additional arguments for get_terms() function. Optional
				'query_args' => array(),
			),
			// POST
			array(
				'name'        => __( 'Posts (Pages)', 'quinn_' ),
				'id'          => "{$prefix}pages",
				'type'        => 'post',
				// Post type
				'post_type'   => 'page',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type'  => 'select_advanced',
				'placeholder' => __( 'Select an Item', 'quinn_' ),
				// Query arguments (optional). No settings means get all published posts
				'query_args'  => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				),
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name'    => __( 'WYSIWYG / Rich Text Editor', 'quinn_' ),
				'id'      => "{$prefix}wysiwyg",
				'type'    => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'     => false,
				'std'     => __( 'WYSIWYG default value', 'quinn_' ),

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => true,
					'media_buttons' => false,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),
			// FILE UPLOAD
			array(
				'name' => __( 'File Upload', 'quinn_' ),
				'id'   => "{$prefix}file",
				'type' => 'file',
			),
			// FILE ADVANCED (WP 3.5+)
			array(
				'name'             => __( 'File Advanced Upload', 'quinn_' ),
				'id'               => "{$prefix}file_advanced",
				'type'             => 'file_advanced',
				'max_file_uploads' => 4,
				'mime_type'        => 'application,audio,video', // Leave blank for all file types
			),
			// IMAGE UPLOAD
			array(
				'name' => __( 'Image Upload', 'quinn_' ),
				'id'   => "{$prefix}image",
				'type' => 'image',
			),
			// THICKBOX IMAGE UPLOAD (WP 3.3+)
			array(
				'name' => __( 'Thickbox Image Upload', 'quinn_' ),
				'id'   => "{$prefix}thickbox",
				'type' => 'thickbox_image',
			),
			// PLUPLOAD IMAGE UPLOAD (WP 3.3+)
			array(
				'name'             => __( 'Plupload Image Upload', 'quinn_' ),
				'id'               => "{$prefix}plupload",
				'type'             => 'plupload_image',
				'max_file_uploads' => 4,
			),
			// IMAGE ADVANCED (WP 3.5+)
			array(
				'name'             => __( 'Image Advanced Upload', 'quinn_' ),
				'id'               => "{$prefix}imgadv",
				'type'             => 'image_advanced',
				'max_file_uploads' => 10,
			),
			// BUTTON
			array(
				'id'   => "{$prefix}button",
				'type' => 'button',
				'name' => ' ', // Empty name will "align" the button to all field inputs
			),
		),
	);

	return $meta_boxes;
}


