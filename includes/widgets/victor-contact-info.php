<?php
add_filter( 'kpb_get_widgets_list', array( 'Victor_Contact_Info', 'register_block' ) );

class Victor_Contact_Info extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_block( $blocks ) {
		$blocks['Victor_Contact_Info'] = new Victor_Contact_Info();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-contact-info pt-40';
		$this->widget_id = 'victorious-contact-info';
		$this->widget_name = __( 'Victorious Contact Info', 'victor-toolkit' );
		$this->widget_description = __( 'Display your contact infomartion', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Contact', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'desc' => array(
				'type' => 'textarea',
				'std' => '',
				'label' => __( 'Description', 'victor-toolkit' )
			),
			'contact_phone' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Contact Phone', 'victor-toolkit' )
			),
			'contact_fax' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Contact Fax', 'victor-toolkit' )
			),
			'contact_email' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Contact Email', 'victor-toolkit' )
			),
			'contact_address' => array(
				'type' => 'textarea',
				'std' => '',
				'label' => __( 'Contact Address', 'victor-toolkit' )
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
			<p class="desc"><?php echo wp_kses_post( $instance['desc'] ); ?></p>
			<?php
		}
		if ( $instance['contact_email'] || $instance['contact_phone'] || $instance['contact_fax'] || $instance['contact_address'] ) {
			?>
			<ul class="clearfix">
				<?php if ( $instance['contact_email'] ) { ?>
					<li>
						<p><span><?php echo __( 'Email', 'victor-toolkit' ); ?>: </span><a href="<?php echo esc_attr( $instance['contact_email'] ); ?>"><?php echo wp_kses_post( $instance['contact_email'] ) ?></a></p>
					</li>
					<?php
				}
				if ( $instance['contact_phone'] ) {
					?>
					<li>
						<p><span><?php echo __( 'Phone', 'victor-toolkit' ); ?>: </span><?php echo wp_kses_post( $instance['contact_phone'] ); ?></p>
					</li>
					<?php
				}
				if ( $instance['contact_fax'] ) {
					?>
					<li>
						<p><span><?php echo __( 'Fax', 'victor-toolkit' ); ?>: </span><?php echo wp_kses_post( $instance['contact_fax'] ); ?></p>
					</li>
					<?php
				}
				if ( $instance['contact_address'] ) {
					?>
					<li>
						<p><span><?php echo __( 'Address', 'victor-toolkit' ); ?>: </span><?php echo wp_kses_post( $instance['contact_address'] ); ?></p>
					</li>
				<?php } ?>
			</ul>
			<?php
		}
		echo $after_widget;
	}

}
