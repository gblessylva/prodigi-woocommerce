<?php
/**
 * Plugin Name: ProdiGrow Core
 * Plugin URI: https://ProdiGrow.com
 * Description: Simple plugin to dropship with Prodigi
 * Version: 1.0.0
 * Author: sylvanus
 * Author URI: https://ProdiGrow.com
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'ProdiGrow' ) ) {

	/**
	 * Main ProdiGrow class
	 */
	class ProdiGrow {
		const VERSION = '1.0.0';

		/**
		 * @var string The path to the plugin directory
		 */
		public static $pluginDirPath;

		/**
		 * @var string The URL to the plugin directory
		 */
		public static $pluginDirUrl;

		/**
		 * @var ProdiGrow|null Instance of this class
		 */
		private static $instance;

		/**
		 * ProdiGrow constructor.
		 */
		public function __construct() {
			self::$pluginDirPath = plugin_dir_path( __FILE__ );
			self::$pluginDirUrl = plugin_dir_url( __FILE__ );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Returns the active instance of this class.
		 *
		 * @return ProdiGrow The active instance.
		 */
		public static function run() {
			if ( ! self::$instance ) {
				self::$instance = new self();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 * Enqueue styles.
		 */
		public function enqueue_styles() {
			wp_enqueue_style( 'prodigrow-styles', self::$pluginDirUrl . 'includes/assets/styles/admin-styles.css', array(), self::VERSION, 'all' );
		}

		/**
		 * Include necessary files.
		 */
		private function includes() {
			// Admin classes
			require_once self::$pluginDirPath . 'includes/classes/class-prodigi-shipping-settings-page.php';
			require_once self::$pluginDirPath . 'includes/classes/admin/class-prodigrow-setup.php';
		}

		/**
		 * Redirect on plugin activation.
		 */
		public static function prodigrow_setup() {
			$option_name = 'prodigrow_activated'; // Replace with your unique option name
			$has_been_activated = get_option( $option_name, false ); // Check if activated before

			if ( ! $has_been_activated ) {
				add_option( $option_name, true ); // Set the option on first activation
				$redirect_url = admin_url( 'your-custom-page.php' ); // Replace with your custom page URL
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}
	// register_activation_hook( __FILE__, array( 'ProdiGrow', 'prodigrow_setup' ) );
}

// Run the ProdiGrow plugin.
ProdiGrow::run();
