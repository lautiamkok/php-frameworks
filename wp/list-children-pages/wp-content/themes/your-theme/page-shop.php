<?php
/*
Template Name: Shop
*/
get_header(); ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<ul>
		    <?php
		    // global $id;
		    // wp_list_pages( array(
		    //     'title_li'    => '',
		    //     'child_of'    => $id
		    // ) );
		    ?>
		</ul>

		<ul class="subpages">

		<?php
		$field_id = 'quinn_wysiwyg';

		echo rwmb_meta($field_id, $args = array(), $post_id = $post->ID);
		?>

		<?php $parent = $post->ID; ?>
		<?php
		query_posts('posts_per_page=15&post_type=page&post_parent='.$parent);
			while (have_posts()) : the_post();
		?>

		<li>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<p>
			<?php
				$field_id = 'quinn_wysiwyg';
				$post_id = $post->ID;
				echo rwmb_meta( $field_id, $args = array(), $post_id );
			?>
			</p>
		</li>

		<?php endwhile; ?>

		</ul>

		<?php //echo wpb_list_child_pages(); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
