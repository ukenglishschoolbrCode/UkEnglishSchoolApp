<?php
/**
 * Requirements
 *
 * @package GamiPress\Mark_As_Completed\Requirements
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Custom fields on requirements UI
 *
 * @since 1.0.0
 *
 * @param integer $requirement_id
 * @param integer $post_id
 */
function gamipress_mark_as_completed_after_requirement_title( $requirement_id, $post_id ) {

    $show_as = gamipress_get_post_meta( $requirement_id, '_gamipress_mark_as_completed_show_as', true );
    $position = gamipress_get_post_meta( $requirement_id, '_gamipress_mark_as_completed_position', true );
    $button_text = gamipress_get_post_meta( $requirement_id, '_gamipress_mark_as_completed_button_text', true );
    $button_text_completed = gamipress_get_post_meta( $requirement_id, '_gamipress_mark_as_completed_button_text_completed', true );

    if( empty( $button_text ) ) {
        $button_text = __( 'Mark as completed', 'gamipress-mark-as-completed' );
    }

    if( empty( $button_text_completed ) ) {
        $button_text_completed = __( 'Completed!', 'gamipress-mark-as-completed' );
    }?>
    <div class="gamipress-mark-as-completed-options" style="margin-top: 5px;">
        <label><?php _e( 'Show as:', 'gamipress-mark-as-completed' ); ?></label>
        <select name="mark_as_completed_show_as" class="input-mark-as-completed-show-as">
            <option value="checkbox" <?php selected( $show_as, 'checkbox' ); ?>><?php _e( 'Checkbox', 'gamipress-mark-as-completed' );  ?></option>
            <option value="button" <?php selected( $show_as, 'button' ); ?>><?php _e( 'Button', 'gamipress-mark-as-completed' );  ?></option>
        </select>
        <select name="mark_as_completed_position" class="input-mark-as-completed-position">
            <option value="before" <?php selected( $position, 'before' ); ?>><?php _e( 'Before', 'gamipress-mark-as-completed' );  ?></option>
            <option value="after" <?php selected( $position, 'after' ); ?>><?php _e( 'After', 'gamipress-mark-as-completed' );  ?></option>
        </select>
        <?php _e( 'the requirement label', 'gamipress-mark-as-completed' ); ?>
        <span class="gamipress-mark-as-completed-button-options" style="margin-left: -3px; <?php if( $show_as !== 'button' ) : ?>display: none;<?php endif; ?>">
            <?php _e( ', button label:', 'gamipress-mark-as-completed' ); ?>
            <input type="text" name="button_text" class="input-mark-as-completed-button-text" value="<?php echo $button_text; ?>" placeholder="<?php echo __( 'Button text', 'gamipress-mark-as-completed' ); ?>">
            <?php _e( 'button label on complete:', 'gamipress-mark-as-completed' );  ?>
            <input type="text" name="button_text_completed" class="input-mark-as-completed-button-text-completed" value="<?php echo $button_text_completed; ?>" placeholder="<?php echo __( 'Button text', 'gamipress-mark-as-completed' ); ?>">
        </span>
    </div>
    <?php
}
add_action( 'gamipress_requirement_ui_html_after_limit', 'gamipress_mark_as_completed_after_requirement_title', 10, 2 );

/**
 * Custom handler to save the custom fields on requirements UI
 *
 * @since 1.0.0
 *
 * @param $requirement_id
 * @param $requirement
 */
function gamipress_mark_as_completed_ajax_update_requirement( $requirement_id, $requirement ) {

    if( isset( $requirement['trigger_type'] ) ) {

        if( $requirement['trigger_type'] === 'gamipress_mark_as_completed' ) {
            update_post_meta( $requirement_id, '_gamipress_mark_as_completed_show_as', $requirement['mark_as_completed_show_as'] );
            update_post_meta( $requirement_id, '_gamipress_mark_as_completed_position', $requirement['mark_as_completed_position'] );
            update_post_meta( $requirement_id, '_gamipress_mark_as_completed_button_text', $requirement['mark_as_completed_button_text'] );
            update_post_meta( $requirement_id, '_gamipress_mark_as_completed_button_text_completed', $requirement['mark_as_completed_button_text_completed'] );
        }

    }
}
add_action( 'gamipress_ajax_update_requirement', 'gamipress_mark_as_completed_ajax_update_requirement', 10, 2 );