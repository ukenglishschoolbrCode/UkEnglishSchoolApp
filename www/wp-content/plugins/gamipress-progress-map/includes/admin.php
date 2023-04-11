<?php
/**
 * Admin
 *
 * @package     GamiPress\Progress_Map\Admin
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcut function to get plugin options
 *
 * @since  1.0.0
 *
 * @param string    $option_name
 * @param bool      $default
 *
 * @return mixed
 */
function gamipress_progress_map_get_option( $option_name, $default = false ) {

    $prefix = 'gamipress_progress_map_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * Add GamiPress Progress Map admin bar menu
 *
 * @since 1.0.4
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
function gamipress_progress_map_admin_bar_menu( $wp_admin_bar ) {

    // - Progress Maps
    $wp_admin_bar->add_node( array(
        'id'     => 'gamipress-progress-map',
        'title'  => __( 'Progress Maps', 'gamipress-progress-map' ),
        'parent' => 'gamipress',
        'href'   => admin_url( 'edit.php?post_type=progress-map' )
    ) );

}
add_action( 'admin_bar_menu', 'gamipress_progress_map_admin_bar_menu', 100 );

/**
 * GamiPress Progress Map Settings meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_progress_map_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'gamipress_progress_map_';

    $meta_boxes['gamipress-progress-map-settings'] = array(
        'title' => gamipress_dashicon( 'progress-map' ) . __( 'Progress Map', 'gamipress-progress-map' ),
        'fields' => apply_filters( 'gamipress_progress_map_settings_fields', array(
            $prefix . 'post_type_title' => array(
                'name' => __( 'Progress Map Post Type', 'gamipress-progress-map' ),
                'desc' => __( 'From this settings you can modify the default configuration of the progress map post type.', 'gamipress-progress-map' ),
                'type' => 'title',
            ),
            $prefix . 'slug' => array(
                'name' => __( 'Slug', 'gamipress-progress-map' ),
                'desc' => '<span class="gamipress-progress-map-full-slug hide-if-no-js">' . site_url() . '/<strong class="gamipress-progress-map-slug"></strong>/</span>',
                'type' => 'text',
                'default' => 'progress-maps',
            ),
            $prefix . 'public' => array(
                'name' => __( 'Public', 'gamipress-progress-map' ),
                'desc' => __( 'Check this option if you want to allow to your visitors access to a progress map as a page. Not checking this option will make progress map just visible through shortcodes or widgets.', 'gamipress-progress-map' ),
                'type' => 'checkbox',
                'classes' => 'gamipress-switch',
            ),
            $prefix . 'supports' => array(
                'name' => __( 'Supports', 'gamipress-progress-map' ),
                'desc' => __( 'Check the features you want to add to the progress map post type.', 'gamipress-progress-map' ),
                'type' => 'multicheck',
                'classes' => 'gamipress-switch',
                'options' => array(
                    'title'             => __( 'Title' ),
                    'editor'            => __( 'Editor' ),
                    'author'            => __( 'Author' ),
                    'thumbnail'         => __( 'Thumbnail' ) . ' (' . __( 'Featured Image' ) . ')',
                    'excerpt'           => __( 'Excerpt' ),
                    'trackbacks'        => __( 'Trackbacks' ),
                    'custom-fields'     => __( 'Custom Fields' ),
                    'comments'          => __( 'Comments' ),
                    'revisions'         => __( 'Revisions' ),
                    'page-attributes'   => __( 'Page Attributes' ),
                    'post-formats'      => __( 'Post Formats' ),
                ),
                'default' => array( 'title', 'editor', 'excerpt' )
            ),
        ) )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_progress_map_settings_meta_boxes' );

/**
 * GamiPress Progress Map Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_progress_map_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-progress-map-license'] = array(
        'title' => __( 'GamiPress Progress Map', 'gamipress-progress-map' ),
        'fields' => array(
            'gamipress_progress_map_license' => array(
                'name' => __( 'License', 'gamipress-progress-map' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_PROGRESS_MAP_FILE,
                'item_name' => 'Progress Map',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_progress_map_licenses_meta_boxes' );

/**
 * GamiPress Progress Map automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_progress_map_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-progress-map'] = __( 'Progress Map', 'gamipress-progress-map' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_progress_map_automatic_updates' );

/**
 * Register custom meta boxes used throughout GamiPress
 *
 * @since  1.0.0
 */
function gamipress_progress_map_meta_boxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_progress_map_';

    // Setup achievement types options
    $achievement_types_options = array();

    foreach( gamipress_get_achievement_types() as $achievement_type_slug => $data ) {
        $achievement_types_options[$achievement_type_slug] = $data['plural_name'];
    }

    $type_options = array(
        'specific-achievements' => __( 'Specific Achievements', 'gamipress-progress-map' ),
        'all-achievements' => __( 'All Achievements of Type', 'gamipress-progress-map' ),
    );

    // Setup rank types and slugs options (They will be empty if GamiPress is not update to 1.3.1)
    $rank_types_options = array();
    $rank_slugs = array();

    // TODO: rank are just available from 1.3.1 so a future remove check
    if ( version_compare( GAMIPRESS_VER, '1.3.1', '>=' ) ) {

        // Add type options based on ranks
        $type_options['specific-ranks'] = __( 'Specific Ranks', 'gamipress-progress-map' );
        $type_options['all-ranks'] = __( 'All Ranks of Type', 'gamipress-progress-map' );

        // Get the rank slugs for the ajax search field
        $rank_slugs = gamipress_get_rank_types_slugs();

        // Setup the rank type options for the rank type field
        foreach( gamipress_get_rank_types() as $rank_type_slug => $data ) {
            $rank_types_options[$rank_type_slug] = $data['plural_name'];
        }
    }

    // Progress Map Data
    gamipress_add_meta_box(
        'progress-map-data',
        __( 'Progress Map Data', 'gamipress-progress-map' ),
        'progress-map',
        array(
            $prefix . 'type' => array(
                'name' 	=> __( 'Type', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Choose the progress map type', 'gamipress-progress-map' ),
                'type' 	=> 'select',
                'options'	=> $type_options,
                'default' => 'specific-achievements'
            ),
            $prefix . 'achievements' => array(
                'name' 	=> __( 'Achievements', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Choose the specific achievements to show as progress map items.', 'gamipress-progress-map' ),
                'type' 	=> 'post_ajax_search',
                'multiple'      => true,
                'sortable'      => true,
                'query_args'	=> array(
                    'post_type'			=> gamipress_get_achievement_types_slugs(),
                    'posts_per_page'	=> -1
                )
            ),
            $prefix . 'achievement_type' => array(
                'name' 	=> __( 'Achievement Type', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Choose the achievement type of the achievements to show as progress map items.', 'gamipress-progress-map' ),
                'type' 	=> 'select',
                'options'	    => $achievement_types_options
            ),
            $prefix . 'ranks' => array(
                'name' 	=> __( 'Ranks', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Choose the specific ranks to show as progress map items.', 'gamipress-progress-map' ),
                'type' 	=> 'post_ajax_search',
                'multiple'      => true,
                'sortable'      => true,
                'query_args'	=> array(
                    'post_type'			=> $rank_slugs,
                    'posts_per_page'	=> -1
                )
            ),
            $prefix . 'rank_type' => array(
                'name' 	=> __( 'Rank Type', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Choose the rank type of the ranks to show as progress map items.', 'gamipress-progress-map' ),
                'type' 	=> 'select',
                'options'	=> $rank_types_options
            ),
        ),
        array( 'priority' => 'high', )
    );

    // Setup the achievement fields
    $achievement_fields = array();

    $original_achievement_fields = GamiPress()->shortcodes['gamipress_achievement']->fields;

    unset( $original_achievement_fields['id'] );

    foreach( $original_achievement_fields as $achievement_field_id => $achievement_field ) {

        if( $achievement_field['type'] === 'checkbox' && isset( $achievement_field['default'] ) ) {
            unset( $achievement_field['default'] );
        }

        $achievement_fields[$prefix . $achievement_field_id] = $achievement_field;
    }

    // Setup the rank fields
    $rank_fields = array();

    // TODO: rank are just available from 1.3.1 so a future remove check
    if ( version_compare( GAMIPRESS_VER, '1.3.1', '>=' ) ) {

        $original_rank_fields = GamiPress()->shortcodes['gamipress_rank']->fields;

        unset( $original_rank_fields['id'] );

        foreach( $original_rank_fields as $rank_field_id => $rank_field ) {

            if( $rank_field['type'] === 'checkbox' && isset( $rank_field['default'] ) ) {
                unset( $rank_field['default'] );
            }

            // Need to add prefix 'rank_' to avoid issues with achievement fields
            $rank_fields[$prefix . 'rank_' . $rank_field_id] = $rank_field;
        }

    }

    $color_picker = class_exists( 'CMB2_Type_Colorpicker' ) ? 'colorpicker' : 'rgba_colorpicker';

    // Progress Map Display Options
    gamipress_add_meta_box(
        'progress-map-display-options',
        __( 'Progress Map Display Options', 'gamipress-progress-map' ),
        'progress-map',
        array_merge( array(
            $prefix . 'direction' => array(
                'name' 	=> __( 'Direction', 'gamipress-progress-map' ),
                'type' 	=> 'radio',
                'inline' 	=> true,
                'options'	=> array(
                    'vertical'      => __( 'Vertical', 'gamipress-progress-map' ),
                    'horizontal'    => __( 'Horizontal', 'gamipress-progress-map' )
                ),
                'default' => 'vertical'
            ),
            $prefix . 'alignment' => array(
                'name' 	=> __( 'Alignment', 'gamipress-progress-map' ),
                'type' 	=> 'radio',
                'inline' 	=> true,
                'options'	=> array(
                    'top'       => __( 'Top', 'gamipress-progress-map' ),
                    'left'      => __( 'Left', 'gamipress-progress-map' ),
                    'center'	=> __( 'Center', 'gamipress-progress-map' ),
                    'bottom'	=> __( 'Bottom', 'gamipress-progress-map' ),
                    'right'	    => __( 'Right', 'gamipress-progress-map' )
                ),
                'default' => 'center'
            ),
            $prefix . 'bar_color' => array(
                'name' 	=> __( 'Progress Bar Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#0098d7',
            ),
            $prefix . 'bar_background_color' => array(
                'name' 	=> __( 'Progress Bar Background Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#eeeeee',
            ),
            $prefix . 'mark_text_color' => array(
                'name' 	=> __( 'Mark Text Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#000000',
            ),
            $prefix . 'mark_background_color' => array(
                'name' 	=> __( 'Mark Background Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#eeeeee',
            ),
            $prefix . 'completed_mark_text_color' => array(
                'name' 	=> __( 'Completed Mark Text Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#ffffff',
            ),
            $prefix . 'completed_mark_background_color' => array(
                'name' 	=> __( 'Completed Mark Background Color', 'gamipress-progress-map' ),
                'type' 	=> $color_picker,
                'options' => array( 'alpha' => true ),
                'default' => '#0098d7',
            ),
            $prefix . 'hide_upcoming_achievements' => array(
                'name' 	=> __( 'Hide Upcoming Items', 'gamipress-progress-map' ),
                'desc' 	=> __( 'Check this option to hide the text of upcoming items.', 'gamipress-progress-map' ),
                'type' 	=> 'checkbox',
                'classes' 	=> 'gamipress-switch',
            ),
        ), $achievement_fields, $rank_fields ),
        array(
            'priority' => 'high',
            'tabs' => array(
                'progress-map' => array(
                    'icon' => 'dashicons-admin-generic',
                    'title' => __( 'Progress Map', 'gamipress-progress-map' ),
                    'fields' => array(
                        $prefix . 'direction',
                        $prefix . 'alignment',
                        $prefix . 'bar_color',
                        $prefix . 'bar_background_color',
                        $prefix . 'mark_text_color',
                        $prefix . 'mark_background_color',
                        $prefix . 'completed_mark_text_color',
                        $prefix . 'completed_mark_background_color',
                        $prefix . 'hide_upcoming_achievements',
                    ),
                ),
                'achievement' => array(
                    'icon' => 'dashicons-awards',
                    'title' => __( 'Achievement', 'gamipress-progress-map' ),
                    'fields' => array_keys( $achievement_fields ),
                ),
                'rank' => array(
                    'icon' => 'dashicons-rank',
                    'title' => __( 'Rank', 'gamipress-progress-map' ),
                    'fields' => array_keys( $rank_fields ),
                ),
            ),
        )
    );

    // Progress Map Shortcode
    gamipress_add_meta_box(
        'progress-map-shortcode',
        __( 'Progress Map Shortcode', 'gamipress-progress-map' ),
        'progress-map',
        array(
            $prefix . 'shortcode' => array(
                'desc' 	        => __( 'Place this shortcode anywhere to display this progress map.', 'gamipress-progress-map' ),
                'type' 	        => 'text',
                'attributes'    => array(
                    'readonly'  => 'readonly',
                    'onclick'   => 'this.focus(); this.select();'
                ),
                'default_cb'    => 'gamipress_progress_map_shortcode_field_default_cb'
            ),
        ),
        array(
            'context'  => 'side',
            'priority' => 'default'
        )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_progress_map_meta_boxes' );

/**
 * Custom text rendering for Ajax search results
 *
 * @since 1.0.0
 *
 * @param string    $text
 * @param integer   $object_id
 * @param string    $object_type
 *
 * @return string
 */
function gamipress_progress_map_achievements_ajax_search_result_text( $text, $object_id, $object_type ) {
    $achievement_types = gamipress_get_achievement_types();

    $post_type = get_post_type( $object_id );

    if( isset( $achievement_types[$post_type] ) ) {
        $singular = $achievement_types[$post_type]['singular_name'];
    } else {
        $singular = ucfirst( $post_type );
    }

    $text = sprintf( '#%s - %s (%s)', $object_id, $text, $singular ); // #123 - Post title (post type)

    return $text;
}
add_filter( 'cmb__gamipress_progress_map_achievements_ajax_search_result_text', 'gamipress_progress_map_achievements_ajax_search_result_text', 10, 3 );

/**
 * Custom text rendering for Ajax search results
 *
 * @since 1.0.1
 *
 * @param string    $text
 * @param integer   $object_id
 * @param string    $object_type
 *
 * @return string
 */
function gamipress_progress_map_ranks_ajax_search_result_text( $text, $object_id, $object_type ) {
    $rank_types = gamipress_get_rank_types();

    $post_type = get_post_type( $object_id );

    if( isset( $rank_types[$post_type] ) ) {
        $singular = $rank_types[$post_type]['singular_name'];
    } else {
        $singular = ucfirst( $post_type );
    }

    $text = sprintf( '#%s - %s (%s)', $object_id, $text, $singular ); // #123 - Post title (post type)

    return $text;
}
add_filter( 'cmb__gamipress_progress_map_ranks_ajax_search_result_text', 'gamipress_progress_map_ranks_ajax_search_result_text', 10, 3 );

// Shortcode field default cb
function gamipress_progress_map_shortcode_field_default_cb( $field_args, $field ) {
    return '[gamipress_progress_map id="' . $field->object_id . '"]';
}