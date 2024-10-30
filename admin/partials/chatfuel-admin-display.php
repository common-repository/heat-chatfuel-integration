<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       taicv.com
 * @since      1.0.0
 *
 * @package    Chatfuel
 * @subpackage Chatfuel/admin/partials
 */
?>
<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function chatfuel_settings_init()
{
 // register a new setting for "chatfuel" page
 register_setting('chatfuel', 'chatfuel_options');

 // register a new section in the "chatfuel" page
 add_settings_section('chatfuel_section_customer_chat_plugin', __('Customer Chat Plugin', 'chatfuel') , 'chatfuel_section_customer_chat_plugin_cb', 'chatfuel');

 // register a new field in the "chatfuel_section_customer_chat_plugin" section, inside the "chatfuel" page
 add_settings_field('chatfuel_field_enable_customer_chat_plugin', // as of WP 4.6 this value is used only internally
     // use $args' label_for to populate the id inside the callback
     __('Enable?', 'chatfuel') , 'chatfuel_field_enable_customer_chat_plugin_cb', 'chatfuel', 'chatfuel_section_customer_chat_plugin', ['label_for' => 'chatfuel_field_enable_customer_chat_plugin', 'class' => 'chatfuel_row', 'chatfuel_custom_data' => 'custom', ]);


 add_settings_field('chatfuel_field_customer_chat_plugin_code', // as of WP 4.6 this value is used only internally
    // use $args' label_for to populate the id inside the callback
    __('Customer chat plugin code', 'chatfuel') , 'chatfuel_field_customer_chat_plugin_code_cb', 'chatfuel', 'chatfuel_section_customer_chat_plugin', ['label_for' => 'chatfuel_field_customer_chat_plugin_code', 'class' => 'chatfuel_row', 'chatfuel_custom_data' => 'custom', ]);

 // register a new section in the "chatfuel" page
 add_settings_section('chatfuel_section_json_api', __('JSON API', 'chatfuel') , 'chatfuel_section_json_api_cb', 'chatfuel');

 // register a new field in the "chatfuel_json_api" section, inside the "chatfuel" page
 add_settings_field('chatfuel_field_enable_json_api', // as of WP 4.6 this value is used only internally
     // use $args' label_for to populate the id inside the callback
     __('Enable?', 'chatfuel') , 'chatfuel_field_enable_json_api_cb', 'chatfuel', 'chatfuel_section_json_api', ['label_for' => 'chatfuel_field_enable_json_api', 'class' => 'chatfuel_row', 'chatfuel_custom_data' => 'custom', ]);


}

/**
 * register our chatfuel_settings_init to the admin_init action hook
 */
add_action('admin_init', 'chatfuel_settings_init');

/**
 * custom option and settings:
 * callback functions
 */

// Start Customer_chat_plugin

function chatfuel_section_customer_chat_plugin_cb($args)
{
 ?>
 <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Allows you to place a Messenger chat window right on your website. All your site visitors starting a chat on the page will automatically become your bot subscribers!', 'chatfuel'); ?></p>
 <?php
}

function chatfuel_field_enable_customer_chat_plugin_cb($args)
{
 // get the value of the setting we've registered with register_setting()
 $options = get_option('chatfuel_options');
 // output the field

 ?>
 <select id="<?php echo esc_attr($args['label_for']); ?>"
         data-custom="<?php echo esc_attr($args['chatfuel_custom_data']); ?>"
         name="chatfuel_options[<?php echo esc_attr($args['label_for']); ?>]"
     >
  <option value="disable" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'disable', false)) : (''); ?>>
   <?php esc_html_e('Disable', 'chatfuel'); ?>
  </option>
  <option value="enable" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'enable', false)) : (''); ?>>
   <?php esc_html_e('Enable', 'chatfuel'); ?>
  </option>

 </select>

 <?php
}
function chatfuel_field_customer_chat_plugin_code_cb($args)
{
 // get the value of the setting we've registered with register_setting()
 $options = get_option('chatfuel_options');
 // output the field

 ?>
 <textarea cols='120' rows='6' id="<?php echo esc_attr($args['label_for']); ?>"
           data-custom="<?php echo esc_attr($args['chatfuel_custom_data']); ?>"
           name="chatfuel_options[<?php echo esc_attr($args['label_for']); ?>]"
     ><?php echo $options[$args['label_for']]; ?></textarea>

 <p class="description">
  <?php esc_html_e('Paste your code from Chatfuel.', 'chatfuel'); ?>
 </p>
 <?php
}

