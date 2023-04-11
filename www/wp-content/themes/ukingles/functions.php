<?php

// add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
// function theme_enqueue_styles() {
// 	wp_enqueue_style( 'theme-style', get_stylesheet_uri(), null, STM_THEME_VERSION, 'all' );
// }



// Enfilera css pai e filho 
function theme_enqueue_styles_novo() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles_novo' );






/**
 * 
 * Funções extras add ao tema
*/

/**
 * Modifications in Admin structure
 */
//require get_template_directory() . '/inc/template-admin.php';

// change logo to admin page
function login_logo() { ?>
	<style type="text/css">.login h1 a {background: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.jpg') center center!important; width:284px!important; height:133px!important; box-shadow: none!important;} .wp-core-ui .button-primary {background: #003A59!important; border:0;}</style>
<?php }
add_action( 'login_enqueue_scripts', 'login_logo' );
  
  
  
  
//  Link on login page
function url_login_logo() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'url_login_logo' );
  
  
//  Title on login page
function url_title_login() {
return 'UK Inglês Online';
}
add_filter( 'login_headertext', 'url_title_login' );
	




/**
 * limita o js e css do contactform 7 à página que tem o formulário
 *
 */

 function ac_remove_cf7_scripts() {
	if ( !is_page('contato') ) {
		wp_deregister_script( 'contact-form-7' );
		//wp_deregister_script( 'wp-polyfill' );
		// wp_deregister_script( 'wpcf7-recaptcha' ); // remove google recaptcha from other pages
		// wp_deregister_script( 'google-recaptcha' ); // remove google recaptcha from other pages
	}
	
	wp_deregister_style( 'contact-form-7' );
}
add_action( 'wp_enqueue_scripts', 'ac_remove_cf7_scripts', 99 );



  

/**********
 * REMOVE COMENTÁRIOS E FORMS DE COMENTARIOS
 * *****************/

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// Remove comment-reply.min.js from footer
function remove_comment_reply(){
    wp_deregister_script( 'comment-reply' );
}
add_action('init','remove_comment_reply');


/**
 * FRONTEND
 *
 */
remove_action('wp_head', 'wp_generator'); //  remove wordpress version
remove_action('wp_head', 'print_emoji_detection_script', 7); // remove emoticons js
remove_action('wp_print_styles', 'print_emoji_styles'); // remove emoticons css



/**
 * Config. wordpress ADM
 *
 */

// remove .recentcomments a{display:inline.... no head
function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

//remove o logo e menu wp do painel admin
function remove_wp_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_wp_admin_bar' );

// remove o painel de boas vindas do wordpress
remove_action('welcome_panel', 'wp_welcome_panel');

//  remove a barra de admin do wordpress no frontend
//add_filter('show_admin_bar', '__return_false');
	
	
	
	
/**
 * remove from menu wordpress
 *
 */
function custom_remove_admin_menus (){
	// Check that the built-in WordPress function remove_menu_page() exists in the current installation
	if ( function_exists( 'remove_menu_page' ) ) {
		//remove_menu_page('edit.php'); // remove posts from menu wp
		remove_menu_page('edit-comments.php'); // remove comments from menu wp
		//remove_submenu_page('themes.php', 'theme-editor.php');
		//remove_submenu_page('themes.php', 'widgets.php');
	
		//global $submenu;
		// Appearance customize Menu
		//unset($submenu['themes.php'][6]);
	}
}
// Add our function to the admin_menu action
add_action('admin_menu', 'custom_remove_admin_menus', 999);





// REMOVE SVG ON FOOTER AFTER LOAD THE WEBSITE
add_action('after_setup_theme', function () {
	remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
	remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
}, 10, 0);


/**
 * disable generated image sizes
 *
 */
function shapeSpace_disable_image_sizes($sizes) {
	//unset($sizes['thumbnail']);    // disable thumbnail size
	unset($sizes['medium']);       // disable medium size
	//unset($sizes['large']);        // disable large size

	unset($sizes['medium_large']); // disable medium-large size
	unset($sizes['1536x1536']);    // disable 2x medium-large size
	unset($sizes['2048x2048']);    // disable 2x large size

	return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_image_sizes');

// disable scaled image size
add_filter('big_image_size_threshold', '__return_false');

// disable other image sizes
// function shapeSpace_disable_other_image_sizes() {

// 	remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size()
// 	remove_image_size('another-size');   // disable any other added image sizes

// }
// add_action('init', 'shapeSpace_disable_other_image_sizes');




// remove feed
function itsme_disable_feed() {
	wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );


// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action ('wp_head', 'rsd_link');

 // Disable X-Pingback to header
add_filter( 'wp_headers', 'disable_x_pingback' );
function disable_x_pingback( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}


// remove manifest
remove_action( 'wp_head', 'wlwmanifest_link');

// remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head');


// Remove api.w.org relation link
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);


/**
 * Optimize WooCommerce Scripts
 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
 */
// add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

// function child_manage_woocommerce_styles() {
// 	//remove generator meta tag
// 	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

// 	//first check that woo exists to prevent fatal errors
// 	if ( function_exists( 'is_woocommerce' ) ) {
// 		//dequeue scripts and styles
// 		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
// 			wp_dequeue_style( 'woocommerce_frontend_styles' );
// 			wp_dequeue_style( 'woocommerce_fancybox_styles' );
// 			wp_dequeue_style( 'woocommerce_chosen_styles' );
// 			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
// 			wp_dequeue_script( 'wc_price_slider' );
// 			wp_dequeue_script( 'wc-single-product' );
// 			wp_dequeue_script( 'wc-add-to-cart' );
// 			wp_dequeue_script( 'wc-cart-fragments' );
// 			wp_dequeue_script( 'wc-checkout' );
// 			wp_dequeue_script( 'wc-add-to-cart-variation' );
// 			wp_dequeue_script( 'wc-single-product' );
// 			wp_dequeue_script( 'wc-cart' );
// 			wp_dequeue_script( 'wc-chosen' );
// 			wp_dequeue_script( 'woocommerce' );
// 			wp_dequeue_script( 'prettyPhoto' );
// 			wp_dequeue_script( 'prettyPhoto-init' );
// 			wp_dequeue_script( 'jquery-blockui' );
// 			wp_dequeue_script( 'jquery-placeholder' );
// 			wp_dequeue_script( 'fancybox' );
// 			wp_dequeue_script( 'jqueryui' );
// 		}
// 	}
// }



function add_this_script_footer(){
	?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
<?php 
} 

add_action('wp_footer', 'add_this_script_footer');

