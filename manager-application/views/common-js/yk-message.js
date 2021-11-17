(function ($) {
    $.ykmsg = function (fn, msg, closeButton, progressBar, positionClass) {
        setOptions(fn, msg, closeButton, progressBar, positionClass);
    };

    var autoCloseTimeOut = "5000";

    setOptions = function (fn, msg, closeButton = true, progressBar = true, positionClass = 'toast-bottom-center') {
        toastr.options = {
            "closeButton": closeButton,
            "debug": false,
            "newestOnTop": true,
            "progressBar": progressBar,
            "positionClass": positionClass,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": autoCloseTimeOut,
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
        success: function (message, timeOut = "5000") {
            autoCloseTimeOut = timeOut;
            setOptions('success', message);
        },
        info: function (message, timeOut = "5000") {
            autoCloseTimeOut = timeOut;
            setOptions('info', message);
        },
        warning: function (message, timeOut = "5000") {
            autoCloseTimeOut = timeOut;
            setOptions('warning', message);
        },
        error: function (message, timeOut = "5000") {
            autoCloseTimeOut = timeOut;
            setOptions('error', message);
        },
        close: function () {
            $('.toast').remove();
            toastr.clear();
        }
    });
})(jQuery);

jQuery(function () {
    setOptions();
});