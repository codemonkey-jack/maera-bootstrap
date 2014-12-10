<?php

class Maera_Bootstrap_Customizer {

	function __construct() {

		add_action( 'customize_register', array( $this, 'customizer_sections' ) );

		add_filter( 'kirki/controls', array( $this, 'settings_advanced' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_layout' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_layout_advanced' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_nav' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_nav_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_typo_nav' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_colors' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_html_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_body_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_typo_base' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_typo_headers' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_blog_options' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_feat_archive' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_feat_single' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_jumbo_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_structure_jumbo' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_typo_jumbo' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_header_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_social' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_footer_bg' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_branding' ) );
		add_filter( 'kirki/controls', array( $this, 'settings_general' ) );

	}

	function layouts() {

		$layouts = array(
			0 => get_template_directory_uri() . '/assets/images/1c.png',
			1 => get_template_directory_uri() . '/assets/images/2cr.png',
			2 => get_template_directory_uri() . '/assets/images/2cl.png',
			3 => get_template_directory_uri() . '/assets/images/3cl.png',
			4 => get_template_directory_uri() . '/assets/images/3cr.png',
			5 => get_template_directory_uri() . '/assets/images/3cm.png',
		);

		return $layouts;

	}
	/*
	 * Create the sections
	 */
	function customizer_sections( $wp_customize ) {

		$panels = array(
			'structure'   => array( 'title' => __( 'Structure', 'maera_bootstrap' ),   'description' => __( 'Set the structure options', 'maera_bootstrap' ),       'priority' => 10 ),
			'backgrounds' => array( 'title' => __( 'Backgrounds', 'maera_bootstrap' ), 'description' => __( 'Set the site backgrounds', 'maera_bootstrap' ),        'priority' => 20 ),
			'typography'  => array( 'title' => __( 'Typography', 'maera_bootstrap' ),  'description' => __( 'Set the site typography options', 'maera_bootstrap' ), 'priority' => 30 ),
			'blog'        => array( 'title' => __( 'Blog', 'maera_bootstrap' ),        'description' => __( 'Set the blog options', 'maera_bootstrap' ),            'priority' => 40 ),
		);

		$sections = array(
			'branding' => array( 'title' => __( 'Branding', 'maera_bootstrap' ), 'priority' => 5, 'panel' => '' ),

			'general'         => array( 'title' => __( 'General', 'maera_bootstrap' ),         'priority' => 10, 'panel' => 'structure' ),
			'layout'          => array( 'title' => __( 'Layout', 'maera_bootstrap' ),          'priority' => 15, 'panel' => 'structure' ),
			'layout_advanced' => array( 'title' => __( 'Advanced Layout', 'maera_bootstrap' ), 'priority' => 20, 'panel' => 'structure' ),
			'structure_jumbo' => array( 'title' => __( 'Jumbotron', 'maera_bootstrap' ),       'priority' => 30, 'panel' => 'structure' ),

			'html_bg'    => array( 'title' => __( 'HTML', 'maera_bootstrap' ),         'priority' => 10, 'panel' => 'backgrounds' ),
			'body_bg'    => array( 'title' => __( 'Body', 'maera_bootstrap' ),         'priority' => 15, 'panel' => 'backgrounds' ),
			'nav_bg'     => array( 'title' => __( 'Navbar', 'maera_bootstrap' ),       'priority' => 20, 'panel' => 'backgrounds' ),
			'header_bg'  => array( 'title' => __( 'Extra Header', 'maera_bootstrap' ), 'priority' => 25, 'panel' => 'backgrounds' ),
			'jumbo_bg'   => array( 'title' => __( 'Jumbotron', 'maera_bootstrap' ),    'priority' => 30, 'panel' => 'backgrounds' ),
			'footer_bg'  => array( 'title' => __( 'Footer', 'maera_bootstrap' ),       'priority' => 35, 'panel' => 'backgrounds' ),

			'colors' => array( 'title' => __( 'Colors', 'maera_bootstrap' ), 'priority' => 25, 'panel' => '' ),

			'typo_base'    => array( 'title' => __( 'Base', 'maera_bootstrap' ),         'priority' => 10, 'panel' => 'typography' ),
			'typo_headers' => array( 'title' => __( 'Headers', 'maera_bootstrap' ),      'priority' => 15, 'panel' => 'typography' ),
			'typo_nav'     => array( 'title' => __( 'Navbar', 'maera_bootstrap' ),       'priority' => 20, 'panel' => 'typography' ),
			'typo_header'  => array( 'title' => __( 'Extra Header', 'maera_bootstrap' ), 'priority' => 25, 'panel' => 'typography' ),
			'typo_jumbo'   => array( 'title' => __( 'Jumbotron', 'maera_bootstrap' ),    'priority' => 30, 'panel' => 'typography' ),
			'typo_footer'  => array( 'title' => __( 'Footer', 'maera_bootstrap' ),       'priority' => 35, 'panel' => 'typography' ),

			'blog_options' => array( 'title' => __( 'Blog Options', 'maera_bootstrap' ),                'priority' => 10, 'panel' => 'blog' ),
			'feat_archive' => array( 'title' => __( 'Featured Images on archives', 'maera_bootstrap' ), 'priority' => 15, 'panel' => 'blog' ),
			'feat_single'  => array( 'title' => __( 'Featured Images on posts', 'maera_bootstrap' ),    'priority' => 20, 'panel' => 'blog' ),

			'social' => array( 'title' => __( 'Social Links', 'maera_bootstrap' ), 'priority' => 45, 'panel' => '' ),
			'advanced' => array( 'title' => __( 'Advanced', 'maera_bootstrap' ), 'priority' => 50, 'panel' => '' ),
		);

		foreach ( $sections as $section => $args ) {

			$wp_customize->add_section( $section, array(
				'title'    => $args['title'],
				'priority' => $args['priority'],
				'panel'    => $args['panel']
			) );

		}

		foreach ( $panels as $panel => $args ) {
			$wp_customize->add_panel( $panel, array(
				'priority'       => $args['priority'],
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => $args['title'],
				'description'    => $args['description']
			) );
		}

	}

	function settings_advanced( $controls ) {

		$controls[] = array(
			'type'     => 'textarea',
			'setting'  => 'css',
			'label'    => __( 'Custom CSS', 'maera_bootstrap' ),
			'subtitle' => __( 'You can write your custom CSS here. This code will appear in a script tag appended in the header section of the page.', 'maera_bootstrap' ),
			'section'  => 'advanced',
			'priority' => 4,
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'textarea',
			'setting'  => 'less',
			'label'    => __( 'Custom LESS', 'maera_bootstrap' ),
			'subtitle' => __( 'You can write your custom LESS here. This code will be compiled with the other LESS files of the theme and be appended to the header.', 'maera_bootstrap' ),
			'section'  => 'advanced',
			'priority' => 5,
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'textarea',
			'setting'  => 'js',
			'label'    => __( 'Custom JS', 'maera_bootstrap' ),
			'subtitle' => __( 'You can write your custom JavaScript/jQuery here. The code will be included in a script tag appended to the bottom of the page.', 'maera_bootstrap' ),
			'section'  => 'advanced',
			'priority' => 6,
			'default'  => '',
		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'minimize_css',
			'label'    => __( 'Minimize CSS', 'maera_bootstrap' ),
			'description' => __( 'Minimize the generated CSS. This should be always be checked for production sites.', 'maera_bootstrap' ),
			'section'  => 'advanced',
			'priority' => 10,
			'default'  => 1,
		);

		return $controls;

	}

	function settings_layout( $controls ) {

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'site_style',
			'label'    => __( 'Site Style', 'maera_bootstrap' ),
			'subtitle' => __( 'Wide and boxed Layouts are responsive while fluid layouts are full-width.', 'maera_bootstrap' ),
			'section'  => 'layout',
			'priority' => 2,
			'default'  => 'wide',
			'choices'  => array(
				'wide'    => __( 'Wide', 'maera_bootstrap' ),
				'boxed'   => __( 'Boxed', 'maera_bootstrap' ),
				'fluid'   => __( 'Fluid', 'maera_bootstrap' ),
			),
		);

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'image',
			'setting'  => 'layout',
			'label'    => __( 'Layout', 'maera_bootstrap' ),
			'subtitle' => __( 'Select your main layout. Please note that if no widgets are present in a sidebar then that sidebar will not be displayed. ', 'maera_bootstrap' ),
			'section'  => 'layout',
			'priority' => 3,
			'default'  => 1,
			'choices'  => $this->layouts(),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'layout_primary_width',
			'label'    => __( 'Primary Sidebar Width', 'maera_bootstrap' ),
			'description' => '',
			'section'  => 'layout',
			'priority' => 4,
			'default'  => 4,
			'choices'  => array(
				'min'  => 1,
				'max'  => 5,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'layout_secondary_width',
			'label'    => __( 'Secondary Sidebar Width', 'maera_bootstrap' ),
			'description' => '',
			'section'  => 'layout',
			'priority' => 5,
			'default'  => 3,
			'choices'  => array(
				'min'  => 1,
				'max'  => 5,
				'step' => 1,
			),
		);

		return $controls;

	}

	function settings_layout_advanced( $controls ) {

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'widgets_mode',
			'label'    => __( 'Widgets mode', 'maera_bootstrap' ),
			'subtitle' => __( 'How do you want your widgets to be displayed?', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 13,
			'default'  => 2,
			'choices'  => array(
				'none'  => __( 'None', 'maera_bootstrap' ),
				'well'  => __( 'Well', 'maera_bootstrap' ),
				'panel' => __( 'Panel', 'maera_bootstrap' ),
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'screen_tablet',
			'label'    => __( 'Small Screen / Tablet view', 'maera_bootstrap' ),
			'subtitle' => __( 'The width of Tablet screens. Default: 768px', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 81,
			'default'  => 768,
			'choices'  => array(
				'min'  => 620,
				'max'  => 2100,
				'step' => 1
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'screen_desktop',
			'label'    => __( 'Desktop Container Width', 'maera_bootstrap' ),
			'subtitle' => __( 'The width of normal screens. Default: 992px', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 82,
			'default'  => 992,
			'choices'  => array(
				'min'  => 620,
				'max'  => 2100,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'screen_large_desktop',
			'label'    => __( 'Large Desktop Container Width', 'maera_bootstrap' ),
			'subtitle' => __( 'The width of Large Desktop screens. Default: 1200px', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 83,
			'default'  => 1200,
			'choices'  => array(
				'min'  => 620,
				'max'  => 2100,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'gutter',
			'label'    => __( 'Gutter', 'maera_bootstrap' ),
			'subtitle' => __( 'The spacing between grid columns. Default: 30px', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 84,
			'default'  => 30,
			'choices'  => array(
				'min'  => 0,
				'max'  => 80,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'cpt_layout_toggle',
			'label'    => __( 'Per Post-Type layouts', 'maera_bootstrap' ),
			'subtitle' => __( 'After you enable this setting you will have to save your settings and refresh your page in order to see the new options.', 'maera_bootstrap' ),
			'section'  => 'layout_advanced',
			'priority' => 90,
			'default'  => 0,
		);

		if ( 1 == get_theme_mod( 'cpt_layout_toggle', 0 ) ) {

			$post_types = get_post_types( array( 'public' => true ), 'names' );

			$layout = get_theme_mod( 'layout', 1 );

			foreach ( $post_types as $post_type ) {
				$controls[] = array(
					'type'     => 'radio',
					'mode'     => 'image',
					'setting'  => $post_type . '_layout',
					'label'    => $post_type . ' ' . __( 'layout', 'maera_bootstrap' ),
					'description' => null,
					'section'  => 'layout_advanced',
					'priority' => 92,
					'default'  => $layout,
					'choices'  => $this->layouts(),
				);
			}
		}

		return $controls;

	}

	function settings_nav( $controls ) {
		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'navbar_position',
			'label'    => __( 'NavBar Positioning', 'maera_bootstrap' ),
			'description' => __( 'Using this option you can set the navbar to be fixed to top, fixed to bottom or normal. When you\'re using one of the \'fixed\' options, the navbar will stay fixed on the top or bottom of the page. Default: Normal', 'maera_bootstrap' ),
			'section'  => 'nav',
			'default'  => 'normal',
			'choices'  => array(
				'normal'        => __( 'Normal', 'maera_bootstrap' ),
				'full'          => __( 'Full-Width', 'maera_bootstrap' ),
				'fixed-top'     => __( 'Fixed (top)', 'maera_bootstrap' ),
				'fixed-bottom'  => __( 'Fixed (bottom)', 'maera_bootstrap' ),
				'after-headers' => __( 'After Extra Headers', 'maera_bootstrap' ),
				'left-slide'	=> __( 'Left Slide', 'maera_bootstrap' ),
				'right-slide'	=> __( 'Right Slide', 'maera_bootstrap' )
			),
			'priority' => 23,
		);

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'grid_float_breakpoint',
			'label'    => __( 'Responsive NavBar Threshold', 'maera_bootstrap' ),
			'subtitle' => __( 'Point at which the navbar becomes uncollapsed', 'maera_bootstrap' ),
			'section'  => 'nav',
			'default'  => 'screen_sm_min',
			'choices'  => array(
				'min'           => __( 'Never', 'maera_bootstrap' ),
				'screen_xs_min' => __( 'Extra Small', 'maera_bootstrap' ),
				'screen_sm_min' => __( 'Small', 'maera_bootstrap' ),
				'screen_md_min' => __( 'Desktop', 'maera_bootstrap' ),
				'screen_lg_min' => __( 'Large Desktop', 'maera_bootstrap' ),
				'max'           => __( 'Always', 'maera_bootstrap' ),
			),
			'priority' => 24,
		);

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'navbar_search',
			'label'    => __( 'Display search form on the NavBar', 'maera_bootstrap' ),
			'section'  => 'nav',
			'default'  => 1,
			'priority' => 26,
		);

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'navbar_nav_align',
			'label'    => __( 'Menus alignment', 'maera_bootstrap' ),
			'section'  => 'nav',
			'default'  => 'left',
			'choices'  => array(
				'left'   => __( 'Left', 'maera_bootstrap' ),
				'center' => __( 'Center', 'maera_bootstrap' ),
				'right'  => __( 'Right', 'maera_bootstrap' ),
			),
			'priority' => 27,
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'navbar_height',
			'label'    => __( 'NavBar Height', 'maera_bootstrap' ),
			'subtitle' => __( 'Select the height of your navbars in pixels.', 'maera_bootstrap' ),
			'section'  => 'nav',
			'default'  => 50,
			'priority' => 33,
			'choices'  => array(
				'min'  => 38,
				'max'  => 200,
				'step' => 1,
			),
		);

		return $controls;

	}

	function settings_nav_bg( $controls ) {

		$controls[] = array(
			'type'     => 'color',
			'setting'  => 'navbar_bg',
			'label'    => __( 'NavBar Background Color', 'maera_bootstrap' ),
			'description' => __( 'Pick a background color for the NavBar. Default: #f8f8f8.', 'maera_bootstrap' ),
			'section'  => 'nav_bg',
			'default'  => '#f8f8f8',
			'priority' => 30,
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'navbar_bg_opacity',
			'label'    => __( 'NavBar Background Opacity', 'maera_bootstrap' ),
			'section'  => 'nav_bg',
			'default'  => 100,
			'priority' => 31,
			'choices'  => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		);

		return $controls;

	}

	function settings_typo_nav( $controls ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'font_menus_font_family',
			'label'    => __( 'Menus font', 'maera_bootstrap' ),
			'section'  => 'typo_nav',
			'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
			'priority' => 40,
			'choices'  => Kirki_Fonts::get_font_choices(),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_menus_weight',
			'subtitle' => __( 'Font Weight', 'maera_bootstrap' ),
			'section'  => 'typo_nav',
			'default'  => 400,
			'priority' => 43,
			'choices'  => array(
				'min'  => 100,
				'max'  => 800,
				'step' => 100,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_menus_size',
			'subtitle' => __( 'Font Size', 'maera_bootstrap' ),
			'section'  => 'typo_nav',
			'default'  => 14,
			'priority' => 44,
			'choices'  => array(
				'min'  => 10,
				'max'  => 30,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_menus_height',
			'subtitle' => __( 'Line Height', 'maera_bootstrap' ),
			'section'  => 'typo_nav',
			'default'  => 1.1,
			'priority' => 25,
			'choices'  => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		);

		return $controls;

	}

	function settings_colors( $controls ) {

		$controls[] = array(
			'type'     => 'color',
			'setting'  => 'color_brand_primary',
			'label'    => __( 'Brand Colors: Primary', 'maera_bootstrap' ),
			'description' => __( 'Select your primary branding color. Also referred to as an accent color. This will affect various areas of your site, including the color of your primary buttons, link color, the background of some elements and many more.', 'maera_bootstrap' ),
			'section'  => 'colors',
			'default'  => '#428bca',
			'priority' => 1,
			'shell_var' => '@brand-primary'
		);

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'gradients_toggle',
			'label'    => __( 'Enable Gradients', 'maera_bootstrap' ),
			'description' => __( 'Enable or disable gradients. These are applied to navbars, buttons and other elements. Please note that gradients will not be applied in the preview mode and can only be seen on the live site.', 'maera_bootstrap' ),
			'section'  => 'colors',
			'priority' => 10,
			'default'  => 0,
			'choices'  => array(
				0 => __( 'Flat', 'maera_bootstrap' ),
				1 => __( 'Gradients', 'maera_bootstrap' ),
			),
		);

		return $controls;

	}

	function settings_html_bg( $controls ) {

		$controls[] = array(
			'type'         => 'background',
			'setting'      => 'html_bg',
			'label'        => __( 'General Background', 'maera_bootstrap' ),
			'section'      => 'html_bg',
			'default'      => array(
				'color'    => '#ffffff',
				'image'    => null,
				'repeat'   => 'repeat',
				'size'     => 'inherit',
				'attach'   => 'inherit',
				'position' => 'left-top',
				'opacity'  => false,
			),
			'priority' => 2,
			'output' => 'body.bootstrap',
		);

		return $controls;

	}

	function settings_body_bg( $controls ) {

		$controls[] = array(
			'type'         => 'color',
			'setting'      => 'body_bg_color',
			'label'        => __( 'Background Color', 'maera_bootstrap' ),
			'section'      => 'body_bg',
			'default'      => '#ffffff',
			'priority'     => 31,
		);

		$controls[] = array(
			'type'         => 'slider',
			'setting'      => 'body_bg_opacity',
			'label'        => __( 'Opacity', 'maera_bootstrap' ),
			'section'      => 'body_bg',
			'default'      => 100,
			'priority'     => 33,
			'choices'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			)
		);

		return $controls;

	}

	function settings_typo_base( $controls ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'font_base_family',
			'label'    => __( 'Base font', 'maera_bootstrap' ),
			'section'  => 'typo_base',
			'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
			'priority' => 20,
			'choices'  => Kirki_Fonts::get_font_choices(),
		);

		$controls[] = array(
			'type'     => 'multicheck',
			'setting'  => 'font_subsets',
			'label'    => __( 'Google-Font subsets', 'maera_bootstrap' ),
			'description' => __( 'The subsets used from Google\'s API.', 'maera_bootstrap' ),
			'section'  => 'typo_base',
			'default'  => 'latin',
			'priority' => 22,
			'choices'  => Kirki_Fonts::get_google_font_subsets(),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_base_weight',
			'label'    => __( 'Base Font Weight', 'maera_bootstrap' ),
			'section'  => 'typo_base',
			'default'  => 400,
			'priority' => 24,
			'choices'  => array(
				'min'  => 100,
				'max'  => 900,
				'step' => 100,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_base_size',
			'label'    => __( 'Base Font Size', 'maera_bootstrap' ),
			'section'  => 'typo_base',
			'default'  => 14,
			'priority' => 25,
			'choices'  => array(
				'min'  => 7,
				'max'  => 48,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_base_height',
			'label'    => __( 'Base Line Height', 'maera_bootstrap' ),
			'section'  => 'typo_base',
			'default'  => 1.43,
			'priority' => 26,
			'choices'  => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.01,
			),
		);

		return $controls;

	}

	function settings_typo_headers( $controls ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'headers_font_family',
			'label'    => __( 'Font-Family', 'maera_bootstrap' ),
			'section'  => 'typo_headers',
			'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
			'priority' => 30,
			'choices'  => Kirki_Fonts::get_font_choices(),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_headers_weight',
			'label'    => __( 'Font Weight.', 'maera_bootstrap' ) . ' ' . __( 'Default: ', 'maera_bootstrap' ) . 400,
			'section'  => 'typo_headers',
			'default'  => 400,
			'priority' => 34,
			'choices'  => array(
				'min'  => 100,
				'max'  => 900,
				'step' => 100,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_headers_size',
			'label'    => __( 'Font Size', 'maera_bootstrap' ) . ' ' . __( 'Default: ', 'maera_bootstrap' ) . '1',
			'description' => __( 'The size defined here applies to H5. All other header elements are calculated porportionally, based on the base font size.', 'maera_bootstrap' ),
			'section'  => 'typo_headers',
			'default'  => 1,
			'priority' => 35,
			'choices'  => array(
				'min'  => 0.1,
				'max'  => 3,
				'step' => 0.01,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_headers_height',
			'label'    => __( 'Line Height', 'maera_bootstrap' ) . ' ' . __( 'Default: ', 'maera_bootstrap' ) . '1.1',
			'section'  => 'typo_headers',
			'default'  => 1.1,
			'priority' => 36,
			'choices'  => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		);

		return $controls;

	}

	function settings_blog_options( $controls ) {

		$controls[] = array(
			'type'        => 'radio',
			'mode'        => 'buttonset',
			'setting'     => 'blog_post_mode',
			'label'       => __( 'Archives Display Mode', 'maera_bootstrap' ),
			'description' => __( 'Display the excerpt or the full post on post archives.', 'maera_bootstrap' ),
			'section'     => 'blog_options',
			'priority'    => 1,
			'default'     => 'excerpt',
			'choices'     => array(
				'excerpt' => __( 'Excerpt', 'maera_bootstrap' ),
				'full'    => __( 'Full Post', 'maera_bootstrap' ),
			),
		);

		$controls[] = array(
			'type'        => 'text',
			'setting'     => 'maera_entry_meta_config',
			'label'       => __( 'Post Meta elements', 'maera_bootstrap' ),
			'subtitle'    => __( 'You can define a comma-separated list of meta elements you want on your posts, in the order that you want them. Accepted values: <code>author, sticky, date, category, tags, comments</code>', 'maera_bootstrap' ),
			'section'     => 'blog_options',
			'priority'    => 2,
			'default'     => 'date, author, comments',
		);

		$controls[] = array(
			'type'        => 'checkbox',
			'setting'     => 'breadcrumbs',
			'label'       => __( 'Show Breadcrumbs. Please note that this setting requires you to save your options and refresh the page. Breadcrumbs are not displayed on the homepage.', 'maera_bootstrap' ),
			'section'     => 'blog_options',
			'priority'    => 3,
			'default'     => 0,
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'post_excerpt_length',
			'label'    => __( 'Post excerpt length', 'maera_bootstrap' ),
			'description' => __( 'Choose how many words should be used for post excerpt. Default: 55', 'maera_bootstrap' ),
			'section'  => 'blog_options',
			'priority' => 10,
			'default'  => 55,
			'choices'  => array(
				'min'  => 10,
				'max'  => 150,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'        => 'text',
			'setting'     => 'post_excerpt_link_text',
			'label'       => __( '"more" text', 'maera_bootstrap' ),
			'subtitle'    => __( 'Text to display in case of excerpt too long. Default: Continued', 'maera_bootstrap' ),
			'section'     => 'blog_options',
			'priority'    => 12,
			'default'     => __( 'Continued', 'maera_bootstrap' ),
		);

		return $controls;

	}

	function settings_feat_archive( $controls ) {

		$controls[] = array(
			'type'        => 'checkbox',
			'setting'     => 'feat_img_archive',
			'label'       => __( 'Display Featured Images', 'maera_bootstrap' ),
			'description' => __( 'Display featured Images on post archives ( such as categories, tags, month view etc ).', 'maera_bootstrap' ),
			'section'     => 'feat_archive',
			'priority'    => 50,
			'default'     => 0,
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'feat_img_archive_width',
			'label'    => __( 'Featured Image Width', 'maera_bootstrap' ),
			'subtitle' => __( 'Set to -1 for max width and 0 for original width. Default: -1', 'maera_bootstrap' ),
			'section'  => 'feat_archive',
			'priority' => 52,
			'default'  => -1,
			'choices'  => array(
				'min'  => -1,
				'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
				'step' => '1'
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'feat_img_archive_height',
			'label'    => __( 'Featured Image Height', 'maera_bootstrap' ),
			'subtitle' => __( 'Set to 0 to resize the image using the original image proportions. Default: 0', 'maera_bootstrap' ),
			'section'  => 'feat_archive',
			'priority' => 53,
			'default'  => 0,
			'choices'  => array(
				'min'  => 0,
				'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
				'step' => '1'
			),
		);

		$post_types = get_post_types( array( 'public' => true ), 'names' );
		$controls[] = array(
			'type'        => 'multicheck',
			'mode'        => 'checkbox',
			'setting'     => 'feat_img_per_post_type',
			'label'       => __( 'Disable featured images per post type.', 'maera_bootstrap' ),
			'subtitle'    => __( 'CAUTION: This setting will also disable displaying the featured images on single posts as well.', 'maera_bootstrap' ),
			'section'     => 'feat_archive',
			'priority'    => 65,
			'default'     => '',
			'choices'     => $post_types,
		);

		return $controls;

	}

	function settings_feat_single( $controls ) {

		$controls[] = array(
			'type'        => 'checkbox',
			'setting'     => 'feat_img_post',
			'label'       => __( 'Display Featured Images', 'maera_bootstrap' ),
			'subtitle'    => __( 'Display featured Images on simgle posts.', 'maera_bootstrap' ),
			'section'     => 'feat_single',
			'priority'    => 60,
			'default'     => 0,
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'feat_img_post_width',
			'label'    => __( 'Featured Image Width', 'maera_bootstrap' ),
			'subtitle' => __( 'Set to -1 for max width and 0 for original width. Default: -1', 'maera_bootstrap' ),
			'section'  => 'feat_single',
			'priority' => 62,
			'default'  => -1,
			'choices'  => array(
				'min'  => -1,
				'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
				'step' => '1'
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'feat_img_post_height',
			'label'    => __( 'Featured Image Height', 'maera_bootstrap' ),
			'subtitle' => __( 'Set to 0 to use the original image proportions. Default: 0', 'maera_bootstrap' ),
			'section'  => 'feat_single',
			'priority' => 63,
			'default'  => 0,
			'choices'  => array(
				'min'  => 0,
				'max'  => get_theme_mod( 'screen_large_desktop', 1200 ),
				'step' => '1'
			),
		);

		return $controls;

	}

	function settings_jumbo_bg( $controls ) {

		$controls[] = array(
			'type'         => 'background',
			'setting'      => 'jumbo_bg',
			'label'        => __( 'Jumbotron Background', 'maera_bootstrap' ),
			'section'      => 'jumbo_bg',
			'default'      => array(
				'color'    => '#eeeeee',
				'image'    => null,
				'repeat'   => 'repeat',
				'size'     => 'inherit',
				'attach'   => 'inherit',
				'position' => 'left-top',
				'opacity'  => 100,
			),
			'priority' => 1,
			'output' => '.jumbotron',
		);

		return $controls;

	}

	function settings_structure_jumbo( $controls ) {

		$controls[] = array(
			'type'     => 'checkbox',
			'setting'  => 'jumbotron_nocontainer',
			'label'    => __( 'Full-Width', 'maera_bootstrap' ),
			'description' => __( 'When selected, the Jumbotron is no longer restricted by the width of your page, taking over the full width of your screen. This option is useful when you have assigned a slider widget on the Jumbotron area and you want its width to be the maximum width of the screen. Default: OFF.', 'maera_bootstrap' ),
			'section'  => 'structure_jumbo',
			'default'  => 0,
			'priority' => 11,
		);

		return $controls;

	}

	function settings_typo_jumbo( $controls ) {

		$controls[] = array(
			'type'     => 'select',
			'setting'  => 'font_jumbotron_font_family',
			'label'    => __( 'Jumbotron font', 'maera_bootstrap' ),
			'section'  => 'typo_jumbo',
			'default'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
			'priority' => 20,
			'choices'  => Kirki_Fonts::get_font_choices(),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_jumbotron_weight',
			'subtitle' => __( 'Font Weight', 'maera_bootstrap' ),
			'section'  => 'typo_jumbo',
			'default'  => 400,
			'priority' => 23,
			'choices'  => array(
				'min'  => 100,
				'max'  => 800,
				'step' => 100,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_jumbotron_size',
			'subtitle' => __( 'Font Size', 'maera_bootstrap' ),
			'section'  => 'typo_jumbo',
			'default'  => 20,
			'priority' => 24,
			'choices'  => array(
				'min'  => 7,
				'max'  => 48,
				'step' => 1,
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'font_jumbotron_height',
			'subtitle' => __( 'Line Height', 'maera_bootstrap' ),
			'section'  => 'typo_jumbo',
			'default'  => 22,
			'priority' => 25,
			'choices'  => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 0.1,
			),
		);

		return $controls;

	}

	function settings_header_bg( $controls ) {

		$controls[] = array(
			'type'         => 'background',
			'setting'      => 'header_bg',
			'label'        => __( 'Header Background', 'maera_bootstrap' ),
			'section'      => 'header_bg',
			'default'      => array(
				'color'    => '#ffffff',
				'image'    => null,
				'repeat'   => 'repeat',
				'size'     => 'inherit',
				'attach'   => 'inherit',
				'position' => 'left-top',
				'opacity'  => 100,
			),
			'priority' => 10,
			'output' => 'header.page-header',
		);

		return $controls;

	}

	function settings_social( $controls ) {

		$controls[] = array(
			'type'     => 'radio',
			'mode'     => 'buttonset',
			'setting'  => 'navbar_social',
			'label'    => __( 'Display social links in the NavBar.', 'maera_bootstrap' ),
			'subtitle' => __( 'Social network links can be set-up in the "Social" section.', 'maera_bootstrap' ),
			'section'  => 'social',
			'default'  => 'off',
			'choices'  => array(
				'off'      => __( 'Off', 'maera_bootstrap' ),
				'inline'   => __( 'Inline', 'maera_bootstrap' ),
				'dropdown' => __( 'Dropdown', 'maera_bootstrap' ),
			),
			'priority' => 1,
		);

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

		$i = 0;
		foreach ( $social_links as $social_link => $label ) {

			$controls[] = array(
				'type'     => 'text',
				'setting'  => $social_link . '_link',
				'label'    => $label . ' ' . __( 'link', 'maera_bootstrap' ),
				'section'  => 'social',
				'default'  => '',
				'priority' => 10 + $i,
			);

			$i++;

		}

		return $controls;

	}

	function settings_footer_bg( $controls ) {

		$controls[] = array(
			'type'         => 'background',
			'setting'      => 'footer_bg',
			'label'        => __( 'Footer Background', 'maera_bootstrap' ),
			'section'      => 'footer_bg',
			'default'      => array(
				'color'    => '#ffffff',
				'image'    => null,
				'repeat'   => 'repeat',
				'size'     => 'inherit',
				'attach'   => 'inherit',
				'position' => 'left-top',
				'opacity'  => 100,
			),
			'priority' => 10,
			'output' => 'footer.page-footer',
		);

		return $controls;

	}

	function settings_branding( $controls ) {

		$controls[] = array(
			'type'     => 'textarea',
			'label'    => __( 'Footer Text', 'maera_bootstrap' ),
			'setting'  => 'footer_text',
			'default'  => '&copy; [year] [sitename]',
			'section'  => 'branding',
			'priority' => 12,
			'subtitle' => __( 'The text that will be displayed in your footer. You can use [year] and [sitename] and they will be replaced appropriately. Default: &copy; [year] [sitename]', 'maera_bootstrap' ),
		);

		return $controls;

	}

	function settings_general( $controls ) {

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'border_radius',
			'label'    => __( 'Border-Radius', 'maera_bootstrap' ),
			'description' => __( 'You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', 'maera_bootstrap' ),
			'section'  => 'general',
			'priority' => 2,
			'default'  => 4,
			'choices'  => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1
			),
		);

		$controls[] = array(
			'type'     => 'slider',
			'setting'  => 'padding_base',
			'label'    => __( 'Padding Base', 'maera_bootstrap' ),
			'description' => __( 'You can adjust the padding base. This affects buttons size and lots of other cool stuff too! Default: 6', 'maera_bootstrap' ),
			'section'  => 'general',
			'priority' => 3,
			'default'  => 6,
			'choices'  => array(
				'min'  => 0,
				'max'  => 22,
				'step' => 1
			),
		);

		$widgets_class = new Maera_Bootstrap_Widgets();
		$extra_widget_areas = $widgets_class->extra_widget_areas_array();

		$i = 1;

		foreach ( $extra_widget_areas as $area => $settings ) {

			$controls[] = array(
				'type'     => 'checkbox',
				'setting'  => $area . '_toggle',
				'label'    => $area,
				'section'  => 'custom_widget_areas',
				'default'  => $settings['default'],
				'priority' => $i,
			);

			$i++;
		}

		return $controls;

	}

}

$customizer = new Maera_Bootstrap_Customizer();