// End Customer_chat_plugin

// Start JSON API

function chatfuel_section_json_api_cb($args)
{
 ?>
 <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Give data sources to Chatfuel JSON API Plugin for getting posts or products and display as Messenger cards', 'chatfuel'); ?></p>
 <?php
}

function chatfuel_field_enable_json_api_cb($args)
{
 // get the value of the setting we've registered with register_setting()
 $options = get_option('chatfuel_options');
 // output the field

 ?>
 <select id="<?php echo esc_attr($args['label_for']); ?>"
         data-custom="<?php echo esc_attr($args['chatfuel_custom_data']); ?>"
         name="chatfuel_options[<?php echo esc_attr($args['label_for']); ?>]"
     >
  <option value="disable" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'disable', false)) : (''); ?>>
   <?php esc_html_e('Disable', 'chatfuel'); ?>
  </option>
  <option value="enable" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'enable', false)) : (''); ?>>
   <?php esc_html_e('Enable', 'chatfuel'); ?>
  </option>

 </select>

 <p class="description">
  <br/>
  <br/>
  <b>Select your data source :</b>
   <br/>
  <select id="jsonapilink_posttype" class="jsonapilink_select">
   <option value="0">Select your data source</option>
   <option value="post">Posts</option>
   <?php
   $post_types = get_post_types();
   if (in_array("product", $post_types)) {
    echo '<option value="product">Products (WooCommerce)</option>';
   }
   ?>
  </select>

  <select id="jsonapilink_filter" class="jsonapilink_select">
   <option value="category" selected>By Category</option>
   <option value="keyword">By Keyword</option>
  </select>

  <?php
  $args = array(
      'show_option_all'    => '',
      'show_option_none'   => 'All Categories',
      'option_none_value'  => '0',
      'orderby'            => 'ID',
      'order'              => 'ASC',
      'show_count'         => 1,
      'hide_empty'         => 1,
      'child_of'           => 0,
      'exclude'            => '',
      'include'            => '',
      'echo'               => 1,
      'selected'           => 0,
      'hierarchical'       => 1,
      'name'               => '',
      'id'                 => 'jsonapilink_filter_condition_product',
      'class'              => 'jsonapilink_select',
      'depth'              => 0,
      'tab_index'          => 0,
      'taxonomy'           => 'product_cat',
      'hide_if_empty'      => false,
      'value_field'	     => 'slug',
  );
  wp_dropdown_categories( $args ); ?>

  <?php
  $args = array(
      'show_option_all'    => '',
      'show_option_none'   => 'All Categories',
      'option_none_value'  => '0',
      'orderby'            => 'ID',
      'order'              => 'ASC',
      'show_count'         => 1,
      'hide_empty'         => 1,
      'child_of'           => 0,
      'exclude'            => '',
      'include'            => '',
      'echo'               => 1,
      'selected'           => 0,
      'hierarchical'       => 1,
      'name'               => '',
      'id'                 => 'jsonapilink_filter_condition_post',
      'class'              => 'jsonapilink_select',
      'depth'              => 0,
      'tab_index'          => 0,
      'taxonomy'           => 'category',
      'hide_if_empty'      => false,
      'value_field'	     => 'slug',
  );
  wp_dropdown_categories( $args ); ?>

  <input id="jsonapilink_keyword" class="jsonapilink_select hidden" placeholder="Input your keyword"/>

  <p id="jsonapilink_holder">
  <br/>
  Here is your JSON API link:<br/>
  <a href="" target="_blank" id="jsonapilink"></a>
  </p>
  <script>

   jQuery(function() {
    jQuery( ".jsonapilink_select" ).change(function() {
     if(jQuery( "#jsonapilink_posttype").val()!=0)
     {
      if(jQuery( "#jsonapilink_filter").val()=='category')
      {
       jQuery("#jsonapilink_keyword").hide();
       if(jQuery( "#jsonapilink_posttype").val()=='post')
       {
        jQuery('#jsonapilink_filter_condition_product').hide();
        jQuery('#jsonapilink_filter_condition_post').show();
        jQuery( "#jsonapilink").attr('href','<?php echo get_home_url()?>/wp-json/chatfuel/'+jQuery( "#jsonapilink_posttype").val()+"/"+jQuery( "#jsonapilink_filter").val()+"/"+jQuery( "#jsonapilink_filter_condition_post").val()+"/0");
       }
       else if(jQuery( "#jsonapilink_posttype").val()=='product')
       {
        jQuery('#jsonapilink_filter_condition_product').show();
        jQuery('#jsonapilink_filter_condition_post').hide();
        jQuery( "#jsonapilink").attr('href','<?php echo get_home_url()?>/wp-json/chatfuel/'+jQuery( "#jsonapilink_posttype").val()+"/"+jQuery( "#jsonapilink_filter").val()+"/"+jQuery( "#jsonapilink_filter_condition_product").val()+"/0");
       }
      }
      else if(jQuery( "#jsonapilink_filter").val()=='keyword')
      {
       jQuery("#jsonapilink_keyword").show();
       jQuery('#jsonapilink_filter_condition_product').hide();
       jQuery('#jsonapilink_filter_condition_post').hide();
       jQuery( "#jsonapilink").attr('href','<?php echo get_home_url()?>/wp-json/chatfuel/'+jQuery( "#jsonapilink_posttype").val()+"/"+jQuery( "#jsonapilink_filter").val()+"/"+jQuery( "#jsonapilink_keyword").val()+"/0");

      }


      jQuery( "#jsonapilink").text( jQuery( "#jsonapilink").attr('href'));
     }
     else{
      jQuery( "#jsonapilink").attr('href',"#");
      jQuery( "#jsonapilink").html('<i>Please select your source first</i>');

     }

    });

    jQuery("#jsonapilink_keyword").keyup(function(){
     jQuery( "#jsonapilink").attr('href','<?php echo get_home_url()?>/wp-json/chatfuel/'+jQuery( "#jsonapilink_posttype").val()+"/"+jQuery( "#jsonapilink_filter").val()+"/"+jQuery( "#jsonapilink_keyword").val()+"/0");
     jQuery( "#jsonapilink").text( jQuery( "#jsonapilink").attr('href'));
    });
   });
  </script>

 </p>

 <?php
}

