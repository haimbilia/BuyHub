/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "input[type='search']", function () {
    if ("" == $(this).val() && typeof searchRecords === 'function') {
        searchRecords(document.frmRecordSearch);
    }

    var callback = $(this).data('callback');
    if ("" == $(this).val() && typeof callback !== 'undefined') {
        eval(callback);
    }
});
/* -------------------------------------------------- */

$(document).on("click", ".advSrchToggleJs", function () {
    var elm = $('.advSrchBtnJs').find('.submitBtnJs');
    if (elm.prop("disabled")) {
        elm.attr("disabled", false);
    } else {
        elm.attr("disabled", true);
    }
});

$(document).on("click", ".resetModalFormJs", function (e) {
    if ($.ykmodal.isSideBarView()) {
        $.ykmodal(fcom.getLoader());
    }

    var onClear = $(".modalFormJs").data("onclear");
    if ('undefined' != typeof onClear) {
        eval(onClear);
    } else if (0 < $("." + $.ykmodal.element + " .navTabsJs .nav-link").length) {
        $("." + $.ykmodal.element + " .navTabsJs .nav-link.active").click();
    } else {
        $.ykmodal.close();
    }
    fcom.removeLoader();
});

$(document).on("click", ".navTabsJs a", function (e) {
    if ($(this).hasClass('fat-inactive')) {
        return;
    }
    $(this).siblings('a.active').removeClass('active');
    $(this).addClass('active');
});

(function () {
    markPopupTabActive = function () {
        $("." + $.ykmodal.element + " .navTabsJs .nav-link.active").removeClass('active');
        $("." + $.ykmodal.element + " .navTabsJs a[onclick^='" + markPopupTabActive.caller.name + "']").addClass('active').removeClass('fat-inactive');
    }

    checkControllerName = function () {
        if ("undefined" == typeof controllerName || "" == controllerName) {
            fcom.displayErrorMessage(langLbl.controllerNameRequired);
            return false;
        }
        return true;
    };

    clearSearch = function () {
        document.frmRecordSearch.reset();
        $(document.frmRecordSearch.page).val(1);
        searchRecords(document.frmRecordSearch);
    };

    loadMore = function () {
        if (false === checkControllerName()) {
            return false;
        }

        var frm = document.frmLoadMoreRecordsPaging;
        var page = 1;
        if ("undefined" != typeof frm.page.value && "" != frm.page.value && 0 < frm.page.value) {
            page += parseInt(frm.page.value);
        }

        $(frm.page).val(page);
        var reference = $(".appendRowsJs .rowJs:last").data("reference");
        if ("undefined" != typeof reference && "undefined" != typeof frm.reference) {
            $(frm.reference).val(reference);
        }

        var data = fcom.frmData(frm);

        var loadMoreBtn = $('.loadMoreBtnJs');
        var btnText = loadMoreBtn.text();
        loadMoreBtn.html(fcom.getRowSpinner());

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getRows"), data, function (rows) {
            $(".appendRowsJs").append(rows.html);
            loadMoreBtn.html(btnText);

            var similarElement = '.appendRowsJs [data-reference="' + reference + '"]';
            var lastSimilar = $(similarElement + ':last');
            if (1 < $(similarElement).length) {
                var li = lastSimilar.find('.ulJs').html();
                lastSimilar.remove();
                $(similarElement + ':last ul.ulJs').append(li);
            }

            if (page == frm.pageCount.value) {
                $(".loadMorePaginationJs").remove();
            }
        });
    };

    closeForm = function () {
        $.ykmodal.close();
    };

    hideYkModalFooter = function () {
        $('.contentBodyJs .form-edit-foot').hide();
    };

    showYkModalFooter = function () {
        $('.contentBodyJs .form-edit-foot').show();
    };

    /* Fix width of table headings. */
    fixTableColumnWidth = function () {
        if (0 < $('.listingTableJs').length) {
            $('.listingTableJs').each(function () {
                let autoColumnWidth = $(this).attr('data-autoColumnWidth');
                if ('undefined' == typeof autoColumnWidth || 0 < autoColumnWidth || '' == autoColumnWidth) {
                    fixWidth($(this));
                }
            });
        } else {
            let autoTableColumWidth = $('.listingTableJs').data('autoColumnWidth');
            if (1 > autoTableColumWidth) {
                return false;
            }
            fixWidth($('.listingTableJs'));
        }
    }

    fixWidth = function (formObj) {
        var thWidthArr = [];

        $('.tableHeadJs th', formObj).each(function () {
            var arr = {
                'width': $(this).outerWidth(true),
                'element': $(this)
            };
            thWidthArr.push(arr);
        });
        /* Sort By width */
        thWidthArr.sort((a, b) => (a.width > b.width) ? 1 : -1)
        /* Sort By width */

        $.each(thWidthArr, function (index, value) {
            var width = value.width;
            var element = value.element;
            $(element).attr('width', width);
        });
    }

    fixWidthHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    }

    fixPlaceholderStyle = function (e, ui) {
        ui.placeholder.height(ui.item.height());
        ui.placeholder.css("visibility", "visible");
        ui.placeholder.css('background-color', '#f3f6f9');
    }

    validateFileUpload = function (file) {
        if (file.size >= langLbl.allowedFileSize) {
            let msg = langLbl.fileSizeExceeded;
            msg = msg.replace("{size-limit}", bytesToSize(langLbl.allowedFileSize));
            fcom.displayErrorMessage(msg);
            return false;
        }
        return true;
    }
})();

