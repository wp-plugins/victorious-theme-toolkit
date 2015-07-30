<?php

/* --------------------- ROWS -------------------------- */
add_shortcode( 'row', 'victor_shortcode_row' );
add_shortcode( 'col', '__return_false' );

function victor_shortcode_row( $atts, $content = null ) {
	extract( shortcode_atts( array(), $atts ) );

	$media = array();

	$regex_matches = '';
	$regex_pattern = get_shortcode_regex();
	preg_match_all( '/' . $regex_pattern . '/s', $content, $regex_matches );

	foreach ( $regex_matches[0] as $shortcode ) {
		$regex_matches_new = '';
		preg_match( '/' . $regex_pattern . '/s', $shortcode, $regex_matches_new );

		if ( in_array( $regex_matches_new[2], array( 'col' ) ) ) :
			$media[] = array(
				'shortcode' => $regex_matches_new[0],
				'type' => $regex_matches_new[2],
				'content' => $regex_matches_new[5],
				'atts' => shortcode_parse_atts( $regex_matches_new[3] )
			);

		endif;
	}

	$panels = array();

	if ( $media ) {
		foreach ( $media as $item ) {
			$panels[] = sprintf( '<div class="col-md-%s col-sm-%s col-xs-12 col-20"><div class="e-wrapper"><p>%s</p></div></div>', $item['atts']['col'], $item['atts']['col'], do_shortcode( $item['content'] ) );
		}
	}

	$output = '<div class="row">';
	$output.= implode( '', $panels );
	$output.= '</div>';
	return apply_filters( 'victor_shortcode_row', $output, $atts, $content );
}
