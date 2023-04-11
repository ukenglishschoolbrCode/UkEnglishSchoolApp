<?php
/**
 * Scripts
 *
 * @package     GamiPress\Progress_Map\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_progress_map_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Libraries
    wp_register_script( 'gamipress-progress-map-dragscroll-js', GAMIPRESS_PROGRESS_MAP_URL . 'assets/libs/dragscroll/dragscroll' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_PROGRESS_MAP_VER, true );

    // Stylesheets
    wp_register_style( 'gamipress-progress-map-css', GAMIPRESS_PROGRESS_MAP_URL . 'assets/css/gamipress-progress-map' . $suffix . '.css', array( ), GAMIPRESS_PROGRESS_MAP_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-progress-map-js', GAMIPRESS_PROGRESS_MAP_URL . 'assets/js/gamipress-progress-map' . $suffix . '.js', array( 'jquery', 'gamipress-progress-map-dragscroll-js' ), GAMIPRESS_PROGRESS_MAP_VER, true );

}
add_action( 'init', 'gamipress_progress_map_register_scripts' );

/**
 * Enqueue frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_progress_map_enqueue_scripts( $hook = null ) {

    // Enqueue assets
    wp_enqueue_style( 'gamipress-progress-map-css' );
    wp_enqueue_script( 'gamipress-progress-map-js' );

}
add_action( 'wp_enqueue_scripts', 'gamipress_progress_map_enqueue_scripts', 100 );

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_progress_map_admin_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-progress-map-admin-css', GAMIPRESS_PROGRESS_MAP_URL . 'assets/css/gamipress-progress-map-admin' . $suffix . '.css', array( ), GAMIPRESS_PROGRESS_MAP_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-progress-map-admin-js', GAMIPRESS_PROGRESS_MAP_URL . 'assets/js/gamipress-progress-map-admin' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_PROGRESS_MAP_VER, true );

}
add_action( 'admin_init', 'gamipress_progress_map_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_progress_map_admin_enqueue_scripts( $hook ) {

    global $post_type;

    //Stylesheets
    wp_enqueue_style( 'gamipress-progress-map-admin-css' );

    //Scripts
    wp_enqueue_script( 'gamipress-progress-map-admin-js' );

}
add_action( 'admin_enqueue_scripts', 'gamipress_progress_map_admin_enqueue_scripts', 100 );