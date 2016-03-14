<?php
/**
 * The template for displaying general pages (page article)
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

	<!-- container -->
	<div class="container">
    page article

    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

        // Include the page content template.
        get_template_part( 'content-page', 'page' );

    // End the loop.
    endwhile;
    ?>

	</div>
	<!-- container -->

<?php get_footer(); ?>
