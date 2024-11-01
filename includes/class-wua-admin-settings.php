<?php

/**
 * WooCommerce Uploads Addon Admin Class
 *
 * Loads and executes all admin functions and hooks
 *
 * @author      James Ugbanu
 * @package     WooCommerce Uploads Addon
 */

if( ! class_exists( 'wua_admin_settings_class' ) ){
  
  class wua_admin_settings_class {
    
    public function __construct(){
      
      add_action( 'admin_init', array(&$this, 'addon_settings_api_init' ) );
    }
    
    /**
     * Settings API init
     */
    function addon_settings_api_init(){
      
      register_setting( 'addon_settings', 'wau_addon_settings' );
      add_settings_section(
        'wua_addon_settings_section', 
        _e( '', 'woo-uploads-addon' ), 
        array(&$this, 'addon_settings_callback'), 
        'addon_settings'
      );

      add_settings_field( 
        'wua_settings_enable', 
        __( 'Enable Addon Uploads', 'woo-uploads-addon' ), 
        array(&$this, 'wau_settings_enable_renderer'), 
        'addon_settings', 
        'wau_addon_settings_section' 
      );

    }
    
    /**
     * Call back to display Settings Section information
     */
    function addon_settings_callback(){
      
      echo _e( 'Configure your Settings', 'woo-uploads-addon' );
      
    }
    
    /**
     * Display HTML for settings
     */
    function wuu_settings_enable_renderer(){
      
      $options = get_option( 'wua_addon_settings' );
      $checked = '';
      if( isset( $options['wua_enable_addon'] ) ){
        $checked = checked( $options['wua_enable_addon'], 1, false );
      }
      ?>
      
      <div class="row">
        <input type='checkbox' 
               id="wua_addon_settings[wua_enable_addon]" 
               name="wua_addon_settings[wua_enable_addon]" <?php echo $checked; ?> value='1'>
        <label for="wua_addon_settings[wua_enable_addon]">
          <?php _e( 'Enable Addon Uploads on Product Page', 'woo-uploads-addon' );?>
        </label>
      </div>
      
      <?php
    }
    
    /**
     * Display Settings and Save Button
     */
    function load_addon_settings(){
      
      settings_fields( 'addon_settings' );
      do_settings_sections( 'addon_settings' );
      submit_button();
      
    }
    
  }
  
}