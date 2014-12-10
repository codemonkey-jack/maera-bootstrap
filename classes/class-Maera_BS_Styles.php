<?php

if ( ! class_exists( 'Maera_BS_Styles' ) ) {

	/**
	* The Bootstrap Shell module
	*/
	class Maera_BS_Styles {


		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add the custom CSS
			add_action( 'wp_enqueue_scripts', array( $this, 'custom_css' ), 105 );

			// Styles
			add_filter( 'maera/styles', array( $this, 'header_css' ) );
			add_filter( 'maera/styles', array( $this, 'layout_css' ) );
			add_filter( 'maera/styles', array( $this, 'navbar_css' ) );
			add_filter( 'maera/styles', array( $this, 'body_css' ) );

			add_action( 'wp_print_styles', array( $this, 'google_font' ) );

		}


		/**
		* Enqueue Google fonts if enabled
		*/
		function google_font() {

			$default_font = '"Helvetica Neue",Helvetica,Arial,sans-serif';

			$font_families = array(
				str_replace( ' ', '+', get_theme_mod( 'font_base_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'headers_font_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'font_jumbotron_font_family', $default_font ) ),
				str_replace( ' ', '+', get_theme_mod( 'font_menus_font_family', $default_font ) ),
			);

			$font_weights = array(
				get_theme_mod( 'font_base_weight', 400 ),
				get_theme_mod( 'font_headers_weight', 400 ),
			);

			$font_subsets = get_theme_mod( 'font_subsets', 'latin' );

			wp_register_style( 'maera_google_font', Kirki_Fonts::get_google_font_uri( $font_families, $font_weights, $font_subsets ) );
	 		wp_enqueue_style( 'maera_google_font' );

		}

		/**
		 * Body styles
		 */
		function body_css( $styles ) {

			$color   = get_theme_mod( 'body_bg_color', '#ffffff' );
			$opacity = get_theme_mod( 'body_bg_opacity', 100 );
			$navbar_position = get_theme_mod( 'navbar_position', 'normal' );


			$bg = $color;
			if ( 100 != $opacity && function_exists( 'kirki_get_rgba' ) ) {
				$bg = kirki_get_rgba( $color, $opacity );
			}

			$styles .= 'body.bootstrap #wrap-main-section{background:' . $bg . ';}';

			if ( $navbar_position == 'fixed-top' ) {
				$navbar_height = get_theme_mod( 'navbar_height', 50 );
				$styles .= 'body.body-nav-fixed-top{padding-top:' . $navbar_height . 'px;}';
			}

			return $styles;

		}


		/*
		 * Any necessary extra CSS is generated here
		 */
		function header_css( $styles ) {

			$header_bg = get_theme_mod( 'header_bg_color', '#ffffff' );

			if ( 1 == get_theme_mod( 'header_toggle', 0 ) ) {

				$el = ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) ? 'body .header-boxed' : 'body .header-wrapper';
				// $styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . Maera::text_color_calculated( $header_bg ) . ';}';
				// TODO: use getReadableContrastingColor() from Jetpack_Color class.
				// See https://github.com/Automattic/jetpack/issues/1068
				$styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . '#222222' . ';}';

			}

			return $styles;

		}

		/**
		 * Navbar additional CSS
		 */
		function navbar_css( $styles ) {

			$font_size = get_theme_mod( 'font_menus_size', 14 );

			$color   = get_theme_mod( 'navbar_bg', '#f8f8f8' );
			$opacity = get_theme_mod( 'navbar_bg_opacity', 100 );

			$bg = $color;
			if ( 100 != $opacity && function_exists( 'kirki_get_rgba' ) ) {
				$bg = kirki_get_rgba( $color, $opacity );
			}

			$styles .= ( 14 != $font_size ) ? '.nav-main{font-size:' . $font_size . 'px;}' : '';
			$styles .= '#banner-header{background:' . $bg . ';}';

			return $styles;

		}


		/**
		 * Additional CSS rules for layout options
		 */
		function layout_css( $style ) {

			global $wp_customize;

			// Customizer-only styles
			if ( $wp_customize ) {

				$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
				$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

				$style .= '
				.container { padding-left: ' . round( $gutter / 2 ) . 'px; padding-right: ' . round( $gutter / 2 ) . 'px; }
				@media (min-width: ' . $screen_sm . 'px) { .container { width: ' . ( $screen_sm - ( $gutter / 2 ) ). 'px; } }
				@media (min-width: ' . $screen_lg . 'px) { .container { width: ' . ( $screen_md - ( $gutter / 2 ) ). 'px; } }
				@media (min-width: ' . $screen_lg . 'px) { .container { width: ' . ( $screen_lg - ( $gutter / 2 ) ). 'px; } }
				.container-fluid { padding-left: ' . round( $gutter / 2 ) . 'px; padding-right: ' . round( $gutter / 2 ) . 'px; }
				.row { margin-left: -' . round( $gutter / 2 ) . 'px; margin-right: -' . round( $gutter / 2 ) . 'px; }
				.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 { padding-left: ' . round( $gutter / 2 ) . 'px; padding-right: ' . round( $gutter / 2 ) . 'px; }';

			}

			return $style;

		}


		/**
		 * Include the custom CSS
		 */
		function custom_css() {
			$css = get_theme_mod( 'css', '' );

			if ( ! empty( $css ) ) {
				wp_add_inline_style( 'maera', $css );
			}
		}

	}

}
