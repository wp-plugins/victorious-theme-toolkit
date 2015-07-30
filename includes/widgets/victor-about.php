<?php
add_filter( 'kpb_get_widgets_list', array( 'Victor_About_Widget', 'register_block' ) );

class Victor_About_Widget extends Kopa_Widget {

	public $kpb_group = 'post';

	public static function register_block( $blocks ) {
		$blocks['Victor_About_Widget'] = new Victor_About_Widget();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-about-widget mb-60';
		$this->widget_id = 'victorious-about-widget';
		$this->widget_name = __( 'Victorious About Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display an article about your company', 'victor-toolkit' );
		$company = get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1 ) );
		$com = array();
		foreach ( $company as $val ) {
			$com[$val->ID] = $val->post_title;
		}
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Our Mission', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'post' => array(
				'type' => 'select',
				'std' => '',
				'label' => __( 'Select Post', 'victor-toolkit' ),
				'options' => $com
			),
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $instance['post'] ) {
			$post = get_post( $instance['post'] );
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content">
				<div class="row row-20">
					<div class="col-left col-md-6 col-sm-6 col-xs-12 col-20">
						<div class="entry-thumb mb-40">
							<?php echo victor_crop_image( 'about-widget', $instance['post'] ); ?>
						</div>
					</div>
					<div class="col-right col-md-6 col-sm-6 col-xs-12 col-20">
						<div class="about-content mb-40">
							<?php echo apply_filters( 'the_content', $post->post_content ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php
			echo $after_widget;
			wp_reset_postdata();
		}
	}

}
