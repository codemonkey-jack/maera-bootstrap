<?php

if ( ! class_exists( 'Maera_Bootstrap_Structure' ) ) {

	/**
	* The Bootstrap Shell module
	*/
	class Maera_Bootstrap_Structure {

		/**
		 * Class constructor
		 */
		public function __construct() {

			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_filter( 'maera/content_width', array( $this, 'content_width_px' ) );

			if ( 0 != get_theme_mod( 'breadcrumbs', 0 ) ) {
				add_action( 'maera/content/before', array( $this, 'breadcrumbs' ) );
			}

		}


		/*
		 * Calculate the width of the content area in pixels.
		 */
		public static function content_width_px() {

			$layout = apply_filters( 'maera/layout/modifier', get_theme_mod( 'layout', 1 ) );

			$container  = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter     = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

			$main_span  = filter_var( Maera_BS_Layout::layout_classes( 'content' ), FILTER_SANITIZE_NUMBER_INT );
			$main_span  = str_replace( '-' , '', $main_span );

			// If the layout is #5, override the default function and calculate the span width of the main area again.
			if ( is_active_sidebar( 'sidebar-secondary' ) && is_active_sidebar( 'sidebar-primary' ) && $layout == 5 ) {
				$main_span = 12 - intval( get_theme_mod( 'layout_primary_width', 4 ) ) - intval( get_theme_mod( 'layout_secondary_width', 3 ) );
			}

			$width = $container * ( $main_span / 12 ) - $gutter;

			// Width should be an integer since we're talking pixels, round up!.
			$width = round( $width );

			return $width;
		}

		/**
		 * Add and remove body_class() classes
		 */
		function body_class( $classes ) {

			$site_style = get_theme_mod( 'site_style', 'wide' );

			if ( 'boxed' == $site_style ) {
				$classes[] = 'container';
				$classes[] = 'boxed';
			}

			$navbar_position = get_theme_mod( 'navbar_position', 'normal' );
			$classes[] = 'body-nav-' . $navbar_position;
			// Add the 'bootstrap' class
			$classes[] = 'bootstrap';

			return $classes;

		}

		/**
		 * Configure and initialize the Breadcrumbs
		 */
		function breadcrumbs() {

			$args = array(
				'container'       => 'ol',
				'separator'       => '</li><li>',
				'before'          => '<li>',
				'after'           => '</li>',
				'show_on_front'   => false,
				'network'         => false,
				'show_title'      => true,
				'show_browse'     => true,
				'echo'            => true,
				'labels'          => array(
					'browse'      => '',
					'home'        => '<i class="glyphicon glyphicon-home"></i>',
				),
			);

			if ( function_exists( 'breadcrumb_trail' ) ) {
				breadcrumb_trail( $args );
			}

		}

	}

}
