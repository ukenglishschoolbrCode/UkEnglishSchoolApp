<?php
/**
 * Filters
 *
 * @package GamiPress\Mark_As_Completed\Filters
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Filter requirements titles
 *
 * @since   1.0.0
 *
 * @param  string   $title          The requirement title
 * @param  object   $requirement    The requirement object
 * @param int       $user_id        User's ID
 * @param array     $template_args  The given template args
 *
 * @return string
 */
function gamipress_mark_as_completed_markup( $title = '', $requirement = null, $user_id = 0, $template_args = array() ) {

    $user_id = get_current_user_id();

    // Guest not supported yet
    if( $user_id === 0 ) {
        return $title;
    }

    if( ! isset( $template_args['user_id'] ) ) {
        $template_args['user_id'] = get_current_user_id();
    }

    // Return if user is displaying achievements of another user
    if( $user_id !== absint( $template_args['user_id'] ) ) {
        return $title;
    }

    $trigger = gamipress_get_post_meta( $requirement->ID, '_gamipress_trigger_type', true );

    // Bail if not is our trigger type
    if( $trigger !== 'gamipress_mark_as_completed' ) {
        return $title;
    }

    $can_earn = gamipress_can_user_earn_requirement( $requirement->ID, $user_id );
    $completed = ! $can_earn;

    // Special check for steps and rank requirements
    if( in_array( $requirement->post_type, array( 'step', 'rank-requirement' ) ) ) {
        $completed = ! $can_earn && gamipress_has_user_earned_achievement( $requirement->ID, $user_id );
    }

    // Setup the input display
    $show_as = gamipress_get_post_meta( $requirement->ID, '_gamipress_mark_as_completed_show_as', true );

    switch ( $show_as ) {
        case 'button':
            $button_text = gamipress_get_post_meta( $requirement->ID, '_gamipress_mark_as_completed_button_text', true );
            $button_text_completed = gamipress_get_post_meta( $requirement->ID, '_gamipress_mark_as_completed_button_text_completed', true );

            if( empty( $button_text ) ) {
                $button_text = __( 'Mark as completed', 'gamipress-mark-as-completed' );
            }

            if( empty( $button_text_completed ) ) {
                $button_text_completed = __( 'Completed!', 'gamipress-mark-as-completed' );
            }

            $input = '<button type="button" class="gamipress-mark-as-completed-button" ' . ( $completed ? 'data-disabled="true"' : '' ) . ' data-id="' . $requirement->ID . '" data-text-completed="' . $button_text_completed . '">'
                    . ( $completed ? $button_text_completed : $button_text )
                . '</button>';
            break;
        case 'checkbox':
        default:
            $input = '<input type="checkbox" class="gamipress-mark-as-completed-checkbox" ' . ( $completed ? 'checked' : '' ) . ' data-id="' . $requirement->ID . '">';
            break;
    }

    // Setup the placement of the input
    $position = gamipress_get_post_meta( $requirement->ID, '_gamipress_mark_as_completed_position', true );

    switch ( $position ) {
        case 'after':
            $title .= ' ' . $input;
            break;
        case 'before':
        default:
            $title = $input . ' ' . $title;
            break;
    }


    return $title;

}
add_filter( 'gamipress_step_title_display', 'gamipress_mark_as_completed_markup', 9999, 4 );
add_filter( 'gamipress_points_award_title_display', 'gamipress_mark_as_completed_markup', 9999, 4 );
add_filter( 'gamipress_points_deduct_title_display', 'gamipress_mark_as_completed_markup', 9999, 4 );
add_filter( 'gamipress_rank_requirement_title_display', 'gamipress_mark_as_completed_markup', 9999, 4 );