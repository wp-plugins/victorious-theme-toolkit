var victorious_Toolkit, victor_gallery, victor_gallery_button, victor_icon_field;

jQuery(document).ready(function() {
  victorious_Toolkit.init_field_datetime();
  victorious_Toolkit.init_field_gallery();
});

jQuery(document).ajaxSuccess(function() {
  victorious_Toolkit.init_field_datetime();
  victorious_Toolkit.init_field_gallery();
});

victor_icon_field = '';

victor_gallery = '';

victor_gallery_button = '';

victorious_Toolkit = {
  init_field_gallery: function() {
    jQuery('.victor-ui-gallery-wrap').on('click', '.victor-ui-gallery-button', function(event) {
      event.preventDefault();
      victor_gallery_button = jQuery(this);
      if (victor_gallery) {
        victor_gallery.open();
        return;
      }
      victor_gallery = wp.media.frames.victor_gallery = wp.media({
        title: 'Gallery config',
        button: {
          text: 'Use'
        },
        library: {
          type: 'image'
        },
        multiple: true
      });
      victor_gallery.on('open', function() {
        var ids, selection;
        ids = victor_gallery_button.parents('.victor-ui-gallery-wrap').find('input.victor-ui-gallery').val();
        if ('' !== ids) {
          selection = victor_gallery.state().get('selection');
          ids = ids.split(',');
          jQuery(ids).each(function(index, element) {
            var attachment;
            attachment = wp.media.attachment(element);
            attachment.fetch();
            selection.add(attachment ? [attachment] : []);
          });
        }
      });
      victor_gallery.on('select', function() {
        var result, selection;
        result = [];
        selection = victor_gallery.state().get('selection');
        selection.map(function(attachment) {
          attachment = attachment.toJSON();
          return result.push(attachment.id);
        });
        if (result.length > 0) {
          result = result.join(',');
          victor_gallery_button.parents('.victor-ui-gallery-wrap').find('input.victor-ui-gallery').val(result);
        }
      });
      victor_gallery.open();
    });
  },
  select_icon: function(event, obj, icon) {
    event.preventDefault();
    victor_icon_field.val(icon);
    window.tb_remove();
  },
  open_icons: function(event, obj) {
    event.preventDefault();
    window.tb_show(obj.attr('title'), obj.attr('href'), '');
    victor_icon_field = obj.parent().find('.victor-icon');
  },
  filter_icons: function(event, obj) {
    var filter, regex;
    event.preventDefault();
    filter = obj.val();
    if (!filter) {
      jQuery("#victor-list-icon .victor-ui-icon-item").show();
      return false;
    }
    regex = new RegExp(filter, "i");
    jQuery("#victor-list-icon .victor-ui-icon-item span").each(function(index, element) {
      if (jQuery(this).text().search(regex) < 0) {
        jQuery(this).parents('.victor-ui-icon-item').hide();
      } else {
        jQuery(this).parents('.victor-ui-icon-item').show();
      }
    });
  },
  remove_icon: function(event, obj) {
    event.preventDefault();
    obj.parent().find('.victor-icon').val('');
  },
  init_field_datetime: function() {
    if (jQuery('.victor-datetime').length > 0) {
      jQuery('.victor-datetime').each(function(index, element) {
        jQuery(element).datetimepicker({
          lang: 'en',
          timepicker: jQuery(element).data('timepicker'),
          datepicker: jQuery(element).data('datepicker'),
          format: jQuery(element).data('format'),
          i18n: {
            en: {
              months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
              dayOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
            }
          }
        });
      });
    }
  }
};
