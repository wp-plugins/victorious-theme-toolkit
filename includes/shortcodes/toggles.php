<?php
/* --------------------- TOGGLES -------------------------- */
add_shortcode( 'toggles', 'victor_shortcode_toggles' );
add_shortcode( 'toggle', '__return_false' );

function victor_shortcode_toggles( $atts = array(), $content = NULL ) {
	extract( shortcode_atts( array(), $atts ) );

	$matches = victor_get_shortcode( $content, true, array( 'toggle' ) );

	$toggles_id = 'toggles-' . mt_rand( 10, 100000 );
	for ( $i = 0; $i < count( $matches ); $i++ ) {

		$toggleid[$i] = 'toggle-' . mt_rand( 10, 100000 ) . '-' . strtolower( str_replace( array( "!", "@", "#", "$", "%", "^", "&", "*", ")", "(", "+", "=", "[", "]", "/", "\\", ";", "{", "}", "|", '"', ":", "<", ">", "?", "~", "`", " " ), "", $matches[$i]['atts']['title'] ) );
	}
	ob_start();
	?>
	<div class="kopa-toggle panel-group">
		<?php
		for ( $i = 0; $i < count( $matches ); $i++ ) {
			$active = '';
			$collapse = 'collapse';
			if ( $i == 0 ) {
				$active = 'in';
				$collapse = '';
			}
			?>
			<div class="panel panel-default">
				<div class="panel-heading <?php echo esc_attr( $active ? $active : '' ); ?>">
					<h4 class="panel-title">
						<span class="collapsed"><?php echo (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : ''); ?><i></i></span>
					</h4>
				</div>
				<div id="<?php echo $toggleid[$i]; ?>" class="panel-collapse <?php echo $collapse ? $collapse : ''; ?>">
					<div class="panel-body">
						<?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div><!--/ .kopa-toggle-->
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	return apply_filters( 'victor_shortcode_toggles', $string, $atts, $content );
}
