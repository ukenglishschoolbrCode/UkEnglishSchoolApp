<?php
/**
 * Frontend Reports Points Types Chart Widget
 *
 * @package     GamiPress\Frontend_Reports\Widgets\Widget\Frontend_Reports_Points_Types_Chart
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class GamiPress_Frontend_Reports_Points_Types_Chart_Widget extends GamiPress_Widget {

    /**
     * Shortcode for this widget.
     *
     * @var string
     */
    protected $shortcode = 'gamipress_frontend_reports_points_types_chart';

    public function __construct() {
        parent::__construct(
            $this->shortcode . '_widget',
            __( 'GamiPress: Points Types Chart', 'gamipress-frontend-reports' ),
            __( 'Render a chart with user points balances of desired points type(s).', 'gamipress-frontend-reports' )
        );
    }

    public function get_tabs() {
        return GamiPress()->shortcodes[$this->shortcode]->tabs;
    }

    public function get_fields() {
        return GamiPress()->shortcodes[$this->shortcode]->fields;
    }

    public function get_widget( $args, $instance ) {
        // Build shortcode attributes from widget instance
        $atts = gamipress_build_shortcode_atts( $this->shortcode, $instance );

        echo gamipress_do_shortcode( $this->shortcode, $atts );
    }

}