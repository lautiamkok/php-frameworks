<?php
/*
Template Name: Home
*/
/**
 * The template for displaying home page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Quinn
 * @since Quinn 1.0
 */

get_header(); ?>

    <?php
    $images = rwmb_meta( 'quinn_imgadv', 'type=image&size=full');
    ?>

	<!-- container -->
	<div class="container-fluid">
        <div class="row-fluid">

            <div class="enter text-center">
                <h1><a href="<?php echo site_url(); ?>/work/">Peter Quinn Davis</a></h1>
            </div>

            <?php if (count($images) > 0) { ?>

            <!-- carousel -->
            <div id="carousel-example-generic" class="carousel slide">

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php
                    $counter = 0;
                    foreach ($images as $index => $image) {
                    ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $counter;?>"<?php if ($counter == '0'):?> class="active"<?php endif; ?>></li>
                    <?php
                        $counter++;
                    }
                    ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <?php
                    $counter = 1;
                    foreach ($images as $index => $image) {
                    ?>

                    <div class="item<?php if ($counter == '1'):?> active<?php endif; ?>">
                        <div class="img-container">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-responsive" />
                        </div>
                    </div>
                    <?php
                        $counter++;
                    }
                    ?>

                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="icon-prev"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="icon-next"></span>
                </a>

            </div>
            <!-- carousel -->
            <?php } ?>

        </div>
    </div>
	<!-- container -->

<?php get_footer(); ?>
