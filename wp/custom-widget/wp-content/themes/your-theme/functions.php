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

/**
 * Extending WP default WP_Widget.
 *
 * @origin located at wp-includes/widgets/class-wp-widget-text.php
 */
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

/**
 * Create a new text widget for follow social media, instead of extending WP default WP_Widget.
 *
 * @origin located at wp-includes/widgets/class-wp-widget-text.php
 */
class Follow_Text_Widget extends WP_Widget {
    /**
     * Sets up a new Text widget instance.
     *
     * @since 2.8.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array('classname' => 'widget_text_social_media', 'description' => __('Arbitrary text or HTML.'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('text_social_media', __('Social Media Text Widget'), $widget_ops, $control_ops);
    }

    /**
     * Outputs the content for the current Text widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Text widget instance.
     */
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $after_title; } ?>
            <?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
        <?php
        echo $after_widget;
    }

    /**
     * Handles updating settings for the current Text widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }

    /**
     * Outputs the Text widget settings form.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
        $title = sanitize_text_field( $instance['title'] );
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

        <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
        <?php
    }
}
