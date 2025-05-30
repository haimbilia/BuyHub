(function ($) {
    var displayInPopup = false;
    $.ykmodal = function (data, popupView = '', dialogClassParm = "", modalClassParm = "", bodyClass = "") {
        modalClass = 'fixed-right ' + modalClassParm;
        var dialogClass = 'modalDialogJs  modal-dialog-vertical ' + dialogClassParm;
        var bodyClass = 'pd-0 ' + bodyClass;

        /* !! is used to convert variable type in to bool. */
        displayInPopup = !!popupView;
        if (true == popupView) {
            modalClass = modalClassParm;
            dialogClass = 'modalDialogJs  modal-dialog-centered ' + dialogClassParm;
        }
        if ($(data).hasClass("loaderJs") && 0 < $("." + $.ykmodal.element + " .loaderContainerJs").length) {
            dialogClass = $('.modalDialogJs').attr('class');
            dialogClass = dialogClass.replace("modal-dialog ", "");
        }

        init(modalClass, dialogClass);
        if (data.ajax) { fillYKModalFromAjax(data.ajax); }
        else if (data.image) { fillYKModalFromImage(data.image); }
        else if (data.div) { fillYKModalFromHref(data.div); }
        else if ($.isFunction(data)) { data.call($); }
        else { $.ykmodal.reveal(data, bodyClass); }
    };

    $.extend($.ykmodal, {
        element: Date.now(),
        reveal: function (data, bodyClass) {
            if ($(data).hasClass("loaderJs") && 0 < $("." + $.ykmodal.element + " .loaderContainerJs").length) {
                $("." + $.ykmodal.element + " .loaderContainerJs").prepend(data);
                return;
            }

            if (0 == $(data).find(".modal-body").length && false === $(data).hasClass("modal-body")) {
                data = '<div class="modal-body">' + data + "</div>";
            }

            var contentBody = "." + $.ykmodal.element + " .contentBodyJs";
            $(contentBody).html(data);
            var headerHtm = '<div class="modal-header">';
            var closeBtnHtm = '<button type="button" class="btn-close ykmodalJs" data-bs-dismiss="modal" aria-label="' + langLbl.close + '"></button>';

            if (1 > $(contentBody).find(".modal-header").length) {
                $(contentBody).prepend(headerHtm + closeBtnHtm + "</div>");
            }
            else if (0 < $(contentBody).find(".modal-header").length && 1 > $("body ." + $.ykmodal.element + " .contentBodyJs .modal-header").find(".close").length) {
                $("body ." + $.ykmodal.element + " .contentBodyJs .modal-header").append(closeBtnHtm);
            }

            if ("undefined" != typeof bodyClass && 0 == $(data).find(bodyClass).length) {
                $(contentBody + " .modal-body").addClass(bodyClass);
            }

            $.ykmodal.show();
        },
        close: function () {
            $("." + $.ykmodal.element).modal("hide");
            return
        },
        show: function () {
            $("." + $.ykmodal.element).modal("show");
            return
        },
        isAdded: function () {
            return (0 < $("." + $.ykmodal.element).length);
        },
        remove: function () {
            $("." + $.ykmodal.element + ', .modal-backdrop').remove();
        },
        isSideBarView: function () {
            return !!$(".fixed-right." + $.ykmodal.element).length;
        },
    });

    function init(modalClass, dialogClass) {
        if (1 > $("body").find("." + $.ykmodal.element).length) {
            var content = '<div class="modal-dialog ' + dialogClass + ' " role="document"><div class="modal-content contentBodyJs"></div></div>';
            var htm = '<div class="modal ' + modalClass + ' fade ' + $.ykmodal.element + '" tabindex="-1" role="dialog">' + content + "</div>";
            $("body").append(htm)
        } else if (true === displayInPopup && true === $("." + $.ykmodal.element).hasClass('fixed-right')) {
            $("." + $.ykmodal.element).removeClass('fixed-right');
        } else if (false === displayInPopup && false === $("." + $.ykmodal.element).hasClass('fixed-right')) {
            $("." + $.ykmodal.element).addClass('fixed-right');
        }

        /* Cannot worked if wider class not sent in case of other tabs data. */
        // $("body ." + $.ykmodal.element + " .modal-dialog").attr('class', 'modal-dialog ' + dialogClass);

        $("body ." + $.ykmodal.element + " .modal-dialog").removeAttr('class').attr('class', 'modal-dialog ' + dialogClass);
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
            $.ykmodal.reveal(data);
        })
    }

    $(document).bind("close.ykmodal", function () {
        $.ykmodal.close()
    });

    $(document).on("hidden.bs.modal", "." + $.ykmodal.element, function () {
        $.ykmodal.close()
    });
    let submitInterval;
    $(document).on("click", ".submitBtnJs", function () {
        if (submitInterval != undefined) {
            clearInterval(submitInterval);
            submitInterval = undefined;
        }
        submitInterval = setTimeout(function () {
            if ($('.' + $.ykmodal.element).hasClass("show")) {
                var form = $('.' + $.ykmodal.element + ' form');                
                if (true === extendEditorJs) {
                    var onSubmit = form.attr('onsubmit');
                    if ('undefined' != typeof onSubmit) {
                        onSubmit = onSubmit.replace("return(false);", "");
                        eval(onSubmit);
                    }
                } else {                   
                    form.submit();
                }
            }
        }, 800);
    });

    /* $('.' + $.ykmodal.element).on("scroll", function () {
        console.log("Scrolling");
    });
    $(document).on("shown.bs.modal", "." + $.ykmodal.element, function () {
        $(this).on("scroll", function () {
        });
    }); */


    /* Submit Form on Enter Key Press. For sidebar forms. */
    $(document).on("keyup", ".modalFormJs, .modalLangFormJs", function (e) {
        if (1 >= $(this).find(':input:not([type=hidden]),select,textarea').length) {
            return;
        }
        e.stopImmediatePropagation();
        if (e.keyCode === 13 && !$(e.target).is('textarea') && (false === displayInPopup)) {
            $('.' + $.ykmodal.element + " .submitBtnJs").click();
        }
    });
})(jQuery);