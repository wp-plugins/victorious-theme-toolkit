<?php
add_action( 'widgets_init', array( 'Victor_Entry_List', 'register_widget' ) );

class Victor_Entry_List extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_widget() {
		register_widget( 'Victor_Entry_List' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-entry-list-widget s1';
		$this->widget_id = 'victorious-entry-list';
		$this->widget_name = __( 'Victorious Entry List', 'victor-toolkit' );
		$this->widget_description = __( 'Display your article list', 'victor-toolkit' );
		$this->settings = victor_widget_settings();
		$this->settings['excerpt_length'] = array(
			'type' => 'number',
			'std' => 40,
			'label' => __( 'Excerpt Length', 'victor-toolkit' ),
			'min' => 1
		);
		$this->settings['style'] = array(
			'type' => 'select',
			'std' => 's1',
			'label' => __( 'Style', 'victor-toolkit' ),
			'options' => array(
				's1' => __( 'Style 1', 'victor-toolkit' ),
				's2' => __( 'Style 2', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$query_args = victor_build_query( $instance );
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			if ( $instance['style'] === 's2' ) {
				$before_widget = sprintf( '<div id="%1s" class="widget %2s">', $this->widget_id . rand(), 'kopa-entry-list-widget s2' );
			}
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<ul class="clearfix">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					?>
					<li>
						<div class="entry-top clearfix">
							<div class="entry-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php
									if ( $instance['style'] === 's1' ) {
										echo victor_crop_image( 'entry-list-1', get_the_ID() );
									} else {
										echo victor_crop_image( 'entry-list-1-style2', get_the_ID() );
									}
									?>
								</a>
							</div>
							<div class="entry-meta">
								<span><?php the_time( get_option( 'date_format' ) ); ?></span>
							</div>                                    
							<a href="<?php the_permalink(); ?>" class="entry-title"><?php the_title(); ?></a>
						</div>  
						<p class="excerpt"><?php echo victor_excerpt( false, isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 40  ); ?></p>
					</li>  
					<?php
				}
				?>
			</ul>
			<?php
			echo $after_widget;
		}
		wp_reset_postdata();
	}

}
