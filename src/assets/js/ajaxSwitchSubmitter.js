;(function ($, window, document, undefined) {
    $('body').on('switchChange.bootstrapSwitch', 'input.bootstrap-switch-ajax', function(event, state) {
        var pk = $(this).data('primary-key'),
            key = $(this).data('key'),
            url = $(this).data('url'),
            attribute = $(this).data('attribute'),
            formName = $(this).data('form-name');

        var data = {};
        data[formName] = {};
        data[formName][pk] = key;
        data[formName][attribute] = state ? 1 : 0;

        jQuery.ajax({
            'type': 'POST',
            'url': $(this).data('url'),
            'data': data
        }).done(function(data) {
            var options = {
                text: data.text
            };

            if (data.success === false) {
                options.type = 'error';
                options.icon = 'fa fa-fw fa-exclamation-triangle';
                $(this).bootstrapSwitch('toggleReadonly');
            } else {
                options.type = 'success';
                options.icon = 'fa fa-fw fa-check-circle';
            }

            hipanel.notify.create(options);
        }.bind(this));
    });
})(jQuery, window, document);
