<?php
/**
 * The main file of the <%= pkg.title %> plugin
 *
 * @package tecut
 * @version <%= pkg.version %>
 *
 * Plugin Name: <%= pkg.title %>
 * Plugin URI: <%= pkg.pluginUrl %>
 * Description: <%= pkg.description %>
 * Author: <%= pkg.author %>
 * Author URI: <%= pkg.authorUrl %>
 * Version: <%= pkg.version %>
 * Text Domain: tecut
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'TECUT_SLUG' ) ) {
	define( 'TECUT_SLUG', '<%= pkg.slug %>' );
}

if ( ! defined( 'TECUT_VERSION' ) ) {
	define( 'TECUT_VERSION', '<%= pkg.version %>' );
}

if ( ! defined( 'TECUT_URL' ) ) {
	define( 'TECUT_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'TECUT_PATH' ) ) {
	define( 'TECUT_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * Custom autoloader function for plugin classes.
 * Autoloader and architecture below heavily inspired by WP Rig.
 * Thank you guys for your awesome work!
 *
 * Changes were made to fit the boilerplates needs (e.g. change namespaces and function names).
 *
 * @access private
 * @see https://github.com/wprig/wprig
 * @param string $class_name Class name to load.
 * @return bool True if the class was loaded, false otherwise.
 */
function tecut_autoload( $class_name ) {
	$namespace = 'tecut';

	if ( strpos( $class_name, $namespace . '\\' ) !== 0 ) {
		return false;
	}

	$parts = explode( '\\', substr( $class_name, strlen( $namespace . '\\' ) ) );
	$path  = TECUT_PATH . 'inc';

	foreach ( $parts as $part ) {
		$path .= '/' . $part;
	}

	$path .= '.php';

	if ( ! file_exists( $path ) ) {
		return false;

	}

	require_once $path;

	return true;
}
spl_autoload_register( 'tecut_autoload' );

// Load the `wp_tecut()` entry point function.
require TECUT_PATH . 'inc/functions.php';

// Initialize the plugin.
call_user_func( 'tecut\wp_tecut' );
