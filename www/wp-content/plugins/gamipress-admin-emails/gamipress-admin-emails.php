<?php
/**
 * Plugin Name:     GamiPress - Admin Emails
 * Plugin URI:      https://gamipress.com/add-ons/gamipress-admin-emails
 * Description:     Send emails to your website administrators based on pre-defined conditions.
 * Version:         1.0.3
 * Author:          GamiPress
 * Author URI:      https://gamipress.com/
 * Text Domain:     gamipress-admin-emails
 * License:         GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         GamiPress\Admin_Emails
 * @author          GamiPress
 * @copyright       Copyright (c) GamiPress
 */

final class GamiPress_Admin_Emails {

    /**
     * @var         GamiPress_Admin_Emails $instance The one true GamiPress_Admin_Emails
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Admin_Emails self::$instance The one true GamiPress_Admin_Emails
     */
    public static function instance() {

        if( ! self::$instance ) {

            self::$instance = new GamiPress_Admin_Emails();
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
        define( 'GAMIPRESS_ADMIN_EMAILS_VER', '1.0.3' );

        // GamiPress minimum required version
        define( 'GAMIPRESS_ADMIN_EMAILS_GAMIPRESS_MIN_VER', '2.0.0' );

        // Plugin file
        define( 'GAMIPRESS_ADMIN_EMAILS_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_ADMIN_EMAILS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_ADMIN_EMAILS_URL', plugin_dir_url( __FILE__ ) );

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

            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/admin.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/custom-tables.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/admin-emails.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/functions.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/logs.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_ADMIN_EMAILS_DIR . 'includes/template-functions.php';

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

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );

    }

    /**
     * Activation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function activate() {

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function deactivate() {

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
                        __( 'GamiPress - Admin Emails requires %s (%s or higher) in order to work. Please install and activate it.', 'gamipress-admin-emails' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        GAMIPRESS_ADMIN_EMAILS_GAMIPRESS_MIN_VER
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

        if ( class_exists( 'GamiPress' ) && version_compare( GAMIPRESS_VER, GAMIPRESS_ADMIN_EMAILS_GAMIPRESS_MIN_VER, '>=' ) ) {
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
        $lang_dir = GAMIPRESS_ADMIN_EMAILS_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_admin_emails_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-admin-emails' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-admin-emails', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-admin-emails/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'gamipress-admin-emails', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'gamipress-admin-emails', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-admin-emails', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Admin_Emails instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Admin_Emails The one true GamiPress_Admin_Emails
 */
function gamipress_admin_emails() {
    return GamiPress_Admin_Emails::instance();
}
add_action( 'plugins_loaded', 'gamipress_admin_emails' );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_Admin_Emails', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_Admin_Emails', 'deactivate' ) );