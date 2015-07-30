<?php
if ( !class_exists( 'Victor_Service' ) ) {
	return;
}

add_filter( 'kpb_get_widgets_list', array( 'Victor_Service_Stat_Widget', 'register_block' ) );

class Victor_Service_Stat_Widget extends Kopa_Widget {

	public $kpb_group = 'service';

	public static function register_block( $blocks ) {
		$blocks['Victor_Service_Stat_Widget'] = new Victor_Service_Stat_Widget();
		return $blocks;
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-service3-widget mb-40"';
		$this->widget_id = 'victorious-service-statistics-widget';
		$this->widget_name = __( 'Victorious Service Statistics', 'victor-toolkit' );
		$this->widget_description = __( 'Display statistics about service', 'victor-toolkit' );

		$this->settings = array(
			'office' => array(
				'type' => 'number',
				'std' => 56,
				'label' => __( 'Office World Wide', 'victor-toolkit' ),
				'min' => 1
			),
			'employees' => array(
				'type' => 'number',
				'std' => 4273,
				'label' => __( 'Employees', 'victor-toolkit' ),
				'min' => 1
			),
			'tons' => array(
				'type' => 'number',
				'std' => 680000,
				'label' => __( 'Tons of air freight every year', 'victor-toolkit' ),
				'min' => 1
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		if ( $instance['office'] || $instance['employees'] || $instance['tons'] ) {
			echo $before_widget;
			?>
			<ul>
				<?php
				if ( $instance['office'] ) {
					?>
					<li>
						<div class="service-icon"><span class="fa fa-map-marker"></span></div>
						<div class="service-content">
							<p class="number"><?php echo wp_kses_post( $instance['office'] ); ?></p>
							<p class="desc"><?php echo __( 'OFFICES WORLD WIDE', 'victor-toolkit' ); ?></p>
						</div>
					</li>
					<?php
				}
				if ( $instance['employees'] ) {
					?>
					<li>
						<div class="service-icon"><span class="fa fa-users"></span></div>
						<div class="service-content">
							<p class="number"><?php echo wp_kses_post( $instance['employees'] ); ?></p>
							<p class="desc"><?php echo __( 'Employees', 'victor-toolkit' ); ?></p>
						</div>
					</li>
					<?php
				}
				if ( $instance['tons'] ) {
					?>
					<li>
						<div class="service-icon"><span class="fa fa-space-shuttle"></span></div>
						<div class="service-content">
							<p class="number"><?php echo wp_kses_post( $instance['tons'] ); ?></p>
							<p class="desc"><?php echo __( 'TONS OF AIR FREIGHT EVERY YEAR', 'victor-toolkit' ); ?></p>
						</div>
					</li>
				<?php } ?>
			</ul>
			<?php
			echo $after_widget;
		}
	}

}
