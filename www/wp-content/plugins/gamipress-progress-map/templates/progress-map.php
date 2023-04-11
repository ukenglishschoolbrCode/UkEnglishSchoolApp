<?php
/**
 * Progress Map template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/progress-map/progress-map.php
 */
global $gamipress_progress_map_template_args;

// Shorthand
$a = $gamipress_progress_map_template_args;

$progress_map_id = $a['id'];

?>

<div id="gamipress-progress-map-<?php echo $progress_map_id; ?>" class="gamipress-progress-map">

    <?php
    /**
     * Before progress map
     *
     * @param $progress_map_id   integer The progress map ID
     * @param $template_args    array   Template received arguments
     */
    do_action( 'gamipress_before_progress_map', $progress_map_id, $a ); ?>

    <?php if( ! empty( $a['title'] ) ) : ?>
        <h2 class="gamipress-progress-map-title"><?php echo $a['title']; ?></h2>

        <?php
        /**
         * After progress map title
         *
         * @param $progress_map_id  integer The progress map ID
         * @param $template_args    array   Template received arguments
         */
        do_action( 'gamipress_after_progress_map_title', $progress_map_id, $a ); ?>
    <?php endif; ?>

    <?php // Progress Map Short Description
    if( $a['excerpt'] === 'yes' ) :  ?>
        <div class="gamipress-progress-map-excerpt">
            <?php
            $excerpt = has_excerpt() ? gamipress_get_post_field( 'post_excerpt', $progress_map_id ) : gamipress_get_post_field( 'post_content', $progress_map_id );
            echo wpautop( do_blocks( do_shortcode( apply_filters( 'get_the_excerpt', $excerpt, get_post( $progress_map_id ) ) ) ) );
            ?>
        </div><!-- .gamipress-achievement-excerpt -->

        <?php
        /**
         * After progress map excerpt
         *
         * @param $progress_map_id  integer The progress map ID
         * @param $template_args    array   Template received arguments
         */
        do_action( 'gamipress_after_progress_map_excerpt', $progress_map_id, $a ); ?>
    <?php endif; ?>

    <?php

    $args = array(
        'user_id' => $a['user_id'],
    );

    // Setup the progress map table
    $progress_map_render = new GamiPress_Progress_Map_Render( $progress_map_id, $args );

    // Display the progress map
    $progress_map_render->display();
    ?>

    <?php
    /**
     * After progress map
     *
     * @param $progress_map_id   integer The progress map ID
     * @param $template_args    array   Template received arguments
     */
    do_action( 'gamipress_after_progress_map', $progress_map_id, $a ); ?>

</div>
