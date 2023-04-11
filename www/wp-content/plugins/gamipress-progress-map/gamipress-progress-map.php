<?php
/**
 * Plugin Name:     GamiPress - Progress Map
 * Plugin URI:      https://gamipress.com/add-ons/gamipress-progress-map
 * Description:     Add interactive achievements progress maps to your site.
 * Version:         1.1.2
 * Author:          GamiPress
 * Author URI:      https://gamipress.com/
 * Text Domain:     gamipress-progress-map
 * License:         GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         GamiPress\Progress_Map
 * @author          GamiPress
 * @copyright       Copyright (c) GamiPress
 */

final class GamiPress_Progress_Map {

    /**
     * @var         GamiPress_Progress_Map $instance The one true GamiPress_Progress_Map
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Progress_Map self::$instance The one true GamiPress_Progress_Map
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_Progress_Map();
            self::$instance->constants();
            self::$instance->classes();
            self::$instance->libraries();
            self::$instance->includes();
            self::$instance->hooks();
            self::$instance->load_textdomain();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'GAMIPRESS_PROGRESS_MAP_VER', '1.1.2' );

        // GamiPress minimum required version
        define( 'GAMIPRESS_PROGRESS_MAP_GAMIPRESS_MIN_VER', '2.0.0' );

        // Plugin file
        define( 'GAMIPRESS_PROGRESS_MAP_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_PROGRESS_MAP_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_PROGRESS_MAP_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin classes
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function classes() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'classes/class-gamipress-progress-map-render.php';

        }
    }

    /**
     * Include plugin libraries
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function libraries() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'libraries/cmb2-field-ajax-search/cmb2-field-ajax-search.php';

        }
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/admin.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/content-filters.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/functions.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/post-types.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/blocks.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/shortcodes.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/template-functions.php';
            require_once GAMIPRESS_PROGRESS_MAP_DIR . 'includes/widgets.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {
        // Setup our activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    /**
     * Activation hook for the plugin.
     *
     * @since  1.0.0
     */
    function activate() {

        if( $this->meets_requirements() ) {

        }

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    function deactivate() {

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        if ( ! $this->meets_requirements() && ! defined( 'GAMIPRESS_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'GamiPress - Progress Map requires %s (%s or higher) in order to work. Please install and activate them.', 'gamipress-progress-map' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        GAMIPRESS_PROGRESS_MAP_GAMIPRESS_MIN_VER
                    ); ?>
                </p>
            </div>

            <?php define( 'GAMIPRESS_ADMIN_NOTICES', true ); ?>

        <?php endif;

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( class_exists( 'GamiPress' ) && version_compare( GAMIPRESS_VER, GAMIPRESS_PROGRESS_MAP_GAMIPRESS_MIN_VER, '>=' ) ) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = GAMIPRESS_PROGRESS_MAP_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_progress_map_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-progress-map' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-progress-map', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-progress-map/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'gamipress-progress-map', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'gamipress-progress-map', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-progress-map', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Progress_Map instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Progress_Map The one true GamiPress_Progress_Map
 */
function GamiPress_Progress_Map() {
    return GamiPress_Progress_Map::instance();
}
add_action( 'plugins_loaded', 'GamiPress_Progress_Map' );
