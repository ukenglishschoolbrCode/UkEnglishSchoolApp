<?php
/**
 * Triggers
 *
 * @package GamiPress\Mark_As_Completed\Triggers
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin activity triggers
 *
 * @since  1.0.0
 *
 * @param array $activity_triggers
 * @return mixed
 */
function gamipress_mark_as_completed_activity_triggers( $activity_triggers ) {

    $activity_triggers[__( 'Mark As Completed', 'gamipress-mark-as-completed' )] = array(
        'gamipress_mark_as_completed' => __( 'Mark as completed', 'gamipress-mark-as-completed' ),
    );

    return $activity_triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_mark_as_completed_activity_triggers' );

/**
 * Get user for a given trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $user_id user ID to override.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 *
 * @return integer          User ID.
 */
function gamipress_mark_as_completed_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {
        case 'gamipress_mark_as_completed':
            $user_id = $args[0];
            break;

    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_mark_as_completed_trigger_get_user_id', 10, 3 );

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.6
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_mark_as_completed_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {
        case 'gamipress_mark_as_completed':
            // Add the post ID
            $log_meta['post_id'] = $args[1];
            break;
    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_mark_as_completed_log_event_trigger_meta_data', 10, 5 );

/**
 * Override the meta data to filter the logs count
 *
 * @since   1.0.0
 *
 * @param  array    $log_meta       The meta data to filter the logs count
 * @param  int      $user_id        The given user's ID
 * @param  string   $trigger        The given trigger we're checking
 * @param  int      $since 	        The since timestamp where retrieve the logs
 * @param  int      $site_id        The desired Site ID to check
 * @param  array    $args           The triggered args or requirement object
 *
 * @return array                    The meta data to filter the logs count
 */
function gamipress_mark_as_completed_get_user_trigger_count_log_meta( $log_meta, $user_id, $trigger, $since, $site_id, $args ) {

    switch( $trigger ) {
        case 'gamipress_mark_as_completed':
            // Add the button id
            if( isset( $args[1] ) ) {
                $log_meta['post_id'] = $args[1];
            }

            // $args could be a requirement object
            if( isset( $args['ID'] ) ) {
                $log_meta['post_id'] = $args['ID'];
            }
            break;
    }

    return $log_meta;

}
add_filter( 'gamipress_get_user_trigger_count_log_meta', 'gamipress_mark_as_completed_get_user_trigger_count_log_meta', 10, 6 );