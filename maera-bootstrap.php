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

if ( ! class_exists( 'Maera_Bootstrap' ) ) {

	/**
	* The Bootstrap Shell module
	*/
	class Maera_Bootstrap {

		private static $instance;

		/**
		 * Class constructor
		 */
		public function __construct() {

			if ( ! defined( 'MAERA_SHELL_PATH' ) ) {
				define( 'MAERA_SHELL_PATH', dirname( __FILE__ ) );
			}

			$this->required_plugins();

			add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );

			// Include other classes
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Widget_Dropdown.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Widgets.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Styles.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Structure.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Compiler.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Images.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Excerpt.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Scripts.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Meta.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Layout.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Navbar.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Social.php' );
			include_once( MAERA_SHELL_PATH . '/includes/variables.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Timber.php' );

			// Include the customizer
			include_once( MAERA_SHELL_PATH . '/customizer.php' );

			// Instantianate addon classes
			$bs_structure = new Maera_Bootstrap_Structure();
			$bs_widgets   = new Maera_Bootstrap_Widgets();
			$bs_styles    = new Maera_BS_Styles();
			$bs_compiler  = new Maera_Bootstrap_Compiler();
			$bs_images    = new Maera_BS_Images();
			$bs_excerpt   = new Maera_BS_Excerpt();
			$bs_timber    = new Maera_BS_Timber();
			$bs_scripts   = new Maera_BS_Scripts();
			$bs_layout    = new Maera_BS_Layout();
			$bs_navbar    = new Maera_BS_Navbar();
			$bs_social    = new Maera_BS_Social();

		}


		/**
		 * Singleton
		 */
		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		/**
		 * Add theme supports
		 */
		function theme_supports() {

			add_theme_support( 'kirki' );
			add_theme_support( 'maera_image' );
			add_theme_support( 'maera_color' );
			add_theme_support( 'less_compiler' );

		}


		/**
		* Build the array of required plugins.
		* You can use the 'maera/required_plugins' filter to add or remove plugins.
		*/
		function required_plugins() {

			$plugins[] = array(
				'name' => 'Breadcrumb Trail',
				'file' => 'breadcrumb-trail.php',
				'slug' => 'breadcrumb-trail'
			);
			$plugins[] = array(
				'name' => 'Less & scss compilers',
				'file' => 'less-plugin.php',
				'slug' => 'lessphp'
			);

			$plugins = new Maera_Required_Plugins( $plugins );

		}

	}

}
