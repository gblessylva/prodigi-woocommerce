<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Prodigi_Dropship_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		PRODIGIDRO
 * @subpackage	Classes/Prodigi_Dropship_Run
 * @author		Sylvanus
 * @since		1.0.0
 */
class Prodigi_Dropship_Run{

	
	/**
	 * Our Prodigi_Dropship_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'plugin_action_links_' . PRODIGIDRO_PLUGIN_BASE, array( $this, 'add_plugin_action_link' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_menu_items' ), 100, 1 );
		add_action( 'plugins_loaded', array( $this, 'add_wp_webhooks_integrations' ), 9 );
		add_action( 'plugins_loaded', array( $this, 'include_files' ), 10 );

	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	* Adds action links to the plugin list table
	*
	* @access	public
	* @since	1.0.0
	*
	* @param	array	$links An array of plugin action links.
	*
	* @return	array	An array of plugin action links.
	*/
	public function add_plugin_action_link( $links ) {

		$links['our_shop'] = sprintf( '<a href="%s" title="Custom Link" style="font-weight:700;">%s</a>', 'https://test.test', __( 'Custom Link', 'prodigi-dropship' ) );

		return $links;
	}

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		
		wp_enqueue_style( 'prodigidro-backend-styles', PRODIGIDRO_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), PRODIGIDRO_VERSION, 'all' );
		wp_enqueue_script( 'prodigidro-backend-scripts', PRODIGIDRO_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array(), PRODIGIDRO_VERSION, false );
		wp_enqueue_script( 'prodigidro-tailwind-scripts', 'https://cdn.tailwindcss.com', array(), PRODIGIDRO_VERSION, false );
		wp_localize_script( 'prodigidro-backend-scripts', 'prodigidro', array(
			'plugin_name'   	=> __( PRODIGIDRO_NAME, 'prodigi-dropship' ),
		));
	}

	/**
	 * Add a new menu item to the WordPress topbar
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	object $admin_bar The WP_Admin_Bar object
	 *
	 * @return	void
	 */
	public function add_admin_bar_menu_items( $admin_bar ) {

		$admin_bar->add_menu( array(
			'id'		=> 'prodigi-dropship-id', // The ID of the node.
			'title'		=> __( 'Demo Menu Item', 'prodigi-dropship' ), // The text that will be visible in the Toolbar. Including html tags is allowed.
			'parent'	=> false, // The ID of the parent node.
			'href'		=> '#', // The ‘href’ attribute for the link. If ‘href’ is not set the node will be a text node.
			'group'		=> false, // This will make the node a group (node) if set to ‘true’. Group nodes are not visible in the Toolbar, but nodes added to it are.
			'meta'		=> array(
				'title'		=> __( 'Demo Menu Item', 'prodigi-dropship' ), // The title attribute. Will be set to the link or to a div containing a text node.
				'target'	=> '_blank', // The target attribute for the link. This will only be set if the ‘href’ argument is present.
				'class'		=> 'prodigi-dropship-class', // The class attribute for the list item containing the link or text node.
				'html'		=> false, // The html used for the node.
				'rel'		=> false, // The rel attribute.
				'onclick'	=> false, // The onclick attribute for the link. This will only be set if the ‘href’ argument is present.
				'tabindex'	=> false, // The tabindex attribute. Will be set to the link or to a div containing a text node.
			),
		));

		$admin_bar->add_menu( array(
			'id'		=> 'prodigi-dropship-sub-id',
			'title'		=> __( 'My sub menu title', 'prodigi-dropship' ),
			'parent'	=> 'prodigi-dropship-id',
			'href'		=> '#',
			'group'		=> false,
			'meta'		=> array(
				'title'		=> __( 'My sub menu title', 'prodigi-dropship' ),
				'target'	=> '_blank',
				'class'		=> 'prodigi-dropship-sub-class',
				'html'		=> false,    
				'rel'		=> false,
				'onclick'	=> false,
				'tabindex'	=> false,
			),
		));

	}

	public function include_files(){
		$folder = plugin_dir_path( __FILE__ ) ;
		include( $folder. '/class-prodigi-shipping-settings-page.php');

	}

	/**
	 * ####################
	 * ### WP Webhooks 
	 * ####################
	 */

	/*
	 * Register dynamically all integrations
	 * The integrations are available within core/includes/integrations.
	 * A new folder is considered a new integration.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function add_wp_webhooks_integrations(){

		// Abort if WP Webhooks is not active
		if( ! function_exists('WPWHPRO') ){
			return;
		}

		$custom_integrations = array();
		$folder = PRODIGIDRO_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'integrations';

		try {
			$custom_integrations = WPWHPRO()->helpers->get_folders( $folder );
		} catch ( Exception $e ) {
			WPWHPRO()->helpers->log_issue( $e->getTraceAsString() );
		}

		if( ! empty( $custom_integrations ) ){
			foreach( $custom_integrations as $integration ){
				$file_path = $folder . DIRECTORY_SEPARATOR . $integration . DIRECTORY_SEPARATOR . $integration . '.php';
				WPWHPRO()->integrations->register_integration( array(
					'slug' => $integration,
					'path' => $file_path,
				) );
			}
		}
	}

}
