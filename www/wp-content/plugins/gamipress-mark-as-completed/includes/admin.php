<?php
/**
 * Admin
 *
 * @package GamiPress\Mark_As_Completed\Admin
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_mark_as_completed_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-mark-as-completed-license'] = array(
        'title' => __( 'GamiPress Mark As Completed', 'gamipress-mark-as-completed' ),
        'fields' => array(
            'gamipress_mark_as_completed_license' => array(
                'name' => __( 'License', 'gamipress-mark-as-completed' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_MARK_AS_COMPLETED_FILE,
                'item_name' => 'Mark As Completed',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_mark_as_completed_licenses_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_mark_as_completed_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-mark-as-completed'] = __( 'GamiPress - Mark As Completed', 'gamipress-mark-as-completed' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_mark_as_completed_automatic_updates' );