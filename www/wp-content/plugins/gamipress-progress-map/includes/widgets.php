<?php
/**
 * Widgets
 *
 * @package     GamiPress\Progress_Map\Widgets
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_PROGRESS_MAP_DIR .'includes/widgets/progress-map-widget.php';

// Register plugin widgets
function gamipress_progress_map_register_widgets() {
    register_widget( 'gamipress_progress_map_widget' );
}
add_action( 'widgets_init', 'gamipress_progress_map_register_widgets' );