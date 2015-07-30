<?php
add_action( 'widgets_init', array( 'Victor_FeedBurner', 'register_widget' ) );

class Victor_FeedBurner extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget() {
		register_widget( 'Victor_FeedBurner' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-newsletter-widget';
		$this->widget_id = 'victorious-feedburner-subscribe';
		$this->widget_name = __( 'Victorious Feedburner Subscribe', 'victor-toolkit' );
		$this->widget_description = __( 'Display Feedburner subscription form', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'NEWSLETTER', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'id' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Feedburner Link (http://feeds.feedburner.com/wordpress)', 'victor-toolkit' )
			),
			'email' => array(
				'type' => 'text',
				'std' => __( 'Enter your email', 'victor-toolkit' ),
				'label' => __( 'Email field placeholder', 'victor-toolkit' )
			),
			'button' => array(
				'type' => 'text',
				'std' => __( 'Subscribe', 'victor-toolkit' ),
				'label' => __( 'Submit button text', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		if ( $instance['id'] ) {
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content">
				<form action="http://feedburner.google.com/fb/a/mailverify" method="post" class="newsletter-form clearfix">
					<input type="hidden" value="<?php echo esc_attr( $instance['id'] ); ?>" name="uri">
					<div class="input-area">
						<input type="text" onfocus="if (this.value == this.defaultValue)
			                        this.value = '';" onblur="if (this.value == '')
			                                    this.value = this.defaultValue;" name="name" value="<?php echo esc_attr( $instance['email'] ); ?>" class="name" size="40">
						<button class="subscribe" type="submit"><span><?php echo esc_attr( $instance['button'] ); ?></span></button>
					</div>
				</form>
				<div id="newsletter-response"></div>
			</div>
			<?php
			echo $after_widget;
		}
	}

}
