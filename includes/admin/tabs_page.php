<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//hook into Woocommerce single product setting
	add_filter( 'woocommerce_product_data_tabs', 'add_woo_ua_product_data_tab' , 10 , 1 );
	function add_woo_ua_product_data_tab( $product_data_tabs ) {
		$product_data_tabs['woo_ua'] = array(
			'label' => __( 'File Upload', 'my_text_domain' ),
			'target' => 'woo_ua_product_data',
		);
		return $product_data_tabs;
	}

	add_action( 'woocommerce_product_data_panels', 'add_woo_ua_product_data_fields' );
	function add_woo_ua_product_data_fields() {
		global $woocommerce, $post;
		?>
		<!-- id below must match target registered in above add_my_custom_product_data_tab function -->
		<div id="woo_ua_product_data" class="panel woocommerce_options_panel">
			<?php
			woocommerce_wp_checkbox( array( 
				'id'            => '_woo_ua_field', 
				'label'         => __( 'Enable', 'my_text_domain' ),
				'description'   => __( 'Enable Woocommerce Upload on this product', 'my_text_domain' ),
				'default'       => '1',
				'desc_tip'      => true,
			) );
			?>
		</div>
		<?php
	}
	
	
	add_action( 'woocommerce_process_product_meta', 'woocommerce_process_product_meta_fields_save' );
	function woocommerce_process_product_meta_fields_save( $post_id ){
		// save custom field data of checkbox. You have to do it as per your custom fields
		$woo_checkbox = isset( $_POST['_woo_ua_field'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_woo_ua_field', $woo_checkbox );
	}