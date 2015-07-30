<?php
if ( !class_exists( 'Victor_Staff' ) ) {

	class Victor_Staff {

		function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 0 );
			add_action( 'admin_init', array( $this, 'register_metabox' ) );
			add_filter( 'manage_staff_posts_columns', array( $this, 'manage_columns' ) );
			add_action( 'manage_staff_posts_custom_column', array( $this, 'manage_column' ) );
		}

		function register_post_type() {
			$labels = array(
				'name' => __( 'Staffs', 'victor-toolkit' ),
				'singular_name' => __( 'Staff', 'victor-toolkit' ),
				'menu_name' => __( 'Staffs', 'victor-toolkit' ),
				'add_new' => __( 'Add Staff', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Staff', 'victor-toolkit' ),
				'edit' => __( 'Edit', 'victor-toolkit' ),
				'edit_item' => __( 'Edit Staff', 'victor-toolkit' ),
				'new_item' => __( 'New Staff', 'victor-toolkit' ),
				'view' => __( 'View Staff', 'victor-toolkit' ),
				'view_item' => __( 'View Staff', 'victor-toolkit' ),
				'search_items' => __( 'Search Staffs', 'victor-toolkit' ),
				'not_found' => __( 'No Staffs Found', 'victor-toolkit' ),
				'not_found_in_trash' => __( 'No Staffs Found in Trash', 'victor-toolkit' ),
				'parent' => __( 'Parent Staff', 'victor-toolkit' ),
			);
			$args = array(
				'menu_icon' => 'dashicons-businessman',
				'public' => true,
				'labels' => $labels,
				'supports' => array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'staff' ),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => 100
			);
			register_post_type( 'staff', $args );

			$labels = array(
				'name' => __( 'Staff Tags', 'victor-toolkit' ),
				'singular_name' => __( 'Staff Tag', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'staff-tag' ),
			);
			register_taxonomy( 'staff_tag', array( 'staff' ), $args );

			$labels = array(
				'name' => __( 'Staff Categories', 'victor-toolkit' ),
				'singular_name' => __( 'Staff Category', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'staff-categories' ),
			);
			register_taxonomy( 'staff_categories', array( 'staff' ), $args );
		}

		function register_metabox() {
			$args = array(
				'id' => 'staff-option-metabox',
				'title' => __( 'Options', 'victor-toolkit' ),
				'pages' => array( 'staff' ),
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'title' => __( 'Position', 'victor-toolkit' ),
						'type' => 'text',
						'id' => 'staff-position'
					),
					array(
						'title' => __( 'Facebook URL', 'victor-toolkit' ),
						'type' => 'url',
						'id' => 'staff-facebook',
						'default' => 'http://facebook.com'
					),
					array(
						'title' => __( 'Twitter URL', 'victor-toolkit' ),
						'type' => 'url',
						'id' => 'staff-twitter',
						'default' => 'http://twitter.com'
					),
					array(
						'title' => __( 'Google Plus URL', 'victor-toolkit' ),
						'type' => 'url',
						'id' => 'staff-gplus'
					),
					array(
						'title' => __( 'Linkedin URL', 'victor-toolkit' ),
						'type' => 'url',
						'id' => 'staff-linkedin',
						'default' => 'http://linkedin.com'
					)
				)
			);
			kopa_register_metabox( $args );
		}

		function manage_columns( $column ) {
			$column = array(
				'cb' => '<input type="checkbox"/>',
				'thumb' => __( 'Thumb', 'victor-toolkit' ),
				'title' => __( 'Name', 'victor-toolkit' ),
				'author' => __( 'Author', 'victor-toolkit' ),
				'taxonomy-staff_categories' => __( 'Staff Categories', 'victor-toolkit' ),
				'taxonomy-staff_tag' => __( 'Staff Tags', 'victor-toolkit' ),
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

	$victor_staff = new Victor_Staff();
}