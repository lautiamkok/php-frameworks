<?php
/*
Template Name: Shop
*/
/**
 * The template for displaying shop page
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

    shop page

        <div id="wrapper">
            <div id="columns">
                <?php
                $parent = $post->ID;
                query_posts('posts_per_page=15&post_type=page&post_parent='.$parent);
                    while (have_posts()) : the_post();
                ?>

                    <div class="pin">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                        <p><?php the_title(); ?> -
                        <?php
                            $field_id = 'quinn_wysiwyg';
                            $post_id = $post->ID;
                            echo strip_tags(rwmb_meta( $field_id, $args = array(), $post_id ));
                        ?>
                        </p>

                        <button type="button" class="btn btn-default button-add-to-cart">
                            <i class="icon-large icon-shopping-cart v-center"></i>
                            <span class="v-center">
                                Add to Cart
                            </span>
                        </button>

                    </div>

                <?php endwhile; ?>
            </div>
        </div>

	</div>
	<!-- container -->

<?php get_footer(); ?>
