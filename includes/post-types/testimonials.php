<?php

if ( !class_exists( 'Victor_Testimonials' ) ) {

	class Victor_Testimonials {

		function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 0 );
			add_action( 'admin_init', array( $this, 'register_metabox' ) );
			add_filter( 'manage_testimonials_posts_columns', array( $this, 'manage_columns' ) );
			add_action( 'manage_testimonials_posts_custom_column', array( $this, 'manage_column' ) );
		}

		function register_post_type() {
			$labels = array(
				'name' => __( 'Testimonials', 'victor-toolkit' ),
				'singular_name' => __( 'Testimonial', 'victor-toolkit' ),
				'menu_name' => __( 'Testimonials', 'victor-toolkit' ),
				'add_new' => __( 'Add Testimonial', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Testimonial', 'victor-toolkit' ),
				'edit' => __( 'Edit', 'victor-toolkit' ),
				'edit_item' => __( 'Edit Testimonial', 'victor-toolkit' ),
				'new_item' => __( 'New Testimonial', 'victor-toolkit' ),
				'view' => __( 'View Testimonial', 'victor-toolkit' ),
				'view_item' => __( 'View Testimonial', 'victor-toolkit' ),
				'search_items' => __( 'Search Testimonials', 'victor-toolkit' ),
				'not_found' => __( 'No Testimonials Found', 'victor-toolkit' ),
				'not_found_in_trash' => __( 'No Testimonials Found in Trash', 'victor-toolkit' ),
				'parent' => __( 'Parent Testimonial', 'victor-toolkit' ),
			);
			$args = array(
				'menu_icon' => 'dashicons-testimonial',
				'public' => true,
				'labels' => $labels,
				'supports' => array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'testimonials' ),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => 100
			);
			register_post_type( 'testimonials', $args );
			//Testimonial tag
			$labels = array(
				'name' => __( 'Testimonials Tags', 'victor-toolkit' ),
				'singular_name' => __( 'Testimonials Tag', 'victor-toolkit' ),
				'search_items' => __( 'Search Tags', 'victor-toolkit' ),
				'popular_items' => __( 'Popular Tags', 'victor-toolkit' ),
				'all_items' => __( 'All Tags', 'victor-toolkit' ),
				'parent_item' => '',
				'parent_item_colon' => '',
				'edit_item' => __( 'Edit Tag', 'victor-toolkit' ),
				'update_item' => __( 'Update Tag', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Tag', 'victor-toolkit' ),
				'new_item_name' => __( 'New Tag Name', 'victor-toolkit' ),
				'separate_items_with_commas' => __( 'Separate tags with commas', 'victor-toolkit' ),
				'add_or_remove_items' => __( 'Add or remove tags', 'victor-toolkit' ),
				'choose_from_most_used' => __( 'Choose from the most used tags', 'victor-toolkit' ),
			);
			$args = array(
				'hierarchical' => false,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'testimonials-tag' ),
			);
			register_taxonomy( 'testimonial_tag', array( 'testimonials' ), $args );

			//Testimonial categories
			$labels = array(
				'name' => __( 'Testimonial Categories', 'victor-toolkit' ),
				'singular_name' => __( 'Testimonials Categories', 'victor-toolkit' ),
				'search_items' => __( 'Search Categories', 'victor-toolkit' ),
				'popular_items' => '',
				'all_items' => __( 'All Categories', 'victor-toolkit' ),
				'parent_item' => __( 'Parent Category', 'victor-toolkit' ),
				'parent_item_colon' => __( 'Parent Category:', 'victor-resolution-toolkit' ),
				'edit_item' => __( 'Edit Category', 'victor-toolkit' ),
				'update_item' => __( 'Update Category', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Category', 'victor-toolkit' ),
				'new_item_name' => __( 'New Category Name', 'victor-toolkit' ),
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			);
			$args = array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'testimonials-categories' )
			);
			register_taxonomy( 'testimonial_categories', array( 'testimonials' ), $args );
		}

		function register_metabox() {
			$args = array(
				'id' => 'testimonials-option-metabox',
				'title' => __( 'Options', 'victor-toolkit' ),
				'pages' => array( 'testimonials' ),
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'title' => __( 'Avatar', 'victor-toolkit' ),
						'type' => 'upload',
						'id' => 'testimonial-avatar'
					),
					array(
						'title' => __( 'Position', 'victor-toolkit' ),
						'type' => 'text',
						'id' => 'testimonial-position'
					),
				)
			);
			kopa_register_metabox( $args );
		}

		function manage_columns( $column ) {
			$column = array(
				'cb' => '<input type="checkbox"/>',
				'thumb' => __( 'Thumb', 'victor-toolkit' ),
				'title' => __( 'Title', 'victor-toolkit' ),
				'taxonomy-testimonial_categories' => __( 'Testimonial Categories', 'victor-toolkit' ),
				'taxonomy-testimonial_tag' => __( 'Testimonial Tags', 'victor-toolkit' ),
				'comments' => '',
				'date' => __( 'Date', 'victor-toolkit' )
			);
			return $column;
		}

		function manage_column( $column ) {
			global $post;
			switch ( $column ) {
				case 'thumb':
					if ( has_post_thumbnail( $post->ID ) ) {
						echo victor_crop_image( 'admin-icon', $post->ID );
					}
					break;
			}
		}

	}

	$victor_testimonials = new Victor_Testimonials();
}