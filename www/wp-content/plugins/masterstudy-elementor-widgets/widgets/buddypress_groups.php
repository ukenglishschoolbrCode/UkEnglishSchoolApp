<?php

use Elementor\Controls_Manager;

class Elementor_STM_Buddypress_Groups extends \Elementor\Widget_Base {


	public function get_name() {
		return 'stm_buddypress_groups';
	}

	public function get_title() {
		return esc_html__( 'Buddypress Groups', 'masterstudy-elementor-widgets' );
	}

	public function get_icon() {
		return 'ms-elementor-buddypress_groups lms-icon';
	}

	public function get_categories() {
		return array( 'stm_lms_theme' );
	}

	public function add_dimensions( $selector = '' ) {  }

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'elementor-stm-widgets' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'masterstudy-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type Title here', 'masterstudy-elementor-widgets' ),
			)
		);

		$this->end_controls_section();

		$this->add_dimensions( '.masterstudy_elementor_buddypress_groups_' );

	}

	protected function render() {
		if ( function_exists( 'masterstudy_show_template' ) ) {

			$settings = $this->get_settings_for_display();

			$settings['css_class'] = ' masterstudy_elementor_buddypress_groups_';

			masterstudy_show_template( 'buddypress_groups', $settings );

		}
	}

	protected function content_template() {
	}

}
