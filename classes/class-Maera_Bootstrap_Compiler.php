<?php


/**
* The Meara Bootstrap variables
*/
class Maera_Bootstrap_Compiler {

	/**
	 * Class constructor
	 */
	function __construct() {

		global $wp_customize;

		$theme_options = get_option( 'maera_admin_options', array() );

		// Early exit if the lessphp plugin is not installed
		if ( ! class_exists( 'Pre_Processors_Compiler' ) ) {
			return;
		}
		// Instantianate the compiler and pass the shell's properties to it
		$compiler = new Pre_Processors_Compiler( array(
			'compiler'     => 'less',
			'minimize_css' => ( 1 == get_theme_mod( 'minimize_css' ) ) ? true : false,
			'uname'        => 'maera',
		) );

		if ( $wp_customize || ( 1 == @$theme_options['dev_mode'] ) ) {

			add_action( 'wp_head', array( $this, 'echo_less' ) );
			remove_filter( 'maera/stylesheet/url', array( $compiler, 'stylesheet_url' ) );

		}

		add_filter( 'maera/compiler', array( $this, 'less' ) );

		// Trigger the compiler the first time the theme is enabled
		add_action( 'after_switch_theme', array( $compiler, 'makecss' ) );
		// Trigger the compiler when the customizer options are saved.
		add_action( 'customize_save_after', array( $compiler, 'makecss' ), 77 );
		// Trigger the compiler when the options in the admin page are saved
		add_action( 'maera/admin/save', array( $compiler, 'makecss' ) );

		// If the CSS file does not exist, attempt creating it.
		if ( ! file_exists( $compiler->file( 'path' ) ) ) {
			add_action( 'wp', array( $compiler, 'makecss' ) );
		}

	}

