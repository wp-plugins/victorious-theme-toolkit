<?php
if ( !class_exists( 'Victor_Service' ) ) {
	return;
}
add_filter( 'kpb_get_widgets_list', array( 'Victor_Service_Widget', 'register_block' ) );

class Victor_Service_Widget extends Kopa_Widget {

	public $kpb_group = 'service';

	public static function register_block( $blocks ) {
		$blocks['Victor_Service_Widget'] = new Victor_Service_Widget();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-service1-widget';
		$this->widget_id = 'victorious-service-widget';
		$this->widget_name = __( 'Victorious Service Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display a list of service', 'victor-toolkit' );

		$cats = victor_get_taxonomy( 'service_categories' );
		$tags = victor_get_taxonomy( 'service_tag' );

		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Service', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'service_cat' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Service Categories', 'victor-toolkit' ),
				'options' => $cats
			),
			'relation' => array(
				'type' => 'select',
				'std' => 'or',
				'label' => __( 'Relation', 'victor-toolkit' ),
				'options' => array(
					'or' => __( 'OR', 'victor-toolkit' ),
					'and' => __( 'AND', 'victor-toolkit' )
				)
			),
			'service_tag' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select service tags', 'victor-toolkit' ),
				'options' => $tags
			),
			'posts_per_page' => array(
				'type' => 'number',
				'std' => 4,
				'label' => __( 'Posts per page', 'victor-toolkit' ),
				'min' => 1
			),
			'orderby' => array(
				'type' => 'select',
				'std' => 'date',
				'label' => __( 'Order by', 'victor-toolkit' ),
				'options' => array(
					'date' => __( 'Latest', 'victor-toolkit' ),
					'comment_count' => __( 'Popular', 'victor-toolkit' ),
					'rand' => __( 'Random', 'victor-toolkit' )
				)
			),
			'order' => array(
				'type' => 'select',
				'std' => 'desc',
				'label' => __( 'Order', 'victor-toolkit' ),
				'options' => array(
					'asc' => __( 'Ascending', 'victor-toolkit' ),
					'desc' => __( 'Descending', 'victor-toolkit' ),
				)
			),
			'read_more' => array(
				'type' => 'text',
				'std' => __( 'Read more', 'victor-toolkit' ),
				'label' => __( 'Read more text', 'victor-toolkit' )
			),
			'excerpt_length' => array(
				'type' => 'number',
				'std' => 10,
				'label' => __( 'Excerpt Length', 'victor-toolkit' ),
				'min' => 1
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$query_args = array(
			'post_type' => array( 'service' ),
			'posts_per_page' => $instance['posts_per_page'],
			'relation' => $instance['relation'],
			'tax_tags' => 'service_tag',
			'tags' => $instance['service_tag'],
			'categories' => $instance['service_cat'],
			'tax_categories' => 'service_categories',
			'orderby' => $instance['orderby'],
			'order' => $instance['order']
		);
		$query_args = victor_build_query_post_type( $query_args );
		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content clearfix">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$icon = get_post_meta( get_the_id(), 'service-icon', true );
					$external = get_post_meta( get_the_id(), 'service-external', true );
					$page = get_post_meta( get_the_id(), 'service-page', true );
					if ( $external ) {
						$link = $external;
					} else {
						if ( $page ) {
							$link = get_page_link( $page );
						} else {
							$link = get_permalink();
						}
					}
					?>
					<div class="item-wrapper col-md-3 col-sm-6 col-xs-12">
						<?php
						if ( $icon ) {
							?>
							<a href="<?php echo esc_url( $link ? $link : '#'  ); ?>" class="item-icon-wrapper">
								<span class="<?php echo esc_attr( $icon ); ?>"></span>
							</a>
							<?php
						}
						?>
						<h5 class="item-title">
							<a href="<?php echo esc_url( $link ? $link : '#'  ); ?>"><?php the_title(); ?></a></h5>
						<p class="item-excerpt"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10  ); ?></p>

					</div>
					<?php
				}
				?>
			</div>
			<?php
			echo $after_widget;
		}
		wp_reset_postdata();
	}

}
