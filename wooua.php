<?php
/*
Plugin Name: Upload Add-on for Woocommerce
Plugin URI: https://crystalwebpro.com/open-source/
Description: Enable customer to upload image before adding to cart
Author: James Ugbanu
Text Domain: woo_ua
Author URI: https://crystalwebpro.com
License: GPL2
Version: 1.1.1
* WC requires at least: 4.2.0
 * WC tested up to: 4.5.1
*/

/*  Copyright 2020 James Ugbanu

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/



// plugin variable: woo_ua


//  plugin functions
register_activation_hook( 	__FILE__, "woo_ua_activate" );
register_deactivation_hook( __FILE__, "woo_ua_deactivate" );
register_uninstall_hook( 	__FILE__, "woo_ua_uninstall" );

function woo_ua_activate() {
	
	// default options
	$woo_ua_options = array(
	   'woo_ua_enable' => 0,
	   'woo_ua_upload_label' => '',
	   'woo_ua_cart_btn' => '',
	   'woo_ua_file_size' => 1
    );
	add_option("woo_ua_options", $woo_ua_options);
	
}

function woo_ua_deactivate() {
    delete_option("woo_ua_options");
	delete_option("woo_ua_my_plugin_notice_shown");
}

function woo_ua_uninstall() {
}

// check to make sure Woocommerce is installed and active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {	
	
	// public includes
	include_once('includes/functions.php');
	include_once('includes/woo_ua_upload.php');
	include_once('includes/enqueue.php');
	
	// admin includes
	if (is_admin()) {
		include_once('includes/admin/tabs_page.php');
		include_once('includes/admin/settings_page.php');
		include_once('includes/admin/menu_links.php');
	}
	
} else {
	
	// give warning if woocommerce is not active
	function woo_ua_my_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( '<b>Woocommerce Upload Add-on:</b> Woocommerce is not installed and / or active! Please install <a target="_blank" href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a>.', 'woo_ua' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'woo_ua_my_admin_notice' );
	
}

add_action( 'plugins_loaded', 'woo_ua_load_textdomain' );
function woo_ua_load_textdomain() {
	load_plugin_textdomain( 'woo_ua', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

?>