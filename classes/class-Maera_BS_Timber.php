<?php

class Maera_BS_Timber {

	function __construct() {
		add_filter( 'timber_context', array( $this, 'timber_extras' ), 20 );
	}

	/**
	 * Timber extras.
	 */
	function timber_extras( $data ) {

		// Get the layout we're using (sidebar arrangement).
		$layout = apply_filters( 'maera/layout/modifier', get_theme_mod( 'layout', 1 ) );

		// get secondary sidebar
		$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );
		$data['sidebar']['secondary'] = apply_filters( 'maera/sidebar/secondary', $sidebar_secondary );

		if ( 0 == $layout ) {

			$data['sidebar']['primary']   = null;
			$data['sidebar']['secondary'] = null;

			// Add a filter for the layout.
			add_filter( 'maera/layout/modifier', 'maera_return_0' );

		} elseif ( $layout < 3 ) {
			$data['sidebar']['secondary'] = null;
		}

		$comment_form_args = array(
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'maera_bootstrap' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'id_submit'     => 'comment-submit',
		);

		$data['content_width'] = Maera_Bootstrap_Structure::content_width_px();
		$data['post_meta'] = Maera_BS_Meta::meta_elements();

		$data['teaser_mode'] = get_theme_mod( 'blog_post_mode', 'excerpt' );

		$data['comment_form'] = TimberHelper::get_comment_form( null, $comment_form_args );

		return $data;
	}

}
