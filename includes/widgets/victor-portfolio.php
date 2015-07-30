<?php
if ( !class_exists( 'Victor_Portfolio' ) ) {
	return;
}

add_filter( 'kpb_get_widgets_list', array( 'Victor_Portfolio_Widget', 'register_block' ) );

class Victor_Portfolio_Widget extends Kopa_Widget {

	public $kpb_group = 'portfolio';

	public static function register_block( $blocks ) {
		$blocks['Victor_Portfolio_Widget'] = new Victor_Portfolio_Widget();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-portfolio1-widget mb-100';
		$this->widget_id = 'victorious-portfolio-widget';
		$this->widget_name = __( 'Victorious Portfolio Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display a list of portfolio', 'victor-toolkit' );

		$cats = victor_get_taxonomy( 'portfolio_cat' );
		$tags = victor_get_taxonomy( 'portfolio_tag' );

		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Our Projects', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'portfolio_cat' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Project categories', 'victor-toolkit' ),
				'options' => $cats
			),
			'relation' => array(
				'type' => 'select',
				'std' => 'OR',
				'label' => __( 'Relation', 'victor-toolkit' ),
				'options' => array(
					'OR' => __( 'OR', 'victor-toolkit' ),
					'AND' => __( 'AND', 'victor-toolkit' )
				)
			),
			'portfolio_tag' => array(
				'type' => 'multiselect',
				'std' => '',
				'label' => __( 'Select Portfolio tags', 'victor-toolkit' ),
				'options' => $tags
			),
			'posts_per_page' => array(
				'type' => 'number',
				'std' => 5,
				'label' => __( 'Posts per page', 'victor-toolkit' ),
				'min' => 1
			),
			'orderby' => array(
				'type' => 'select',
				'std' => 'latest',
				'label' => __( 'Order by', 'victor-toolkit' ),
				'options' => array(
					'date' => __( 'Latest', 'victor-toolkit' ),
					'comment_count' => __( 'Popular by Comment Count', 'victor-toolkit' ),
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
			'style' => array(
				'type' => 'select',
				'std' => 'blue',
				'label' => __( 'Style', 'victor-toolkit' ),
				'options' => array(
					'blue' => __( 'None Background', 'victor-toolkit' ),
					'yellow' => __( 'Yellow Background', 'victor-toolkit' )
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$query_args = array(
			'post_type' => array( 'portfolio' ),
			'posts_per_page' => $instance['posts_per_page'],
			'relation' => $instance['relation'],
			'tax_tags' => 'portfolio_tag',
			'tags' => $instance['portfolio_tag'],
			'categories' => $instance['portfolio_cat'],
			'tax_categories' => 'portfolio_cat',
			'orderby' => $instance['orderby'],
			'order' => $instance['order']
		);
		$query_args = victor_build_query_post_type( $query_args );

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			if ( $instance['style'] === 'yellow' ) {
				$before_widget = sprintf( '<div id="%1s" class="widget %2s">', $this->widget_id . rand(), 'kopa-portfolio1-widget s2' );
			}
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content clearfix">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$portfolio_cat = get_the_terms( get_the_ID(), 'portfolio_cat' );
					$cat = array();
					if ( !empty( $portfolio_cat ) ) {
						foreach ( $portfolio_cat as $term ) {
							$cat[] = $term->name;
						}
					}
					?>
					<div class="item-wrapper">
						<div class="item-thumb">
							<?php
							echo victor_crop_image( 'portfolio-1', get_the_ID() );
							?>
						</div>

						<div class="item-hover">
							<h5 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<?php
							if ( !empty( $cat ) ) {
								?>
								<p class="item-cat">
									<?php
									$i = 1;
									foreach ( $cat as $value ) {
										echo $value;
										if ( $i >= 1 && $i < sizeof( $cat ) ) {
											echo __( ', ', 'victor-toolkit' );
										}
										$i++;
									}
									?>
								</p>
							<?php } ?>
							<div class="icon-wrapper">
								<a href="<?php echo victor_crop_image( 'portfolio-1', get_the_ID(), true ); ?>" class="popup-icon">
									<span class="fa fa-expand"></span>
								</a>
								<a href="<?php the_permalink(); ?>" class="link-icon">
									<span class="fa fa-plus"></span>
								</a> 
							</div> 
						</div>

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
