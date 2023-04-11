<?php
/**
 * Blocks
 *
 * @package     GamiPress\Progress_Map\Blocks
 * @since       1.0.5
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin block icons
 *
 * @since 1.0.5
 *
 * @param array $icons
 *
 * @return array
 */
function gamipress_progress_maps_block_icons( $icons ) {

    $icons['progress-map'] =
        '<svg width="24" height="24" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" >
            <g transform="matrix(0.39762895,0,0,0.39762895,20.692351,-97.453533)" >
                <g transform="translate(0.01416119,0.06538758)">
                    <g transform="matrix(0,-0.10010745,0.09870129,0,-51.658795,314.36776)" >
                        <g transform="matrix(2.5542252,0,0,2.536499,419.19227,-106.37003)" >
                            <g transform="matrix(1.1239539,0,0,1.1132466,-140.5224,-45.526679)">
                                <g transform="translate(-2.6237117,7.749948)">
                                    <path d="M 204.51257,156.52623 H 60.206161 v 6.19824 H 204.51257 Z" />
                                    <path d="m 149.27931,159.65864 a 14.044403,14.411746 0 0 1 -14.0444,14.41173 14.044403,14.411746 0 0 1 -14.0444,-14.41173 14.044403,14.411746 0 0 1 14.0444,-14.41174 14.044403,14.411746 0 0 1 14.0444,14.41174 z" />
                                    <path d="m 84.750883,159.65863 c 0,7.95943 -6.287907,14.41178 -14.044407,14.41174 -7.75647,4e-5 -14.044384,-6.45231 -14.04439,-14.41174 4e-6,-4.73781 2.227921,-8.94164 5.66736,-11.56852 2.33874,-1.78619 5.2376,-2.84322 8.37703,-2.84321 7.7565,-5e-5 14.044407,6.45231 14.044407,14.41173 z" />
                                    <path d="m 214.17654,159.65863 a 14.044395,14.411745 0 0 1 -14.04439,14.41174 14.044395,14.411745 0 0 1 -14.04441,-14.41174 14.044395,14.411745 0 0 1 14.04441,-14.41173 14.044395,14.411745 0 0 1 14.04439,14.41173 z" />
                                </g>
                            </g>
                        </g>
                    </g>
                    <rect width="16.506767" height="6.1568251" x="-49.524441" y="248.48643" />
                    <path d="m -49.538601,285.70924 v 6.15465 h 16.508991 v -6.15465 z" />
                    <rect width="16.506767" height="6.1568251" x="-20.781872" y="267.17221" />
                </g>
            </g>        
        </svg>';

    return $icons;

}
add_filter( 'gamipress_block_icons', 'gamipress_progress_maps_block_icons' );

/**
 * Turn select2 fields into 'post' or 'user' field types
 *
 * @since 1.0.5
 *
 * @param array                 $fields
 * @param GamiPress_Shortcode   $shortcode
 *
 * @return array
 */
function gamipress_progress_maps_block_fields( $fields, $shortcode ) {

    switch ( $shortcode->slug ) {
        case 'gamipress_progress_map':
            // Progress Map ID
            $fields['id']['type'] = 'post';
            $fields['id']['post_type'] = 'progress-map';
            break;
    }

    return $fields;

}
add_filter( 'gamipress_get_block_fields', 'gamipress_progress_maps_block_fields', 11, 2 );
