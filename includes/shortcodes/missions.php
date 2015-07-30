<?php
/* ---------------------MISSIONS-------------------------- */
add_shortcode( 'missions', 'victor_shortcode_missions' );
add_shortcode( 'mission', '__return_false' );

function victor_shortcode_missions( $atts, $content ) {
	extract( shortcode_atts( array(
		'style' => '1'
					), $atts ) );
	$missions = victor_get_shortcode( $content, true, array( 'mission' ) );
	ob_start();
	?>
	<ul class="clearfix kopa-mission">
		<?php
		if ( isset( $missions ) && count( $missions ) > 0 ) {
			foreach ( $missions as $mission ) {
				?>
				<li><?php echo wp_kses_post( $mission['content'] ); ?></li>
				<?php
			}
		}
		?>
	</ul>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	return apply_filters( 'victor_shortcode_missions', $string, $atts, $content );
}
