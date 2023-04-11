<?php
/**
 * Custom Tables
 *
 * @package     GamiPress\Admin_Emails\Custom_Tables
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/custom-tables/admin-emails.php';

/**
 * Register all plugin Custom DB Tables
 *
 * @since  1.0.0
 *
 * @return void
 */
function gamipress_admin_emails_register_custom_tables() {

    // Admin Emails Table
    ct_register_table( 'gamipress_admin_emails', array(
        'singular' => __( 'Admin Email', 'gamipress-admin-emails' ),
        'plural' => __( 'Admin Emails', 'gamipress-admin-emails' ),
        'show_ui' => true,
        'version' => 1,
        'global' => gamipress_is_network_wide_active(),
        'supports' => array( 'meta' ),
        'views' => array(
            'list' => array(
                'menu_title' => __( 'Admin Emails', 'gamipress-admin-emails' ),
                'parent_slug' => 'gamipress'
            ),
            'add' => array(
                'show_in_menu' => false,
            ),
            'edit' => array(
                'show_in_menu' => false,
            ),
        ),
        'schema' => array(
            'admin_email_id' => array(
                'type' => 'bigint',
                'length' => '20',
                'auto_increment' => true,
                'primary_key' => true,
            ),
            'title' => array(
                'type' => 'text',
            ),
            'subject' => array(
                'type' => 'text',
            ),
            'content' => array(
                'type' => 'longtext',
            ),
            'status' => array(
                'type' => 'text',
            ),
            'date' => array(
                'type' => 'datetime',
                'default' => '0000-00-00 00:00:00'
            ),
        ),
    ) );

}
add_action( 'ct_init', 'gamipress_admin_emails_register_custom_tables' );