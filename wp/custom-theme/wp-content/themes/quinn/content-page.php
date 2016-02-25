<?php
/**
 * The template used for displaying page artile content
 *
 * @package WordPress
 * @subpackage Quinn
 * @since Quinn 1.0
 */
?>

<div id="wrapper">
    page article content
    <?php
    $images = rwmb_meta( 'quinn_imgadv', 'type=image&size=full');
    ?>
    <div class="col-md-6">
        <?php if (count($images) > 0) { ?>
        <ul class="items-image">
            <?php foreach ($images as $index => $image) { ?>
            <li><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-responsive" /></li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div class="col-md-6">
        <?php the_content(); ?>
    </div>
</div>
