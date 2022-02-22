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
/* Reset result on clear(cross) icon on keyword search field. */

$(document).on("click", ".resetModalFormJs", function (e) {
    if ($.ykmodal.isSideBarView()) {
        $.ykmodal(fcom.getLoader());
    }

    var onClear = $(".modalFormJs").data("onclear");
    if ('undefined' != typeof onClear) {
        eval(onClear);
    } else if (0 < $("." + $.ykmodal.element + " .navTabsJs .nav-link").length) {
        $("." + $.ykmodal.element + " .navTabsJs .nav-link.active").click();
    }
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
            $.ykmsg.error(langLbl.controllerNameRequired);
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


})();

