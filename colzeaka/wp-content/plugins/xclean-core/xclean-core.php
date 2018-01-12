<?php
/**
 * Plugin Name:       xclean core
 * Plugin URI:        http://8theme.com/demo/wooclean
 * Description:       Add shortcodes, import demo data option to 8theme's xclean theme
 * Version:           1.0.2
 * Author:            8theme
 * Author URI:        http://8theme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       xclean-core
 */


/**
 *
 * Include shortcodes part of plugin.
 *
 */
include 'inc/shortcodes.php';


/**
 *
 * Include import parts of plugin only for admin.
 *
 */
if ( is_admin() ) {
	include 'inc/extensions-loader.php';
	include 'inc/wordpress-importer/wordpress-importer.php';
	include 'inc/import/import.php';
}

add_action( 'plugins_loaded', 'xclean_core_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function xclean_core_load_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'xclean-core' );

	load_textdomain( 'xclean-core', WP_LANG_DIR . '/xclean-core/xclean-core-' . $locale . '.mo' );
	load_plugin_textdomain( 'xclean-core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

?>