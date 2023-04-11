<?php
/*
	Admin code.
*/
// Wizard pre-header
include( PMPRO_DIR . '/adminpages/wizard/save-steps.php' );
require_once( PMPRO_DIR . '/includes/lib/SendWP/sendwp.php' );

/**
 * Redirect to Setup Wizard if the user hasn't been there yet.
 *
 * @since 1.10
 * @since 2.10 Redirects to the Setup Wizard instead.
 */
function pmpro_admin_init_redirect_to_dashboard() {
	// Can the current user view the dashboard?
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Check if we should redirect to the wizard. This should only happen on new installs and once.
	if ( pmpro_getOption( 'wizard_redirect', true ) ) {		
		delete_option( 'pmpro_wizard_redirect' );	// Deleting right away to avoid redirect loops.
		wp_redirect( admin_url( 'admin.php?page=pmpro-wizard' ) );
		exit;
	}
}
add_action( 'admin_init', 'pmpro_admin_init_redirect_to_dashboard' );

/**
 * Block Subscibers from accessing the WordPress Dashboard.
 *
 * @since 2.3.4
 */
function pmpro_block_dashboard_redirect() {
	if ( pmpro_block_dashboard() ) {
		wp_redirect( pmpro_url( 'account' ) );
		exit;
	}
}
add_action( 'admin_init', 'pmpro_block_dashboard_redirect', 9 );

/**
 * Is the current user blocked from the dashboard
 * per the advanced setting.
 *
 * @since 2.3
 */
function pmpro_block_dashboard() {
	global $current_user, $pagenow;

	$block_dashboard = pmpro_getOption( 'block_dashboard' );

	if (
		! wp_doing_ajax()
		&& 'admin-post.php' !== $pagenow
		&& ! empty( $block_dashboard )
		&& ! current_user_can( 'manage_options' )
		&& ! current_user_can( 'edit_users' )
		&& ! current_user_can( 'edit_posts' )
		&& in_array( 'subscriber', (array) $current_user->roles )
	) {
		$block = true;
	} else {
		$block = false;
	}
	$block = apply_filters( 'pmpro_block_dashboard', $block );

	/**
	 * Allow filtering whether to block Dashboard access.
	 *
	 * @param bool $block Whether to block Dashboard access.
	 */
	return apply_filters( 'pmpro_block_dashboard', $block );
}

/**
 * Initialize our Site Health integration and add hooks.
 *
 * @since 2.6.2
 */
function pmpro_init_site_health_integration() {

	$site_health = PMPro_Site_Health::init();
	$site_health->hook();
}

add_action( 'admin_init', 'pmpro_init_site_health_integration' );

/**
 * Compare stored and current site URL and decide if we should go into pause mode
 *
 * @since 2.10
 */
function pmpro_site_url_check() {
	if ( pmpro_is_paused() ) {
		//We are paused, show a notice.
		add_action( 'admin_notices', 'pmpro_pause_mode_notice' );
	}
}
add_action( 'admin_init', 'pmpro_site_url_check' );

/**
 * Allows a user to deactivate pause mode and update the last known URL
 *
 * @since 2.10
 */
function pmpro_handle_pause_mode_actions() {

	// Can the current user view the dashboard?
	if ( current_user_can( 'pmpro_manage_pause_mode' ) ) {
		//We're attempting to reactivate all services.
		if( ! empty( $_REQUEST['pmpro-reactivate-services'] ) ) {			
			delete_option( 'pmpro_last_known_url' );
		}
	}

}
add_action( 'admin_init', 'pmpro_handle_pause_mode_actions' );

/**
 * Display a notice about pause mode being enabled
 *
 * @since 2.10
 */
function pmpro_pause_mode_notice() {
	global $current_user;
	if ( isset( $_REQUEST[ 'show_pause_notification' ] ) ) {
		$pmpro_show_pause_notification = (bool)$_REQUEST['show_pause_notification'];
	} else {
		$pmpro_show_pause_notification = false;
	}

	// Remove notice from dismissed user meta if URL parameter is set.
	$archived_notifications = get_user_meta( $current_user->ID, 'pmpro_archived_notifications', true );
	if ( ! is_array( $archived_notifications ) ) {
		$archived_notifications = array();
	}

	if ( array_key_exists( 'hide_pause_notification', $archived_notifications ) ) {
		$show_notice = false;
		if ( ! empty( $pmpro_show_pause_notification ) ) {
			unset( $archived_notifications['hide_pause_notification'] );
			update_user_meta( $current_user->ID, 'pmpro_archived_notifications', $archived_notifications );
			$show_notice = true;
		}
	} else {
		$show_notice = true;
	}

	if ( pmpro_is_paused() && ! empty( $show_notice ) ) {
		// Site is paused. Show the notice. ?>
		<div id="hide_pause_notification" class="notice notice-error pmpro_notification pmpro_notification-error">
			<button type="button" class="pmpro-notice-button notice-dismiss" value="hide_pause_notification"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'paid-memberships-pro' ); ?></span></button>
			<div class="pmpro_notification-icon">
				<span class="dashicons dashicons-warning"></span>
			</div>
			<div class="pmpro_notification-content">
				<h3><?php esc_html_e( 'Site URL Change Detected', 'paid-memberships-pro' ); ?></h3>
				<p><?php printf( __( '<strong>Warning:</strong> We have detected that your site URL has changed. All PMPro-related cron jobs and automated services have been disabled. Paid Memberships Pro considers %s to be the site URL.', 'paid-memberships-pro' ), '<code>' . esc_url( pmpro_getOption( 'last_known_url' ) ) . '</code>' ); ?></p>
				<?php if ( current_user_can( 'pmpro_manage_pause_mode' ) ) { ?>
				<p>
					<a href='#' id="hide_pause_notification_button" class='button' value="hide_pause_notification"><?php esc_html_e( 'Dismiss notice and keep all services paused', 'paid-memberships-pro' ); ?></a>
					<a href='<?php echo admin_url( '?pmpro-reactivate-services=true' ); ?>' class='button button-secondary'><?php esc_html_e( 'Update my primary domain and reactivate all services', 'paid-memberships-pro' ); ?></a>
				</p>
				<?php } else { ?>
					<p><?php _e( 'Only users with the <code>pmpro_manage_pause_mode</code> capability are able to deactivate pause mode.', 'paid-memberships-pro' ); ?></p>
				<?php } ?>
				</div>
		</div>
		<?php
	}
}

/**
 * Remove all WordPress admin notifications from our Wizard area as it's distracting.
 */
function pmpro_wizard_remove_admin_notices() {
	if ( is_admin() && ! empty( $_REQUEST['page'] ) && $_REQUEST['page'] == 'pmpro-wizard' ) {
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
	}
}
add_action( 'in_admin_header', 'pmpro_wizard_remove_admin_notices', 11 );