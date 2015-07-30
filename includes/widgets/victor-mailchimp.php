<?php
add_action( 'widgets_init', array( 'Victor_Mailchimp', 'register_widget' ) );

class Victor_Mailchimp extends Kopa_widget {

	public $kpb_group = 'contact';

	public static function register_widget() {
		register_widget( 'Victor_Mailchimp' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-newsletter-widget';
		$this->widget_id = 'victorious-mailchimp-subscribe';
		$this->widget_name = __( 'Victorious Mailchimp Subscribe', 'victor-toolkit' );
		$this->widget_description = __( 'Display mailchimp newsletter subscription form', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'NEWSLETTER', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'form_action' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Mailchimp Form Action', 'victor-toolkit' )
			),
			'popup' => array(
				'type' => 'checkbox',
				'std' => '',
				'label' => __( 'Enable evil popup mode', 'victor-toolkit' )
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
		if ( $instance['form_action'] ) {
			echo $before_widget;
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}
			?>
			<div class="widget-content">
				<form action="<?php esc_url( $instance['form_action'] ); ?>" method="post" class="newsletter-form clearfix <?php echo esc_attr( $instance['popup'] ) ? 'target="_blank"' : ''; ?>">
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
