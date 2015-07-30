<?php

add_filter('kopa_admin_meta_box_field_gallery', 'victor_metabox_field_gallery', 10, 5);

function victor_metabox_field_gallery($html, $wrap_start, $wrap_end, $value, $option_value){
    ob_start();

    echo $wrap_start;   
    ?>
    <div class="victor-ui-gallery-wrap">
        <input 
        class="medium-text victor-ui-gallery" 
        type="text" 
        name="<?php echo esc_attr($value['id']);?>" 
        id="<?php echo esc_attr($value['id']);?>" 
        value="<?php echo esc_attr($option_value);?>"         
        autocomplete="off">

        <a title="" href="#" class="victor-ui-gallery-button button button-secondary"><?php _e('Config', 'victor-toolkit'); ?></a>  

    </div>
    <?php
    echo $wrap_end;

    $html = ob_get_clean();

    return $html;
}