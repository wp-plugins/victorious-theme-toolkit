<?php

/* ---------------------BUTTON-------------------------- */
add_shortcode( 'button', 'victor_shortcode_button' );

function victor_shortcode_button( $atts, $content ) {
	extract( shortcode_atts( array(
		'size' => 'medium',
					), $atts ) );
	switch ( $atts['size'] ) {
		case 'small':
			$size = 'sm-btn';
			break;
		case 'medium':
			$size = 'md-btn';
			break;
		case 'large':
			$size = 'lg-btn';
			break;
		case 'xlarge':
			$size = 'xl-btn';
			break;
		case 'xxlarge':
			$size = 'xxl-btn';
			break;
		default:
			$size = 'md-btn';
			break;
	}
	$string = '<button class="kopa-btn ' . $size . '">' . $content . '</button>';
	return apply_filters( 'victor_shortcode_button', $string, $atts, $content );
}

add_shortcode( 'button_border', 'victor_shortcode_button_border' );

function victor_shortcode_button_border( $atts, $content ) {
	extract( shortcode_atts( array(
		'type' => '1',
		'size' => 'medium',
					), $atts ) );
	$type = isset( $atts['type'] ) ? $atts['type'] : '1';
	$string = '<button class="kopa-btn bd-btn bd' . $type . '-btn">' . $content . '</button>';
	return apply_filters( 'victor_shortcode_button_border', $string, $atts, $content );
}

add_shortcode( 'button_color', 'victor_shortcode_button_color' );

function victor_shortcode_button_color( $atts, $content ) {
	extract( shortcode_atts( array(
		'color' => 'yellow',
					), $atts ) );
	$color = isset( $atts['color'] ) ? $atts['color'] : 'yellow';
	$string = '<button class="kopa-btn ' . $color . '-btn">' . $content . '</button>';
	return apply_filters( 'victor_shortcode_button_color', $string, $atts, $content );
}
