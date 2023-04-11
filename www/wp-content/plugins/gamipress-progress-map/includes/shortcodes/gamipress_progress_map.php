<?php
/**
 * GamiPress Progress Map Shortcode
 *
 * @package     GamiPress\Progress_Map\Shortcodes\Shortcode\GamiPress_Progress_Map
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register the [gamipress_progress_map] shortcode.
 *
 * @since 1.0.0
 */
function gamipress_register_progress_map_shortcode() {
    gamipress_register_shortcode( 'gamipress_progress_map', array(
        'name'              => __( 'Progress Map', 'gamipress-progress-map' ),
        'description'       => __( 'Render the desired progress map.', 'gamipress-progress-map' ),
        'output_callback'   => 'gamipress_progress_map_shortcode',
        'icon'              => 'progress-map',
        'fields'            => array(
            'title' => array(
                'name' => __( 'Title', 'gamipress-progress-map' ),
                'type' => 'text',
                'default' => ''
            ),
            'id' => array(
                'name'              => __( 'Progress Map', 'gamipress-progress-map' ),
                'desc'              => __( 'Choose the progress map to display.', 'gamipress-progress-map' ),
                'type'              => 'select',
                'classes' 	        => 'gamipress-post-selector',
                'attributes' 	    => array(
                    'data-post-type'    => 'progress-map',
                    'data-placeholder'  => __( 'Select a Progress Map', 'gamipress-progress-map' ),
                ),
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
            'excerpt' => array(
                'name'        => __( 'Show Excerpt', 'gamipress-progress-map' ),
                'description' => __( 'Display the progress map short description.', 'gamipress-progress-map' ),
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
                'default' => 'yes'
            ),
            'user_id' => array(
                'name'        => __( 'User ID', 'gamipress-progress-map' ),
                'description' => __( 'Show progress map of a specific user, leave blank to progress map of current logged in user.', 'gamipress-progress-map' ),
                'type'        => 'select',
                'classes' 	        => 'gamipress-user-selector',
                'default'     => '',
                'options_cb'  => 'gamipress_options_cb_users'
            ),
        ),
    ) );
}
add_action( 'init', 'gamipress_register_progress_map_shortcode' );

/**
 * Social Share Shortcode.
 *
 * @since  1.0.0
 *
 * @param  array $atts Shortcode attributes.
 * @return string 	   HTML markup.
 */
function gamipress_progress_map_shortcode( $atts = array() ) {
    global $post, $gamipress_progress_map_template_args;

    // Progress map post vars
    $progress_map_id = isset( $atts['id'] ) && ! empty( $atts['id'] ) ? $atts['id'] : get_the_ID();
    $progress_map_post = gamipress_get_post( $progress_map_id );

    // Return if progress map post does not exists
    if( ! $progress_map_post )
        return '';

    // Return if not is a progress map
    if( $progress_map_post->post_type !== 'progress-map' )
        return '';

    // Return if progress map was not published
    if( $progress_map_post->post_status !== 'publish' )
        return '';

    $atts = shortcode_atts( array(
        'title'     => $progress_map_post->post_title,
        'id'        => $progress_map_id,
        'excerpt'   => 'yes',
        'user_id'   => '',
    ), $atts, 'gamipress_progress_map' );

    // Initialize user_id by current logged in user
    if( empty( $atts['user_id'] ) )
        $atts['user_id'] = get_current_user_id();

    // Initialize template args
    $gamipress_progress_map_template_args = array();

    $gamipress_progress_map_template_args = $atts;

    // Enqueue assets
    gamipress_progress_map_enqueue_scripts();

    // On network wide active installs, we need to switch to main blog mostly for posts permalinks and thumbnails
    $blog_id = gamipress_switch_to_main_site_if_network_wide_active();

    $post = $progress_map_post;

    setup_postdata( $post );

    // Render the progress map
    ob_start();
    gamipress_get_template_part( 'progress-map' );
    $output = ob_get_clean();

    wp_reset_postdata();

    // If switched to blog, return back to que current blog
    if( $blog_id !== get_current_blog_id() && is_multisite() )
        restore_current_blog();

    // Return our rendered progress map
    return $output;
}
