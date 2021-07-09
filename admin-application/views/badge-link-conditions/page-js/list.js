$(document).ready(function () {
    searchRecords(document.frmSearch);
    bindSellerSelect2();
});

$(document).on('click', '.selectAll-js, .selectItem--js', function () {
    if (0 < $('.selectItem--js:checked').length) {
        $('.deleteSelectedConds--js').removeClass('d-none');
    } else {
        $('.deleteSelectedConds--js').addClass('d-none');
    }
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinkConditions';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        var frm = document.frmSrchPaging;
        searchRecords(frm);
    };

    searchRecords = function (form) {
        $(dv).html(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        $("select[name='blinkcond_user_id']").val("").trigger("change");
        searchRecords(document.frmSearch);
    };

    unlink = function (e, blinkcond_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (blinkcond_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'blinkcond_id=' + blinkcond_id;
        fcom.ajax(fcom.makeUrl(controller, 'badgeUnlink'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                reloadList();
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    deleteSelected = function (e) {
        if (1 > $('.selectItem--js:checked').length) {
            fcom.displayErrorMessage(langLbl.atleastOneRecord);
            return;
        }
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }
        $('.badgesLinksList--js').submit();
    };

    bindSellerSelect2 = function () {
        var selector = $("select[name='blinkcond_user_id']");
        selector.select2({
            // width: 'element',
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: layoutDirection,
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: fcom.makeUrl('Users', 'autoCompleteJson'),
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return {
                        keyword: params.term,
                        user_is_supplier: 1,
                        credential_active: 1,
                        credential_verified: 1,
                    };
                },
                processResults: function (data, params) {
                    return { results: data };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || selector.attr('placeholder');
            }
        });
    }
})()