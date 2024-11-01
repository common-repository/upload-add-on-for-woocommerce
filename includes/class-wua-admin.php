<?php

/**
 * WooCommerce Uploads Addon Admin Class
 *
 * Loads and executes all admin functions and hooks
 *
 * @author      James Ugbanu
 * @package     WooCommerce Uploads Addon
 */

if( ! class_exists( 'wua_admin_class' ) ){
  
  class wua_admin_class {
    
    public function __construct(){
      
      $this->load_admin_dependencies();
      
      // WordPress Administration Menu
      add_action( 'admin_menu', array(&$this, 'addon_upload_settings_menu') );
      
      //add_filter( 'woocommerce_settings_tabs_array', array(&$this, 'addon_upload_settings_menu') , 99 );
      
    }
    
    /*
     * Functions
     */
    
    /**
     * Load dependencies
     */
    function load_admin_dependencies(){
      
      require_once( 'class-wua-admin-settings.php' );
      
      $this->wua_admin_settings_class = new wua_admin_settings_class();
    }
    
    /**
     * Addon Settings Menu in admin
     */
    function addon_upload_settings_menu(){
      
      add_menu_page( 'Addon Upload Settings',
                     'Addon Upload Settings',
                     'manage_woocommerce', 
                     'addon_settings_page' );
      add_submenu_page( 'addon_settings_page.php', 
                        __( 'Addon Upload Settings', 'woo-uploads-addon' ), 
                        __( 'Addon Upload Settings', 'woo-uploads-addon' ), 
                        'manage_woocommerce', 
                        'addon_settings_page', 
                        array(&$this, 'addon_settings_page' ) );
      
    }
    
    /**
     * Addon Settings Page
     */
    function addon_settings_page(){
      
      ?>
        <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
          <a href="admin.php?page=image_settings_page" class="nav-tab nav-tab-active"> 
            <?php _e( 'Addon Upload Settings', 'woo-uploads-addon' );?> 
          </a>
        </h2>

        <?php settings_errors(); ?>

        <form action='options.php' method='post'>
          
          <h2><?php _e( 'Settings', 'woo-uploads-addon' ); ?></h2>
          
          <?php $this->wua_admin_settings_class->load_addon_settings(); ?>
          
        </form>
      <?php
    }
    
  }
  
}