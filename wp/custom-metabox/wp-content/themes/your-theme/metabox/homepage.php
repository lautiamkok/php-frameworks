<?php
/**
 * Adds a meta box to the post editing screen - everywhere on the page/post.
 *
 * @ usage in any your home page template:
 *
 * <?php
        // Retrieves the stored value from the database
        $meta_title = get_post_meta( get_the_ID(), 'quinn_meta_title', true );
        $meta_textarea = get_post_meta( get_the_ID(), 'quinn_meta_textarea', true );

        // Checks and displays the retrieved value
        if( !empty( $meta_title ) ) {
            echo $meta_title;
            echo $meta_textarea;
        }
    ?>
 * @ http://themefoundation.com/wordpress-meta-boxes-guide/
 */

/**
 * Add custom meta box to a specific page in the WP admin.
 *
 * @ http://themefoundation.com/wordpress-meta-boxes-guide/
 * @ http://www.farinspace.com/page-specific-wordpress-meta-box/
 */
function homepage_metabox_init() {
    // Get post/page ID.
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

    // Get post/page slug.
    $post = get_post($post_id);
    $slug = $post->post_name;

    // checks for post/page slug.
    if ($slug == 'home') {
        add_meta_box( 'homepage_meta', __( 'Meta Box Title', 'homepage-textdomain' ), 'homepage_meta_callback', array( 'post', 'page') );
    }
    add_action( 'add_meta_boxes', 'homepage_meta_save' );
}
add_action('admin_init','homepage_metabox_init');

/**
 * Outputs the content of the meta box.
 */
function homepage_meta_callback( $post ) {
    // Better has an underscore as last sign.
    $prefix = 'quinn_';

    wp_nonce_field( basename( __FILE__ ), 'homepage_nonce' );
    $homepage_stored_meta = get_post_meta( $post->ID );

    $field_value = get_post_meta( $post->ID, "{$prefix}meta_textarea", false );

    // Settings that we'll pass to wp_editor
    $args = array (
        'textarea_rows' => 4,
        'teeny'         => true,
        // 'media_buttons' => false,
    );
    ?>
    <div class="rwmb-field rwmb-wysiwyg-wrapper">
        <div class="rwmb-label">
            <label for="<?php echo $prefix; ?>meta_title" class="homepage-row-title"><?php _e( 'Example Text Input', 'homepage-textdomain' )?></label>
        </div>
        <div class="rwmb-input ui-sortable">
            <input type="text" name="<?php echo $prefix; ?>meta_title" id="<?php echo $prefix; ?>meta_title" value="<?php if ( isset ( $homepage_stored_meta["{$prefix}meta_title"] ) ) echo $homepage_stored_meta["{$prefix}meta_title"][0]; ?>" />
        </div>
    </div>

    <div class="rwmb-field rwmb-wysiwyg-wrapper">
        <div class="rwmb-label">
            <label for="<?php echo $prefix; ?>meta_textarea" class="homepage-row-title"><?php _e( 'Example Textarea Input', 'homepage-textdomain' )?></label>
        </div>
        <div class="rwmb-input ui-sortable">
            <?php wp_editor( $field_value[0], "{$prefix}meta_textarea", $args);?>
        </div>
    </div>

    <?php
}

/**
 * Saves the custom meta input.
 */
function homepage_meta_save ( $post_id ) {
    // Better has an underscore as last sign.
    $prefix = 'quinn_';

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'homepage_nonce' ] ) && wp_verify_nonce( $_POST[ 'homepage_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ "{$prefix}meta_title" ] ) ) {
        update_post_meta( $post_id, "{$prefix}meta_title", sanitize_text_field( $_POST[ "{$prefix}meta_title" ] ) );
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ "{$prefix}meta_textarea" ] ) ) {
        // Cleans your input.
        // update_post_meta( $post_id, "{$prefix}meta_textarea", sanitize_text_field( $_POST[ "{$prefix}meta_textarea" ] ) );

        // Stop wp_editor removes html tags.
        update_post_meta( $post_id, "{$prefix}meta_textarea", stripslashes( $_POST[ "{$prefix}meta_textarea" ] ) );
    }

}
add_action( 'save_post', 'homepage_meta_save' );

/**
 * Adds the meta box stylesheet when appropriate
 */
function homepage_admin_styles(){
    global $typenow;

    // Check if the current type is page.
    if( $typenow === 'page' ) {
        wp_enqueue_style( 'homepage_meta_box_styles', get_template_directory_uri () . '/metabox/metabox-homepage.css' );
    }
}
add_action( 'admin_print_styles', 'homepage_admin_styles' );
