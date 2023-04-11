<?php
global $pmpro_msg, $pmpro_msgt, $pmpro_confirm, $current_user, $wpdb;

if ( isset( $_REQUEST['levelstocancel'] ) && 'all' !== $_REQUEST['levelstocancel'] ) {
	// convert spaces back to +
	$_REQUEST['levelstocancel'] = str_replace( array( ' ', '%20' ), '+', $_REQUEST['levelstocancel'] );

	// get the ids
	$old_level_ids = array_map( 'intval', explode( '+', preg_replace( '/[^0-9al\+]/', '', $_REQUEST['levelstocancel'] ) ) );

} elseif ( isset( $_REQUEST['levelstocancel'] ) && 'all' == $_REQUEST['levelstocancel'] ) {
	$old_level_ids = 'all';
} else {
	$old_level_ids = false;
}
?>
<div id="pmpro_cancel" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cancel_wrap', 'pmpro_cancel' ) ); ?>">
	<?php
	if ( $pmpro_msg ) {
		?>
		<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ) ); ?>"><?php echo wp_kses_post( $pmpro_msg ); ?></div>
		<?php
	}
	?>
	<?php
	if ( ! $pmpro_confirm ) {
		?>
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/pmpro_img/pmpro_cancel_icon.svg' ); ?>" alt="">
		<?php
		if ( $old_level_ids ) {
			if ( ! is_array( $old_level_ids ) && 'all' == $old_level_ids ) {
				?>
				<p><?php esc_html_e( 'Are you sure you want to cancel your membership?', 'masterstudy' ); ?></p>
				<?php
			} else {
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$level_names = $wpdb->get_col( "SELECT name FROM $wpdb->pmpro_membership_levels WHERE id IN('" . implode( "','", $old_level_ids ) . "')" );
				?>
				<p><?php printf( esc_html( _n( 'Are you sure you want to cancel your %s membership?', 'Are you sure you want to cancel your %s memberships?', count( $level_names ), 'masterstudy' ) ), esc_html( pmpro_implodeToEnglish( $level_names ) ) ); ?></p>
				<?php
			}
			?>
			<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_actionlinks' ) ); ?>">
				<a class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_btn pmpro_btn-submit pmpro_yeslink yeslink', 'pmpro_btn-submit' ) ); ?>" href="<?php echo esc_url( pmpro_url( 'cancel', '?levelstocancel=' . esc_attr( $_REQUEST['levelstocancel'] ) . '&confirm=true' ) ); ?>"><?php esc_html_e( 'Yes, cancel this membership', 'masterstudy' ); ?></a>
				<a class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_btn pmpro_btn-cancel pmpro_nolink nolink', 'pmpro_btn-cancel' ) ); ?>" href="<?php echo esc_url( STM_LMS_User::my_pmpro_url() ); ?>"><?php esc_html_e( 'No, keep this membership', 'masterstudy' ); ?></a>
			</div>
			<?php
		} else {
			if ( $current_user->membership_level->ID ) {
				?>
				<h2><?php esc_html_e( 'My Memberships', 'masterstudy' ); ?></h2>
				<table class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_table' ) ); ?>" width="100%" cellpadding="0" cellspacing="0" border="0">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Level', 'masterstudy' ); ?></th>
							<th><?php esc_html_e( 'Expiration', 'masterstudy' ); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$current_user->membership_levels = pmpro_getMembershipLevelsForUser( $current_user->ID );
					foreach ( $current_user->membership_levels as $level ) {
						?>
						<tr>
							<td class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cancel-membership-levelname' ) ); ?>">
						<?php echo esc_html( $level->name ); ?>
							</td>
							<td class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cancel-membership-expiration' ) ); ?>">
						<?php
						if ( $level->enddate ) {
							$expiration_text = date_i18n( get_option( 'date_format' ), $level->enddate );
						} else {
							$expiration_text = '---';
						}
						echo wp_kses_post( apply_filters( 'pmpro_account_membership_expiration_text', $expiration_text, $level ) );
						?>
							</td>
							<td class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cancel-membership-cancel' ) ); ?>">
								<a href="<?php echo esc_url( pmpro_url( 'cancel', '?levelstocancel=' . $level->id ) ); ?>"><?php esc_html_e( 'Cancel', 'masterstudy' ); ?></a>
							</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
				<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_actions_nav' ) ); ?>">
					<a href="<?php echo esc_url( pmpro_url( 'cancel', '?levelstocancel=all' ) ); ?>"><?php esc_html_e( 'Cancel All Memberships', 'masterstudy' ); ?></a>
				</div>
				<?php
			}
		}
	} else {
		?>
		<p class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cancel_return_home' ) ); ?>"><a href="<?php echo esc_url( get_home_url() ); ?>"><?php esc_html_e( 'Click here to go to the home page.', 'masterstudy' ); ?></a></p>
		<?php
	}
	?>
</div> <!-- end pmpro_cancel, pmpro_cancel_wrap -->
