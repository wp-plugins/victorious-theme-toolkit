<?php
add_filter( 'kpb_get_widgets_list', array( 'Victor_Text', 'register_block' ) );

class Victor_Text extends Kopa_Widget {

	public $kpb_group = 'widgets';

	public static function register_block( $blocks ) {
		$blocks['Victor_Text'] = new Victor_Text();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-text-widget s1 mb-95';
		$this->widget_id = 'victorious-text-widget';
		$this->widget_name = __( 'Victorious Text Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Arbitrary text or HTML with button', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Welcome to Victorious', 'victor-toolkit' ),
				'label' => __( 'Title' )
			),
			'desc' => array(
				'type' => 'textarea',
				'std' => '',
				'label' => __( 'Description', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		if ( $instance['desc'] ) {
			?>
			<div class="widget-content">
				<?php echo apply_filters( 'the_content', $instance['desc'] ); ?>
			</div>
			<?php
		}
		echo $after_widget;
	}

}
