<?php

if ( !class_exists( 'Kopa_Page_Builder' ) ) {
	return;
}
add_action( 'init', 'victor_page_builder_init' );
add_filter( 'kopa_page_builder_get_layouts', 'victor_page_builder_set_layouts' );
add_filter( 'kopa_page_builder_get_areas', 'victor_page_builder_set_areas' );
add_filter( 'kopa_page_builder_get_section_fields', 'victor_page_builder_set_section_fields' );
add_filter( 'kopa_page_builder_get_customize_fields', 'victor_page_builder_set_customize_fields' );
add_filter( 'body_class', 'victor_page_builder_set_body_class' );
add_action( 'wp_enqueue_scripts', 'victor_page_builder_enqueue_script', 20 );

function victor_page_builder_init() {
	add_filter( 'victor_is_override_default_template', 'victor_is_override_default_template' );
}

function victor_is_override_default_template() {
	if ( is_page() ) {
		global $post;
		$current_layout = Kopa_Page_Builder::get_current_layout( $post->ID );
		if ( $current_layout !== 'disable' && $current_layout !== '' ) {
			return true;
		}
	}
}

function victor_page_builder_set_body_class( $classes ) {
	if ( is_page() ) {
		if ( class_exists( 'Kopa_Page_Builder' ) ) {
			global $post;
			if ( $current_layout = Kopa_Page_Builder::get_current_layout( $post->ID ) ) {
				switch ( $current_layout ) {
					default:
						break;
				}
			}
		}
	}

	return $classes;
}

function victor_page_builder_set_layouts( $layouts ) {
	$layouts['disable'] = array(
		'title' => __( '---Disable---', 'victor-toolkit' )
	);
	$layouts['home-1'] = array(
		'title' => __( 'Home 1', 'victor-toolkit' ),
		'preview' => get_template_directory_uri() . '/images/layouts/victor-home-1.png',
		'customize' => array(
			'custom' => array(
				'title' => __( 'Custom', 'victor-toolkit' ),
				'params' => array(
					'css' => array(
						'type' => 'textarea',
						'title' => __( 'CSS Code', 'victor-toolkit' ),
						'default' => '',
						'rows' => 10,
						'class' => 'kpb-ui-textarea-guide-line'
					)
				)
			),
			'js' => array(
				'title' => __( 'Javascript', 'victor-toolkit' ),
				'params' => array(
					'is_load_google_map_api' => array(
						'type' => 'checkbox',
						'title' => __( 'Load Google-Maps API', 'victor-toolkit' ),
						'default' => 0
					),
				)
			),
		),
		'section' => array(
			'row-1' => array(
				'title' => __( 'Row 1', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-1',
				)
			),
			'row-2' => array(
				'title' => __( 'Row 2', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-2'
				)
			),
			'row-3' => array(
				'title' => __( 'Row 3', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-3'
				)
			),
			'row-4' => array(
				'title' => __( 'Row 4', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-4'
				)
			),
			'row-5' => array(
				'title' => __( 'Row 7', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-5'
				)
			)
		)
	);
	$layouts['about'] = array(
		'title' => __( 'About', 'victor-toolkit' ),
		'preview' => get_template_directory_uri() . '/images/layouts/victor-about.png',
		'customize' => array(
			'custom' => array(
				'title' => __( 'Custom', 'victor-toolkit' ),
				'params' => array(
					'css' => array(
						'type' => 'textarea',
						'title' => __( 'CSS Code', 'victor-toolkit' ),
						'default' => '',
						'rows' => 10,
						'class' => 'kpb-ui-textarea-guide-line'
					)
				)
			),
			'js' => array(
				'title' => __( 'Javascript', 'victor-toolkit' ),
				'params' => array(
					'is_load_google_map_api' => array(
						'type' => 'checkbox',
						'title' => __( 'Load Google-Maps API', 'victor-toolkit' ),
						'default' => 0
					),
				)
			),
		),
		'section' => array(
			'row-1' => array(
				'title' => __( 'Row 1', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-1',
				)
			),
			'row-2' => array(
				'title' => __( 'Row 2', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-2'
				)
			),
			'row-3' => array(
				'title' => __( 'Row 3', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-3'
				)
			),
			'row-4' => array(
				'title' => __( 'Row 4', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 12 ),
				'customize' => array(),
				'area' => array(
					'area-4'
				)
			)
		)
	);
	$layouts['contact-2'] = array(
		'title' => __( 'Contact', 'victor-toolkit' ),
		'preview' => get_template_directory_uri() . '/images/layouts/victor-contact-2.png',
		'customize' => array(
			'custom' => array(
				'title' => __( 'Custom', 'victor-toolkit' ),
				'params' => array(
					'css' => array(
						'type' => 'textarea',
						'title' => __( 'CSS Code', 'victor-toolkit' ),
						'default' => '',
						'rows' => 10,
						'class' => 'kpb-ui-textarea-guide-line'
					)
				)
			),
			'js' => array(
				'title' => __( 'Javascript', 'victor-toolkit' ),
				'params' => array(
					'is_load_google_map_api' => array(
						'type' => 'checkbox',
						'title' => __( 'Load Google-Maps API', 'victor-toolkit' ),
						'default' => 0
					),
				)
			),
		),
		'section' => array(
			'row-1' => array(
				'title' => __( 'Row 2', 'victor-toolkit' ),
				'description' => '',
				'grid' => array( 6, 6 ),
				'customize' => array(),
				'area' => array(
					'area-1-1',
					'area-1-2'
				)
			)
		)
	);
	return $layouts;
}

