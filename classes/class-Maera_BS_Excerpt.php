<?php

class Maera_BS_Excerpt {

	function __construct() {

		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 10, 2 );

	}

	/**
	 * The "more" text
	 */
	function excerpt_more( $more, $post_id = 0 ) {

		$continue_text = get_theme_mod( 'post_excerpt_link_text', 'Continued' );
		return ' &hellip; <a href="' . get_permalink( $post_id ) . '">' . $continue_text . '</a>';

	}

}
