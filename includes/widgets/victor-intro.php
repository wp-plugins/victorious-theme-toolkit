<?php
if ( !class_exists( 'Victor_Service' ) ) {
	return;
}
add_filter( 'kpb_get_widgets_list', array( 'Victor_Intro', 'register_block' ) );

class Victor_Intro extends Kopa_Widget {

	public $kpb_group = 'service';

	public static function register_block( $blocks ) {
		$blocks['Victor_Intro'] = new Victor_Intro();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-intro1-widget';
		$this->widget_id = 'victorious-intro-widget';
		$this->widget_name = __( 'Victorious Intro Widget 1', 'victor-toolkit' );
		$this->widget_description = __( 'Display your intro with featured posts', 'victor-toolkit' );

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
			'excerpt_length' => array(
				'type' => 'number',
				'std' => 20,
				'label' => __( 'Excerpt Length', 'victor-toolkit' ),
				'min' => 1
			),
			'desc' => array(
				'type' => 'textarea',
				'std' => __( '<p class="description">PROVIDING FIRST CLASS<br><span>FREIGHT SERVICES</span><span class="left-icon"></span><span class="right-icon"></span></p>', 'victor-toolkit' ),
				'label' => __( 'Description (Only for Style 3 posts)', 'victor-toolkit' )
			),
			'link_to' => array(
				'type' => 'text',
				'std' => '#',
				'label' => __( 'Link to (Only for Style 3 posts)', 'victor-toolkit' )
			),
			'text_link' => array(
				'type' => 'text',
				'std' => __( 'Learn More', 'victor-toolkit' ),
				'label' => __( 'Text Link (Only for Style 3 posts)', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$instance['posts_per_page'] = 3;
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

		if ( $query->have_posts() || $title || $instance['desc'] || $instance['text_link'] ) {
			echo $before_widget;
			?>
			<div class="widget-header">

				<div class="wrapper">
					<?php
					if ( $title ) {
						echo '<div>' . wp_kses_post( $before_title . $title . $after_title ) . '</div>';
					}
					if ( $instance['desc'] ) {
						?>
						<div class="desc-wrapper">
							<?php echo wp_kses_post( $instance['desc'] ); ?>
						</div>
						<?php
					}
					if ( $instance['text_link'] ) {
						?>
						<a href="<?php echo esc_url( $instance['link_to'] ? $instance['link_to'] : '#'  ); ?>" class="learn-more"><?php echo wp_kses_post( $instance['text_link'] ); ?></a>
					<?php } ?>
				</div>
			</div>
			<?php
		}
		if ( $query->have_posts() ) {
			?>
			<div class="widget-content clearfix">

				<div class="widget-content-top"></div>

				<div class="widget-content-bottom">

					<div class="wrapper">

						<div class="row row-20 clearfix">
							<?php
							while ( $query->have_posts() ) {
								$query->the_post();
								$icon = get_post_meta( get_the_id(), 'service-icon', true );
								?>
								<div class="item-wrapper col-md-4 col-sm-4 col-xs-12 col-20">
									<div class="item-header">
										<?php
										if ( $icon ) {
											?>
											<span class="item-icon <?php echo esc_attr( $icon ); ?>"></span>
										<?php } ?>
										<div class="item-title-wrapper">
											<h5 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										</div>                                        
									</div>
									<div class="item-content">                                       
										<div class="item-hover">                  
											<p class="excerpt"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20  ); ?></p>
											<a href="<?php the_permalink(); ?>" class="learn-more"><?php echo __( 'learn more', 'victor-toolkit' ); ?></a>
										</div>
										<div class="item-thumb">
											<?php echo victor_crop_image( 'intro1-widget', get_the_ID() ); ?>
										</div>
									</div>                                    
								</div>
								<?php
							}
							?>

						</div>

					</div> 

				</div>         

			</div> 
			<?php
			echo $after_widget;
		}
		wp_reset_postdata();
	}

}
