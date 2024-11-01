<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu', 'woo_ua_admin_menu', 20);

function woo_ua_admin_menu() {
    add_submenu_page( 'woocommerce', 'Woocommerce Image Upload', 'Woocommerce Image Upload', 'manage_options', 'woo_ua_admin_table', 'woo_ua_admin_table' );
}

// plugin page links
add_filter('plugin_action_links', 'woo_ua_plugin_settings_link', 10, 2 );
function woo_ua_plugin_settings_link($links,$file) {
	
	if ($file == 'woo-uploads-addon/wooua.php') {		
		$settings_link = 	'<a href="admin.php?page=woo_ua_admin_table">' . __('Settings', 'PTP_LOC') . '</a>';
		array_unshift($links, $settings_link);
	}
	
	return $links; 
}