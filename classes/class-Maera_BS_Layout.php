<?php

class Maera_BS_Layout {

	function __construct() {

		add_filter( 'maera/section_class/content', array( $this, 'layout_classes_content' ) );
		add_filter( 'maera/section_class/primary', array( $this, 'layout_classes_primary' ) );
		add_filter( 'maera/section_class/secondary', array( $this, 'layout_classes_secondary' ) );
		add_filter( 'maera/section_class/wrapper', array( $this, 'layout_classes_wrapper' ) );

		add_action( 'wp', array( $this, 'container_class_modifier' ) );
		add_action( 'wp', array( $this, 'sidebars_bypass' ) );

	}

	/**
	 * Figure out the layout classes.
	 * This will be used by other functions so that layouts are properly calculated.
	 */
	public static function layout_classes( $element ) {

		// What should we use for columns?
		$col = 'col-md-';

		// Get the layout we're using (sidebar arrangement).
		$layout = get_theme_mod( 'layout', 1 );

		// Apply a filter to the layout.
		// Allows us to bypass the selected layout using a simple filter like this:
		// add_filter( 'maera/layout/modifier', function() { return 3 } ); // will only run on PHP > 5.3
		// OR
		// add_filter( 'maera/layout/modifier', 'maera_return_2' ); // will also run on PHP < 5.3
		$layout = apply_filters( 'maera/layout/modifier', $layout );

		// Get the site style. Defaults to 'Wide'.
		$site_mode = get_theme_mod( 'site_style', 'wide' );

		// Get the sidebar widths
		$width_one = ( ! is_active_sidebar( 'sidebar_primary' ) )   ? null : get_theme_mod( 'layout_primary_width', 4 );
		$width_two = ( ! is_active_sidebar( 'sidebar_secondary' ) ) ? null : get_theme_mod( 'layout_secondary_width', 3 );

		// If the selected layout is no sidebars, then disregard the primary sidebar width.
		$width_one = ( 0 == $layout ) ? null : $width_one;

		// If the selected layout only has one sidebar, disregard the 2nd sidebar width.
		$width_two = ( ! in_array( $layout, array( 3, 4, 5 ) ) ) ? null : $width_two;

		// The main wrapper width
		$width_wrapper = ( is_null( $width_two ) ) ? null : 12 - $width_two;

		// The main content area width
		$width_main = 12 - $width_one - $width_two;

		// When we select a layout like sidebar-content-sidebar, we need a wrapper around the primary sidebar and the content.
		// That changes the way we calculate the primary sidebar and the content columns.
		if ( ! is_null( $width_wrapper ) ) {

			$width_main = 12 - floor( ( 12 * $width_one ) / ( 12 - $width_two ) );
			$width_one  = floor( ( 12 * $width_one ) / ( 12 - $width_two ) );

		}

		if ( $element == 'primary' ) {

			// return the primary class
			$columns = $col . intval( $width_one );
			$classes = ( is_null( $width_one ) ) ? null : $columns;

		} elseif ( $element == 'secondary' ) {

			// return the secondary class
			$columns = $col . intval( $width_two );
			$classes = ( is_null( $width_two ) ) ? null : $columns;

		} elseif ( $element == 'wrapper' ) {

			$columns = $col . intval( $width_wrapper );

			if ( ! is_null( $width_wrapper ) ) {
				$classes = ( 3 == $layout ) ? $columns . ' pull-right' : $columns;
			} else {
				$classes = null;
			}

		} else {

			// return the main class
			$columns = $col . intval( $width_main );
			$classes = ( in_array( $layout, array( 2, 3, 5 ) ) && ! is_null( $width_one ) ) ? $columns . ' pull-right' : $columns;

		}

		return $classes;

	}

	/**
	 * This is just a helper function.
	 *
	 * Returns the class of the main content area.
	 */
	function layout_classes_content() {
		return self::layout_classes( 'content' );
	}


	/**
	 * This is just a helper function.
	 *
	 * Returns the class of the main primary sidebar
	 */
	function layout_classes_primary() {
		return self::layout_classes( 'primary' );
	}


	/**
	 * This is just a helper function.
	 *
	 * Returns the class of the main secondary sidebar
	 */
	function layout_classes_secondary() {
		return self::layout_classes( 'secondary' );
	}


	/**
	 * This is just a helper function.
	 *
	 * Returns the class of the wrppaer (main conent area + primary sidebar.)
	 * Makes complex layouts possible.
	 */
	function layout_classes_wrapper() {
		return self::layout_classes( 'wrapper' );
	}

	/**
	 * Null sidebars when needed.
	 * These are applied on the index.php file.
	 */
	function sidebars_bypass() {

		$layout = get_theme_mod( 'layout', 1 );
		$layout = apply_filters( 'maera/layout/modifier', $layout );

		// If the layout does not contain 2 sidebars, do not render the secondary sidebar
		if ( ! in_array( $layout, array( 3, 4, 5 ) ) ) {
			add_filter( 'maera/sidebar/secondary', '__return_null' );
		}

		// If the layout selected contains no sidebars, do not render the sidebars
		if ( 0 == $layout ) {
			add_filter( 'maera/sidebar/primary', '__return_null' );
			add_filter( 'maera/sidebar/secondary', '__return_null' );
		}

		// Have we selected custom layouts per post type?
		// if yes, then make sure the layout used for post types is the custom selected one.
		if ( 1 == get_theme_mod( 'cpt_layout_toggle', 0 ) ) {

			$post_types = get_post_types( array( 'public' => true ), 'names' );

			foreach ( $post_types as $post_type ) {

				if ( is_singular( $post_type ) ) {
					$layout = get_theme_mod( $post_type . '_layout', get_theme_mod( 'layout', 1 ) );
					add_filter( 'maera/layout/modifier', 'maera_return_' . $layout );
				}

			}

		}

	}

	/**
	 * Close the wrapper div when using the left navbar
	 */
	function left_wrapper_close_right() { echo '</div></div>'; }


	/**
	 * return "container-fluid"
	 */
	function return_container_fluid() { return 'container-fluid'; }


	/**
	 * return "container"
	 */
	function return_container() { return 'container'; }

	/**
	 * Filter for the container class.
	 *
	 * When the user selects fluid site mode, remove the container class from containers.
	 */
	function container_class_modifier() {

		$nav_style  = get_theme_mod( 'navbar_position', 'normal' );
		$site_style = ( 'left' != $nav_style ) ? get_theme_mod( 'site_style', 'wide' ) : 'fluid';
		$breakpoint = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );

		if ( 'fluid' == $site_style ) {

			// Fluid mode
			add_filter( 'maera/container_class', array( $this, 'return_container_fluid' ) );
			add_filter( 'maera/header/class/container', array( $this, 'return_container_fluid' ) );

		} else {

			add_filter( 'maera/container_class', array( $this, 'return_container' ) );
			add_filter( 'maera/header/class/container', array( $this, 'return_container' ) );

		}

		if ( 'full' == $nav_style ) {

			add_filter( 'maera/header/class/container', array( $this, 'return_container_fluid' ) );

		}

	}

}
