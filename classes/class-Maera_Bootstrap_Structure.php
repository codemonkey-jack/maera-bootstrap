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
			add_action( 'maera/header/inside/begin', array( $this, 'navbar_search' ), 5 );
			add_action( 'maera/sidebar/inside/begin', array( $this, 'navbar_search' ), 5 );

			// Breadcrumbs
			add_action( 'maera/content/before', array( $this, 'breadcrumbs' ) );

			add_action( 'maera/wrap/before', array( $this, 'header_html' ), 3 );
			add_action( 'maera/wrap/before', array( $this, 'jumbotron_html' ), 5 );

			add_filter( 'maera/header/class', array( $this, 'navbar_positioning_class' ) );

			add_filter( 'body_class', array( $this, 'body_class' ) );

			add_action( 'wp', array( $this, 'sidebars_bypass' ) );

			// Layout
			add_filter( 'maera/section_class/content', array( $this, 'layout_classes_content' ) );
			add_filter( 'maera/section_class/primary', array( $this, 'layout_classes_primary' ) );
			add_filter( 'maera/section_class/secondary', array( $this, 'layout_classes_secondary' ) );
			add_filter( 'maera/section_class/wrapper', array( $this, 'layout_classes_wrapper' ) );
			add_action( 'wp', array( $this, 'container_class_modifier' ) );

			// Post Meta
			add_action( 'maera/entry/meta', array( $this, 'meta_elements' ), 10, 1 );

			add_filter( 'maera/content_width', array( $this, 'content_width_px' ) );

		}


		/*
		 * Calculate the width of the content area in pixels.
		 */
		public static function content_width_px() {

			$layout = apply_filters( 'maera/layout/modifier', get_theme_mod( 'layout', 1 ) );

			$container  = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter     = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

			$main_span  = filter_var( self::layout_classes( 'content' ), FILTER_SANITIZE_NUMBER_INT );
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
		 * Figure out the post meta that we want to use and inject them to our content.
		 */
		public static function meta_elements( $post_id = '' ) {

			if ( '' == $post_id ) {
				global $post;
				$post_id = $post->ID;
			}

			$post = get_post( $post_id );

			// Get the options from the db
			$metas       = get_theme_mod( 'maera_entry_meta_config', 'post-format, date, author, comments' );
			$date_format = get_theme_mod( 'date_meta_format', 1 );

			$categories_list = has_category( '', $post_id ) ? get_the_category_list( __( ', ', 'maera_bootstrap' ), '', $post_id ) : false;
			$tag_list        = has_tag( '', $post_id ) ? get_the_tag_list( '', __( ', ', 'maera_bootstrap' ) ) : false;

			// No need to proceed if the option is empty
			if ( empty( $metas ) ) {
				return;
			}

			$content = '';

			// convert options from CSV to array
			$metas_array = explode( ',', $metas );

			// clean up the array a bit... make sure there are no spaces that may mess things up
			$metas_array = array_map( 'trim', $metas_array );

			return $metas_array;

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


		/*
		 * The content of the Jumbotron region
		 * according to what we've entered in the customizer
		 */
		function jumbotron_html() {

			$site_style   = get_theme_mod( 'site_style', 'wide' );
			// $visibility   = get_theme_mod( 'jumbotron_visibility', 1 );
			$nocontainer  = get_theme_mod( 'jumbotron_nocontainer', 0 );

			if ( 0 != get_theme_mod( 'jumbotron_widgets_nr', 0 ) ) : ?>

				<div class="clearfix"></div>

				<?php if ( 'boxed' == $site_style && 1 != $nocontainer ) : ?>
					<div class="container jumbotron">
				<?php else : ?>
					<div class="jumbotron">
				<?php endif; ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						<div class="container">
					<?php endif; ?>

						<?php do_action( 'maera/jumbotron/content' ); ?>
						<?php do_action( 'maera/jumbotron/content/ewa', 'jumbotron', 'row' ); ?>

					<?php if ( ( 1 != $nocontainer && 'wide' == $site_style ) || 'boxed' == $site_style ) : ?>
						</div>
					<?php endif; ?>

					</div>


				</div>
				<?php

			endif;
		}


		/*
		 * The Header template
		 */
		function header_html() { ?>

			<?php if ( 0 != get_theme_mod( 'header_widgets_nr', 0 ) ) : ?>
				<?php do_action( 'maera/extra_header/before' ); ?>
				<?php do_action( 'maera/extra_header/before/ewa', 'pre_header', 'row' ); ?>

				<header class="page-header">

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						<div class="container header-boxed">
					<?php endif; ?>

						<div class="header-wrapper container-fluid">

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								<div class="container">
							<?php endif; ?>

							<?php do_action( 'maera/extra_header/widgets/ewa', 'header', 'row' ); ?>

							<?php if ( 'wide' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
								</div>
							<?php endif; ?>

						</div>

					<?php if ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) : ?>
						</div>
					<?php endif; ?>

				</header>
				<?php do_action( 'maera/extra_header/after' ); ?>
				<?php do_action( 'maera/extra_header/after/ewa', 'post_header', 'row' ); ?>

			<?php endif;

		}


		/**
		 * Configure and initialize the Breadcrumbs
		 */
		function breadcrumbs() {

			$breadcrumbs = get_theme_mod( 'breadcrumbs', 0 );

			if ( 0 != $breadcrumbs && ! is_home() && ! is_front_page() ) {

				$args = array(
					'container'       => 'ol',
					'separator'       => '</li><li>',
					'before'          => '<li>',
					'after'           => '</li>',
					'show_on_front'   => true,
					'network'         => false,
					'show_title'      => true,
					'show_browse'     => true,
					'echo'            => true,
					'labels'          => array(
						'browse'      => '',
						'home'        => '<i class="el-icon-home"></i>',
					),
				);

				maera_breadcrumb_trail( $args );

			}

		}


		/**
		 * Include the NavBar Search
		 */
		function navbar_search() {
			$navbar_search = get_theme_mod( 'navbar_search' );

			if ( $navbar_search == 1 ) { ?>
				<form role="search" method="get" id="searchform" class="form-search navbar-right navbar-form" action="<?php echo home_url('/'); ?>">
					<label class="hide" for="s"><?php _e('Search for:', 'maera_bootstrap'); ?></label>
					<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="form-control search-query" placeholder="<?php _e('Search', 'maera_bootstrap'); ?> <?php bloginfo('name'); ?>">
				</form>
			<?php }
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
			$navbar_position = get_theme_mod( 'navbar_position', 'none' );

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
