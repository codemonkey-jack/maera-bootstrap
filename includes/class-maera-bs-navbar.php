<?php

class Maera_BS_Navbar {

	function __construct() {
		add_filter( 'maera/header/class', array( $this, 'navbar_positioning_class' ) );
		add_filter( 'maera/header/menu/class', array( $this, 'navbar_links_alignment' ) );
	}

	/**
	 * Navbar Positioning classes
	 */
	function navbar_positioning_class( $classes ) {

		$position = get_theme_mod( 'navbar_position', 'normal' );
		$classes .= ( 'fixed-top' == $position || 'fixed-bottom' == $position ) ? ' navbar-' . $position : ' navbar-static-top';

		return $classes;

	}

	/**
	 * Take care of the alignment of navbar menu items
	 */
	function navbar_links_alignment( $classes ) {

		$align = get_theme_mod( 'navbar_nav_align', 'left' );

		if ( 'center' == $align ) {
			$classes .= ' navbar-center';
		} else if ( 'right' == $align ) {
			$classes .= ' navbar-right';
		}

		return $classes;
	}

}
