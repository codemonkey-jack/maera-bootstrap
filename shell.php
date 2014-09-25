<?php
/*
Plugin Name:         Maera Bootstrap Shell
Plugin URI:
Description:         Add the bootstrap shell to the Maera theme
Version:             1.0-beta1
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
*/

define( 'MAERA_BOOTSTRAP_SHELL_URL', plugins_url( '', __FILE__ ) );
define( 'MAERA_BOOTSTRAP_SHELL_PATH', dirname( __FILE__ ) );

// Include the compiler class
require_once MAERA_BOOTSTRAP_SHELL_PATH . '/class-Maera_Bootstrap.php';

/**
 * Include the shell
 */
function maera_shell_bootstrap_include( $shells ) {

	// Add our shell to the array of available shells
	$shells[] = array(
		'value' => 'bootstrap',
		'label' => 'Bootstrap',
		'class' => 'Maera_Bootstrap',
	);

	return $shells;

}
add_filter( 'maera/shells/available', 'maera_shell_bootstrap_include' );

/**
 * Plugin textdomains
 */
function maera_bootstrap_texdomain() {
	$lang_dir    = get_template_directory() . '/languages';
	$custom_path = WP_LANG_DIR . '/maera-' . get_locale() . '.mo';

	if ( file_exists( $custom_path ) ) {
		load_textdomain( 'maera_bootstrap', $custom_path );
	} else {
		load_plugin_textdomain( 'maera_bootstrap', false, $lang_dir );
	}
}
add_action( 'plugins_loaded', 'maera_bootstrap_texdomain' );
