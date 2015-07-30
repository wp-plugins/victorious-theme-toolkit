<?php
add_action( 'wp_ajax_victor_toolkit_get_lighbox_icons', 'victor_toolkit_get_lighbox_icons' );

function victor_toolkit_get_lighbox_icons(){
	check_ajax_referer('$P$By.WhgC.styMXTVXajsHThQZgrlsVm1', 'security');
	$icons = victor_toolkit_get_list_of_icon();
	if($icons):
		?>
		<div class="victor-list-of-icon">		
			<div class="victor-row">				
				<input type="text" 
				value="" 
				class="victor-textbox"
				placeholder="<?php _e('Search...', 'victor-toolkit'); ?>" 
				onkeyup="VICTOR_Icon_Picker.filter_icons(event, jQuery(this));">				
			</div>	
			<div class="victor-row victor-wrap">
			<?php foreach($icons as $key => $val): ?>
				<span class="victor-item victor-col-xs-2" onclick="VICTOR_Icon_Picker.select_a_icon(event, jQuery(this));">
					<i class="<?php echo esc_attr($key); ?>" data-title="<?php echo esc_attr($val); ?>"></i>
				</span>
			<?php endforeach;?>
			</div>	
		</div>
		<?php	
	endif;
	exit();
}