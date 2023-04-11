<?php
/**
 * Scripts
 *
 * @package     GamiPress\Daily_Login_Rewards\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_daily_login_rewards_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-daily-login-rewards-css', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/css/gamipress-daily-login-rewards' . $suffix . '.css', array( ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-daily-login-rewards-js', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/js/gamipress-daily-login-rewards' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, true );

}
add_action( 'init', 'gamipress_daily_login_rewards_register_scripts' );

/**
 * Enqueue frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_daily_login_rewards_enqueue_scripts( $hook = null ) {

    // Localize scripts
    wp_localize_script( 'gamipress-daily-login-rewards-js', 'gamipress_daily_login_rewards', array(
        'ajaxurl' => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
        'nonce' => wp_create_nonce( 'gamipress_daily_login_rewards' )
    ) );

    // Enqueue assets
    wp_enqueue_style( 'gamipress-daily-login-rewards-css' );
    wp_enqueue_script( 'gamipress-daily-login-rewards-js' );

}
add_action( 'wp_enqueue_scripts', 'gamipress_daily_login_rewards_enqueue_scripts', 100 );

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_daily_login_rewards_admin_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-daily-login-rewards-admin-css', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/css/gamipress-daily-login-rewards-admin' . $suffix . '.css', array( ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-daily-login-rewards-admin-js', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/js/gamipress-daily-login-rewards-admin' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, true );
    wp_register_script( 'gamipress-daily-login-rewards-rewards-ui-js', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/js/gamipress-daily-login-rewards-rewards-ui' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, true );
    wp_register_script( 'gamipress-daily-login-rewards-admin-widgets-js', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/js/gamipress-daily-login-rewards-admin-widgets' . $suffix . '.js', array( 'jquery', 'gamipress-select2-js' ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, true );
    wp_register_script( 'gamipress-daily-login-rewards-shortcode-editor-js', GAMIPRESS_DAILY_LOGIN_REWARDS_URL . 'assets/js/gamipress-daily-login-rewards-shortcode-editor' . $suffix . '.js', array( 'jquery', 'gamipress-select2-js' ), GAMIPRESS_DAILY_LOGIN_REWARDS_VER, true );

}
add_action( 'admin_init', 'gamipress_daily_login_rewards_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_daily_login_rewards_admin_enqueue_scripts( $hook ) {

    global $post_type;

    //Stylesheets
    wp_enqueue_style( 'gamipress-daily-login-rewards-admin-css' );

    //Scripts
    wp_localize_script( 'gamipress-daily-login-rewards-admin-js', 'gamipress_daily_login_rewards_admin', array(
        'nonce' => gamipress_get_admin_nonce(),
        'rewards_calendar_placeholder' => __( 'Select Calendar(s)', 'gamipress-daily-login-rewards' ),
    ) );

    wp_enqueue_script( 'gamipress-daily-login-rewards-admin-js' );

    // Rewards UI
    if( $post_type === 'rewards-calendar' ) {

        wp_enqueue_media();

        wp_localize_script( 'gamipress-daily-login-rewards-rewards-ui-js', 'gamipress_daily_login_rewards_rewards_ui', array(
            'nonce' => gamipress_get_admin_nonce(),
            'achievement_placeholder' => __( 'Select an Achievement', 'gamipress-daily-login-rewards' ),
            'rank_placeholder' => __( 'Select a Rank', 'gamipress-daily-login-rewards' ),
            'media_title' => __( 'Reward Image', 'gamipress-daily-login-rewards' ),
        ) );

        wp_enqueue_script( 'gamipress-daily-login-rewards-rewards-ui-js' );

    }

    // Widgets scripts
    if( $hook === 'widgets.php' ) {

        wp_localize_script( 'gamipress-daily-login-rewards-admin-widgets-js', 'gamipress_daily_login_rewards_admin_widgets', array(
            'nonce' => gamipress_get_admin_nonce(),
            'rewards_calendar_placeholder' => __( 'Select a Calendar', 'gamipress-daily-login-rewards' ),
        ) );

        wp_enqueue_script( 'gamipress-daily-login-rewards-admin-widgets-js' );

    }

    // Just enqueue on add/edit views and on post types that supports editor feature
    if( ( $hook === 'post.php' || $hook === 'post-new.php' ) && post_type_supports( $post_type, 'editor' ) ) {

        wp_localize_script( 'gamipress-daily-login-rewards-shortcode-editor-js', 'gamipress_daily_login_rewards_shortcode_editor', array(
            'nonce' => gamipress_get_admin_nonce(),
            'rewards_calendar_placeholder' => __( 'Select a Calendar', 'gamipress-daily-login-rewards' ),
        ) );

        wp_enqueue_script( 'gamipress-daily-login-rewards-shortcode-editor-js' );

    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_daily_login_rewards_admin_enqueue_scripts', 100 );