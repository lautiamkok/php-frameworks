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
 * @subpackage <name>
 * @since <name> 1.0
 */

get_header(); ?>

    <ul class="subpages">

        <?php
        $args = array( 'posts_per_page' => 5, 'offset'=> 0, 'category' => 1 );

        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>

        <div>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <p>
            <?php
                $field_id = 'quinn_wysiwyg';
                $post_id = $post->ID;
                echo rwmb_meta( $field_id, $args = array(), $post_id );
            ?>
            </p>
        </div>

        <?php endforeach; ?>

    </ul>

<?php get_footer(); ?>
