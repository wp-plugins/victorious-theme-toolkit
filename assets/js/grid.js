(function () {
    tinymce.PluginManager.add('row', function (ed) {
        ed.addButton('row', {
            type: 'splitbutton',
            title: 'Victorious Shortcode',
            icon: 'shortcode',
            menu: [
                {
                    text: 'Missions',
                    icon: 'check',
                    onclick: function () {
                        var string = '[missions][mission]Business program[/mission]<br/>[mission]Business program[/mission]<br/>[mission]Business program[/mission][/missions]';
                        ed.selection.setContent(string);
                    }
                },
            ]
        });
    });
}());