# List Children Page

## Custom function

1. Modify the code below accordingly and place it at the bottom in functions.php:

    ```
    function wpb_list_child_pages() {

        global $post;

        if ( is_page() && $post->post_parent )

            $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
        else
            $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

        if ( $childpages ) {
            $string = '<ul>' . $childpages . '</ul>';
        }

        return $string;

    }

    add_shortcode('wpb_childpages', 'wpb_list_child_pages');
   ```

2. Go to the parent page in your WP admin, add this text-widget in the content:

    `[wpb_childpages]`


    Or echo the function in the parent's page template:

    `<?php echo wpb_list_child_pages(); ?>`

### Refs:

    1. http://www.wpbeginner.com/wp-tutorials/how-to-display-a-list-of-child-pages-for-a-parent-page-in-wordpress/

## WP Default Function

1. Place `wp_list_pages` function in the parent's page template:

    <ul>
        <?php
        global $id;
        wp_list_pages( array(
            'title_li'    => '',
            'child_of'    => $id
        ) );
        ?>
    </ul>

### Refs:

    1. https://developer.wordpress.org/reference/functions/wp_list_pages/
    2. https://wordpress.org/support/topic/limit-number-of-pages-shown-from-of-wp_list_pages-and-a-read-more-link
    3. https://wordpress.org/support/topic/limit-number-of-subpages-displayed-from-wp_list_pages

2. With child's thumbnail.

### Refs:

    1. https://wordpress.org/support/topic/listing-subpages-with-their-thumbnails
    2. https://wordpress.org/support/topic/get_post_meta-vs-the_post_thumbnail
    3. https://developer.wordpress.org/reference/functions/the_post_thumbnail/
