<?php
add_shortcode( 'pricing_table', 'victor_shortcode_pricing_table' );
add_shortcode( 'pt_caption', '__return_false' );
add_shortcode( 'pt_price', '__return_false' );
add_shortcode( 'pt_featured', '__return_false' );
add_shortcode( 'pt_button', '__return_false' );

function victor_shortcode_pricing_table( $atts, $content ) {
	extract( shortcode_atts( array( 'class' ), $atts ) );
	$caption = victor_get_shortcode( $content, false, array( 'pt_caption' ) );
	$price = victor_get_shortcode( $content, false, array( 'pt_price' ) );
	$featureds = victor_get_shortcode( $content, true, array( 'pt_featured' ) );
	$button = victor_get_shortcode( $content, true, array( 'pt_button' ) );
	ob_start();
	?>
	<ul class="kopa-pricing-table package clearfix <?php echo esc_attr( $atts['class'] ); ?>">
		<?php
		if ( isset( $caption[0] ) ) {
			?>
			<li class="title"><?php echo wp_kses_post( $caption[0]['content'] ); ?></li>
			<?php
		}
		if ( isset( $price[0] ) ) {
			?>
			<li class="price-row">
				<span><?php echo $price[0]['atts']['prefix']; ?></span>
				<p class="price"><?php echo wp_kses_post($price[0]['content']); ?></p>
			<?php } ?>
		</li>
		<?php
		if ( isset( $featureds ) && count( $featureds ) > 0 ) {
			foreach ( $featureds as $featured ) {
				?>
				<li><?php echo wp_kses_post($featured['content']); ?></li>
				<?php
			}
		}
		if ( isset( $button[0] ) ) {
			$target = $button[0]['atts']['target'];
			if ( empty( $target ) ) {
				$target = '_self';
			}
			?>
			<li class="link-row">
				<a href="<?php echo esc_url( $button[0]['atts']['url'] ); ?>" target="<?php echo esc_attr( $target ); ?>" class="kopa-btn dark-blue-btn"><?php echo wp_kses_post( $button[0]['content'] ); ?></a>
			</li>
		<?php } ?>
	</ul>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	return apply_filters( 'victor_shortcode_pricing_table', $string, $atts, $content );
}
