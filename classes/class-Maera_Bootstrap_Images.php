<?php

class Maera_Bootstrap_Images {

	function __construct() {

		if ( is_singular() ) {
			add_filter( 'maera/image/width', array( $this, 'featured_single_width' ) );
			add_filter( 'maera/image/height', array( $this, 'featured_single_height' ) );
		} else {
			add_filter( 'maera/image/width', array( $this, 'featured_archive_width' ) );
			add_filter( 'maera/image/height', array( $this, 'featured_archive_height' ) );
		}

	}

	function featured_single_width() {
		global $content_width;

		$theme_mod = get_theme_mod( 'feat_img_post_width', 1200 );
		$width = ( '-1' == $theme_mod ) ? $content_width : $theme_mod;

		return $width;
	}

	function featured_single_height() {
		return get_theme_mod( 'feat_img_post_height', 0 );
	}

	function featured_archive_width() {
		global $content_width;

		$theme_mod = get_theme_mod( 'feat_img_archive_width', 1200 );
		$width = ( '-1' == $theme_mod ) ? $content_width : $theme_mod;

		return $width;
	}

	function featured_archive_height() {
		return get_theme_mod( 'feat_img_archive_height', 0 );
	}

}
