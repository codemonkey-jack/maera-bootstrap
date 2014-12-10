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

			add_action( 'maera/header/inside/begin', array( $this, 'social_links_navbar_content' ), 10 );
			add_action( 'maera/sidebar/inside/end', array( $this, 'social_links_navbar_content' ), 10 );
			add_filter( 'maera/header/menu/class', array( $this, 'navbar_links_alignment' ) );

			add_filter( 'maera/header/class', array( $this, 'navbar_positioning_class' ) );

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
		 * Navbar Positioning classes
		 */
		function navbar_positioning_class( $classes ) {

			$position = get_theme_mod( 'navbar_position', 'normal' );

			$classes .= ( 'fixed-top' == $position || 'fixed-bottom' == $position ) ? ' navbar-' . $position : ' navbar-static-top';

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

		/**
		 * Build the social links
		 */
		function social_links_builder( $before = '', $after = '', $separator = '' ) {

			$social_links = array(
				'blogger'     => __( 'Blogger', 'maera_bootstrap' ),
				'deviantart'  => __( 'DeviantART', 'maera_bootstrap' ),
				'digg'        => __( 'Digg', 'maera_bootstrap' ),
				'dribbble'    => __( 'Dribbble', 'maera_bootstrap' ),
				'facebook'    => __( 'Facebook', 'maera_bootstrap' ),
				'flickr'      => __( 'Flickr', 'maera_bootstrap' ),
				'github'      => __( 'Github', 'maera_bootstrap' ),
				'googleplus'  => __( 'Google+', 'maera_bootstrap' ),
				'instagram'   => __( 'Instagram', 'maera_bootstrap' ),
				'linkedin'    => __( 'LinkedIn', 'maera_bootstrap' ),
				'myspace'     => __( 'MySpace', 'maera_bootstrap' ),
				'pinterest'   => __( 'Pinterest', 'maera_bootstrap' ),
				'reddit'      => __( 'Reddit', 'maera_bootstrap' ),
				'rss'         => __( 'RSS', 'maera_bootstrap' ),
				'skype'       => __( 'Skype', 'maera_bootstrap' ),
				'soundcloud'  => __( 'SoundCloud', 'maera_bootstrap' ),
				'tumblr'      => __( 'Tumblr', 'maera_bootstrap' ),
				'twitter'     => __( 'Twitter', 'maera_bootstrap' ),
				'vimeo'       => __( 'Vimeo', 'maera_bootstrap' ),
				'vkontakte'   => __( 'Vkontakte', 'maera_bootstrap' ),
				'youtube'     => __( 'YouTube', 'maera_bootstrap' ),
			);

			$content = $before;

			foreach ( $social_links as $social_link => $label ) {
				$link = get_theme_mod( $social_link . '_link', '' );

				if ( '' != esc_url( $link ) ) {
					$content .= '<a role="link" aria-labelledby="' . $label . '" href="' . $link . '" target="_blank" title="' . $label . '"><i class="el-icon-' . $social_link . '"></i>';

					if ( 'dropdown' == get_theme_mod( 'navbar_social', 'off' ) ) {
						$content .= '&nbsp;'.$label;
					}
					$content .= '</a>';
					$content .= $separator;
				}
			}

			$content .= $after;

			return $content;

		}


		/**
		 * Social links in navbars
		 */
		function social_links_navbar_content() {

			$content = $before = $after = $separator = '';

			$social_mode = get_theme_mod( 'navbar_social', 'off' );
			$navbar_position = get_theme_mod( 'navbar_position', 'normal' );

			if ( 'inline' == $social_mode ) {
				if ( $navbar_position == 'right-slide' || $navbar_position == 'left-slide' ) {
					$before    = '<ul class="nav navbar-nav navbar-inline-socials"><li>';
				} else {
					$before    = '<ul class="nav navbar-nav navbar-right navbar-inline-socials"><li>';
				}
				$after     = '</li></ul>';
				$separator = '</li><li>';
			} elseif ( 'dropdown' == $social_mode ) {
				if ( $navbar_position == 'right-slide' || $navbar_position == 'left-slide' ) {
					$before    = '<ul class="nav navbar-nav navbar-dropdown-socials"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="el-icon-network"></i>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu" role="menu"><li>';
				} else {
					$before    = '<ul class="nav navbar-nav navbar-right navbar-dropdown-socials"><li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="el-icon-network"></i>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu" role="menu"><li>';
				}
				$after     = '</li></ul></li></ul>';
				$separator = '</li><li>';
			} elseif ( 'off' == $social_mode ) {
				return;
			}

			$content = $this->social_links_builder( $before, $after, $separator );

			echo $content;
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

}
