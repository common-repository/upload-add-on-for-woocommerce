<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if directly
 
// Display Woocomerce Upload additional product fields
add_action( 'woocommerce_before_add_to_cart_button', 'display_woo_ua_product_fields', 9 );
function display_woo_ua_product_fields(){
        global $product;
        $id = $product->get_id();
        
	// get options
    	wp_cache_flush();
		$options = get_option("woo_ua_options");
		$woo_ua_enable = $options['woo_ua_enable'];
		$woo_ua_upload_label = $options['woo_ua_upload_label'];
		
		$woo_ua_field = get_post_meta($id, "_woo_ua_field", true);
		
		if($woo_ua_enable) {
		    if($woo_ua_field == 'yes') {
    ?>
    <p class="form-row validate-required" id="image" >
		<label for="file_field">
			<?php empty($woo_ua_upload_label) ? _e("upload Image") : _e($woo_ua_upload_label) . ': '; ?>
			<input type="file" name='wua_file_addon' id="wua_file_addon" accept='image/*'>
		</label>
    </p>
    <?php
		}
	}
}

add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_woo_ua__add_to_cart_text');
 
function woocommerce_woo_ua__add_to_cart_text() {
		global $product;
        $id = $product->get_id();
    // get options
    	wp_cache_flush();
		$options = get_option("woo_ua_options");
		$woo_ua_enable = $options['woo_ua_enable'];
		$woo_ua_cart_btn = $options['woo_ua_cart_btn'];
		$woo_ua_field = get_post_meta($id, "_woo_ua_field", true);
		
		if($woo_ua_enable && $woo_ua_field == 'yes') {
		    if(!empty($woo_ua_cart_btn)) {
		        return __($woo_ua_cart_btn, 'woocommerce');
		    }
		}
		  return __('Add to cart', 'woocommerce');
}


// Add woo_ua fields data as the cart item custom data
add_filter( 'woocommerce_add_cart_item_data', 'add_custom_fields_data_as_woo_ua_cart_item_data', 10, 2 );
function add_custom_fields_data_as_woo_ua_cart_item_data( $cart_item_meta, $product_id ){
    
    // get options
    	wp_cache_flush();
		$options = get_option("woo_ua_options");
		$woo_ua_enable = $options['woo_ua_enable'];
		$woo_ua_file_size = $options['woo_ua_file_size'];
		$woo_ua_field = get_post_meta($product_id, "_woo_ua_field", true);

		if($woo_ua_file_size == '1') {
		    $max_image_size = 1000 * 1000; // 1 MB (approx)
		} elseif($woo_ua_file_size == '2') {
		    $max_image_size = 1000 * 2000; // 2 MB (approx)
		}
		elseif($woo_ua_file_size == '3') {
		    $max_image_size = 1000 * 5000; // 5 MB (approx)
		}
		elseif($woo_ua_file_size == '4') {
		    $max_image_size = 1000 * 10000; // 10 MB (approx)
		}

	$addon_id = array();
	if($woo_ua_enable && $woo_ua_field == 'yes') {
	if( isset( $_FILES ) && isset( $_FILES['wua_file_addon'] ) && $_FILES['wua_file_addon']['name'] !== '' && $_FILES['wua_file_addon']['size'] <= $max_image_size){
	    
	    // Allowed image types
        // $allowed_image_types = array('image/jpeg','image/png');
	    
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		
		$attach_id = media_handle_upload( 'wua_file_addon', 0 );
		
		if ( is_wp_error( $attach_id ) ) {
		    wc_add_notice( __('There is a problem with your upload...'), 'error' );
		}

		$addon_id['media_id'] = $attach_id;
		$addon_id['media_url'] = wp_get_attachment_url( esc_attr( $attach_id ) );
		$cart_item_meta['wua_addon_ids'][] = $addon_id;
		
	} else {
	    wc_add_notice( __('File too large...'), 'error' );
	}

	return $cart_item_meta;
	}
}

add_filter( 'woocommerce_get_cart_item_from_session', 'wua_get_cart_item_from_session', 10, 2 );
function wua_get_cart_item_from_session( $cart_item, $values ){
	if( isset( $values['wua_addon_ids'] ) ){
		$cart_item['wua_addon_ids'] = $values['wua_addon_ids'];
	}
	return $cart_item;
}


// Display woo_ua cart item data in cart
add_filter( 'woocommerce_get_item_data', 'display_woo_ua_item_data', 10, 2 );
function display_woo_ua_item_data( $cart_item_data, $cart_item ) {
	if ( isset( $cart_item['wua_addon_ids'] ) ) {
		foreach ( $cart_item['wua_addon_ids'] as $addon_id ) {
			$name    = __( 'Uploaded File', 'woo-addon-uploads' );
			$display = $addon_id['media_id'];
			$cart_item_data[] = array(
				'name'    => $name,
				'display' => wp_get_attachment_image( $display, 'thumbnail', 'true', '' )
			);
		}
	}
	return $cart_item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'wua_add_item_meta_url', 10, 4 );
function wua_add_item_meta_url( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['wua_addon_ids'] ) ) {
		return;
	}
	foreach ( $values['wua_addon_ids'] as $addon_key => $addon_id ) {
		$media_url = wp_get_attachment_url( esc_attr( $addon_id['media_id'] ) );

		$item->add_meta_data( __( 'Uploaded Media', 'woo-addon-uploads' ), $media_url );
	}
}

add_action( 'woocommerce_cart_item_removed', 'wua_remove_cart_action', 10, 2 );
function wua_remove_cart_action( $cart_item_key, $cart ) {
	$removed_item = $cart->removed_cart_contents[ $cart_item_key ];

	if ( isset( $removed_item['wua_addon_ids'] ) && isset( $removed_item['wua_addon_ids'][0] ) &&
			isset( $removed_item['wua_addon_ids'][0]['media_id'] ) && $removed_item['wua_addon_ids'][0]['media_id'] !== '' ) {

		$media_id = $removed_item['wua_addon_ids'][0]['media_id'];

		$delete_status = wp_delete_attachment( $media_id, true );
	}
}

function wc_email_new_order_custom_meta_data( $order, $sent_to_admin, $plain_text, $email ) {
	// On "new order" email notifications
	if ( 'new_order' === $email->id ) {
		foreach ($order->get_items() as $item ) {
			if ( $file_data = $item->get_meta( 'woo-addon-uploads' ) ) {
				echo '<p>
					<a href="'.$file_data['media_url'].'" target="blank" class="button">'._("Download Image") . '</a><br>
					<pre><code style="font-size:12px; background-color:#eee; padding:5px;">'.$file_data['media_url'].'</code></pre>
				</p><br>';
			}
		}
	}
}

// Admin orders: Display a linked button + the link of the image file
add_action( 'woocommerce_after_order_itemmeta', 'backend_image_link_after_order_itemmeta', 10, 3 );
function backend_image_link_after_order_itemmeta( $item_id, $item, $product ) {
    // Only in backend for order line items (avoiding errors)
    if( is_admin() && $item->is_type('line_item') && $file_data = $item->get_meta( 'woo-addon-uploads' ) ){
        echo '<p><a href="'.$file_data['media_url'].'" target="blank" class="button">'._("Open Image") . '</a></p>'; // Optional
        echo '<p><code>'.$file_data['media_url'].'</code></p>'; // Optional
    }
}
