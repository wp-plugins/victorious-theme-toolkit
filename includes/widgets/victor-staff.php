<?php
if ( !class_exists( 'Victor_Staff' ) ) {
	return;
}

add_filter( 'kpb_get_widgets_list', array( 'Victor_Staff_Widget', 'register_block' ) );

class Victor_Staff_Widget extends Kopa_Widget {

	public $kpb_group = 'staff';

	public static function register_block( $blocks ) {
		$blocks['Victor_Staff_Widget'] = new Victor_Staff_Widget();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-team1-widget mb-70';
		$this->widget_id = 'victorious-staffs-widget';
		$this->widget_name = __( 'Victorious Staff Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display a list of staff', 'victor-toolkit' );
		$cats = victor_get_taxonomy( 'staff_categories' );
		$tags = victor_get_taxonomy( 'staff_tag' );

		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'We are team', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'staff_cat' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Staff Categories', 'victor-toolkit' ),
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
			'staff_tag' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Staff Tags', 'victor-toolkit' ),
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
			'style' => array(
				'type' => 'select',
				'std' => 'normal',
				'label' => __( 'Style', 'victor-toolkit' ),
				'options' => array(
					'normal' => __( 'Style 1', 'victor-toolkit' ),
					'other' => __( 'Style 2', 'victor-toolkit' )
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$query_args = array(
			'post_type' => array( 'staff' ),
			'posts_per_page' => $instance['posts_per_page'],
			'relation' => $instance['relation'],
			'tax_tags' => 'staff_tag',
			'tags' => $instance['staff_tag'],
			'categories' => $instance['staff_cat'],
			'tax_categories' => 'staff_categories',
			'orderby' => $instance['orderby'],
			'order' => $instance['order']
		);
		$query_args = victor_build_query_post_type( $query_args );

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			if ( $instance['style'] === 'other' ) {
				$before_widget = sprintf( '<div id="%1s" class="widget %2s">', $this->widget_id . rand(), 'kopa-team2-widget mb-70' );
			}
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content clearfix">
				<?php
				if ( $instance['style'] === 'normal' ) {
					?>
					<div class="row">
						<?php
					}
					$i = 1;
					while ( $query->have_posts() ) {
						$query->the_post();
						$facebook = get_post_meta( get_the_id(), 'staff-facebook', true );
						$twitter = get_post_meta( get_the_id(), 'staff-twitter', true );
						$gplus = get_post_meta( get_the_id(), 'staff-gplus', true );
						$linkedin = get_post_meta( get_the_id(), 'staff-linkedin', true );
						$position = get_post_meta( get_the_id(), 'staff-position', true );
						if ( $instance['style'] === 'normal' ) {
							?>
							<div class="col-20 col-md-3 col-sm-6 col-xs-12">
								<div class="entry-wrapper">
									<?php
									if ( has_post_thumbnail() ) {
										?>
										<div class="member-thumb">
											<a href="<?php the_permalink(); ?>">
												<?php echo victor_crop_image( 'staff', get_the_ID() ); ?>
											</a>
										</div>                   
									<?php } ?>
									<div class="member-info">
										<h5 class="member-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										<p class="position"><?php echo wp_kses_post( $position ); ?></p>
										<p class="excerpt"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10  ); ?></p>
										<?php if ( $facebook || $twitter || $linkedin || $gplus ) { ?>
											<div class="kopa-social-links s1">
												<ul class="clearfix">
													<?php
													if ( $facebook ) {
														?>
														<li><a href="<?php echo esc_url( $facebook ? $facebook : '#'  ); ?>" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
														<?php
													}
													if ( $twitter ) {
														?>
														<li><a href="<?php echo esc_url( $twitter ? $twitter : '#'  ); ?>" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
														<?php
													}
													if ( $linkedin ) {
														?>
														<li><a href="<?php echo esc_url( $linkedin ? $linkedin : '#'  ); ?>" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
														<?php
													}
													if ( $gplus ) {
														?>
														<li><a href="<?php echo esc_url( $gplus ? $gplus : '#'  ); ?>" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
														<?php
													}
													?>
												</ul>
											</div>
										<?php } ?>
									</div> 
								</div>                                                               
							</div>
							<?php
						} else {
							?>
							<div class="entry-wrapper <?php echo esc_attr( $i == 1 ? 'first-entry' : ''  ); ?>">
								<div class="member-thumb-outer">
									<a href="<?php the_permalink(); ?>" class="member-thumb">
										<?php echo victor_crop_image( 'staff', get_the_ID() ); ?>
									</a>
								</div>
								<div class="member-info">
									<h5 class="member-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
									<?php if ( $position ) { ?>
										<p class="position"><?php echo wp_kses_post( $position ); ?></p>
									<?php } ?>
									<p class="excerpt"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10  ); ?></p>
									<?php if ( $facebook || $twitter || $linkedin || $gplus ) { ?>
										<div class="kopa-social-links s3">
											<ul class="clearfix">
												<?php
												if ( $facebook ) {
													?>
													<li><a href="<?php echo esc_url( $facebook ? $facebook : '#'  ); ?>" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
													<?php
												}
												if ( $twitter ) {
													?>
													<li><a href="<?php echo esc_url( $twitter ? $twitter : '#'  ); ?>" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
													<?php
												}
												if ( $linkedin ) {
													?>
													<li><a href="<?php echo esc_url( $linkedin ? $linkedin : '#'  ); ?>" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
													<?php
												}
												if ( $gplus ) {
													?>
													<li><a href="<?php echo esc_url( $gplus ? $gplus : '#'  ); ?>" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
															<?php
														}
														?>
											</ul>
										</div>
									<?php } ?>
								</div>                                
							</div>
							<?php
						}
						$i++;
					}
					if ( $instance['style'] === 'normal' ) {
						?>
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
