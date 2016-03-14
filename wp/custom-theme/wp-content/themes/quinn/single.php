<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Quinn
 * @since Quinn 1.0
 */

get_header(); ?>

	<!-- container -->
	<div class="container">
	post article

    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

        /*
         * Include the post format-specific template for the content. If you want to
         * use this in a child theme, then include a file called called content-___.php
         * (where ___ is the post format) and that will be used instead.
         */
        get_template_part( 'content-single', get_post_format() );

    // End the loop.
    endwhile;
    ?>
	</div>
	<!-- container -->

<?php get_footer(); ?>
