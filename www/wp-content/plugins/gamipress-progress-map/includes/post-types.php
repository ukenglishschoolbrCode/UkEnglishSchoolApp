<?php
/**
 * Post Types
 *
 * @package     GamiPress\Progress_Map\Post_Types
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Progress Map CPT
 *
 * @since  1.0.0
 */
function gamipress_progress_map_register_post_types() {

    $labels = gamipress_progress_map_labels();

    $public_progress_map = (bool) gamipress_progress_map_get_option( 'public', false );
    $supports = gamipress_progress_map_get_option( 'supports', array( 'title', 'editor', 'excerpt' ) );

    if( ! is_array( $supports ) ) {
        $supports =  array( 'title', 'editor', 'excerpt' );
    }

    // Register Progress Map
    register_post_type( 'progress-map', array(
        'labels'             => array(
            'name'               => $labels['plural'],
            'singular_name'      => $labels['singular'],
            'add_new'            => __( 'Add New', 'gamipress-progress-map' ),
            'add_new_item'       => sprintf( __( 'Add New %s', 'gamipress-progress-map' ), $labels['singular'] ),
            'edit_item'          => sprintf( __( 'Edit %s', 'gamipress-progress-map' ), $labels['singular'] ),
            'new_item'           => sprintf( __( 'New %s', 'gamipress-progress-map' ), $labels['singular'] ),
            'all_items'          => $labels['plural'],
            'view_item'          => sprintf( __( 'View %s', 'gamipress-progress-map' ), $labels['singular'] ),
            'search_items'       => sprintf( __( 'Search %s', 'gamipress-progress-map' ), $labels['plural'] ),
            'not_found'          => sprintf( __( 'No %s found', 'gamipress-progress-map' ), strtolower( $labels['plural'] ) ),
            'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'gamipress-progress-map' ), strtolower( $labels['plural'] ) ),
            'parent_item_colon'  => '',
            'menu_name'          => $labels['plural'],
        ),
        'public'             => $public_progress_map,
        'publicly_queryable' => $public_progress_map,
        'show_ui'            => current_user_can( gamipress_get_manager_capability() ),
        'show_in_menu'       => 'gamipress',
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => gamipress_progress_map_get_option( 'slug', 'progress-maps' ) ),
        'capability_type'    => 'page',
        'has_archive'        => $public_progress_map,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => $supports
    ) );

}
add_action( 'init', 'gamipress_progress_map_register_post_types', 11 );

/**
 * Progress Map labels
 *
 * @since  1.0.0
 * @return array
 */
function gamipress_progress_map_labels() {
    return apply_filters( 'gamipress_progress_map_labels' , array(
        'singular' => __( 'Progress Map', 'gamipress-progress-map' ),
        'plural' => __( 'Progress Maps', 'gamipress-progress-map' )
    ));
}