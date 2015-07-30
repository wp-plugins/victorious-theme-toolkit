<?php
/* ---------------------ACCORDIONS-------------------------- */
add_shortcode( 'accordions', 'victor_shortcode_accordions' );
add_shortcode( 'accordion', '__return_false' );

function victor_shortcode_accordions( $atts, $content = null ) {
	extract( shortcode_atts( array(
					), $atts ) );


	$matches = victor_get_shortcode( $content, true, array( 'accordion' ) );
	$accordions_id = 'accordions-' . mt_rand( 10, 100000 );
	for ( $i = 0; $i < count( $matches ); $i++ ) {

		$accordionid[$i] = 'accordion-' . mt_rand( 10, 100000 ) . '-' . strtolower( str_replace( array( "!", "@", "#", "$", "%", "^", "&", "*", ")", "(", "+", "=", "[", "]", "/", "\\", ";", "{", "}", "|", '"', ":", "<", ">", "?", "~", "`", " " ), "", $matches[$i]['atts']['title'] ) );
	}
	ob_start();
	?>
	<div class="kopa-accordion clearfix">
		<div class="panel-group" id="<?php echo esc_attr( $accordions_id ); ?>">
			<?php
			for ( $i = 0; $i < count( $matches ); $i++ ) {
				$active = '';
				$b_collapse = '+';
				$collapse = 'collapse';
				if ( $i == 0 ) {
					$active = 'active';
					$b_collapse = '-';
					$collapse = 'in';
				}
				?>
				<div class="panel panel-default">
					<div class="panel-heading <?php echo esc_attr( $active ? $active : '' ); ?>">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#<?php echo $accordions_id; ?>" href="#<?php echo $accordionid[$i]; ?>" class="collapsed">
								<?php echo (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : ''); ?>
								<i></i>
							</a>
						</h4>
					</div>
					<div id="<?php echo $accordionid[$i]; ?>" class="panel-collapse <?php echo $collapse ? $collapse : ''; ?>">
						<div class="panel-body">
							<?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	return apply_filters( 'victor_shortcode_accordions', $string, $atts, $content );
}
