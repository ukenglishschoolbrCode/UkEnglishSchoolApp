<?php
/**
 * Template Functions
 *
 * @package GamiPress\Progress_Map\Template_Functions
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin templates directory on GamiPress template engine
 *
 * @since 1.0.0
 *
 * @param array $file_paths
 *
 * @return array
 */
function gamipress_progress_map_template_paths( $file_paths ) {

    $file_paths[] = trailingslashit( get_stylesheet_directory() ) . 'gamipress/progress-map/';
    $file_paths[] = trailingslashit( get_template_directory() ) . 'gamipress/progress-map/';
    $file_paths[] =  GAMIPRESS_PROGRESS_MAP_DIR . 'templates/';

    return $file_paths;

}
add_filter( 'gamipress_template_paths', 'gamipress_progress_map_template_paths' );