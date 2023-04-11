<?php
/**
 * Functions
 *
 * @package     GamiPress\Admin_Emails\Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Send the admin email
 *
 * @since 1.0.0
 *
 * @param int           $user_id
 * @param int|stdclass  $admin_email
 *
 * @return array        Array with email sends results as array( user_email => (bool) result )
 */
function gamipress_admin_emails_send_email( $user_id, $admin_email ) {

    // Setup table
    ct_setup_table( 'gamipress_admin_emails' );
    $admin_email = ct_get_object( $admin_email );

    // Bail if admin email not exists
    if( ! $admin_email ) return false;

    // Shorthand
    $id = $admin_email->admin_email_id;

    $send_email = true;

    // Bail if admin email is not active
    if( $send_email && $admin_email->status !== 'active' )
        $send_email = false;

    $user = get_userdata( $user_id );

    // Bail if user not exists
    if( $send_email && ! $user )
        $send_email = false;

    /**
     * Filter to determine if a admin email should be sent
     *
     * @since 1.0.0
     *
     * @param bool      $send_email
     * @param int       $user_id
     * @param int       $admin_email_id
     * @param stdClass  $admin_email
     *
     * @return bool
     */
    if( ! apply_filters( 'gamipress_admin_emails_send_email', $send_email, $user_id, $id, $admin_email ) ) {
        return false;
    }

    // Parse subject and content
    $subject = gamipress_admin_emails_parse_subject( $user_id, $admin_email );
    $content = gamipress_admin_emails_parse_content( $user_id, $admin_email );

    ct_reset_setup_table();

    $roles = gamipress_admin_emails_get_option( 'roles', array( 'administrator' ) );

    $users_to_send = get_users( array(
        'role__in'  => $roles,
        'number'    => -1,
    ) );

    $response = array();

    foreach( $users_to_send as $user_to_send ) {

        // Log admin email send
        gamipress_admin_emails_log_send( $id, $user_to_send->ID );

        // Send email to the user
        $response[$user_to_send->user_email] = gamipress_send_email( $user_to_send->user_email, $subject, $content );

    }

    return $response;

}
