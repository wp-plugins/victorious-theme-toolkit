var VICTOR_Icon_Picker, victor_lighbox_icons_id;

victor_lighbox_icons_id = '#victor_lighbox_icons';

jQuery(document).ready(function($) {
  VICTOR_Icon_Picker.init();
});

jQuery(document).ajaxSuccess(function(event, xhr, settings) {
  VICTOR_Icon_Picker.init();
});

jQuery(window).load(function($) {});

VICTOR_Icon_Picker = {
  init: function() {
    if (jQuery('.victor-icon-picker').length > 0) {
      jQuery('.victor-icon-picker').click(function(event) {
        var btn;
        event.preventDefault();
        btn = jQuery(this);
        if (jQuery(victor_lighbox_icons_id).length !== 1) {
          jQuery('body').append('<div id="victor_lighbox_icons" class="victor-hide"></div>');
          jQuery.ajax({
            beforeSend: function(jqXHR) {},
            success: function(data, textStatus, jqXHR) {
              jQuery(victor_lighbox_icons_id).html(data);
            },
            complete: function() {
              VICTOR_Icon_Picker.open_lighbox(btn);
            },
            url: victor_toolkit.ajax.url.get_lighbox_icons,
            dataType: "html",
            type: 'GET',
            async: false,
            data: {
              action: 'victor_toolkit_get_lighbox_icons'
            }
          });
        } else {
          VICTOR_Icon_Picker.open_lighbox(btn);
        }
      });
    }
  },
  open_lighbox: function(btn) {
    jQuery(victor_lighbox_icons_id).dialog({
      width: 360,
      height: 480,
      modal: true,
      title: victor_toolkit.i18n.icon_picker,
      buttons: {
        "OK": function() {
          var icon;
          icon = VICTOR_Icon_Picker.click_ok();
          btn.parent().find('.victor-icon-picker-value').val(icon);
          btn.parent().find('.victor-icon-picker-preview i').attr('class', icon);
        },
        "cancel": function() {
          jQuery(victor_lighbox_icons_id).dialog('close');
        }
      }
    });
  },
  click_ok: function() {
    var icon;
    icon = jQuery(victor_lighbox_icons_id).find('.victor-item.victor-active i').attr('class');
    jQuery(victor_lighbox_icons_id).dialog('close');
    return icon;
  },
  select_a_icon: function(event, obj) {
    event.preventDefault();
    obj.parents('.victor-wrap').find('.victor-item').removeClass('victor-active');
    obj.addClass('victor-active');
  },
  filter_icons: function(event, obj) {
    var filter, regex, wrap;
    event.preventDefault();
    wrap = obj.parents('.victor-list-of-icon');
    filter = obj.val();
    if (!filter) {
      wrap.find('.victor-item').show();
      return false;
    }
    regex = new RegExp(filter, "i");
    wrap.find('.victor-item i').each(function(index, element) {
      if (jQuery(this).data('title').search(regex) < 0) {
        jQuery(this).parent().hide();
      } else {
        jQuery(this).parent().show();
      }
    });
  }
};