// End Customer_chat_plugin

/**
 * top level menu
 */
function chatfuel_options_page()
{
 // add top level menu page
 add_menu_page('Chatfuel Options', 'Chatfuel', 'manage_options', 'chatfuel', 'chatfuel_options_page_html');
}

/**
 * register our chatfuel_options_page to the admin_menu action hook
 */
add_action('admin_menu', 'chatfuel_options_page');

/**
 * top level menu:
 * callback functions
 */
function chatfuel_options_page_html()
{
 // check user capabilities
 if (!current_user_can('manage_options'))
 {
  return;
 }

 // add error/update messages
 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if (isset($_GET['settings-updated']))
 {
  // add settings saved message with the class of "updated"
  add_settings_error('chatfuel_messages', 'chatfuel_message', __('Settings Saved', 'chatfuel') , 'updated');
 }

 // show error/update messages
 settings_errors('chatfuel_messages');
 ?>
 <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form action="options.php" method="post">
   <?php
   // output security fields for the registered setting "chatfuel"
   settings_fields('chatfuel');
   // output setting sections and their fields
   // (sections are registered for "chatfuel", each field is registered to a specific section)
   do_settings_sections('chatfuel');
   // output save settings button
   submit_button('Save Settings');
   ?>
  </form>
 </div>
 <?php
}