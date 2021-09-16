(function ($) {
    $.ykmodal = function (data, klass, bodyClass) {
        if (0 < $(".modal").length) {
            $(".modal, .modal-backdrop").remove()
        }
        init(klass);
        if (data.ajax) fillYKModalFromAjax(data.ajax);
        else if (data.image) fillYKModalFromImage(data.image);
        else if (data.div) fillYKModalFromHref(data.div);
        else if ($.isFunction(data)) data.call($);
        else $.ykmodal.reveal(data, bodyClass)
    };

    $.extend($.ykmodal, {
        element: Date.now(),
        reveal: function (data, bodyClass) {
            var isLoader = $(data).hasClass("circularLoader");
            
            if (0 == $(data).find(".modal-body").length && false === $(data).hasClass("modal-body")) {
                data = '<div class="modal-body">' + data + "</div>"
            }

            var contentBody = "body ." + $.ykmodal.element + " .contentBody--js";
            $(contentBody).html(data);
            var headerHtm = '<div class="modal-header">';
            var closeBtnHtm = '<button type="button" class="close" data-dismiss="modal" aria-label="' + langLbl.close + '"><span aria-hidden="true">×</span></button>';

            if (1 > $(contentBody).find(".modal-header").length && false === isLoader) {
                $(contentBody).prepend(headerHtm + closeBtnHtm + "</div>")
            }
            else if (0 < $(contentBody).find(".modal-header").length && 1 > $("body ." + $.ykmodal.element + " .contentBody--js .modal-header").find(".close").length) {
                $("body ." + $.ykmodal.element + " .contentBody--js .modal-header").append(closeBtnHtm)
            }

            if ("undefined" != typeof bodyClass && 0 == $(data).find(bodyClass).length) {
                $(contentBody + " .modal-body").addClass(bodyClass)
            }
            $.ykmodal.show()
        },
        close: function () {
            $("." + $.ykmodal.element).modal("hide");
            return
        },
        show: function () {
            $("." + $.ykmodal.element).modal("show");
            return
        },
    });

    function init(klass) {
        klass = "undefined" == typeof klass ? "" : klass;
        if (1 > $("body").find("." + $.ykmodal.element).length) {
            var content = '<div class="modal-dialog modal-dialog-centered ' + klass + ' " role="document"><div class="modal-content contentBody--js"></div></div>';
            var htm = '<div class="modal fade ' + $.ykmodal.element + '" tabindex="-1" role="dialog">' + content + "</div>";
            $("body").append(htm)
        }

        if (!$("body ." + $.ykmodal.element + " .modal-dialog").hasClass(klass)) {
            $("body ." + $.ykmodal.element + " .modal-dialog").addClass(klass)
        }
    }

    function fillYKModalFromHref(href) {
        if (href.match(/#/)) {
            var url = window.location.href.split("#")[0];
            var target = href.replace(url, "");
            if (target == "#") return;
            $.ykmodal.reveal($(target).html())
        }
        else if (href.match($.ykmodal.settings.imageTypesRegexp)) {
            fillYKModalFromImage(href)
        }
        else {
            fillYKModalFromAjax(href)
        }
    }

    function fillYKModalFromImage(href) {
        var image = new Image();
        image.onload = function () {
            $.ykmodal.reveal('<div class="image"><img src="' + image.src + '" /></div>')
        };
        image.src = href
    }

    function fillYKModalFromAjax(href) {
        $.ykmodal.jqxhr = $.get(href, function (data) {
            $.ykmodal.reveal(data)
        })
    }

    $(document).bind("close.ykmodal", function () {
        $.ykmodal.close()
    });

    $(document).on("hidden.bs.modal", "." + $.ykmodal.element, function () {
        $.ykmodal.close()
    })
})(jQuery);