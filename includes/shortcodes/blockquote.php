<?php

/* ---------------------BLOCK QUOTE-------------------------- */
add_shortcode( 'blockquote', 'victor_shortcode_block_quote' );

function victor_shortcode_block_quote( $atts, $content ) {
	extract( shortcode_atts( array(
		'style' => '1',
		'author_name' => ''
					), $atts ) );
	$style = isset( $atts['style'] ) ? $atts['style'] : '1';
	$author = isset( $atts['author_name'] ) ? '<span class="sign">' . $atts['author_name'] . '</span>' : '';
	$string = '<blockquote class = "s' . $style . '">' . do_shortcode( trim( $content ) ) . $author . '</blockquote>';
	return apply_filters( 'victor_shortcode_block_quote', $string, $atts, $content );
}
