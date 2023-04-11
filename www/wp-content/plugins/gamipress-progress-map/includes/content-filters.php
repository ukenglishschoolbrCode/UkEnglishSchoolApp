<?php
/**
 * Content Filters
 *
 * @package     GamiPress\Progress_Map\Content_Filters
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Filter progress map content to add the progress map
 *
 * @since  1.0.0
 *
 * @param  string $content The page content
 *
 * @return string          The page content after reformat
 */
function gamipress_progress_map_reformat_entries( $content ) {

    // Filter, but only on the main loop!
    if ( ! gamipress_progress_map_is_main_loop( get_the_ID() ) )
        return $content;

    // now that we're where we want to be, tell the filters to stop removing
    $GLOBALS['gamipress_progress_map_reformat_content'] = true;

    global $gamipress_progress_map_template_args;

    // Initialize template args global
    $gamipress_progress_map_template_args = array();

    $gamipress_progress_map_template_args['original_content'] = $content;

    ob_start();

    gamipress_get_template_part( 'single-progress-map' );

    $new_content = ob_get_clean();

    // Ok, we're done reformating
    $GLOBALS['gamipress_progress_map_reformat_content'] = false;

    return $new_content;
}
add_filter( 'the_content', 'gamipress_progress_map_reformat_entries', 9 );

/**
 * Helper function tests that we're in the main loop
 *
 * @since  1.0.0
 * @param  bool|integer $id The page id
 * @return boolean     A boolean determining if the function is in the main loop
 */
function gamipress_progress_map_is_main_loop( $id = false ) {

    // only run our filters on the gamipress progress map singular pages
    if ( is_admin() || ! is_singular( 'progress-map' ) )
        return false;
    // w/o id, we're only checking template context
    if ( ! $id )
        return true;

    // Checks several variables to be sure we're in the main loop (and won't effect things like post pagination titles)
    return ( ( $GLOBALS['post']->ID == $id ) && in_the_loop() && empty( $GLOBALS['gamipress_progress_map_reformat_content'] ) );
}