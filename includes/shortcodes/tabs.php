<?php

/* ---------------------TABS-------------------------- */
add_shortcode( 'tabs', 'victor_shortcode_tabs' );
add_shortcode( 'tab', '__return_false' );

function victor_shortcode_tabs( $atts, $content ) {
	$rand = rand();
	extract( shortcode_atts( array(
		'style' => '1'
					), $atts ) );
	$style = isset( $atts['style'] ) ? $atts['style'] : '1';
	$wrapper = '<div class="e-wrapper">';
	$endwrapper = '</div>';

	$matches = victor_get_shortcode( $content, true, array( 'tab' ) );
	$string = $wrapper . '<ul class="nav nav-tabs kopa-tabs s' . $style . '">';
	$string.= '<li class="active"><a href="#tab' . $style . '-1-' . $rand . '" data-toggle="tab">' . (isset( $matches[0]['atts']['title'] ) ? $matches[0]['atts']['title'] : '') . '</a></li>';
	for ( $i = 1; $i < count( $matches ); $i++ ) {
		$string.= '<li class=""><a href="#tab' . $style . '-' . ($i + 1) . '-' . $rand . '" data-toggle="tab">' . (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : '') . '</a></li>';
	}
	$string.= '</ul><div class="tab-content">';
	$string.= '<div class="tab-pane active" id="tab' . $style . '-1-' . $rand . '">                        
                                    <p>' . do_shortcode( trim( (isset( $matches[0]['content'] ) ? $matches[0]['content'] : '' ) ) ) . '</p>
                                </div>';
	for ( $i = 1; $i < count( $matches ); $i++ ) {
		$string.= '<div class="tab-pane" id="tab' . $style . '-' . ($i + 1) . '-' . $rand . '">                        
                                    <p>' . do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ) . '</p>
                                </div>';
	}
	$string.= '</div>' . $endwrapper;
	return apply_filters( 'victor_shortcode_tabs', $string, $atts, $content );
}
