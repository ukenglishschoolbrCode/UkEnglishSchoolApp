<?php
/**
 * Admin Emails Functions
 *
 * @package     GamiPress\Admin_Emails\Admin_Emails_Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Get the registered admin emails statuses
 *
 * @since  1.0.0
 *
 * @return array Array of admin emails statuses
 */
function gamipress_admin_emails_get_admin_email_statuses() {

    return apply_filters( 'gamipress_admin_emails_get_admin_email_statuses', array(
        'active'    => __( 'Active', 'gamipress-admin-emails' ),
        'inactive'  => __( 'Inactive', 'gamipress-admin-emails' ),
    ) );

}

/**
 * Get the registered admin emails conditions
 *
 * @since  1.0.0
 *
 * @return array Array of admin emails conditions
 */
function gamipress_admin_emails_get_admin_email_conditions() {

    return apply_filters( 'gamipress_admin_emails_get_admin_email_conditions', array(
        'points-balance'        => __( 'Reach a points balance', 'gamipress-admin-emails' ),
        'specific-achievement'  => __( 'Unlock a specific achievement', 'gamipress-admin-emails' ),
        'any-achievement'       => __( 'Unlock any achievement of type', 'gamipress-admin-emails' ),
        'all-achievements'     	=> __( 'Unlock all achievements of type', 'gamipress-admin-emails' ),
        'specific-rank'         => __( 'Reach a specific rank', 'gamipress-admin-emails' ),
    ) );

}

/**
 * Get all active admin emails
 *
 * @since  1.0.0
 *
 * @return array
 */
function gamipress_admin_emails_all_active_admin_emails() {

    global $wpdb;

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_admin_emails' );

    // Search all admin emails actives and published before current date
    $admin_emails = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$ct_table->db->table_name} AS cn
        WHERE cn.status = %s
          AND cn.date < %s",
        'active',
        date( 'Y-m-d 00:00:00', current_time('timestamp') )
    ) );

    ct_reset_setup_table();

    /**
     * Filter all active admin emails
     *
     * @since  1.0.0
     *
     * @param array     $admin_emails
     *
     * @return array
     */
    return apply_filters( 'gamipress_admin_emails_all_active_admin_emails', $admin_emails );

}

/**
 * Get all active admin emails based on given condition
 *
 * @since  1.0.0
 *
 * @param string $condition
 *
 * @return array
 */
function gamipress_admin_emails_get_active_admin_emails( $condition ) {

    global $wpdb;

    $prefix = '_gamipress_admin_emails_';

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_admin_emails' );

    // Search all admin emails actives, published before current date and based on a given condition
    $admin_emails = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$ct_table->db->table_name} AS cn
        LEFT JOIN {$ct_table->meta->db->table_name} AS cnm ON ( cn.admin_email_id = cnm.admin_email_id AND cnm.meta_key = %s )
        WHERE cnm.meta_value = %s
          AND cn.status = %s
          AND cn.date <= %s",
        $prefix . 'condition',
        $condition,
        'active',
        date( 'Y-m-d 00:00:00', current_time('timestamp') )
    ) );

    ct_reset_setup_table();

    /**
     * Filter active admin emails based on given condition
     *
     * @since  1.0.0
     *
     * @param array     $admin_emails
     * @param string    $condition
     *
     * @return array
     */
    return apply_filters( 'gamipress_admin_emails_get_active_admin_emails', $admin_emails, $condition );

}