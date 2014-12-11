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
			include_once( MAERA_SHELL_PATH . '/classes/class-Maera_BS_Layout.php' );
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
			$bs_layout    = new Maera_BS_Layout();

			global $extra_widget_areas;
			$extra_widget_areas = $bs_widgets->extra_widget_areas_array();

			$widget_width = new Maera_Widget_Dropdown(
				array(
					'id'      => 'maera_widget_width',
					'label'   => __( 'Width' ),
					'choices' => array(
						1   => array( 'label' => 1,  'classes' => 'col-md-1' ),
						2   => array( 'label' => 2,  'classes' => 'col-md-2' ),
						3   => array( 'label' => 3,  'classes' => 'col-md-3' ),
						4   => array( 'label' => 4,  'classes' => 'col-md-4' ),
						5   => array( 'label' => 5,  'classes' => 'col-md-5' ),
						6   => array( 'label' => 6,  'classes' => 'col-md-6' ),
						7   => array( 'label' => 7,  'classes' => 'col-md-7' ),
						8   => array( 'label' => 8,  'classes' => 'col-md-8' ),
						9   => array( 'label' => 9,  'classes' => 'col-md-9' ),
						10  => array( 'label' => 10, 'classes' => 'col-md-10' ),
						11  => array( 'label' => 11, 'classes' => 'col-md-11' ),
						12  => array( 'label' => 12, 'classes' => 'col-md-12' ),
					),
					'default' => 12,
				)
			);

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
