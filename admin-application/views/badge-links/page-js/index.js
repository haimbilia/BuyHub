$(document).ready(function () {
    searchRecords(document.frmSearch);
});

$(document).on('change', '.addUpdateForm--js select[name="badgelink_condition_type"]', function () {
    if ('' == $(this).val()) {
        return;
    }

    var selector = $('input[name="badgelink_condition_from"], input[name="badgelink_condition_to"]');
    if (COND_TYPE_DATE == $(this).val()) {
        selector.attr('readonly', 'readonly').datetimepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd'
        });
    } else {
        selector.removeAttr('readonly').datetimepicker("destroy");
    }
});

$(document).on('change', '.addUpdateForm--js select[name="badgelink_record_type"]', function () {
    var recordNameSelector = $(".addUpdateForm--js select[name='record_name']");
    if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
    $(".addUpdateForm--js select[name='record_name']").val('').trigger('change');
});

$(document).on('change', '.addUpdateForm--js select[name="badge_type"]', function () {
    var label = $('.addUpdateForm--js select[name="badge_name"]').closest('.field-set').find('label');
    var badgeTypeText = $(".addUpdateForm--js select[name='badge_type'] option:selected").text();
    var htm = '<span class="badgeTypeText--js">' + badgeTypeText + '</span>';
    if (0 < $('.addUpdateForm--js .badgeTypeText--js').length) {
        $('.addUpdateForm--js .badgeTypeText--js').replaceWith(htm);
    } else {
        label.prepend(htm + " ");
    }
});

$(document).on('change', '.addUpdateForm--js select[name="record_condition"]', function () {
    var recordCondition = $(this).val();
    /* 
        1 : Automatically 
        2 : Manually 
    */
    var recordNameSelector = $('select[name="record_name"]');
    var parent = recordNameSelector.closest('.field-set').parent();
    if (1 == recordCondition) {
        var requirement = { required: false };
        parent.hide();
    } else {
        var requirement = { required: true };
        parent.fadeIn();
    }
    recordNameSelector.attr('data-fatreq', JSON.stringify(requirement));
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

    form = function (badgelink_id, recordType = 0) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badgelink_id, recordType]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
            bindBadgeNameSelect2();
            bindRecordsSelect2();

            if (0 < badgelink_id) {
                $('.addUpdateForm--js select[name="badgelink_condition_type"]').change();
                $(".addUpdateForm--js input[name='badgelink_record_ids']").val(JSON.stringify($(".addUpdateForm--js select[name='record_name']").val()));
            }
            $('.addUpdateForm--js select[name="badge_type"], .addUpdateForm--js select[name="record_condition"]').change();
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
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
            // form(t.badgelink_id, t.recordType);
            backToListing();
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
                reloadList();
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    bulkBadgesUnlink = function (e) {
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

    bindBadgeNameSelect2 = function () {
        var selector = $("select[name='badge_name']");
        selector.select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: function () {
                    return fcom.makeUrl('Badges', 'autoComplete', [$('.addUpdateForm--js select[name="badge_type"]').val()]);
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
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
        var searchSelector = $(".addUpdateForm--js select[name='record_name']").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
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
        var selector = $("select[name='record_name']");
        selector.select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: selector.attr('placeholder'),
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
            var JSONObj = [e.params.args.data.id];

            var badgeLinkRecordIds = $(".addUpdateForm--js input[name='badgelink_record_ids']").val();
            if ('' != badgeLinkRecordIds) {
                JSONObj = JSON.parse(badgeLinkRecordIds);
                JSONObj.push(e.params.args.data.id);
            }
            $(".addUpdateForm--js input[name='badgelink_record_ids']").val(JSON.stringify(JSONObj));
        }).on('select2:unselect', function (e) {
            $(".addUpdateForm--js input[name='badgelink_record_ids']").val(JSON.stringify($(".addUpdateForm--js select[name='record_name']").val()));
        });
    }
})()