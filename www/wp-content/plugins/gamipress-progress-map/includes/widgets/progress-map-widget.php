<?php
/**
 * Progress Map Widget
 *
 * @package     GamiPress\Progress_Map\Widgets\Widget\Progress_Map
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class GamiPress_Progress_Map_Widget extends GamiPress_Widget {

    /**
     * Shortcode for this widget.
     *
     * @var string
     */
    protected $shortcode = 'gamipress_progress_map';

    public function __construct() {
        parent::__construct(
            $this->shortcode . '_widget',
            __( 'GamiPress: Progress Map', 'gamipress-progress-map' ),
            __( 'Render a desired progress map.', 'gamipress-progress-map' )
        );
    }

    public function get_fields() {

        // Need to change field id to progress_map_id to avoid problems with GamiPress javascript selectors
        $fields = GamiPress()->shortcodes[$this->shortcode]->fields;

        // Get the fields keys
        $keys = array_keys( $fields );

        // Get the numeric index of the field 'id'
        $index = array_search( 'id', $keys );

        // Replace the 'id' key by 'progress_map_id'
        $keys[$index] = 'progress_map_id';

        // Combine new array with new keys with an array of values
        $fields = array_combine( $keys, array_values( $fields ) );

        return $fields;
    }

    public function get_widget( $args, $instance ) {

        // Get back replaced fields
        $instance['id'] = $instance['progress_map_id'];

        // Title is rendered from widget
        $instance['title'] = '';

        // Build shortcode attributes from widget instance
        $atts = gamipress_build_shortcode_atts( $this->shortcode, $instance );

        echo gamipress_do_shortcode( $this->shortcode, $atts );
    }

}