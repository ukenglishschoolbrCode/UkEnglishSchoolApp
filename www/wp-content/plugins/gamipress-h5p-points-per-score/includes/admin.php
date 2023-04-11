<?php
/**
 * Admin
 *
 * @package GamiPress\H5P\Points_Per_Score\Admin
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin meta boxes
 *
 * @since  1.0.0
 */
function gamipress_h5p_points_per_score_meta_boxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_h5p_points_per_score_';

    gamipress_add_meta_box(
        'gamipress-h5p-points-per-score',
        __( 'Points per H5P score', 'gamipress-h5p-points-per-score' ),
        'points-type',
        array(
            $prefix . 'award_points' => array(
                'name' 	=> __( 'Award points to users per H5P score?', 'gamipress-h5p-points-per-score' ),
                'desc' 	=> '',
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
            ),
            $prefix . 'percent' => array(
                'name' => __( 'Percent to award', 'gamipress-h5p-points-per-score' ),
                'desc' => __( 'Set the amount\'s percent to award.', 'gamipress-h5p-points-per-score' )
                    . '<br>' . __( 'A 100% will award the same user score as points (e.g. score of 40 = 40 points).', 'gamipress-h5p-points-per-score' )
                    . '<br>' . __( 'A 200% will award the double of the user score as points (e.g. score of 40 = 80 points).', 'gamipress-h5p-points-per-score' )
                    . '<br>' . __( 'A 50% will award the half of the user score as points (e.g. score of 40 = 20 points).', 'gamipress-h5p-points-per-score' ),
                'type' => 'text',
                'attributes' => array(
                    'type' => 'number',
                    'min' => '1',
                ),
                'default' => '100',
            ),
            $prefix . 'one_time' => array(
                'name' 	=> __( 'Award only one time', 'gamipress-h5p-points-per-score' ),
                'desc' 	=> __( 'Award the points only on first attempt. ', 'gamipress-h5p-points-per-score' ),
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
            ),
        ),
        array( 'context' => 'side' )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_h5p_points_per_score_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_h5p_points_per_score_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-h5p-points-per-score'] = __( 'H5P Points Per Score', 'gamipress-h5p-points-per-score' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_h5p_points_per_score_automatic_updates' );