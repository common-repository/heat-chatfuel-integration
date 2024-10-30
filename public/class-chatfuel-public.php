<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       taicv.com
 * @since      1.0.0
 *
 * @package    Chatfuel
 * @subpackage Chatfuel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chatfuel
 * @subpackage Chatfuel/public
 * @author     TaiCV <hello@taicv.com>
 */
class Chatfuel_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chatfuel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chatfuel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chatfuel-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chatfuel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chatfuel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chatfuel-public.js', array( 'jquery' ), $this->version, false );

	}

}
$chatfuel_options	=	get_option( 'chatfuel_options' );
add_action( 'wp_footer', function () {
	$chatfuel_options	=	get_option( 'chatfuel_options' );
	if($chatfuel_options['chatfuel_field_enable_customer_chat_plugin']=='enable')
		echo $chatfuel_options['chatfuel_field_customer_chat_plugin_code'];
} );

if($chatfuel_options['chatfuel_field_enable_json_api']=='enable')
{
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/chatfuel-public-display.php';

}

