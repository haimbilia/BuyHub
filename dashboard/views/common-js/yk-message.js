(function ($) {
    $.ykmsg = function (fn, msg, closeButton, progressBar, positionClass) {
        setOptions(fn, msg, closeButton, progressBar, positionClass);
    };

    getTimeout = function () {
        return 0 < CONF_AUTO_CLOSE_SYSTEM_MESSAGES ? CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000 : -1;
    };

    var autoCloseTimeOut = getTimeout();
    var dir = langLbl.layoutDirection;
    var toastExtraClass = 'toast';

    setOptions = function (fn, msg, closeButton = true, progressBar = true, positionClass = 'toast-bottom-center') {
        var hasClassToast = toastExtraClass.indexOf("toast");
        toastExtraClass = (-1 == hasClassToast) ? "toast " + toastExtraClass : toastExtraClass;

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
            "toastClass": toastExtraClass,
        };

        if (undefined != fn && undefined != msg) {
            toastr[fn](msg);
        }
    }

    $.extend($.ykmsg, {
        success: function (message, timeOut = "", toastClass = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            toastExtraClass = "successMsgJs " + toastClass;
            if ($($.parseHTML(message)).hasClass("div_msg")) {
                message = $(message).removeClass('div_msg').get(0);
            }
            setOptions('success', message);
        },
        info: function (message, timeOut = "", toastClass = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            toastExtraClass = "infoMsgJs " + toastClass;
            if ($($.parseHTML(message)).hasClass("div_info")) {
                message = $(message).removeClass('div_info').get(0);
            }
            setOptions('info', message);
        },
        warning: function (message, timeOut = "", toastClass = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            toastExtraClass = "warningMsgJs " + toastClass;
            setOptions('warning', message);
        },
        error: function (message, timeOut = "", toastClass = "") {
            autoCloseTimeOut = ("" == timeOut ? getTimeout() : timeOut);
            toastExtraClass = "errorMsgJs " + toastClass;
            if ($($.parseHTML(message)).hasClass("div_error")) {
                message = $(message).removeClass('div_error').get(0);
            }
            setOptions('error', message);
        },
        close: function () {
            toastr.remove();
        },
        clear: function () {
            toastr.clear();
        }
    });
})(jQuery);

jQuery(function () {
    setOptions();
});