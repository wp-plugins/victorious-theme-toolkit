<?php
add_filter( 'kopa_widget_form_field_icon', 'victor_toolkit_widget_field_icon', 10, 5 );

function victor_toolkit_widget_field_icon($html, $wrap_start, $wrap_end, $field, $value){
	ob_start();

	echo $wrap_start;		
	?>	
	<label for="<?php echo $field['id']; ?>"><?php echo esc_html( $field['label'] ); ?></label>
	<br/>
	<div class="victor-row">
		<div class="victor-col-xs-12">
			<a class="victor-icon-picker" href="#"><?php _e('select icon', 'victor-toolkit'); ?></a>
			<input type="hidden"
			id="<?php echo $field['id']; ?>" 
			name="<?php echo $field['name']; ?>" 
			autocomplete="off"
			class="victor-icon-picker-value widefat"
			value="<?php echo esc_attr( $value ); ?>" />	
			<span class="victor-icon-picker-preview"><i class="<?php echo esc_attr( $value ); ?>"></i></span>
		</div>
	</div>		
	<?php

	echo $wrap_end;

	$html = ob_get_clean();

	return $html;
}

