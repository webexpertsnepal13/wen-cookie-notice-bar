<?php
/*
 * Plugin Name:  WEN Cookie Notice Bar
 * Description:  Allow to add a simple cookie notice bar for making your site GDPR compliant according to EU law
 * Version:      1.1
 * Author:       Web Experts Nepal
 * Author URI:   https://www.webexpertsnepal.com/
 * Text Domain:  wen-cookie-notice-bar
*/
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WCNB_PATH', plugin_dir_path( __FILE__ ) );	
define( 'WCNB_URL', plugin_dir_url( __FILE__ ) );

require_once( WCNB_PATH . '/inc/classes/class-wcnb-admin.php' );
require_once( WCNB_PATH . '/inc/classes/class-wcnb.php' );

// Delete all option data when plugin is uninstalled
function wcnb_plugin_uninstall() {
	global $wpdb;

	$plugin_options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'wcnb_%'" );

	foreach( $plugin_options as $option ) {
	    delete_option( $option->option_name );
	}
}

function wcnb_plugin_activate() {
    register_uninstall_hook( __FILE__, 'wcnb_plugin_uninstall' );
}
register_activation_hook( __FILE__, 'wcnb_plugin_activate' );

// Disable cookie notice bar on plugin deactivation
function wcnb_plugin_deactivate() {
    update_option( 'wcnb_enabled', '0' );
}
register_deactivation_hook( __FILE__, 'wcnb_plugin_deactivate' );
 
// plug it in
function wcnb_require_files() {
	$wcnb_admin = new WCNB_Admin();
	$wcnb_admin->init();
}
add_action( 'plugins_loaded', 'wcnb_require_files' );