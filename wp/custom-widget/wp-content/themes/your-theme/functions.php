<?php
/**
 * YOUR_THEME_NAME functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage YOUR_THEME_NAME
 * @since YOUR_THEME_NAME 1.0
 */

/**
 * Add new sidebar under Widgets.
 *
 * @ usage in template:
 *
    <?php if ( is_active_sidebar( 'sidebar-follow' ) ) { ?>
        <div class="follow-container"><div>
            <?php dynamic_sidebar( 'sidebar-follow' ); ?>
            </div>
        </div>
    <?php } ?>
 *
 * @ https://codex.wordpress.org/Function_Reference/register_sidebar
 */
// function child_register_sidebar(){
//     register_sidebar(array(
//         'name' => 'Social Media (Follow)',
//         'id' => 'sidebar-follow',
//         'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
//         'before_widget' => '',
//         'after_widget' => '',
//         'before_title' => '',
//         'after_title' => ''
//     ));
// }
// add_action( 'widgets_init', 'child_register_sidebar' );

function register_child_widgets() {
    register_sidebar(array(
        'name' => 'Social Media (Follow)',
        'id' => 'sidebar-follow',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_widget( 'Follow_Text_Widget' );
}
add_action( 'widgets_init', 'register_child_widgets' );

class Follow_Text_Widget extends WP_Widget_Text {
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
            <?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
        <?php
        echo $after_widget;
    }
}
