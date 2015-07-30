<?php
add_filter( 'kopa_widget_form_field_link_icon', 'victor_toolkit_widget_field_link_icon', 10, 5 );

function victor_toolkit_widget_field_link_icon($html, $wrap_start, $wrap_end, $field, $value){
	ob_start();

	echo $wrap_start;
		
	$value = wp_parse_args((array) $value, array('icon'=> NULL, 'text' => NULL, 'url' => NULL));
	extract($value );	
	?>	
	<label for="<?php echo $field['id']; ?>"><?php echo esc_html( $field['label'] ); ?></label>
	<br/>
	<div class="victor-row">

		<div class="victor-col-xs-5">
			<a class="victor-icon-picker" href="#"><?php _e('select icon', 'victor-toolkit'); ?></a>
			<input type="hidden"
			id="<?php echo $field['id']; ?>" 
			name="<?php printf("%s[icon]", $field['name']);?>" 
			autocomplete="off"
			class="victor-icon-picker-value widefat"
			value="<?php echo esc_attr( $icon ); ?>" />	
			<span class="victor-icon-picker-preview"><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
		</div>

		<div class="victor-col-xs-7">
			<p class="victor-block victor-block-first">
				<input class="widefat" 
				id="<?php echo $field['id']; ?>" 
				name="<?php printf("%s[text]", $field['name']);?>" 
				type="text"
				placeholder="<?php _e('Link text', 'victor-toolkit'); ?>"
				autocomplete="off"
				value="<?php echo esc_attr( $text ); ?>" />		
			</p>
			<p class="victor-block">
				<input class="widefat" 
				id="<?php echo $field['id']; ?>" 
				name="<?php printf("%s[url]", $field['name']);?>" 
				type="url" 
				placeholder="<?php _e('Link URL', 'victor-toolkit'); ?>"
				autocomplete="off"
				value="<?php echo esc_url( $url ); ?>" />	
			</p>
		</div>
	</div>		
	<?php

	echo $wrap_end;

	$html = ob_get_clean();

	return $html;
}