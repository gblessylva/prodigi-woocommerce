<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Prodigi_Dropship' ) ) :

	/**
	 * Main Prodigi_Dropship Class.
	 *
	 * @package		PRODIGIDRO
	 * @subpackage	Classes/Prodigi_Dropship
	 * @since		1.0.0
	 * @author		Sylvanus
	 */
	final class Prodigi_Dropship {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Prodigi_Dropship
		 */
		private static $instance;

		/**
		 * PRODIGIDRO helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Prodigi_Dropship_Helpers
		 */
		public $helpers;

		/**
		 * PRODIGIDRO settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Prodigi_Dropship_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'prodigi-dropship' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'prodigi-dropship' ), '1.0.0' );
		}

		/**
		 * Main Prodigi_Dropship Instance.
		 *
		 * Insures that only one instance of Prodigi_Dropship exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Prodigi_Dropship	The one true Prodigi_Dropship
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Prodigi_Dropship ) ) {
				self::$instance					= new Prodigi_Dropship;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Prodigi_Dropship_Helpers();
				self::$instance->settings		= new Prodigi_Dropship_Settings();

				//Fire the plugin logic
				new Prodigi_Dropship_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'PRODIGIDRO/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once PRODIGIDRO_PLUGIN_DIR . 'core/includes/classes/class-prodigi-dropship-helpers.php';
			require_once PRODIGIDRO_PLUGIN_DIR . 'core/includes/classes/class-prodigi-dropship-settings.php';

			require_once PRODIGIDRO_PLUGIN_DIR . 'core/includes/classes/class-prodigi-dropship-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'prodigi-dropship', FALSE, dirname( plugin_basename( PRODIGIDRO_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.