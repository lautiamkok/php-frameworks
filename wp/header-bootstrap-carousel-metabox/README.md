# Header Carousel with Bootstrap, Meta Box, and CSS3 (`background-size`)

## Requirements

1. jQuery
2. Bootstrap
3. Meta Box (plugin)

## Installation (manually)

```
<!-- Latest compiled and minified jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
```

## Installation (Wordpress)

* Go to `wp-content/themes/[twentyfifteen]/functions.php` and add this code,

```
function your_function_name() {

    // Load bootstrap stylesheet.
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');

    // Load bootstrap carousel custom stylesheet.
    wp_enqueue_style( 'bootstrap-carousel-custom', get_template_directory_uri() . '/css/carousel-custom.css');

    // Load bootstrap jQuery.
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/jquery.js');

    // Load bootstrap JavaScript.
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.js');
}

add_action('wp_enqueue_scripts', 'your_function_name');

```

* An modification example of `twentyfifteen` theme,

```
function twentyfifteen_scripts() {

    // Load bootstrap stylesheet.
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');

    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

    // Load our main stylesheet.
    wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

    // Load bootstrap carousel custom stylesheet.
    wp_enqueue_style( 'bootstrap-carousel-custom', get_template_directory_uri() . '/css/carousel-custom.css');

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
    wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
    wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

    wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
    }

    if ( is_singular() && wp_attachment_is_image() ) {
            wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
    }

    wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20141212', true );

    // Load bootstrap JavaScript.
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.js');

    wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
            'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
            'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
    ) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

```

## Production

HTML,

Add this to `wp-content/themes/[twentyfifteen]/header.php` - just right after `<body>` before other tags,

```

<?php $images = rwmb_meta( 'w4_plupload', 'type=image&size=full'); ?>

<?php if( count($images) > 0 ):?>
    
<div id="article-carousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    
    <?php if( count($images) > 1 ):?>
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <?php $count = 0;?>
        <?php foreach ( $images as $index => $image ):?>
        <li data-target="#article-carousel" data-slide-to="<?php echo $count;?>"<?php if($count === 0):?> class="active"<?php endif;?>></li>
        <?php $count ++;?>
        <?php endforeach; ?>
    </ol>
    <?php endif;?>
    
    <!-- Carousel items -->
    <div class="carousel-inner">
        
        <?php $count = 0;?>
        <?php foreach( $images as $index => $image ):?>
        <div class="item<?php if($count === 0):?> active<?php endif;?>" style="background-image: url(<?php echo $image['url'];?>)">
            
            <?php if( $image['title'] || $image['alt'] ):?>
            <div class="carousel-caption">

                <?php if( $image['title'] ):?>
                <h3><?php echo $image['title'];?></h3>
                <?php endif;?>

                <?php if( $image['alt'] ):?>
                <p><?php echo $image['alt'];?></p>
                <?php endif;?>

            </div>
            <?php endif;?>

        </div>
        <?php $count ++;?>
        <?php endforeach; ?>

    </div>
    
    <?php if( count($images) > 1 ):?>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#article-carousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="carousel-control right" href="#article-carousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    <?php endif;?>
    
</div>
    
<?php endif;?>

```

You may need this hack below to wrap the carousel code above - if you modify the theme from `twentyfifteen` (though not recommended as you **should** develop your own theme),

```

<div style="width:100%; clear: both; position: relative;">
...
</div>

```

CSS,

Customise Bootstrap carousel. Create a new `.css` and place these codes,

```

/* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */

/* Carousel base class */
.carousel .item {
    height: 500px;
    background-position: center;
    background-size: cover;
}

.carousel .item img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 500px;
}

.carousel-caption {
  background-color: transparent;
  margin-bottom: 50px;
  /*text-align: left;*/
}

/* RESPONSIVE CSS
-------------------------------------------------- */

@media (max-width: 979px) {

  .carousel .item {
    height: 500px;
  }
  .carousel img {
    width: auto;
    height: 500px;
  }
}


@media (max-width: 767px) {

  .carousel {
    margin-left: -20px;
    margin-right: -20px;
  }

  .carousel .item {
    height: 350px;
  }

  .carousel img {
    height: 350px;
  }

  .carousel-caption {
    width: 65%;
    padding: 0 70px;
    margin-top: 100px;
  }

  .carousel-caption h1 {
    font-size: 30px;
  }

  .carousel-caption .lead,
  .carousel-caption .btn {
    font-size: 18px;
  }

}

```

## References

* Bootstrap carousel

1. http://jockstothecore.com/proper-implementation-of-background-images-with-text-inside-responsive-carousels/
2. http://stackoverflow.com/questions/25980576/bootstrap-how-to-make-a-fixed-height-responsive

* Add CSS & JS to Wordpress header

1. http://stackoverflow.com/questions/18519573/adding-other-css-files-to-wp-head

# Standard bootstrap carousel (using `<img>`)

CSS, 

```
<style>
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
    width: 100%;
    margin: auto;
}

#article-carousel {
    height:500px;
    overflow: hidden;

}
</style>

```

HTML,

```
<?php $images = rwmb_meta( 'w4_plupload', 'type=image&size=full'); ?>
  
<div id="article-carousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    
    <?php if( count($images) > 1 ):?>
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <?php $count = 0;?>
        <?php foreach ( $images as $index => $image ):?>
        <li data-target="#article-carousel" data-slide-to="<?php echo $count;?>"<?php if($count === 0):?> class="active"<?php endif;?>></li>
        <?php $count ++;?>
        <?php endforeach; ?>
    </ol>
    <?php endif;?>
    
    <!-- Carousel items -->
    <div class="carousel-inner">
        
        <?php $count = 0;?>
        <?php foreach( $images as $index => $image ):?>
        <div class="item<?php if($count === 0):?> active<?php endif;?>">
            <img src="<?php echo $image['url'];?>" title="<?php echo $item_image->title;?>" alt="<?php echo $image['alt'];?>" class="img-responsive"/>
            <?php if( $image['title'] || $image['alt'] ):?>
            <div class="carousel-caption">

                <?php if( $image['title'] ):?>
                <h3><?php echo $image['title'];?></h3>
                <?php endif;?>

                <?php if( $image['alt'] ):?>
                <p><?php echo $image['alt'];?></p>
                <?php endif;?>

            </div>
            <?php endif;?>

        </div>
        <?php $count ++;?>
        <?php endforeach; ?>

    </div>
    
    <?php if( count($images) > 1 ):?>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#article-carousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="carousel-control right" href="#article-carousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    <?php endif;?>
    
</div>

```

and,

```

<div style="width:100%;clear: both; position: relative;">

 <!-- 
 place your Carousel code here
 -->
 
</div>

```