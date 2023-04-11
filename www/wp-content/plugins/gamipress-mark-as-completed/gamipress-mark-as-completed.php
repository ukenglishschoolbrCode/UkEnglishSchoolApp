<?php
/**
 * Plugin Name:         GamiPress - Mark As Completed
 * Plugin URI:          https://wordpress.org/plugins/gamipress-mark-as-completed/
 * Description:         Allow users to mark requirements as completed manually.
 * Version:             1.0.4
 * Author:              GamiPress
 * Author URI:          https://gamipress.com/
 * Text Domain:         gamipress-mark-as-completed
 * Domain Path: 		/languages/
 * Requires at least: 	4.4
 * Tested up to: 		5.7
 * License:             GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package             GamiPress\Mark_As_Completed
 * @author              GamiPress <contact@gamipress.com>
 * @copyright           Copyright (c) GamiPress
 */

final class GamiPress_Mark_As_Completed {

    /**
     * @var         GamiPress_Mark_As_Completed $instance The one true GamiPress_Mark_As_Completed
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Mark_As_Completed self::$instance The one true GamiPress_Mark_As_Completed
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_Mark_As_Completed();
            self::$instance->constants();
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
        define( 'GAMIPRESS_MARK_AS_COMPLETED_VER', '1.0.4' );

        // Plugin file
        define( 'GAMIPRESS_MARK_AS_COMPLETED_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_MARK_AS_COMPLETED_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_MARK_AS_COMPLETED_URL', plugin_dir_url( __FILE__ ) );
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

            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/admin.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/ajax-functions.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/filters.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/requirements.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/rules-engine.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_MARK_AS_COMPLETED_DIR . 'includes/triggers.php';

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
     */
    function activate() {

        if( $this->meets_requirements() ) {

        }

    }

    /**
     * Deactivation hook for the plugin.
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
                        __( 'GamiPress - Mark As Completed requires %s in order to work. Please install and activate them.', 'gamipress-mark-as-completed' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>'
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

        if ( class_exists( 'GamiPress' ) ) {
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
        $lang_dir = GAMIPRESS_MARK_AS_COMPLETED_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_mark_as_completed_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-mark-as-completed' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-mark-as-completed-integration', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-mark-as-completed-integration/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress-mark-as-completed-integration/ folder
            load_textdomain( 'gamipress-mark-as-completed', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress-mark-as-completed-integration/languages/ folder
            load_textdomain( 'gamipress-mark-as-completed', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-mark-as-completed', false, $lang_dir );
        }
    }

}

/**
 * The main function responsible for returning the one true GamiPress_Mark_As_Completed instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Mark_As_Completed The one true GamiPress_Mark_As_Completed
 */
function GamiPress_Mark_As_Completed() {
    return GamiPress_Mark_As_Completed::instance();
}
add_action( 'plugins_loaded', 'GamiPress_Mark_As_Completed' );
