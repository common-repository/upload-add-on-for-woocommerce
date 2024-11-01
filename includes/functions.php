<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    

	// display activation notice
	function woo_ua_my_plugin_admin_notices() {
		if ( !get_option( 'woo_ua_my_plugin_notice_shown' ) ) {
			echo "<div class='updated'><p><a href='admin.php?page=woo_ua_admin_table'>Click here to view the plugin settings</a>.</p></div>";
			update_option( "woo_ua_my_plugin_notice_shown", "true" );
		}
	}
	add_action( 'admin_notices', 'woo_ua_my_plugin_admin_notices' );


	// admin footer rate us link
	function woo_ua_admin_rate_us( $footer_text ) {
		
		$screen = get_current_screen();

		if ( $screen->base == 'contact_page_woo_ua_admin_table' ) {
			
			$rate_text = sprintf( __( 'Thank you for using our plugin. Please <a href="%2$s" target="_blank">rate us on WordPress.org</a>', '' ),
				'https://crystalwebpro.com',
				'https://wordpress.org/support/plugin/woo-uploads-addon/reviews/?filter=5'
			);
			
			return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
			
		} else {
			return $footer_text;
		}

	}
	add_filter( 'admin_footer_text', 'woo_ua_admin_rate_us' );