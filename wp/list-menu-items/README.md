# List menus

1. List all menus:

    ```
    // Get all menu objects.
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    print_r($menus);
   ```

2. List all items in a menu:

    ```
    // Get all items in a menu object.
    $menu_items = wp_get_nav_menu_items('quinn-menu');

    echo '<ul>';

    foreach($menu_items as $item)
    {
        echo '<li>'.$item->title.'</li>';
    }

    echo '</ul>';
    ```

3. List all items in a menu object - with add_filter in functions.php

    ```
    // Get all items in a menu object - with add_filter in functions.php
    // @https://developer.wordpress.org/reference/functions/wp_nav_menu/
    $arg = array(
        'container' => false,
        'menu_class' => 'nav navbar-nav navbar-right'
    );
    wp_nav_menu($arg);
    ```

    in functions.php:

    ```
    // Adding .active class to active menu item
    // @ https://wordpress.org/support/topic/adding-active-class-to-active-menu-item?replies=8
    add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
    function special_nav_class($classes, $item){
        if( in_array('current-menu-item', $classes) ){
            $classes[] = 'active ';
        }
        return $classes;
    }
    ```
