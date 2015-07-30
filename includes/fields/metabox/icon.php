<?php
add_filter( 'kopa_admin_meta_box_field_icon', 'victor_toolkit_metabox_field_icon', 10, 5 );

function victor_toolkit_metabox_field_icon($html, $wrap_start, $wrap_end, $field, $value){
    ob_start();

    echo $wrap_start;        
    ?>  
    <div class="victor-row">
        <div class="victor-col-xs-12">
            <a class="victor-icon-picker" href="#"><?php _e('Select Icon', 'victor-toolkit'); ?></a>
            <input type="hidden"
                name="<?php echo esc_attr($field['id']);?>" 
                id="<?php echo esc_attr($field['id']);?>" 
                value="<?php echo esc_attr($value);?>" 
                autocomplete="off"
                class="victor-icon-picker-value widefat"/>
            <span class="victor-icon-picker-preview"><i class="<?php echo esc_attr( $value ); ?>"></i></span>
        </div>
    </div>      
    <?php
    echo $wrap_end;
    $html = ob_get_clean();

    return $html;
}