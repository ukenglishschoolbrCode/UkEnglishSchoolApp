<?php
/**
 * Single Progress Map template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/progress-map/single-progress-map.php
 */
global $gamipress_progress_map_template_args;

// Shorthand
$a = $gamipress_progress_map_template_args;

?>

<div id="gamipress-progress-map-<?php the_ID(); ?>" class="single-gamipress-progress-map">

    <?php
    /**
     * Before single progress map
     *
     * @param $progress_map_id   integer The progress map ID
     * @param $template_args    array   Template received arguments
     */
    do_action( 'gamipress_before_single_progress_map', get_the_ID(), $a ); ?>

    <?php // Progress map content
    if( isset( $a['original_content'] ) ) :
        echo wpautop( $a['original_content'] );
    endif; ?>

    <?php
    /**
     * After single progress map content
     *
     * @param $progress_map_id   integer The progress map ID
     * @param $template_args    array   Template received arguments
     */
    do_action( 'gamipress_after_single_progress_map_content', get_the_ID(), $a ); ?>

    <?php
    // Setup the progress map render
    $progress_map_render = new GamiPress_Progress_Map_Render( get_the_ID() );

    // Display the progress map
    $progress_map_render->display();
    ?>

    <?php
    /**
     * After single progress map
     *
     * @param $progress_map_id   integer The progress map ID
     * @param $template_args    array   Template received arguments
     */
    do_action( 'gamipress_after_single_progress_map', get_the_ID(), $a ); ?>

</div>
