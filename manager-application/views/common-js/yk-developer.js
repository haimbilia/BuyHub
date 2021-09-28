$(document).ready(function () {
    if (/ip(hone|od)|ipad/i.test(navigator.userAgent)) {
        $("body").css("cursor", "pointer");
    }
});


(function () {
    var screenHeight = $(window).height() - 100;
    window.onresize = function (event) {
        var screenHeight = $(window).height() - 100;
    };

    $.extend(fcom, {
        scrollToTop: function (obj) {
            if (typeof obj == undefined || obj == null) {
                $('html, body').animate({
                    scrollTop: $('html, body').offset().top - 100
                }, 'slow');
            } else {
                $('html, body').animate({
                    scrollTop: $(obj).offset().top - 100
                }, 'slow');
            }
        },

        resetEditorInstance: function () {
            if (typeof oUtil != 'undefined') {
                var editors = oUtil.arrEditor;
                for (x in editors) {
                    eval('delete window.' + editors[x]);
                }
                oUtil.arrEditor = [];
            }
        },

        resetEditorWidth: function (width = "100%") {
            if (typeof oUtil != 'undefined') {
                (oUtil.arrEditor).forEach(function (input) {
                    var oEdit1 = eval(input);
                    $("#idArea" + oEdit1.oName).attr("width", width);
                });
            }
        },

        setEditorLayout: function (lang_id) {
            var editors = oUtil.arrEditor;
            layout = langLbl['language' + lang_id];
            for (x in editors) {
                var oEdit1 = eval(editors[x]);
                if ($('#idArea' + oEdit1.oName).parents(".layout--rtl").length) {
                    $('#idContent' + editors[x]).contents().find("body").css('direction', layout);
                    $('#idArea' + oEdit1.oName + ' td[dir="ltr"]').attr('dir', layout);
                }
            }
        },

        getLoader: function () {
            $(document.body).css({ 'cursor': 'wait' });
            $('.loaderJs').remove();
            var html = '<div class="table-processing loaderJs"><div class="spinner spinner--sm spinner--brand"></div></div>';
            return html;
        },

        removeLoader: function (cls) {
            $(document.body).css({ 'cursor': 'default' });
            $('.loaderJs').remove();
        },
    });

    clearCache = function () {
        // $(document.body).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Home', 'clear'), '', function (t) {
            window.location.reload();
        });
    };

    quickMenuItemSearch = function (e) {
        var value = e.val().toLowerCase();
        if (value.length < 1) {
            return;
        }
        $(".navMenuItems li").each(function () {
            if ($(this).find('h6').text().toLowerCase().search(value) > -1 || $(this).find('a').text().toLowerCase().search(value) > -1) {
                $(this).show();
                $('.navMenuItems').show();
            } else {
                $(this).hide();
                $('.navMenuItems').show();
            }
        });
    };

})();

$(document).on("search", "#quickSearch", function (e) {
    quickMenuItemSearch($(this));
});

$(document).on("keyup", "#quickSearch", function (e) {
    quickMenuItemSearch($(this));
});

$(window).keydown(function (e) {
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) {
        if (!$('#quickSearchCtrl').is(':checked')) {
            $(".quickSearchMain").trigger('click');
            e.preventDefault();
        }
    }
});