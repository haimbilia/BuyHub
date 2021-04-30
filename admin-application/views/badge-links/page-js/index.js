$(document).ready(function () {
    searchRecords(document.frmSearch);
});

$(document).on('change', '.addUpdateForm--js select[name="badgelink_condition_type"]', function () {
    var selector = $('input[name="badgelink_condition_from"], input[name="badgelink_condition_to"]');
    if (CONDITION_TYPE_DATE == $(this).val()) {
        selector.attr('readonly', 'readonly').datetimepicker({minDate: new Date()});
    } else {
        selector.removeAttr('readonly').datetimepicker("destroy");
    }
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinks';

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

    form = function (badgelink_id, type) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badgelink_id, type]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
            bindBadgeNameSelect2();
            bindRecordsSelect2();
        });
    };

    backToListing = function () {
        $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn();
    }

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            reloadList();
            form(t.badgelink_id, t.badge_type);
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    unlink = function (e, badgelink_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (badgelink_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badgelink_id=' + badgelink_id;
        fcom.ajax(fcom.makeUrl(controller, 'badgeUnlink'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    bulkBadgesUnlink = function (e, badgelink_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (badgelink_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badgelink_id=' + badgelink_id;
        fcom.ajax(fcom.makeUrl(controller, 'badgeUnlink'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    bulkBadgesUnlink = function () {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }
        $(element).submit();
    };

    bindBadgeNameSelect2 = function () {
        $("select[name='badge_name']").select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: $("select[name='badge_name']").attr('placeholder'),
            ajax: {
                url: fcom.makeUrl('Badges', 'autoComplete'),
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
                    console.log(data.badges);
                    return { results: data.badges };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            $(".addUpdateForm--js input[name='badgelink_badge_id']").val(e.params.args.data.id);

        }).on('select2:unselecting', function (e) {
            $(".addUpdateForm--js input[name='badgelink_badge_id']").val("");
        });
    }

    getRecordTypeURL = function () {
        var recordType = $('.addUpdateForm--js select[name="badgelink_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('SellerProducts', 'autoCompleteProducts');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Shops', 'autoComplete');
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $('.addUpdateForm--js select[name="badgelink_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType || RECORD_TYPE_SHOP == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.products;
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        $("select[name='record_name']").select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: $("select[name='record_name']").attr('placeholder'),
            ajax: {
                url: function () {
                    return getRecordTypeURL()
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
                    return { results: getRecordData(data) };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            $("input[name='badgelink_record_id']").val(e.params.args.data.id);

        }).on('select2:unselecting', function (e) {
            $("input[name='badgelink_record_id']").val("");
        });
    }
})()
