<?php
add_action( 'widgets_init', array( 'Victor_Social', 'register_widget' ) );

class Victor_Social extends Kopa_Widget {

	public $kpb_group = 'social';

	public static function register_widget() {
		register_widget( 'Victor_Social' );
	}

	function __construct() {
		$this->widget_cssclass = 'kopa-social-widget';
		$this->widget_id = 'victorious-icon-box';
		$this->widget_name = __( 'Victorious Social Widget', 'victor-toolkit' );
		$this->widget_description = __( 'Display your social links', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Social Profiles', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			),
			'facebook' => array(
				'type' => 'text',
				'label' => __( 'Facebook link', 'victor-toolkit' ),
			),
			'twitter' => array(
				'type' => 'text',
				'label' => __( 'Twitter link', 'victor-toolkit' ),
			),
			'google_plus' => array(
				'type' => 'text',
				'label' => __( 'Google Plus link', 'victor-toolkit' ),
			),
			'linkedin' => array(
				'type' => 'text',
				'label' => __( 'Linkedin link', 'victor-toolkit' ),
			),
			'instagram' => array(
				'type' => 'text',
				'label' => __( 'Instagram link', 'victor-toolkit' ),
			),
			'behance' => array(
				'type' => 'text',
				'label' => __( 'Behance link', 'victor-toolkit' ),
			),
			'rss' => array(
				'type' => 'text',
				'label' => __( 'RSS link (Enter "HIDE" to hide rss)', 'victor-toolkit' ),
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

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		if ( $title && $instance['style'] === 's2' ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		if ( !empty( $instance ) ) {
			?>
			<div class="kopa-social-links s<?php echo esc_attr( $instance['style'] === 's1' ? '2' : '5'  ); ?>">
				<ul class="clearfix">
					<?php
					if ( $instance['facebook'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['facebook'] ? $instance['facebook'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
						<?php
					}
					if ( $instance['twitter'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['twitter'] ? $instance['twitter'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
						<?php
					}
					if ( $instance['google_plus'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['google_plus'] ? $instance['google_plus'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
						<?php
					}
					if ( $instance['linkedin'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['linkedin'] ? $instance['linkedin'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
						<?php
					}
					if ( $instance['instagram'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['instagram'] ? $instance['instagram'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-instagram"></i></a></li>
						<?php
					}
					if ( $instance['rss'] !== 'HIDE' ) {
						?>
						<li><a href="<?php echo esc_url( $instance['rss'] ? $instance['rss'] : bloginfo( 'rss2_url' )  ); ?>" rel="nofollow"><i class="fa fa-rss"></i></a></li>
						<?php
					}
					if ( $instance['behance'] ) {
						?>
						<li><a href="<?php echo esc_url( $instance['behance'] ? $instance['behance'] : '#'  ); ?>" rel="nofollow"><i class="fa fa-behance"></i></a></li>
								<?php
							}
							?>
				</ul>
			</div>
			<?php
		}
		echo $after_widget;
	}

}
