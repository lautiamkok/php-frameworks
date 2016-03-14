<?php
/**
 * The main post template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Quinn
 * @since Quinn 1.0
 */

get_header(); ?>

    <div class="container">

    post page

        <div id="wrapper">
            <div id="columns">

                <?php
                $args = array( 'posts_per_page' => 5, 'offset'=> 0, 'category' => 1 );

                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
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
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>

<?php get_footer(); ?>
