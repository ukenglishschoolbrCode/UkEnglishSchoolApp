<?php
/**
 * Filters
 *
 * @package GamiPress\H5P\Points_Per_Score\Filters
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * H5P content completed listener
 *
 * @param object    &$data      Has the following properties score,max_score,opened,finished,time
 * @param int       $result_id  Only set if updating result
 * @param int       $content_id Identifier of the H5P Content
 */
function gamipress_h5p_points_per_score_completed( $data, $result_id, $content_id ) {

    global $wpdb;

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_h5p_points_per_score_';

    // Bail if no content
    if( ! $data ) {
        return;
    }

    // Get the h5p content name
    $content_name = $wpdb->get_var( $wpdb->prepare(
        "SELECT c.title
        FROM {$wpdb->prefix}h5p_contents c
        WHERE c.id = %d",
        $content_id
    ) );

    $user_id = get_current_user_id();
    $score = absint( $data['score'] );

    foreach( gamipress_get_points_types() as $points_type => $type ) {

        // Skip if award points is not checked
        if( ! (bool) gamipress_get_post_meta( $type['ID'], $prefix . 'award_points' ) ) {
            continue;
        }

        $percent = (int) gamipress_get_post_meta( $type['ID'], $prefix . 'percent' );

        // Skip if percent is not higher than 0
        if( $percent <= 0 ) {
            continue;
        }

        // Check if award is limited to 1 time only
        if( (bool) gamipress_get_post_meta( $type['ID'], $prefix . 'one_time' ) ) {
            // Skip if points of this type has been already awarded
            if( (bool) get_post_meta( $content_id, $prefix . $points_type . '_awarded', true ) ) {
                continue;
            }
        }

        // Setup the ratio value used to convert the score into points
        $ratio = $percent / 100;

        $points_to_award = absint( $score * $ratio );

        /**
         * Filter to allow override this amount at any time
         *
         * @since 1.0.0
         *
         * @param int       $points_to_award    Points amount that will be awarded
         * @param int       $user_id            User ID that will receive the points
         * @param string    $points_type        Points type slug of the points amount
         * @param int       $percent            Percent setup on the points type
         *
         * @return int
         */
        $points_to_award = (int) apply_filters( 'gamipress_h5p_points_per_score_points_to_award', $points_to_award, $user_id, $points_type, $percent );

        // Award the points to the user
        if( $points_to_award > 0 ) {

            gamipress_award_points_to_user( $user_id, $points_to_award, $points_type );

            // Insert the custom user earning for the manual balance adjustment
            gamipress_insert_user_earning( $user_id, array(
                'title'	        => sprintf(
                    __( '%s for complete the content "%s" with a score of %s', 'gamipress-h5p-points-per-score' ),
                    gamipress_format_points( $points_to_award, $points_type ),
                    $content_name,
                    $score . ''
                ),
                'user_id'	    => $user_id,
                'post_id'	    => $type['ID'],
                'post_type' 	=> 'points-type',
                'points'	    => $points_to_award,
                'points_type'	=> $points_type,
                'date'	        => date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ),
            ) );

            // Set a post meta to meet that points have been awarded
            update_post_meta( $content_id, $prefix . $points_type . '_awarded', '1' );

        }
    }

}

add_action( 'h5p_alter_user_result', 'gamipress_h5p_points_per_score_completed', 10, 3 );