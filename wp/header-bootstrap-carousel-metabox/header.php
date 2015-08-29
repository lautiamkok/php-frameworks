<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
        
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
        
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<div style="width:100%; clear: both; position: relative;">
        
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
        
</div>    
    
    <div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;
				?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

		<?php get_sidebar(); ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
