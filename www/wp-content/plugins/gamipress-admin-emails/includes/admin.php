<?php
/**
 * Admin
 *
 * @package     GamiPress\Admin_Emails\Admin
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add plugin admin bar menu
 *
 * @since 1.0.0
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
function gamipress_admin_emails_admin_bar_menu( $wp_admin_bar ) {

    // - Admin Emails
    $wp_admin_bar->add_node( array(
        'id'     => 'gamipress-admin-emails',
        'title'  => __( 'Admin Emails', 'gamipress-admin-emails' ),
        'parent' => 'gamipress',
        'href'   => admin_url( 'admin.php?page=gamipress_admin_emails' )
    ) );

}
add_action( 'admin_bar_menu', 'gamipress_admin_emails_admin_bar_menu', 150 );

/**
 * Shortcut function to get plugin options
 *
 * @since  1.0.0
 *
 * @param string    $option_name
 * @param bool      $default
 *
 * @return mixed
 */
function gamipress_admin_emails_get_option( $option_name, $default = false ) {

    $prefix = 'gamipress_admin_emails_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * Plugin settings meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_admin_emails_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'gamipress_admin_emails_';

    $meta_boxes['gamipress-admin-emails-settings'] = array(
        'title' => __( 'Admin Emails', 'gamipress-admin-emails' ),
        'fields' => apply_filters( 'gamipress_admin_emails_settings_fields', array(
            $prefix . 'roles' => array(
                'name'          => __( 'Roles', 'gamipress-admin-emails' ),
                'desc'          => __( 'Set the user roles that will receive admin email. If none role is selected, by default admin emails will be sent to administrators.', 'gamipress-admin-emails' ),
                'type'          => 'multicheck',
                'options_cb'    => 'gamipress_admin_emails_get_roles_options',
                'classes'       => 'gamipress-switch',
            ),
        ) )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_admin_emails_settings_meta_boxes' );

// Callback to retrieve user roles as select options
function gamipress_admin_emails_get_roles_options() {

    $options = array();

    $editable_roles = array_reverse( get_editable_roles() );

    foreach ( $editable_roles as $role => $details ) {

        $options[$role] = translate_user_role( $details['name'] );

    }

    return array_reverse( $options );
}


/**
 * Plugin Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_admin_emails_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-admin-emails-license'] = array(
        'title' => __( 'GamiPress Admin Emails', 'gamipress-admin-emails' ),
        'fields' => array(
            'gamipress_admin_emails_license' => array(
                'name' => __( 'License', 'gamipress-admin-emails' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_ADMIN_EMAILS_FILE,
                'item_name' => 'Admin Emails',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_admin_emails_licenses_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_admin_emails_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-admin-emails'] = __( 'Admin Emails', 'gamipress-admin-emails' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_admin_emails_automatic_updates' );