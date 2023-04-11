<?php
/**
 * Ajax Functions
 *
 * @package     GamiPress\Mark_As_Completed\Ajax_Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Mark as completed listener
 *
 * @since 1.0.0
 */
function gamipress_ajax_mark_as_completed() {
    // Security check, forces to die if not security passed
    check_ajax_referer( 'gamipress_mark_as_completed', 'nonce' );

    $events_triggered = array();

    // Setup var
    $user_id = get_current_user_id();
    $requirement_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

    // Trigger mark as completed
    do_action( 'gamipress_mark_as_completed', $user_id, $requirement_id );
    $events_triggered['gamipress_mark_as_completed'] = array( $user_id, $requirement_id );

    $parent_id = gamipress_get_post_field( 'post_parent', $requirement_id );

    $response = array(
        'events_triggered' => $events_triggered,
        'parent_completed' => gamipress_has_user_earned_achievement( $parent_id, $user_id ),
    );

    wp_send_json_success( $response );
    exit;
}
add_action( 'wp_ajax_gamipress_mark_as_completed', 'gamipress_ajax_mark_as_completed' );