function victor_page_builder_set_areas( $area ) {
	$area['area-1'] = __( 'Area 1', 'victor-toolkit' );
	$area['area-1-1'] = __( 'Area 1.1', 'victor-toolkit' );
	$area['area-1-2'] = __( 'Area 1.2', 'victor-toolkit' );
	$area['area-1-3'] = __( 'Area 1.3', 'victor-toolkit' );
	$area['area-2'] = __( 'Area 2', 'victor-toolkit' );
	$area['area-2-1'] = __( 'Area 2', 'victor-toolkit' );
	$area['area-2-2'] = __( 'Area 2', 'victor-toolkit' );
	$area['area-3'] = __( 'Area 3', 'victor-toolkit' );
	$area['area-3-1'] = __( 'Area 3.1', 'victor-toolkit' );
	$area['area-3-2'] = __( 'Area 3.2', 'victor-toolkit' );
	$area['area-4'] = __( 'Area 4', 'victor-toolkit' );
	$area['area-5'] = __( 'Area 5', 'victor-toolkit' );
	$area['area-6'] = __( 'Area 6', 'victor-toolkit' );
	$area['area-7'] = __( 'Area 7', 'victor-toolkit' );
	$area['area-8'] = __( 'Area 8', 'victor-toolkit' );
	$area['area-9-1'] = __( 'Area 9.1', 'victor-toolkit' );
	$area['area-9-2'] = __( 'Area 9.2', 'victor-toolkit' );

	return $area;
}

function victor_dynamic_area( $post_id, $data ) {

	if ( $data ) {

		foreach ( $data as $widget_id => $widget ) {
			if ( $widget_data = get_post_meta( $post_id, $widget_id, true ) ) {
				$class_name = $widget['class_name'];

				if ( class_exists( $class_name ) ) {

					$instance = $widget_data['widget'];

					$obj = new $class_name;

					$obj->id = $widget_id;

					$widget_wrap = array(
						'before_widget' => sprintf( '<div id="%1$s" class="widget %2$s clearfix">', $obj->id, $obj->widget_options['classname'] ),
						'after_widget' => '</div>',
						'before_title' => '<h2 class="widget-title">',
						'after_title' => '</h2>'
					);

					if ( isset( $widget_data['customize'] ) ) {
						$customize_data = $widget_data['customize'];
						switch ( $customize_data['title']['style'] ) {
							case 's1':
								$widget_wrap['before_title'] = '<h5 class="e-title">';
								$widget_wrap['after_title'] = '</h5>';
								break;
							case 's2':
								$widget_wrap['before_title'] = '<h3 class="widget-title">';
								$widget_wrap['after_title'] = '</h3>';
								break;
							case 's4':
								$widget_wrap['before_title'] = '<h2 class="widget-title s1">';
								break;
							case 's5':
								$widget_wrap['before_title'] = '<h2 class="widget-title s2">';
								break;
							case 's6':
								$widget_wrap['before_title'] = '<h2 class="widget-title s3">';
								break;
							case 's7':
								$widget_wrap['before_title'] = '<h2 class="widget-title s4">';
								break;
							case 's8':
								$widget_wrap['before_title'] = '<h2 class="widget-title s5">';
								break;
							case 's9':
								$widget_wrap['before_title'] = '<h2 class="widget-title s7">';
								break;
							case 's10':
								$widget_wrap['before_title'] = '<h2 class="widget-title s8">';
								break;
							default:
								$widget_wrap['before_title'] = '<h2 class="widget-title">';
								break;
						}
					}
					$obj->widget( $widget_wrap, $instance );
				}
			}
		}
	}
}

