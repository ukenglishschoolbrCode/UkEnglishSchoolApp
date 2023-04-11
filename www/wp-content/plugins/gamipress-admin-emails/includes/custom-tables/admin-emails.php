<?php
/**
 * Admin Emails
 *
 * @package     GamiPress\Admin_Emails\Custom_Tables\Admin_Emails
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Define the search fields for logs
 *
 * @since 1.0.0
 *
 * @param array $search_fields
 *
 * @return array
 */
function gamipress_admin_emails_search_fields( $search_fields ) {

    $search_fields[] = 'title';

    return $search_fields;

}
add_filter( 'ct_query_gamipress_admin_emails_search_fields', 'gamipress_admin_emails_search_fields' );

/**
 * Columns for logs list view
 *
 * @since 1.2.8
 *
 * @param array $columns
 *
 * @return array
 */
function gamipress_manage_admin_emails_columns( $columns = array() ) {

    $columns['title']       = __( 'Title', 'gamipress-admin-emails' );
    $columns['status']      = __( 'Status', 'gamipress-admin-emails' );
    $columns['date']        = __( 'Date', 'gamipress-admin-emails' );

    return $columns;
}
add_filter( 'manage_gamipress_admin_emails_columns', 'gamipress_manage_admin_emails_columns' );

/**
 * Sortable columns for logs list view
 *
 * @since 1.6.7
 *
 * @param array $sortable_columns
 *
 * @return array
 */
function gamipress_manage_admin_emails_sortable_columns( $sortable_columns ) {

    $sortable_columns['title']      = array( 'title', false );
    $sortable_columns['status']     = array( 'status', false );
    $sortable_columns['date']       = array( 'date', true );

    return $sortable_columns;

}
add_filter( 'manage_gamipress_admin_emails_sortable_columns', 'gamipress_manage_admin_emails_sortable_columns' );

/**
 * Columns rendering for list view
 *
 * @since  1.0.0
 *
 * @param string $column_name
 * @param integer $object_id
 */
function gamipress_admin_emails_manage_admin_emails_custom_column( $column_name, $object_id ) {

    // Setup vars
    $prefix = '_gamipress_admin_emails_';
    $admin_email = ct_get_object( $object_id );

    switch( $column_name ) {
        case 'title':
            ?>

            <strong>
                <a href="<?php echo ct_get_edit_link( 'gamipress_admin_emails', $admin_email->admin_email_id ); ?>"><?php echo $admin_email->title . ' (ID:' . $admin_email->admin_email_id . ')'; ?></a>
            </strong>

            <?php
            break;
        case 'status':
            $statuses = gamipress_admin_emails_get_admin_email_statuses(); ?>

            <span class="gamipress-admin-emails-status gamipress-admin-emails-status-<?php echo $admin_email->status; ?>"><?php echo ( isset( $statuses[$admin_email->status] ) ? $statuses[$admin_email->status] : $admin_email->status ); ?></span>

            <?php
            break;
        case 'date':
            ?>

            <abbr title="<?php echo date( 'Y/m/d g:i:s a', strtotime( $admin_email->date ) ); ?>"><?php echo date( 'Y/m/d', strtotime( $admin_email->date ) ); ?></abbr>

            <?php
            break;
    }
}
add_action( 'manage_gamipress_admin_emails_custom_column', 'gamipress_admin_emails_manage_admin_emails_custom_column', 10, 2 );

/**
 * Default data when creating a new item (similar to WP auto draft) see ct_insert_object()
 *
 * @since  1.0.0
 *
 * @param array $default_data
 *
 * @return array
 */
function gamipress_admin_emails_default_data( $default_data = array() ) {

    $default_data['title'] = '';
    $default_data['status'] = 'inactive';
    $default_data['date'] = date( 'Y-m-d 00:00:00' );

    return $default_data;
}
add_filter( 'ct_gamipress_admin_emails_default_data', 'gamipress_admin_emails_default_data' );

/**
 * Register custom CMB2 meta boxes
 *
 * @since  1.0.0
 */
