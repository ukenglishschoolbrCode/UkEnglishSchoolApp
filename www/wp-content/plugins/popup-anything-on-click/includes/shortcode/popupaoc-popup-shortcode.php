<?php/** * 'popup_anything' Shortcode *  * @package Popup Anything on Click * @since 1.0 */if ( ! defined( 'ABSPATH' ) ) {	exit; // Exit if accessed directly.}function popupaoc_popup_shortcode( $atts, $content = null ) {	global $paoc_popup_data;	// Shortcode Parameter	$atts = shortcode_atts(array(		'id' => 0,	), $atts, 'popup_anything');	$atts['id'] = isset( $atts['id'] ) ? popupaoc_clean_number( $atts['id'] ) : false;	extract( $atts );	// Taking some variable	$prefix	= POPUPAOC_META_PREFIX;	$enable	= popupaoc_get_option( 'enable' );	// Return id popup is disabled from plugin settings	if( ! $enable ) {		return $content;	}	// Taking some variable	$post_status	= popupaoc_get_post_status( $id );	$post_type		= get_post_type( $id );	/* Timer ID is not there	 * Timer post status is not publish	 * Timer post type is not match	*/	if( empty( $id ) || $post_status != 'publish' || $post_type != POPUPAOC_POST_TYPE ) {		return $content;	}	// Taking some variables	$paoc_popup_data = ( ! empty( $paoc_popup_data ) && is_array( $paoc_popup_data ) ) ? $paoc_popup_data : array();	ob_start();	// Taking some variable	$unique			= popupaoc_get_unique();	$popup_appear	= get_post_meta( $id, $prefix.'popup_appear', true );	$behaviour		= popupaoc_get_meta( $id, $prefix.'behaviour' );	// Assigning it into global var	$paoc_popup_data[ $id ]['popup_id'] = $id;	// If `Popup Appear` is `Simple Link`	if( $popup_appear == 'simple_link' ) {		$link_text = isset( $behaviour['link_text'] ) ? $behaviour['link_text'] : __('Click Me!!!', 'popup-anything-on-click');	}	// If `Popup Appear` is `Image Click`	if( $popup_appear == 'image' ) {		$image_url			= isset( $behaviour['image_url'] )			? $behaviour['image_url']		: '';		$popup_img_id		= isset( $behaviour['popup_img_id'] )		? $behaviour['popup_img_id']	: 0;		$show_img_title		= ! empty( $behaviour['image_title'] )		? 1 : 0;		$show_img_caption	= ! empty( $behaviour['image_caption'] )	? 1 : 0;		$image_title		= '';		$image_caption		= '';		$image_alt			= '';		// Get Image `Title` & `Caption`		if( ! empty( $popup_img_id ) ) {			$image_data		= get_post( $popup_img_id );			$image_title	= $image_data->post_title;			$image_caption	= $image_data->post_excerpt;			$image_alt		= get_post_meta( $popup_img_id, '_wp_attachment_image_alt', true);		}	}	// If `Popup Appear` is `Button Click`	if( $popup_appear == 'button' ) {		$btn_text		= isset( $behaviour['btn_text'] )	? $behaviour['btn_text']	: __('Click Here!!!', 'popup-anything-on-click');		$button_class	= isset( $behaviour['btn_class'] )	? $behaviour['btn_class']	: '';	}	$design_file_path 	= POPUPAOC_DIR . '/templates/content.php';	$design_file_path 	= ( file_exists( $design_file_path ) ) ? $design_file_path : '';	// Include design html file	if( $design_file_path ) {		include( $design_file_path );	}	$content .= ob_get_clean();	return $content;}// Popup Shortcodeadd_shortcode( 'popup_anything', 'popupaoc_popup_shortcode' );