<?php
if ( !class_exists( 'Victor_Service' ) ) {

	class Victor_Service {

		function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 0 );
			add_action( 'admin_init', array( $this, 'register_metabox' ) );
			add_filter( 'manage_service_posts_columns', array( $this, 'manage_columns' ) );
			add_action( 'manage_service_posts_custom_column', array( $this, 'manage_column' ) );
		}

		function register_post_type() {
			$labels = array(
				'name' => __( 'Services', 'victor-toolkit' ),
				'singular_name' => __( 'Service', 'victor-toolkit' ),
				'menu_name' => __( 'Services', 'victor-toolkit' ),
				'add_new' => __( 'Add Service', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Service', 'victor-toolkit' ),
				'edit' => __( 'Edit', 'victor-toolkit' ),
				'edit_item' => __( 'Edit Service', 'victor-toolkit' ),
				'new_item' => __( 'New Service', 'victor-toolkit' ),
				'view' => __( 'View Service', 'victor-toolkit' ),
				'view_item' => __( 'View Service', 'victor-toolkit' ),
				'search_items' => __( 'Search Services', 'victor-toolkit' ),
				'not_found' => __( 'No Services Found', 'victor-toolkit' ),
				'not_found_in_trash' => __( 'No Services Found in Trash', 'victor-toolkit' ),
				'parent' => __( 'Parent Service', 'victor-toolkit' ),
			);
			$args = array(
				'menu_icon' => 'dashicons-share-alt2',
				'public' => true,
				'labels' => $labels,
				'supports' => array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'service' ),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => 100
			);
			register_post_type( 'service', $args );

			//Service tag
			$labels = array(
				'name' => __( 'Service Tags', 'victor-toolkit' ),
				'singular_name' => __( 'Tag', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'service-tag' ),
			);
			register_taxonomy( 'service_tag', array( 'service' ), $args );

			//Service categories
			$labels = array(
				'name' => __( 'Service Categories', 'victor-toolkit' ),
				'singular_name' => __( 'Service Categories', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'service-categories' )
			);
			register_taxonomy( 'service_categories', array( 'service' ), $args );
		}

		function register_metabox() {
			$args = array(
				'id' => 'service-option-metabox',
				'title' => __( 'Options', 'victor-toolkit' ),
				'desc' => '',
				'pages' => array( 'service' ),
				'priority' => 'high',
				'context' => 'normal',
				'fields' => array(
					array(
						'title' => __( 'Link to external page', 'victor-toolkit' ),
						'type' => 'url',
						'default' => '',
						'id' => 'service-external'
					),
					array(
						'title' => __( 'Link to static page', 'victor-toolkit' ),
						'type' => 'select',
						'default' => '',
						'id' => 'service-page',
						'options' => $this->get_list_page()
					),
					array(
						'title' => __( 'Icon', 'victor-toolkit' ),
						'type' => 'icon',
						'default' => '',
						'id' => 'service-icon',
					)
				)
			);
			kopa_register_metabox( $args );
		}

		function get_list_page() {
			$pages = get_pages();
			$page = array();
			$page[] = __( '---Select---', 'victor-toolkit' );
			foreach ( $pages as $value ) {
				$page[$value->ID] = $value->post_title;
			}
			return $page;
		}

		function manage_columns( $column ) {
			$column = array(
				'cb' => '<input type="checbox"/>',
				'icon' => __( 'Icon', 'victor-toolkit' ),
				'title' => __( 'Title', 'victor-toolkit' ),
				'author' => __( 'Author', 'victor-toolkit' ),
				'taxonomy-service_tag' => __( 'Service Tag', 'victor-toolkit' ),
				'taxonomy-service_categories' => __( 'Service Categories', 'victor-toolkit' ),
				'comments' => '',
				'date' => __( 'Date', 'victor-toolkit' )
			);
			return $column;
		}

		function manage_column( $column ) {
			global $post;
			switch ( $column ) {
				case 'icon':
					if ( $icon = get_post_meta( $post->ID, 'service-icon', true ) ) {
						echo '<i class="' . $icon . '"></i>';
					}
					break;
			}
		}

	}

	$victor_service = new Victor_Service();
}