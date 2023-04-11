<?php
/**
 * Functions
 *
 * @package     GamiPress\Progress_Map\Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add hooks to override the items render output
 */
function gamipress_progress_map_enable_unknown_items() {

    // Achievement filters
    add_filter( 'gamipress_render_achievement', 'gamipress_progress_map_unknown_achievement', 999, 3 );
    add_filter( 'gamipress_step_title_display', 'gamipress_progress_map_unknown_step', 999, 4 );

    // Rank filters
    add_filter( 'gamipress_render_rank', 'gamipress_progress_map_unknown_rank', 999, 3 );
    add_filter( 'gamipress_rank_requirement_title_display', 'gamipress_progress_map_unknown_rank_requirement', 999, 4 );

    // Common filters
    add_filter( 'the_title', 'gamipress_progress_map_unknown_title', 999, 2 );
    add_filter( 'post_excerpt', 'gamipress_progress_map_unknown_description', 999, 3 );
    add_filter( 'post_content', 'gamipress_progress_map_unknown_description', 999, 3 );

}

/**
 * Remove the hooks previously added to override the items render output
 */
function gamipress_progress_map_disable_unknown_items() {

    // Remove achievement filters
    remove_filter( 'gamipress_render_achievement', 'gamipress_progress_map_unknown_achievement', 999, 3 );
    remove_filter( 'gamipress_step_title_display', 'gamipress_progress_map_unknown_step', 999, 4 );

    // Remove rank filters
    remove_filter( 'gamipress_render_rank', 'gamipress_progress_map_unknown_rank', 999, 3 );
    remove_filter( 'gamipress_rank_requirement_title_display', 'gamipress_progress_map_unknown_rank_requirement', 999, 4 );

    // Remove common filters
    remove_filter( 'the_title', 'gamipress_progress_map_unknown_title', 999, 4 );
    remove_filter( 'post_excerpt', 'gamipress_progress_map_unknown_description', 999, 3 );
    remove_filter( 'post_content', 'gamipress_progress_map_unknown_description', 999, 3 );

}

function gamipress_progress_map_unknown_title( $title, $post_id = null ) {
    return '???';
}

function gamipress_progress_map_unknown_description( $value, $post_id, $context ) {
    return '???';
}

function gamipress_progress_map_unknown_step( $title, $step, $user_id, $template_args ) {
    return '???';
}

function gamipress_progress_map_unknown_achievement( $output, $achievement_id, $achievement ) {

    // Replace .gamipress-achievement-title text (and the link) with ???
    $output = preg_replace('/(<.*?class="(.*?gamipress-achievement-title.*?)">)(.*?)(<\/.*?>)/', '$1???$4', $output);

    return $output;

}

function gamipress_progress_map_unknown_rank_requirement( $title, $rank_requirement, $user_id, $template_args ) {
    return '???';
}

function gamipress_progress_map_unknown_rank( $output, $rank_id, $rank ) {

    // Replace .gamipress-rank-title text (and the link) with ???
    $output = preg_replace('/(<.*?class="(.*?gamipress-rank-title.*?)">)(.*?)(<\/.*?>)/', '$1???$4', $output);

    return $output;

}