<?php
add_action( 'init', 'victor_shortcode_add_button' );

function victor_shortcode_add_button() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_buttons', 'victor_register_button' );
		add_filter( 'mce_external_plugins', 'victor_add_plugin' );
	}
}

function victor_register_button( $buttons ) {
	array_push( $buttons, 'row' );
	return $buttons;
}

function victor_add_plugin( $buttons ) {
	$buttons['row'] = VICTOR_DIR . 'assets/js/grid.js';
	return $buttons;
}

add_action( 'admin_enqueue_scripts', 'victor_plugin_scripts', 10, 1 );

function victor_plugin_scripts( $hook ) {
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
		wp_enqueue_style( 'victor-shortcode-style', VICTOR_DIR . 'assets/css/shortcode.css', array(), null );
	}
}

function victor_get_shortcode( $content, $enable_multi = false, $shortcodes = array() ) {
	$media = array();
	$regex_matches = '';
	$regex_pattern = get_shortcode_regex();
	preg_match_all( '/' . $regex_pattern . '/s', $content, $regex_matches );

	foreach ( $regex_matches[0] as $shortcode ) {
		$regex_matches_new = '';
		preg_match( '/' . $regex_pattern . '/s', $shortcode, $regex_matches_new );

		if ( in_array( $regex_matches_new[2], $shortcodes ) ) :
			$media[] = array(
				'shortcode' => $regex_matches_new[0],
				'type' => $regex_matches_new[2],
				'content' => $regex_matches_new[5],
				'atts' => shortcode_parse_atts( $regex_matches_new[3] )
			);

			if ( $enable_multi == FALSE ) {
				break;
			}
		endif;
	}

	return $media;
}
