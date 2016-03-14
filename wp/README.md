# Quick guide for WordPress website developments (WordPress 4.4)

## Landing/ Default Page

    Change front page displays from posts (default) to pages

    **Settings** -> Reading, select `A static page`, select a `Front page` (Home page for instance), then click `Save Changes`.

## Clean URL

    Set up clean URLs

    **Permalinks** -> Permalink Settings -> Common Settings -> select `Post name` -> `Save Changes`.

## Menu

1. Set up a menu

    **Appearance** -> Menus -> type in a [Menu Name] -> Create Menu -> Save Menu.

    Select a menu that you created to edit ->  select the [Menu Name] -> click `Select`.

    You must create pages in **Pages** first, then you see the pages you created under `Pages` in **Appearance**, click `Select All` -> click `Add to Menu`, then under `Menu Settings` -> select `Primary Menu`, then click `Save Menu`.


2. Make menu sub items

    **Appearance** -> under `Menu Structure` -> drag the item and drop it under item that you want that to be its parent.

    Then go to **Pages** -> Select the page (Career for an example that you want it to be a sub page -> under `Page Attributes` -> under `Parent` -> select About for an example -> click `Update`.

## Posts

1. Make posts under a page (called Blog for example)

    **Settings** -> Reading -> under `Posts Pages` -> select [Blog - assuming you have created this page under **Pages**] -> click `Save Changes`.


2. Change posts clean URL of posts under its parent page (Blog)

    **Settings** -> Permalinks -> under `Custom Structure` -> change [blog/%postname%/] -> click `Save Changes`.

## Meta Box (Plugin)

1. Install meta box (plugin)

    * Go to https://wordpress.org/plugins/meta-box/ -> download

    Installation guide -> https://wordpress.org/plugins/meta-box/installation/

    * Go to  https://github.com/rilwis/meta-box/blob/master/demo/demo.php -> copy/ download to `wp-content/themes/[twentyfifteen]/`

    * change `wp-content/themes/[twentyfifteen]/demo.php`,

    ```
    add_filter( 'rwmb_meta_boxes', 'w4_register_meta_boxes' );
    function w4_register_meta_boxes( $meta_boxes ) {...}
    $prefix = 'w4_';
    ```

    * Go to `wp-content/themes/[twentyfifteen]/functions.php` -> add this line at the very bottom,

    `include 'demo.php';`


2. Add meta box **standard** and **advanced** to pages.

    In `wp-content/themes/[twentyfifteen]/demo.php`, look for

    ```
    // 2nd meta box
    $meta_boxes[] = array()
    ```

    add,

    `'post_types' => array( 'post', 'page' ),`

    after,

    `'title'  => __( 'Advanced Fields', 'meta-box' ),`


3. Get meta value in the front end

    * Go to http://metabox.io/docs/ -> http://metabox.io/docs/get-meta-value/ for full details.

    * To display uploaded images,  for an example,

    ```
    $images = rwmb_meta( 'w4_plupload', 'type=image&size=full');
    foreach ( $images as $image )
    {
        echo "<a href='{$image['full_url']}' title='{$image['title']}' rel='thickbox'><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a>";
    }
    ```
    * To display wysiwyg meta,  for an example,

    ```
    $field_id = 'w4_wysiwyg';

    echo rwmb_meta( $field_id, $args = array(), $post_id = $post->ID );
    ```

    Place it where you need to in,

    `wp-content/themes/[twentyfifteen]/single.php` (for posts)

    `wp-content/themes/[twentyfifteen]/content-page.php` (for pages)

    * ref: https://metabox.io/docs/get-meta-value/

## Comments

1. Turn off comments on new posts.

    Settings -> Discussion -> uncheck "Allow people to post comments on new articles"

    * ref: https://en.support.wordpress.com/enable-disable-comments-for-future-posts-pages/

2. Turn off comments on older posts.

    1. Go to your All Posts page.
    2. Click on the checkbox in the header.
    3. Choose "Edit" under the bulk actions drop-down and then click Apply. The bulk edit area will appear.
    4. In the middle of the bulk edit area will be four drop-down menus. The second one is for comments. Change it to "Do not allow".

    * ref: https://wordpress.org/ideas/topic/turn-comments-onoff-for-multiple-posts-at-once

## Thumbnail: the_post_thumbnail()

1. Remove width & height attributes from the image tag, add this code below in functions.php:

    ```
    add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

    function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        return $html;
    }
    ```

    * ref: http://wordpress.stackexchange.com/questions/22302/how-do-you-remove-hard-coded-thumbnail-image-dimensions
    * ref: https://developer.wordpress.org/reference/functions/the_post_thumbnail/
