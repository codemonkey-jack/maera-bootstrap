<?php

class Maera_BS_Meta {

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

		$categories_list = has_category( '', $post_id ) ? get_the_category_list( __( ', ', 'maera_bs' ), '', $post_id ) : false;
		$tag_list        = has_tag( '', $post_id ) ? get_the_tag_list( '', __( ', ', 'maera_bs' ) ) : false;

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

}
