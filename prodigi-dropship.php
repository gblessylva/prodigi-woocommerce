<?php
/**
 * Prodigi Dropship 
 *
 * @package       PRODIGIDRO
 * @author        Sylvanus
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Prodigi Dropship 
 * Plugin URI:    prodigi-dropship
 * Description:   A Plugin that allows you to connect Prodigi with WooCommerce
 * Version:       1.0.0
 * Author:        Sylvanus
 * Author URI:    http://github.com/gblessylva
 * Text Domain:   prodigi-dropship
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Prodigi Dropship . If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'PRODIGIDRO_NAME',			'Prodigi Dropship ' );

// Plugin version
define( 'PRODIGIDRO_VERSION',		'1.0.0' );

// Plugin Root File
define( 'PRODIGIDRO_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'PRODIGIDRO_PLUGIN_BASE',	plugin_basename( PRODIGIDRO_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'PRODIGIDRO_PLUGIN_DIR',	plugin_dir_path( PRODIGIDRO_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'PRODIGIDRO_PLUGIN_URL',	plugin_dir_url( PRODIGIDRO_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once PRODIGIDRO_PLUGIN_DIR . 'core/class-prodigi-dropship.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Sylvanus
 * @since   1.0.0
 * @return  object|Prodigi_Dropship
 */
function PRODIGIDRO() {
	return Prodigi_Dropship::instance();
}

PRODIGIDRO();
