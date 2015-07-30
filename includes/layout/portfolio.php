<?php

add_filter( 'kopa_layout_manager_settings', 'victor_toolkit_plus_layout_manager_settings' );

function victor_toolkit_plus_layout_manager_settings( $options ) {
	$positions = array(
		'positions_5' => __( 'Widget Area 5', 'victor-toolkit' ),
		'positions_6' => __( 'Widget Area 6', 'victor-toolkit' ),
		'positions_7' => __( 'Widget Area 7', 'victor-toolkit' ),
		'positions_8' => __( 'Widget Area 8', 'victor-toolkit' ),
		'positions_9' => __( 'Widget Area 9', 'victor-toolkit' ),
	);
	$portfolio_1 = array(
		'title' => __( 'Portfolio', 'victor-toolkit' ),
		'preview' => get_template_directory_uri() . '/images/layouts/victor-portfolio-1.png',
		'positions' => array(
			'positions_5', 'positions_6', 'positions_7', 'positions_8', 'positions_9'
		)
	);
	$portfolio_1_default = array(
		'positions_9' => 'portfolio_1',
		'positions_5' => 'left_bottom',
		'positions_6' => 'left_center_bottom',
		'positions_7' => 'right_center_bottom',
		'positions_8' => 'right_bottom',
	);
	// Portfolio layout
	$options[] = array(
		'title' => __( 'Portfolio', 'victor-toolkit' ),
		'type' => 'title',
		'id' => 'portfolio-title',
	);
	$options[] = array(
		'title' => __( 'Portfolio layout', 'victor-toolkit' ),
		'type' => 'layout_manager',
		'id' => 'portfolio-layout',
		'positions' => $positions,
		'layouts' => array(
			'portfolio-1' => $portfolio_1
		),
		'default' => array(
			'layout_id' => 'portfolio-1',
			'sidebars' => array(
				'portfolio-1' => $portfolio_1_default
			),
		),
	);

	return $options;
}

add_filter( 'kopa_custom_layout_arguments', 'victor_toolkit_plus_edit_custom_layout_feature' );

function victor_toolkit_plus_edit_custom_layout_feature( $args ) {
	$args[] = array(
		'screen' => 'portfolio',
		'taxonomy' => false,
		'layout' => 'portfolio-layout',
	);
	$args[] = array(
		'screen' => 'portfolio_cat',
		'taxonomy' => true,
		'layout' => 'portfolio-layout',
	);

	$args[] = array(
		'screen' => 'portfolio_tag',
		'taxonomy' => true,
		'layout' => 'portfolio-layout',
	);
	return $args;
}

/**
 * Add custom layout feature for custom post types and custom taxonomies
 */
add_filter( 'kopa_custom_template_setting_id', 'victor_toolkit_plus_extra_template' );

function victor_toolkit_plus_extra_template( $setting_id ) {
	if ( is_singular( 'portfolio' ) ) {
		return 'portfolio-layout';
	} elseif ( is_post_type_archive( 'portfolio' ) ||
			is_tax( 'portfolio_cat' ) ||
			is_tax( 'portfolio_tag' ) ) {
		return 'portfolio-layout';
	}

	return $setting_id;
}
