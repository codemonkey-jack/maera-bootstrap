<?php

class Maera_BS_Scripts {

	function __construct() {
		add_action( 'wp_footer', array( $this, 'custom_js' ) );		
	}

	/**
	* Implement the custom js field output and place it to the footer.
	*/
	function custom_js() {

		$js = get_theme_mod( 'js', '' );
		if ( ! empty( $js ) ) {
			echo '<script>' . $js . '</script>';
		}

	}

}
