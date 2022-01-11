(function ($) {
    $.ykmsg = function (fn, msg, closeButton, progressBar, positionClass) {
        setOptions(fn, msg, closeButton, progressBar, positionClass);
    };

    getTimeout = function () {
        return 0 < CONF_AUTO_CLOSE_SYSTEM_MESSAGES ? CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000 : -1;
    };
    
    var autoCloseTimeOut = getTimeout();
    var dir = langLbl.layoutDirection;
    
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
            "timeOut": autoCloseTimeOut, // How long the toast will display without user interaction
            "extendedTimeOut": "60", // How long the toast will display after a user hovers over it
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "rtl": (dir == 'rtl'),
        };
        
        if (undefined != fn && undefined != msg) {
            toastr[fn](msg);
        }
    }

    $.extend($.ykmsg, {
        success: function (message, timeOut = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            setOptions('success', message);
        },
        info: function (message, timeOut = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            setOptions('info', message);
        },
        warning: function (message, timeOut = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            setOptions('warning', message);
        },
        error: function (message, timeOut = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
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