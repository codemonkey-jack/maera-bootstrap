<?php

class Maera_BS_Timber {

	function __construct() {
		add_filter( 'timber_context', array( $this, 'timber_extras' ), 20 );
	}

	/**
	 * Timber extras.
	 */
	function timber_extras( $data ) {

		// get secondary sidebar
		$sidebar_secondary = Timber::get_widgets( 'sidebar_secondary' );
		$data['sidebar']['secondary'] = apply_filters( 'maera/sidebar/secondary', $sidebar_secondary );

		$extra_widget_areas = Maera_BS_Widgets::extra_widget_areas_array();

		foreach ( $extra_widget_areas as $extra_widget_area => $options ) {

			if ( 0 != get_theme_mod( $extra_widget_area . '_toggle', 0 ) ) {
				$data['sidebar'][$extra_widget_area] = Timber::get_widgets( $extra_widget_area );
			}

		}

		$comment_form_args = array(
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'maera_bootstrap' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'id_submit'     => 'comment-submit',
		);

		$data['content_width'] = Maera_BS_Structure::content_width_px();
		$data['post_meta'] = Maera_BS_Meta::meta_elements();

		$data['comment_form'] = TimberHelper::get_comment_form( null, $comment_form_args );

		return $data;
	}

}
