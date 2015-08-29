# Quick guide for WordPress website developments (WordPress 4.1)

1. Change front page displays from posts (default) to pages

    **Settings** -> Reading, select `A static page`, select a `Front page` (Home page for instance), then click `Save Changes`. 


2. Set up clean URLs

    **Permalinks** -> Permalink Settings -> Common Settings -> select `Post name` -> `Save Changes`.


3. Set up a menu

    **Appearance** -> Menus -> type in a [Menu Name] -> Create Menu -> Save Menu.

    Select a menu that you created to edit ->  select the [Menu Name] -> click `Select`.

    You must create pages in **Pages** first, then you see the pages you created under `Pages` in **Appearance**, click `Select All` -> click `Add to Menu`, then under `Menu Settings` -> select `Primary Menu`, then click `Save Menu`.


4. Make menu sub items 

    **Appearance** -> under `Menu Structure` -> drag the item and drop it under item that you want that to be its parent.

    Then go to **Pages** -> Select the page (Career for an example that you want it to be a sub page -> under `Page Attributes` -> under `Parent` -> select About for an example -> click `Update`.


5. Make posts under a page (called Blog for example)

    **Settings** -> Reading -> under `Posts Pages` -> select [Blog - assuming you have created this page under **Pages**] -> click `Save Changes`.


6. Change posts clean URL of posts under its parent page (Blog)

    **Settings** -> Permalinks -> under `Custom Structure` -> change [blog/%postname%/] -> click `Save Changes`.


7. Install meta box (plugin)

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


8. Add meta box **standard** and **advanced** to pages.

    In `wp-content/themes/[twentyfifteen]/demo.php`, look for
 
    ```
    // 2nd meta box
    $meta_boxes[] = array()
    ```

    add,

    `'post_types' => array( 'post', 'page' ),`

    after,

    `'title'  => __( 'Advanced Fields', 'meta-box' ),`


9. Get meta value in the front end

    * Go to http://metabox.io/docs/ -> http://metabox.io/docs/get-meta-value/ for full details.

    * To display uploaded images,  for an example,  

    ```
    $images = rwmb_meta( 'w4_plupload', 'type=image&size=full');
    foreach ( $images as $image )
    {
        echo "<a href='{$image['full_url']}' title='{$image['title']}' rel='thickbox'><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a>";
    }
    ```

    Place it where you need to in, 

    `wp-content/themes/[twentyfifteen]/content.php` (for posts)

    `wp-content/themes/[twentyfifteen]/content-page.php` (for pages)