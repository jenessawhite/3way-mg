<?php
/**
 * Admin Class
 *
 * Handles the admin functionality of plugin
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wprps_Admin {
	
	function __construct() {
		
		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'wprps_register_menu'), 12 );
	}

	/**
	 * Function to add menu
	 * 
	 * @package WP Responsive Recent Post Slider
	 * @since 1.0.0
	 */
	function wprps_register_menu() {

		// Register plugin premium page
		add_submenu_page( 'wprps-about', __('Upgrade to PRO - Recent Post Slider', 'wp-responsive-recent-post-slider'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'wp-responsive-recent-post-slider').'</span>', 'manage_options', 'wprps-premium', array($this, 'wprps_premium_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package WP Responsive Recent Post Slider
	 * @since 1.0.0
	 */
	function wprps_premium_page() {
		include_once( WPRPS_DIR . '/includes/admin/settings/premium.php' );
	}
}

$wprps_admin = new Wprps_Admin();