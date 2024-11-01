<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


// admin table
function woo_ua_admin_table()
{


    if (!current_user_can("manage_options")) {
        wp_die(__("You do not have sufficient permissions to access this page."));
    }


    //save and update options
    if (isset($_POST['update'])) {

        $options['woo_ua_enable'] = sanitize_text_field(isset($_POST['woo_ua_enable']));
        if ($options['woo_ua_enable']) {
            $options['woo_ua_enable'] = '1';
        } else {
            $options['woo_ua_enable'] = '0';
        }

        $options['woo_ua_upload_label'] = sanitize_text_field($_POST['woo_ua_upload_label']);
        if (empty($options['woo_ua_upload_label'])) {
            $options['woo_ua_upload_label'] = '';
        }

        $options['woo_ua_cart_btn'] = sanitize_text_field($_POST['woo_ua_cart_btn']);
        if (empty($options['woo_ua_cart_btn'])) {
            $options['woo_ua_cart_btn'] = '';
        }


        $options['woo_ua_file_size'] = sanitize_text_field($_POST['woo_ua_file_size']);
        if (empty($options['woo_ua_file_size'])) {
            $options['woo_ua_file_size'] = '';
        }


        update_option("woo_ua_options", $options);

        echo "<br /><div class='updated'><p><strong>";
        _e("Settings Updated.");
        _e("</strong></p></div>");

    }


    // get options
    $options = get_option('woo_ua_options');

    if ($options['woo_ua_enable']  == "1") { 
        $checked = "CHECKED"; 
    } else { 
        $checked = ''; 
    }

    if (empty($options['woo_ua_upload_label'])) {
        $options['woo_ua_upload_label'] = '';
    }

    if (empty($options['woo_ua_cart_btn'])) {
        $options['woo_ua_cart_btn'] = '';
    }

    if (empty($options['woo_ua_file_size'])) {
        $options['woo_ua_file_size'] = '';
    }

    ?>


    <form method='post'>

        <table width='70%'>
            <tr>
                <td>
                    <div class='wrap'><h2>Woocommerce Upload addon Settings</h2></div>
                    <br/></td>
            </tr>
        </table>

        <table width='100%'>
            <tr>
                <td width='70%' valign='top'>


                    <h2 class="nav-tab-wrapper">
                        <a href="#"
                           class="nav-tab nav-tab-active">Upload addon Settings</a>
                    </h2>
                    <br/>


                </td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td valign='top'>


                    <div
                         style="display:none;border: 1px solid #CCCCCC; display:block;">
                        <div style="padding:8px;">
                            <h2>Configure settings</h2>
                            <table width='100%'>
                                 <tr>
                                    <td class="woo_ua_width"><b>Upload Mandatory</b></td>
                                    <td><input name='woo_ua_enable' size=40 value='<?php _e($options['woo_ua_enable'] ); ?>' type='checkbox' <?php _e($checked) ?>></td>
                                </tr>
                                 <tr >
                                    <td class='woo_ua_width'><b>Upload Label Text: </b></td>
                                    <td><input type='text' size=40 name='woo_ua_upload_label'
                                               value='<?php _e($options['woo_ua_upload_label']); ?>'> Text that appear besides the upload input field
                                    </td>
                                </tr>
                                <tr>
                                    <td class='woo_ua_width'><b>Add to Cart Button Text: </b></td>
                                    <td><input type='text' size=40 name='woo_ua_cart_btn'
                                               value='<?php _e($options['woo_ua_cart_btn']); ?>'> Text that appear on add to cart button
                                    </td>
                                </tr>
                                <tr>
                                <td class='woo_ua_width'><b>Maximum Upload File Size:</b></td>
		                        <td class='woo_ua_width'>
                                <select name="woo_ua_file_size">
                                            <option <?php if ($options['woo_ua_file_size'] == "1") {
                                                _e("SELECTED");
                                            } ?> value="1">1MB
                                            </option>
                                            <option <?php if ($options['woo_ua_file_size'] == "2") {
                                                _e("SELECTED");
                                            } ?> value="2">2MB
                                            </option>
                                             <option <?php if ($options['woo_ua_file_size'] == "3") {
                                                _e("SELECTED");
                                            } ?> value="3">5MB
                                             </option>
                                             <option <?php if ($options['woo_ua_file_size'] == "4") {
                                                _e("SELECTED");
                                            } ?> value="4">10MB
                                            </option>
                                        </select>
                                </tr>
                                <tr>
                                     <td class='woo_ua_width'><br/>
                                            <input type='submit' name='btn2' class='button-primary'
                                                   style='font-size: 17px;line-height: 28px;height: 32px;' value='Save Settings'>
                                        </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br/>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <br/>
                                    </td>
                                </tr>
                            </table>
                            <br/>

                        </div>
                    </div>

                    <input type='hidden' name='update' value='1'>

    </form>


    </td>
    <td width="3%" valign="top">

    </td>
    <td width="24%" valign="top">

    </td>
    <td width="2%" valign="top">


    </td></tr></table>

<?php

}