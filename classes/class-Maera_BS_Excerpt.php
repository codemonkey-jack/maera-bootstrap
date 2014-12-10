<?php

class Maera_BS_Excerpt {

	function __construct() {
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 10, 2 );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
	}

	/**
	 * The "more" text
	 */
	function excerpt_more( $more, $post_id = 0 ) {
		$continue_text = get_theme_mod( 'post_excerpt_link_text', 'Continued' );
		return ' &hellip; <a href="' . get_permalink( $post_id ) . '">' . $continue_text . '</a>';
	}

	/**
	* Excerpt length
	*/
	function excerpt_length() {
		return get_theme_mod( 'post_excerpt_length', 55 );
	}

}
