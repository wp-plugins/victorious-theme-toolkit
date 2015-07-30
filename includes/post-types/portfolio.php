<?php

if ( !class_exists( 'Victor_Portfolio' ) ) {

	class Victor_Portfolio {

		function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 0 );
			add_action( 'admin_init', array( $this, 'register_metabox' ) );
			add_filter( 'manage_portfolio_posts_columns', array( $this, 'manage_columns' ) );
			add_action( 'manage_portfolio_posts_custom_column', array( $this, 'manage_column' ) );
			require_once(VICTOR_PATH . 'includes/layout/portfolio.php');
			add_filter( 'kopa_sidebar_default', array( &$this, 'victor_toolkit_plus_sidebar_manager' ) );
		}

		function victor_toolkit_plus_sidebar_manager( $options ) {
			$options['portfolio'] = array(
				'name' => __( 'Portfolio 1', 'victor-toolkit' ),
			);
			return $options;
		}

		function register_post_type() {
			$labels = array(
				'name' => __( 'Portfolios', 'victor-toolkit' ),
				'singular_name' => __( 'Portfolio', 'victor-toolkit' ),
				'menu_name' => __( 'Portfolios', 'victor-toolkit' ),
				'add_new' => __( 'Add Portfolio', 'victor-toolkit' ),
				'add_new_item' => __( 'Add New Portfolio', 'victor-toolkit' ),
				'edit' => __( 'Edit', 'victor-toolkit' ),
				'edit_item' => __( 'Edit Portfolio', 'victor-toolkit' ),
				'new_item' => __( 'New Portfolio', 'victor-toolkit' ),
				'view' => __( 'View Portfolio', 'victor-toolkit' ),
				'view_item' => __( 'View Portfolio', 'victor-toolkit' ),
				'search_items' => __( 'Search Portfolios', 'victor-toolkit' ),
				'not_found' => __( 'No Portfolios Found', 'victor-toolkit' ),
				'not_found_in_trash' => __( 'No Portfolios Found in Trash', 'victor-toolkit' ),
				'parent' => __( 'Parent Portfolio', 'victor-toolkit' ),
			);
			$args = array(
				'menu_icon' => 'dashicons-portfolio',
				'public' => true,
				'labels' => $labels,
				'supports' => array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'portfolio' ),
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => 100
			);
			register_post_type( 'portfolio', $args );

			$labels = array(
				'name' => __( 'Portfolio Tags', 'victor-toolkit' ),
				'singular_name' => __( 'Portfolio Tag', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'portfolio-tag' ),
			);
			register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );

			$labels = array(
				'name' => __( 'Portfolio Categories', 'victor-toolkit' ),
				'singular_name' => __( 'Portfolio Category', 'victor-toolkit' ),
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
				'rewrite' => array( 'slug' => 'portfolio-cat' ),
			);
			register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $args );
		}

		function manage_columns( $column ) {
			$column = array(
				'cb' => '<input type="checkbox"/>',
				'thumb' => __( 'Thumb', 'victor-toolkit' ),
				'title' => __( 'Title', 'victor-toolkit' ),
				'author' => __( 'Author', 'victor-toolkit' ),
				'taxonomy-portfolio_tag' => __( 'Portfolio tags', 'victor-toolkit' ),
				'taxonomy-portfolio_cat' => __( 'Portfolio categories', 'victor-toolkit' ),
				'comments' => __( 'Comments', 'victor-toolkit' ),
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

		function register_metabox() {
			$args = array(
				'id' => 'matches-option-metabox',
				'title' => __( 'Options', 'gusty-toolkit' ),
				'desc' => '',
				'pages' => array( 'portfolio' ),
				'priority' => 'high',
				'context' => 'normal',
				'fields' => array(
					array(
						'title' => __( 'Date', 'gusty-toolkit' ),
						'type' => 'datetime',
						'id' => 'portfolio-date',
						'format' => 'd-m-Y',
						'datepicker' => true,
						'timepicker' => false,
					),
					array(
						'title' => __( 'Client', 'gusty-toolkit' ),
						'type' => 'text',
						'id' => 'portfolio-client'
					),
				)
			);
			kopa_register_metabox( $args );
		}
	}

	$victor_portfolio = new Victor_Portfolio();
}