	function echo_less() {

		echo '<style type="text/less">' . $this->less() . '</style>';
		echo '<script>less = {
		    env: "development",
		    async: true,
		    fileAsync: true,
		    poll: 1000,
		    functions: {},
		    dumpLineNumbers: "comments",
		    relativeUrls: true,
		    rootpath: ":/' . MAERA_BOOTSTRAP_SHELL_URL . '/"
		  };</script>';
		echo '<script src="' . MAERA_BOOTSTRAP_SHELL_URL . '/assets/js/less.min.js" type="text/javascript"></script>';

	}


	/**
	 * Parse the array of variables to readable format by the less compiler
	 */
	function less() {

		global $wp_customize;

		$variables = maera_bootstrap_get_variables();

		// define the $content to avoid PHP notices
		$content = '';

		foreach ( $variables as $variable => $value ) {

			$content .= '@' . $variable . ': ' . $value . ';';

		}

		// Utilities
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/hide-text.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/opacity.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/image.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/labels.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/reset-filter.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/resize.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/responsive-visibility.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/size.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/tab-focus.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/text-emphasis.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/text-overflow.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/vendor-prefixes.less' );

		// Components
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/alerts.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/buttons.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/panels.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/pagination.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/list-group.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/nav-divider.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/forms.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/progress-bar.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/table-row.less' );

		// Skins
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/background-variant.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/border-radius.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/gradients.less' );

		// Layout
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/clearfix.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/center-block.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/nav-vertical-align.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/grid-framework.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/mixins/grid.less' );

		// Reset
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/normalize.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/print.less' );

		// Core CSS
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/scaffolding.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/type.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/code.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/grid.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/tables.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/forms.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/buttons.less' );

		// Components
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/component-animations.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/glyphicons.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/dropdowns.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/button-groups.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/input-groups.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/navs.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/navbar.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/breadcrumbs.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/pagination.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/pager.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/labels.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/badges.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/jumbotron.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/thumbnails.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/alerts.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/progress-bars.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/media.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/list-group.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/panels.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/wells.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/close.less' );

		// Components w/ JavaScript
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/modals.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/tooltip.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/popovers.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/carousel.less' );

		// Utility classes
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/utilities.less' );
		$content .= file_get_contents( MAERA_SHELL_PATH . '/assets/less/vendor/bootstrap/responsive-utilities.less' );

		$content .= file_get_contents( MAERA_SHELL_PATH .  '/assets/less/app.less' );
		$content .= ( get_theme_mod( 'gradients_toggle', 0 ) ) ? file_get_contents( MAERA_SHELL_PATH . '/assets/less/gradients.less' ) : '';
		$content .= ( 'static' == get_theme_mod( 'site_style' ) ) ? '@screen-xs-max: 0 !important; .container { max-width: none !important; width: @container-large-desktop; } html { overflow-x: auto !important; }' : '';

		$less = get_theme_mod( 'less', '' );
		$content .= ( ! empty( $less ) ) ? $less : '';

		$body_obj = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );
		$b_p_obj  = new Jetpack_Color( get_theme_mod( 'color_brand_primary', '#428bca' ) );

		$body_bg  = '#' . str_replace( '#', '', $body_obj->toHex() );
		$body_lum = $body_obj->toLuminosity();

		// Base font settings
		$font_base_family    = get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		// TODO: use getReadableContrastingColor() from Jetpack_Color class.
		// See https://github.com/Automattic/jetpack/issues/1068
		$font_base_color     = '#' . $body_obj->getGrayscaleContrastingColor(10)->toHex();

		$font_base_weight    = get_theme_mod( 'font_base_weight', '#333333' );
		$font_base_size      = get_theme_mod( 'font_base_size', 14 );
		$font_base_height    = get_theme_mod( 'font_base_height', 1.4 );

		$content .= 'body {font-family:' . $font_base_family . ';color:' . $font_base_color . ';font-weight:' . $font_base_weight . ';font-size:' . $font_base_size . 'px;line-height:' . $font_base_height . ';}';

		// Headers font
		$headers_font_family = get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );

		$content .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{';
		$content .= 'font-family: ' . $headers_font_family . ';';
		$content .= 'color: ' .$font_base_color . ';';
		$content .= 'font-weight: ' . get_theme_mod( 'font_headers_weight', 400 ) . ';';
		$content .= 'line-height: ' . get_theme_mod( 'font_headers_height', 1.1 ) . ';';
		$content .= '}';

		$content .= 'h1, .h1 { font-size: ' . ( 2.6  * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';
		$content .= 'h2, .h2 { font-size: ' . ( 2.15 * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';
		$content .= 'h3, .h3 { font-size: ' . ( 1.7  * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';
		$content .= 'h4, .h4 { font-size: ' . ( 1.1  * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';
		$content .= 'h5, .h5 { font-size: ' . ( 1    * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';
		$content .= 'h6, .h6 { font-size: ' . ( .85  * get_theme_mod( 'font_headers_size', 1 ) * $font_base_size ) . 'px; }';

		// Navigation font
		$navbar_font_family = get_theme_mod( 'font_menus_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$navbar_obj = new Jetpack_Color( get_theme_mod( 'body_bg_color', '#ffffff' ) );

		$content .= '.navbar{';
		$content .= 'font-family: ' . $navbar_font_family . ';';
		$content .= 'font-weight: ' . get_theme_mod( 'font_menus_weight', 400 ) . ';';
		$content .= 'line-height: ' . get_theme_mod( 'font_menus_height', 1.1 ) . ';';
		$content .= '}';

		// Navigation font
		$jumbotron_font_family = get_theme_mod( 'font_jumbotron_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$jumbotron_obj = new Jetpack_Color( get_theme_mod( 'jumbo_bg', '#ffffff' ) );

		$content .= '.jumbotron{';
		$content .= 'color: ' . '#' . $body_obj->getGrayscaleContrastingColor(10)->toHex() . ';';
		$content .= 'font-family: ' . $jumbotron_font_family . ';';
		$content .= 'font-weight: ' . get_theme_mod( 'font_jumbotron_weight', 400 ) . ';';
		$content .= 'line-height: ' . get_theme_mod( 'font_jumbotron_height', 1.1 ) . ';';
		$content .= '}';

		$content .= '.admin-bar body{';
		$content .= 'padding-top: ' . get_theme_mod( 'navbar_height', 50 ) . ';';
		$content .= '}';

		// Make sure links are readable
		$links_color = $b_p_obj->getReadableContrastingColor( $body_obj, 2 );
		// Use "body a" instead of plain "a" to override the defaults
		$content .= 'body a, body a:visited, body a:hover { color: #' . $links_color->toHex() . ';}';

		return $content;

	}

}
