<?php
if ( !class_exists( 'Polylang' ) ) {
	return;
}

add_action( 'widgets_init', array( 'Victor_Languages', 'register_widget' ) );

class Victor_Languages extends Kopa_widget {

	public $kpb_group = 'widgets';

	public static function register_widget() {
		register_widget( 'Victor_Languages' );
	}

	function __construct() {
		$this->widget_name = __( 'Victorious Languages Switcher', 'victor-toolkit' );
		$this->widget_description = __( 'Displays a language switcher ', 'victor-toolkit' );
		$this->settings = array(
			'title' => array(
				'type' => 'text',
				'std' => __( 'Select Language', 'victor-toolkit' ),
				'label' => __( 'Title', 'victor-toolkit' )
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		global $polylang;
		$languages = $polylang->model->get_languages_list();
		if ( sizeof( $languages ) > 0 ) {
			?>
			<li class="language">
				<?php
				if ( $title ) {
					echo '<span>' . wp_kses_post( $title ) . '</span>';
				}
				?>
				<i class="fa fa-caret-down"></i>
				<ul class="drop-item">
					<?php
					foreach ( $languages as $value ) {
						?>
						<li>
							<div class="item-thumb">
								<img src="<?php echo esc_url( $value->flag_url ); ?>" alt="">
							</div>
							<a href="<?php echo esc_url( $value->home_url ); ?>" class="lang"><?php echo esc_html( $value->name ); ?></a>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
				?>
			</li>
			<?php
		}
	}

}
