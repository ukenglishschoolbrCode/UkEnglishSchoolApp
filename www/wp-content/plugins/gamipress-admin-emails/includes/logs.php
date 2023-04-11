<?php
/**
 * Logs
 *
 * @package     GamiPress\Admin_Emails\Logs
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin log types
 *
 * @since 1.0.0
 *
 * @param array $gamipress_log_types
 *
 * @return array
 */
function gamipress_admin_emails_logs_types( $gamipress_log_types ) {

    $gamipress_log_types['admin_email_send'] = __( 'Admin Email Send', 'gamipress-admin-email' );

    return $gamipress_log_types;

}
add_filter( 'gamipress_logs_types', 'gamipress_admin_emails_logs_types' );

/**
 * Log admin email send on logs
 *
 * @since 1.0.0
 *
 * @param int|stdClass  $admin_email_id
 * @param int           $user_id
 *
 * @return int|false
 */
function gamipress_admin_emails_log_send( $admin_email_id = null, $user_id = null ) {

    ct_setup_table( 'gamipress_admin_emails' );

    $admin_email = ct_get_object( $admin_email_id );

    ct_reset_setup_table();

    // Can't register a not existent admin email
    if( ! $admin_email )
        return false;

    // Set the current user ID if not passed
    if( $user_id === null )
        $user_id = get_current_user_id();

    $subject = gamipress_admin_emails_parse_subject( $user_id, $admin_email );

    // Log meta data
    $log_meta = array(
        'pattern' => sprintf( __( 'Admin email "%s" sent to {user}', 'gamipress-admin-email' ), $subject ),
        'admin_email_id' => $admin_email_id,
    );

    // Register the admin email send on logs
    return gamipress_insert_log( 'admin_email_send', $user_id, 'private', '', $log_meta );

}