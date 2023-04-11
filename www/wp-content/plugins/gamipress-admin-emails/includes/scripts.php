<?php
/**
 * Scripts
 *
 * @package     GamiPress\Admin_Emails\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_admin_emails_admin_register_scripts( $hook ) {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-admin-emails-admin-css', GAMIPRESS_ADMIN_EMAILS_URL . 'assets/css/gamipress-admin-emails-admin' . $suffix . '.css', array(), GAMIPRESS_ADMIN_EMAILS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-admin-emails-admin-js', GAMIPRESS_ADMIN_EMAILS_URL . 'assets/js/gamipress-admin-emails-admin' . $suffix . '.js', array( 'jquery', 'gamipress-admin-functions-js', 'gamipress-select2-js' ), GAMIPRESS_ADMIN_EMAILS_VER, true );

}
add_action( 'admin_init', 'gamipress_admin_emails_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_admin_emails_admin_enqueue_scripts( $hook ) {

    //Scripts

    // Email Digests add/edit screen
    if( $hook === 'gamipress_page_gamipress_admin_emails' || $hook === 'admin_page_edit_gamipress_admin_emails' ) {

        // Enqueue admin functions
        gamipress_enqueue_admin_functions_script();

        //Stylesheets
        wp_enqueue_style( 'gamipress-admin-emails-admin-css' );

        //Scripts
        wp_enqueue_script( 'gamipress-admin-emails-admin-js' );

    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_admin_emails_admin_enqueue_scripts', 100 );