function gamipress_admin_emails_admin_emails_meta_boxes( ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_admin_emails_';

    // Title
    gamipress_add_meta_box(
        'gamipress-admin-email-title',
        __( 'Title', 'gamipress-admin-emails' ),
        'gamipress_admin_emails',
        array(
            'title' => array(
                'name' 	=> __( 'Title', 'gamipress-admin-emails' ),
                'type' 	=> 'text',
                'attributes' => array(
                    'placeholder' => __( 'Enter title here', 'gamipress-admin-emails' ),
                )
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Email Configuration
    gamipress_add_meta_box(
        'gamipress-admin-email-email',
        __( 'Email Configuration', 'gamipress-admin-emails' ),
        'gamipress_admin_emails',
        array(
            'subject' => array(
                'name' 	=> __( 'Subject', 'gamipress-admin-emails' ),
                'type' 	=> 'text',
                'desc' 	=> __( 'Email subject. For a list available tags, check next field description.', 'gamipress-admin-emails' ),
            ),
            'content' => array(
                'name' 	=> __( 'Content', 'gamipress-admin-emails' ),
                'desc' 	=> __( 'Email content. Available tags:', 'gamipress-admin-emails' )
                    . ' ' . gamipress_admin_emails_get_pattern_tags_html(),
                'type' 	=> 'wysiwyg',
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Condition Configuration
    gamipress_add_meta_box(
        'gamipress-admin-email-condition',
        __( 'Condition Configuration', 'gamipress-admin-emails' ),
        'gamipress_admin_emails',
        array(
            $prefix . 'condition' => array(
                'name' 	    => __( 'Condition', 'gamipress-admin-emails' ),
                'type' 	    => 'select',
                'options'   => gamipress_admin_emails_get_admin_email_conditions()
            ),
            $prefix . 'points' => array(
                'name' 	    => __( 'Points', 'gamipress-admin-emails' ),
                'type' 	    => 'gamipress_points',
            ),
            $prefix . 'achievement_type' => array(
                'name'        => __( 'Achievement Type', 'gamipress-admin-emails' ),
                'type'        => 'select',
                'option_all'  => false,
                'option_none' => true,
                'options_cb'  => 'gamipress_options_cb_achievement_types',
            ),
            $prefix . 'achievement' => array(
                'name'              => __( 'Achievement', 'gamipress-admin-emails' ),
                'type'              => 'select',
                'classes' 	        => 'gamipress-post-selector',
                'attributes' 	    => array(
                    'data-post-type' => implode( ',',  gamipress_get_achievement_types_slugs() ),
                    'data-placeholder' => __( 'Select an achievement', 'gamipress-admin-emails' ),
                ),
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
            $prefix . 'rank' => array(
                'name'              => __( 'Rank', 'gamipress-admin-emails' ),
                'type'              => 'select',
                'classes' 	        => 'gamipress-post-selector',
                'attributes' 	    => array(
                    'data-post-type' => implode( ',',  gamipress_get_rank_types_slugs() ),
                    'data-placeholder' => __( 'Select a rank', 'gamipress-admin-emails' ),
                ),
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Admin Email Details
    gamipress_add_meta_box(
        'gamipress-admin-email-details',
        __( 'Details', 'gamipress-admin-emails' ),
        'gamipress_admin_emails',
        array(
            'status' => array(
                'name' 	=> __( 'Status', 'gamipress-admin-emails' ),
                'type' 	=> 'select',
                'options' => gamipress_admin_emails_get_admin_email_statuses()
            ),
            'date' => array(
                'name' 	=> __( 'Date', 'gamipress-admin-emails' ),
                'desc' 	=> __( 'Enter the admin email creation date. This field is important since first email will be sent <strong>after</strong> date selected.', 'gamipress-admin-emails' ),
                'type' 	=> 'text_date_timestamp',
            )
        ),
        array(
            'context' => 'side',
        )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_admin_emails_admin_emails_meta_boxes' );

/**
 * Turns array of date and time into a valid mysql date on update object data
 *
 * @since 1.0.0
 *
 * @param array $object_data
 * @param array $original_object_data
 *
 * @return array
 */
function gamipress_admin_emails_insert_admin_email_data( $object_data, $original_object_data ) {

    global $ct_table;

    // If not is our custom table, return
    if( $ct_table->name !== 'gamipress_admin_emails' ) {
        return $object_data;
    }

    // Fix date format
    if( isset( $object_data['date'] ) && ! empty( $object_data['date'] ) ) {
        $object_data['date'] = date( 'Y-m-d 00:00:00', strtotime( $object_data['date'] ) );
    }

    return $object_data;

}
add_filter( 'ct_insert_object_data', 'gamipress_admin_emails_insert_admin_email_data', 10, 2 );

/**
 * Setup misc publishing actions from submit meta box.
 *
 * @since 1.0.0
 *
 * @param object        $object         Object.
 * @param CT_Table      $ct_table       CT Table object.
 * @param bool          $editing        True if edit screen, false if is adding a new one.
 * @param CT_Edit_View  $view           Edit view object.
 */
function gamipress_admin_emails_misc_publishing_actions( $object, $ct_table, $editing, $view ) {

    $admin_email_actions = array();

    $admin_email_actions['send_test_email'] = array(
        'label' => __( 'Send a test email', 'gamipress-admin-emails' ),
        'icon' => 'dashicons-email-alt'
    );

    $admin_email_actions = apply_filters( 'gamipress_admin_emails_admin_email_actions', $admin_email_actions, $object ); ?>

    <?php foreach( $admin_email_actions as $action => $action_args ) :

        // Setup action vars
        if( isset( $action_args['url'] ) && ! empty( $action_args['url'] ) ) {
            $url = $action_args['url'];
        } else {
            $url = add_query_arg( array( 'gamipress_admin_emails_admin_email_action' => $action ) );
        }

        if( isset( $action_args['target'] ) && ! empty( $action_args['target'] ) ) {
            $target = $action_args['target'];
        } else {
            $target = '_self';
        } ?>

        <div class="misc-pub-section admin-email-action">

            <?php if( isset( $action_args['icon'] ) ) : ?><span class="dashicons <?php echo $action_args['icon']; ?>"></span><?php endif; ?>

            <a href="<?php echo $url; ?>" data-action="<?php echo $action; ?>" target="<?php echo $target; ?>">
                <span class="action-label"><?php echo $action_args['label']; ?></span>
            </a>

        </div>

    <?php endforeach; ?>

    <?php
}
add_action( 'ct_gamipress_admin_emails_edit_screen_submit_meta_box_misc_publishing_actions', 'gamipress_admin_emails_misc_publishing_actions', 10, 4 );

/**
 * Payment actions handler
 *
 * Fire hook gamipress_admin_emails_process_admin_email_action_{$action}
 *
 * @since 1.0.0
 */
function gamipress_admin_emails_handle_admin_email_actions() {

    if( isset( $_REQUEST['gamipress_admin_emails_admin_email_action'] ) && isset( $_REQUEST['admin_email_id'] ) ) {

        $action = $_REQUEST['gamipress_admin_emails_admin_email_action'];
        $admin_email_id = absint( $_REQUEST['admin_email_id'] );

        if( $admin_email_id !== 0 ) {

            /**
             * Hook gamipress_admin_emails_process_admin_email_action_{$action}
             *
             * @since 1.0.0
             *
             * @param integer $admin_email_id
             */
            do_action( "gamipress_admin_emails_process_admin_email_action_{$action}", $admin_email_id );

            // Redirect to the same URL but without the action var if action do not process a redirect
            wp_redirect( remove_query_arg( array( 'gamipress_admin_emails_admin_email_action' ) ) );
            exit;

        }

    }

}
add_action( 'admin_init', 'gamipress_admin_emails_handle_admin_email_actions' );

/**
 * Send test email action
 *
 * @since 1.0.0
 *
 * @param int $admin_email_id
 */
function gamipress_admin_emails_send_test_email_action( $admin_email_id ) {

    define( 'GAMIPRESS_ADMIN_EMAILS_TEST_SEND', true );

    gamipress_admin_emails_send_email( get_current_user_id(), $admin_email_id );

    $redirect = add_query_arg( array( 'message' => 'send_test_email' ), ct_get_edit_link( 'gamipress_admin_emails', $admin_email_id ) );

    // Redirect to the same payment edit screen and with the var message
    wp_redirect( $redirect );
    exit;

}
add_action( 'gamipress_admin_emails_process_admin_email_action_send_test_email', 'gamipress_admin_emails_send_test_email_action' );

/**
 * Register custom messages
 *
 * @since 1.0.0
 *
 * @param array $messages
 *
 * @return array
 */
function gamipress_admin_emails_register_custom_messages( $messages ) {

    $messages['send_test_email'] = __( 'Email sent successfully.', 'gamipress-admin-emails' );

    return $messages;
}
add_filter( 'ct_table_updated_messages', 'gamipress_admin_emails_register_custom_messages' );