function victor_page_builder_set_customize_fields( $fields ) {

	$fields['title']['title'] = __( 'Title Effect', 'victor-toolkit' );
	$fields['title']['params'] = array(
		'style' => array(
			'title' => __( 'Style', 'victor-toolkit' ),
			'type' => 'select',
			'default' => 's3',
			'options' => array(
				's1' => __( 'H5 tag normal', 'victor-toolkit' ),
				's2' => __( 'H3 tag normal', 'victor-toolkit' ),
				's3' => __( 'H2 tag normal', 'victor-toolkit' ),
				's4' => __( 'H2 tag style 1', 'victor-toolkit' ),
				's5' => __( 'H2 tag style 2', 'victor-toolkit' ),
				's6' => __( 'H2 tag style 3', 'victor-toolkit' ),
				's7' => __( 'H2 tag style 4', 'victor-toolkit' ),
				's8' => __( 'H2 tag style 5', 'victor-toolkit' ),
				's9' => __( 'H2 tag style 6', 'victor-toolkit' ),
				's10' => __( 'H2 tag style 7', 'victor-toolkit' ),
			)
		)
	);
	$fields['custom']['title'] = __( 'Custom CSS', 'gusty' );
	$fields['custom']['params'] = array(
		'css' => array(
			'type' => 'textarea',
			'title' => __( 'CSS code', 'gusty' ),
			'default' => '',
			'rows' => 10,
			'class' => 'kpb-ui-textarea-guide-line',
			'help' => __( 'Example: <code>ID a {color: red; }</code> <br/> ID: The ID of this widget.', 'gusty' ),
		),
	);
	return $fields;
}

function victor_page_builder_set_section_fields( $fields ) {

	$fields['background']['title'] = __( 'Background', 'victor-toolkit' );
	$fields['background']['params'] = array(
		'status' => array(
			'type' => 'radio',
			'title' => __( 'Use Default Background', 'victor-toolkit' ),
			'default' => 'true',
			'options' => array(
				'true' => __( 'Yes', 'victor-toolkit' ),
				'false' => __( 'No', 'victor-toolkit' ),
			)
		),
		'background-image' => array(
			'type' => 'image',
			'title' => __( 'Background image', 'victor-toolkit' ),
			'default' => '',
		)
	);
	return $fields;
}

function victor_page_builder_enqueue_script() {
	if ( is_page() ) {
		global $post;
		$current_layout = Kopa_Page_Builder::get_current_layout( $post->ID );

		if ( !empty( $current_layout ) && $current_layout != 'disable' ) {

			$page_data = Kopa_Page_Builder::get_current_layout_data( $post->ID );
			$layouts = apply_filters( 'kopa_page_builder_get_layouts', array() );
			$layout_customize_data = Kopa_Page_Builder::get_layout_customize_data( $post->ID, $current_layout );
			$style = '';

			foreach ( $layouts as $layout_slug => $layout ) {
				if ( $layout_slug == $current_layout ) {
					$sections = $layout['section'];
					if ( count( $sections ) > 0 ) {
						foreach ( $sections as $section_slug => $section ) {
							if ( $wrap = Kopa_Page_Builder::get_current_wrapper_data( $post->ID, $layout_slug, $section_slug ) ) {

								if ( !empty( $wrap['container']['custom'] ) ) {
									$style .= str_replace( 'ID', "#autowork-wrap-{$section_slug}", $wrap['container']['custom'] );
								}
								// BACKGROUND SECTION

								if ( 'false' === $wrap['background']['status'] ) {
									if ( !empty( $wrap['background']['background-image'] ) )
										$style .= sprintf( '.victor-%s { background-image: url("%s"); }', $section_slug, do_shortcode( $wrap['background']['background-image'] ) );
								}
							}
						}
					}
				}
			}

			if ( !empty( $page_data ) ) {
				foreach ( $page_data as $section_id => $section ) {
					if ( !empty( $section ) ) {
						foreach ( $section as $area_id => $area ) {
							if ( !empty( $area ) ) {
								foreach ( $area as $widget_id => $widget ) {
									if ( $widget_data = get_post_meta( $post->ID, $widget_id, true ) ) {

										if ( isset( $widget_data['customize']['custom']['css'] ) && !empty( $widget_data['customize']['custom']['css'] ) ) {
											$style .= str_replace( 'ID', "#{$widget_id}.widget", $widget_data['customize']['custom']['css'] );
										}
									}
								}
							}
						}
					}
				}
			}

			if ( !empty( $layout_customize_data ) ) {
				if ( isset( $layout_customize_data['custom']['css'] ) && !empty( $layout_customize_data['custom']['css'] ) ) {
					$style .= $layout_customize_data['custom']['css'];
				}

				if ( isset( $layout_customize_data['js']['is_load_google_map_api'] ) && !empty( $layout_customize_data['js']['is_load_google_map_api'] ) ) {
					wp_enqueue_script( 'victor-google-map-api', '//maps.google.com/maps/api/js?sensor=true', array( 'jquery' ), NULL, TRUE );
					wp_enqueue_script( 'victor-google-map-custom', get_template_directory_uri() . "/js/gmaps.js", array( 'jquery' ), NULL, TRUE );
				}
			}
			if ( !empty( $style ) ) {
				wp_add_inline_style( 'victor-style', $style );
			}
		}
	}
}
