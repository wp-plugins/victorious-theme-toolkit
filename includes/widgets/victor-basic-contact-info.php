<?php
add_action( 'widgets_init', array( 'Victor_Basic_Contact_Info', 'register_widget' ) );

class Victor_Basic_Contact_Info extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget() {
		register_widget( 'Victor_Basic_Contact_Info' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-basic-contact-info';
		$this->widget_id = 'victorious-basic-contact-info';
		$this->widget_name = __( 'Victorious Basic Contact Info', 'victor-toolkit' );
		$this->widget_description = __( 'Display your basic contact information', 'victor-toolkit' );
		$this->settings = array(
			'address' => array(
				'type' => 'textarea',
				'label' => __( 'Address', 'victor-toolkit' )
			),
			'service' => array(
				'type' => 'text',
				'label' => __( 'Service', 'victor-toolkit' ),
			),
			'phone' => array(
				'type' => 'text',
				'label' => __( 'Phone Number', 'victor-toolkit' ),
			),
			'email' => array(
				'type' => 'text',
				'label' => __( 'Email', 'victor-toolkit' )
			)
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
		if ( $instance['style'] === 's1' ) {
			if ( $instance['address'] ) {
				?>
				<li class="address">
					<img src="<?php echo get_template_directory_uri(); ?>/images/icons/map.png" alt="">
					<i class="fa fa-caret-down"></i>
					<p class="drop-item drop-text"><?php echo wp_kses_post( $instance['address'] ); ?></p>
				</li>
				<?php
			}
			if ( $instance['service'] ) {
				?>
				<li class="service">
					<i class="fa fa-wrench"></i>
					<i class="fa fa-caret-down"></i>
					<p class="drop-item drop-text"><?php echo wp_kses_post( $instance['service'] ); ?></p>
				</li>
				<?php
			}
			if ( $instance['phone'] ) {
				?>
				<li class="phone">
					<i class="fa fa-phone"></i>
					<i class="fa fa-caret-down"></i>
					<p class="drop-item drop-text"><?php echo wp_kses_post( $instance['phone'] ); ?></p>
				</li>    
				<?php
			}
		} else {
			if ( $instance['phone'] ) {
				?>
				<a href="callto:<?php echo esc_attr( $instance['phone'] ); ?>" class="contact-phone"><?php echo wp_kses_post( $instance['phone'] ); ?><span class="fa fa-phone"></span></a>
			<?php
			}
			if ( $instance['email'] ) {
				?>
				<a href="mailto:<?php echo esc_attr( $instance['email'] ); ?>" class="contact-email"><?php echo wp_kses_post( $instance['email'] ); ?><span class="fa fa-envelope-o"></span></a>
				<?php
			}
		}
	}

}
