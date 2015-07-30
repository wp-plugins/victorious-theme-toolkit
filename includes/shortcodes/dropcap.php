<?php

/* --------------------- DROPCAP -------------------------- */
add_shortcode( 'dropcap', 'victor_shortcode_dropcap' );

function victor_shortcode_dropcap( $atts, $content ) {
	extract( shortcode_atts( array(
		'type' => '1'
					), $atts ) );
	$type = isset( $atts['type'] ) ? $atts['type'] : '1';
	$split = str_split( $content );
	$first = $split[0];
	$span = '<span class="kopa-dropcap s' . $type . '">' . strtoupper( $first ) . '</span>';
	$c = substr( $content, 1 );
	if ( $first === '[' || $first === '<' ) {
		$span = NULL;
		$c = $content;
	}
	$string = '<p>' . $span . do_shortcode( trim( $c ) ) . '</p>';
	return apply_filters( 'victor_shortcode_dropcap', $string, $atts, $content );
}
