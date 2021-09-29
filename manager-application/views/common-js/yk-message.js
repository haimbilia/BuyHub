(function ($) {
    $.ykmsg = function (fn, msg, closeButton, progressBar, positionClass) {
        setOptions(fn, msg, closeButton, progressBar, positionClass);
    };

    setOptions = function (fn, msg, closeButton = true, progressBar = true, positionClass = 'toast-top-right') {
        toastr.options = {
            "closeButton": closeButton,
            "debug": false,
            "newestOnTop": true,
            "progressBar": progressBar,
            "positionClass": positionClass,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
        };

        if (undefined != fn && undefined != msg) {
            toastr[fn](msg);
        }
    }

    $.extend($.ykmsg, {
        success: function (message) {
            setOptions('success', message);
        },
        info: function (message) {
            setOptions('info', message);
        },
        warning: function (message) {
            setOptions('warning', message);
        },
        error: function (message) {
            setOptions('error', message);
        },
        close: function () {
            toastr.clear();
        }
    });
})(jQuery);

$(document).ready(function () {
    setOptions();
});