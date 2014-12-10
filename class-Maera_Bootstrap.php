<?php

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

			// Include the customizer
			include_once( MAERA_SHELL_PATH . '/customizer.php' );

			// Include other classes
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Widget_Dropdown.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Widgets.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Styles.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Structure.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_Bootstrap_Compiler.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Images.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Excerpt.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Timber.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Scripts.php' );
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Meta.php' );
			include_once( MAERA_SHELL_PATH . '/includes/variables.php' );

			// Instantianate addon classes
			$bs_structure = new Maera_Bootstrap_Structure();
			$bs_widgets   = new Maera_Bootstrap_Widgets();
			$bs_styles    = new Maera_BS_Styles();
			$bs_compiler  = new Maera_Bootstrap_Compiler();
			$bs_images    = new Maera_BS_Images();
			$bs_excerpt   = new Maera_BS_Excerpt();
			$bs_timber    = new Maera_BS_Timber();
			$bs_scripts   = new Maera_BS_Scripts();

			global $extra_widget_areas;
			$extra_widget_areas = $bs_widgets->extra_widget_areas_array();

			$widget_width = new Maera_Widget_Dropdown( 'maera_widget_width', __( 'Width' ), array(
				1  => 'col-md-1',
				2  => 'col-md-2',
				3  => 'col-md-3',
				4  => 'col-md-4',
				5  => 'col-md-5',
				6  => 'col-md-6',
				7  => 'col-md-7',
				8  => 'col-md-8',
				9  => 'col-md-9',
				10 => 'col-md-10',
				11 => 'col-md-11',
				12 => 'col-md-12',
			) );

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
