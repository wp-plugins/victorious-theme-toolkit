<?php
if ( !class_exists( 'Victor_Testimonials' ) ) {
	return;
}

add_action( 'widgets_init', array( 'Victor_Testimonials_Widget', 'register_widget' ) );

class Victor_Testimonials_Widget extends Kopa_Widget {

	public $kpb_group = 'testimonials';

	public static function register_widget() {
		register_widget( 'Victor_Testimonials_Widget' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-testimonial1-widget';
		$this->widget_id = 'victorious-testimonials';
		$this->widget_name = __( 'Victorious Testimonial Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display a list of testimonial', 'victor-toolkit' );
		$cats = victor_get_taxonomy( 'testimonial_categories' );
		$tags = victor_get_taxonomy( 'testimonial_tag' );

		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Testimonials', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'desc' => array(
				'type' => 'textarea',
				'std' => '',
				'label' => __( 'Description', 'victor-toolkit' )
			),
			'testimonial_cat' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Testimonial Categories', 'victor-toolkit' ),
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
			'testimonial_tag' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Testimonial Tags', 'victor-toolkit' ),
				'options' => $tags
			),
			'posts_per_page' => array(
				'type' => 'number',
				'std' => 3,
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
			'excerpt_length' => array(
				'type' => 'number',
				'std' => 10,
				'label' => __( 'Excerpt Length', 'victor-toolkit' ),
				'min' => 1
			),
			'slide_speed' => array(
				'type' => 'number',
				'std' => 1000,
				'label' => __( 'Slide Speed (ms)', 'victor-toolkit' ),
				'min' => 1
			),
			'items_per_page' => array(
				'type' => 'select',
				'std' => 1,
				'label' => __( 'Items per page', 'victor-toolkit' ),
				'options' => array(
					1 => __( '1', 'victor-toolkit' ),
					2 => __( '2', 'victor-toolkit' ),
					3 => __( '3', 'victor-toolkit' )
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$query_args = array(
			'post_type' => array( 'testimonials' ),
			'posts_per_page' => $instance['posts_per_page'],
			'relation' => $instance['relation'],
			'tax_tags' => 'testimonial_tag',
			'tags' => $instance['testimonial_tag'],
			'categories' => $instance['testimonial_cat'],
			'tax_categories' => 'testimonial_categories',
			'orderby' => $instance['orderby'],
			'order' => $instance['order']
		);
		$query_args = victor_build_query_post_type( $query_args );
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			if ( $instance['items_per_page'] == 2 ) {
				$before_widget = sprintf( '<div id="%1s" class="widget %2s">', $this->widget_id . rand(), 'kopa-testimonial3-widget mb-100' );
			} elseif ( $instance['items_per_page'] == 3 ) {
				$before_widget = sprintf( '<div id="%1s" class="widget %2s">', $this->widget_id . rand(), 'kopa-testimonial2-widget mb-100' );
			}
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content">
				<?php
				$owl_testi = '1';
				if ( $instance['items_per_page'] == 2 ) {
					$owl_testi = '3';
					echo '<div class="row row-20">';
				} elseif ( $instance['items_per_page'] == 3 ) {
					$owl_testi = '2';
					if ( $instance['desc'] ) {
						?>
						<p class="desc"><?php echo wp_kses_post( $instance['desc'] ); ?></p>
						<?php
					}
				}
				?>
				<div class="owl-carousel owl-testi-<?php echo esc_attr( $owl_testi ); ?>" data-slide-speed="<?php echo esc_attr( $instance['slide_speed'] ? $instance['slide_speed'] : 1000  ); ?>"> 
					<?php
					$i = 1;
					while ( $query->have_posts() ) {
						$query->the_post();
						$position = get_post_meta( get_the_ID(), 'testimonial-position', true );
						$avatar = get_post_meta( get_the_ID(), 'testimonial-avatar', true );
						if ( $instance['items_per_page'] == 1 ) {
							?>
							<div class="item-wrapper">
								<p class="comment"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10  ); ?></p>
								<p class="sign"><?php the_title(); ?></p>
							</div>
							<?php
						} elseif ( $instance['items_per_page'] == 2 ) {
							?>
							<div class="item-wrapper col-20 col-md-6 col-sm-6 col-xs-12">
								<div class="corner"><span><?php echo esc_attr( $i < 10 ? '0' . $i : $i  ); ?></span></div>                                
								<div class="content-wrapper">
									<div class="white-corner"></div>
									<?php
									if ( $avatar ) {
										?>
										<div class="entry-thumb">
											<img alt="" src="<?php echo victor_crop_image_by_url( 'testimonial-2', $avatar, true ); ?>">
										</div>
									<?php } ?>
									<div class="comment-outer">
										<p class="comment"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 40  ); ?></p> 
										<p class="sign"><span><?php the_title(); ?></span></p>
									</div>
								</div>
							</div>
							<?php
						} else {
							?>
							<div class="item-wrapper">                                
								<div class="comment-wrapper">
									<div class="comment-outer">
										<p class="comment"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10  ); ?>
											<span class="fa fa-quote-left"></span>
											<span class="fa fa-quote-right"></span>
										</p>                                         
									</div>

									<div class="item-thumb">
										<?php echo victor_crop_image( 'testimonial-3', get_the_ID() ); ?>
									</div>

									<div class="customer-info">
										<?php
										if ( $avatar ) {
											?>
											<div class="entry-thumb">
												<a href="<?php the_permalink(); ?>"><img alt="" src="<?php echo victor_crop_image_by_url( 'testimonial-3-avatar', $avatar, true ); ?>"></a>
											</div>
										<?php } ?>
										<h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										<?php
										if ( $position ) {
											?>
											<p class="position"><?php echo wp_kses_post( $position ); ?></p>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php
						}
						$i++;
					}
					?>
				</div>
				<?php
				if ( $instance['items_per_page'] == 2 ) {
					echo '</div>';
				}
				?>
			</div>
			<?php
			echo $after_widget;
		}
		wp_reset_postdata();
	}

}
