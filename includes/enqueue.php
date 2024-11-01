<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



	// admin enqueue
	function woo_ua_admin_enqueue() {

		// admin css
		wp_register_style( 'woo_ua-admin-css',plugins_url('../assets/css/woo_ua-admin.css',__FILE__),false,false );
		wp_enqueue_style( 'woo_ua-admin-css' );

		// admin js
		wp_enqueue_script( 'woo_ua-admin',plugins_url('../assets/js/admin.js',__FILE__),array( 'jquery' ),false );

	}
	add_action( 'admin_enqueue_scripts','woo_ua_admin_enqueue' );



	// public enqueue
	// function woo_ua_public_enqueue() {
	// 	//redirect js
	// 	wp_enqueue_script( 'woo_ua-redirect_method',plugins_url('../assets/js/redirect.js',__FILE__),array( 'jquery' ),null );
	// 	wp_localize_script('woo_ua-redirect_method', 'ajax_object_woo_ua',
	// 	array (
	// 		'ajax_url' 			=> admin_url('admin-ajax.php'),
	// 	)
	// );
	// }
	// add_action('wp_enqueue_scripts','woo_ua_public_enqueue',10);
