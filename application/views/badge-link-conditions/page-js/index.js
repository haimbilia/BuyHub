$(document).ready(function () {
    searchRecords(document.frmSearch);
});

var formClass = '.addUpdateForm--js ';

$(document).on('change', formClass + 'select[name="blinkcond_condition_type"]', function () {
    if ("" == $(this).val() && REC_COND_AUTO == $(formClass + ".recCond--js").val()) {
        $(this).val(COND_TYPE_AVG_RATING_SELPROD).trigger('change');
        return;
    }

    var selector = $(formClass + 'input[name="blinkcond_condition_from"], ' + formClass + 'input[name="blinkcond_condition_to"]');

    var ratePercElements = [COND_TYPE_RETURN_ACCEPTANCE, COND_TYPE_ORDER_CANCELLED];
    var toSelector = $(formClass + 'input[name="blinkcond_condition_to"]');
    var fromSelector = $(formClass + 'input[name="blinkcond_condition_from"]');
    $(fromSelector).closest('.field-set').show();
    $(toSelector).closest('.field-set').show();

    toSelector.attr('data-fatreq', JSON.stringify({ required: true }));
    if (1 > toSelector.closest('.field-set').find('label').children('.spn_must_field').length) {
        toSelector.closest('.field-set').find('label').append('<span class="spn_must_field">*</span>');
    }
    var htm = '<label class="field_label">' + langLbl.from + '<span class="spn_must_field">*</span></label>';
    fromSelector.closest('.field-set').find('label').replaceWith(htm);

    selector.closest('.field-set').parent().fadeIn().removeClass("col-md-6");

    if ('' == $(this).val()) {
        $(fromSelector).closest('.field-set').hide();
        $(toSelector).closest('.field-set').hide();
        return false;
    }

    if (-1 < jQuery.inArray(parseInt($(this).val()), ratePercElements)) {
        fromSelector.closest('.field-set').parent().addClass("col-md-6");
        toSelector.val('').closest('.field-set').parent().hide();
        toSelector.attr('data-fatreq', JSON.stringify({ required: false }));
        var htm = '<label class="field_label">' + langLbl.rate + '<span class="spn_must_field">*</span></label>';
        fromSelector.closest('.field-set').find('label').replaceWith(htm);
    }
});

$(document).on('change', formClass + 'select[name="blinkcond_record_type"]', function () {
    if ("" == $(this).val() && REC_COND_MANUAL == $(formClass + ".recCond--js").val()) {
        $(this).val(RECORD_TYPE_SELLER_PRODUCT);
        return;
    }
    var recordNameSelector = $(formClass + "select.recordIds--js");
    if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
    $(formClass + "select.recordIds--js").val('').trigger('change');
});

$(document).on('change', '.formSearch--js select[name="badge_type"]', function () {
    var selectors = $(".formSearch--js select[name='record_condition'], .formSearch--js select[name='blinkcond_condition_type']");
    if (TYPE_RIBBON == $(this).val()) {
        selectors.val("").attr('disabled', 'disabled');
        return;
    }
    selectors.removeAttr('disabled');
});

$(document).on('change', formClass + '.recCond--js', function () {
    var recordCondition = $(this).val();
    var recordNameSelector = $(formClass + 'select.recordIds--js');
    var parent = recordNameSelector.closest('.field-set').parent();

    var conditionSelectors = $(formClass + 'select[name="blinkcond_condition_type"], ' + formClass + 'input[name="blinkcond_condition_from"], ' + formClass + 'input[name="blinkcond_condition_to"]');
    if (REC_COND_AUTO == recordCondition) {
        parent.hide();
        recordNameSelector.val("").trigger('change');
        $(formClass + '.conditionType--js').fadeIn();
        $(formClass + '.linkType--js, ' + formClass + '.position--js').hide();
        $(formClass + 'select[name="blinkcond_record_type"]').val("");
        $(formClass + 'select[name="blinkcond_condition_type"]').val(COND_TYPE_AVG_RATING_SELPROD).trigger('change');
        conditionSelectors.attr('data-fatreq', JSON.stringify({ required: true }));
    } else {
        parent.fadeIn();
        conditionSelectors.val("").trigger('change');
        $(formClass + '.conditionType--js').hide();
        $(formClass + '.linkType--js, ' + formClass + '.position--js').fadeIn();
        $(formClass + 'select[name="blinkcond_condition_type"]').val("");
        $(formClass + 'select[name="blinkcond_record_type"]').val(RECORD_TYPE_SELLER_PRODUCT);
        conditionSelectors.attr('data-fatreq', JSON.stringify({ required: false }));
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

    badgeForm = function (blinkcond_id) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_BADGE, blinkcond_id]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);

            bindBadgeNameSelect2();
            bindRecordsSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_AUTO) {
                $(formClass + 'select[name="blinkcond_condition_type"]').change();
                var recordNameSelector = $(formClass + 'select.recordIds--js');
                recordNameSelector.closest('.field-set').parent().hide();
                $(formClass + '.linkType--js').hide();
            } else {
                $(formClass + ".conditionType--js").hide();
                $(formClass + 'select[name="blinkcond_record_type"]').trigger('change');

                var conditionSelectors = $(formClass + 'select[name="blinkcond_condition_type"], ' + formClass + 'input[name="blinkcond_condition_from"], ' + formClass + 'input[name="blinkcond_condition_to"]');
                conditionSelectors.attr('data-fatreq', JSON.stringify({ required: false }));
            }
            
            $(formClass + 'input[name="blinkcond_from_date"], ' + formClass + 'input[name="blinkcond_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
            reloadRecordsList(blinkcond_id);

            updateRecordIds();
        });
    };

    ribbonForm = function (blinkcond_id) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_RIBBON, blinkcond_id]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);

            bindBadgeNameSelect2();
            bindRecordsSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_MANUAL) {
                $(formClass + 'select[name="blinkcond_record_type"]').trigger('change');
            }
            
            $(formClass + 'input[name="blinkcond_from_date"], ' + formClass + 'input[name="blinkcond_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
            reloadRecordsList(blinkcond_id);

            updateRecordIds();
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
            // form(t.blinkcond_id, t.recordType);
            backToListing();
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
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
                    return fcom.makeUrl('Badges', 'autoComplete', [$(formClass + 'input[name="badge_type"]').val()]);
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
            $(formClass + "input[name='blinkcond_badge_id']").val(e.params.args.data.id);

        }).on('select2:unselecting', function (e) {
            $(formClass + "input[name='blinkcond_badge_id']").val("");
        });
    }

    getRecordTypeURL = function () {
        var searchSelector = $(formClass + "select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $(formClass + 'select[name="blinkcond_record_type"]').val();
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
        var recordType = $(formClass + 'select[name="blinkcond_record_type"]').val();
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
        var selector = $(formClass + "select.recordIds--js");
        selector.select2({
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: layoutDirection,
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
            var badgeType = $(formClass + 'input[name="badge_type"]').val();
            var recordType = $(formClass + 'select[name="blinkcond_record_type"]').val();
            var position = 0;
            if (0 < $(formClass + 'select[name="blinkcond_position"]').length) {
                position = $(formClass + 'select[name="blinkcond_position"]').val();
            }
            fcom.ajax(fcom.makeUrl(controller, 'isUnique', [badgeType, recordType, e.params.args.data.id, position]), '', function (t) {
                var resp = JSON.parse(t);
                if (1 > resp.status) {
                    selector.val('').trigger('change');
                    $.systemMessage(resp.msg, 'alert--danger');
                    return false;
                }

                var JSONObj = [e.params.args.data.id];
                var badgeLinkRecordIds = $(formClass + "input[name='record_ids']").val();
                if ('' != badgeLinkRecordIds) {
                    JSONObj = JSON.parse(badgeLinkRecordIds);
                    JSONObj.push(e.params.args.data.id);
                }
                $(formClass + "input[name='record_ids']").val(JSON.stringify(JSONObj));
                setTimeout(function () {
                    selector.val('').trigger('change');
                }, 200);
                var badgeLinkCondId = $(formClass + "input[name='blinkcond_id']").val();
                if ('' != badgeLinkCondId) {
                    bindLink(badgeType, badgeLinkCondId, e.params.args.data.id, position);
                } else {
                    var htm = '<tr><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="icon ion-close"></i></a></id><td>' + e.params.args.data.name + '</td></tr>';
                    var tbl = "";
                    if (1 > $(formClass + 'table.recordListing--js').length) {
                        var tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody></tbody></table>';
                        $(formClass + '.recordsContainer--js').html(tbl);
                    }
                    $(formClass + '.recordListing--js').append(htm);
                }
                $(formClass + "select[name='blinkcond_record_type']").attr('disabled', 'disabled');
            });
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        });
    }

    reloadRecordsList = function (blinkcond_id, page) {
        $(".recordsContainer--js").html(fcom.getLoader());
        var data = 'page=' + page;
        fcom.ajax(fcom.makeUrl(controller, 'records', [blinkcond_id]), data, function (t) {
            $(".recordsContainer--js").html(t);
        });
    };

    removeBadgeLinkRecord = function (e, blinkcond_id, recordId) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (blinkcond_id < 1 || recordId < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        updateRecordIds(recordId);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'unlinkRecord', [blinkcond_id, recordId]), '', function (t) {
            reloadRecordsList(blinkcond_id);
        });
    }

    bindLink = function (badgeType, blinkcond_id, recordId, position) {
        fcom.updateWithAjax(fcom.makeUrl(controller, 'linkRecord', [badgeType, blinkcond_id, recordId, position]), '', function (t) {
            reloadRecordsList(blinkcond_id);
        });
    }

    updateRecordIds = function (removeRecordId = 0) {
        var selectedRecords = $(formClass + "input[name='record_ids']").val();
        if ('' != selectedRecords && 'undefined' != typeof selectedRecords) {
            selectedRecords = $.parseJSON(selectedRecords);
            if (removeRecordId) {
                var index = selectedRecords.indexOf(removeRecordId);
                if (index > -1) {
                    selectedRecords.splice(index, 1);
                }
            }

            $(formClass + "input[name='record_ids']").val(JSON.stringify(selectedRecords));
            var recordType = $(formClass + "select[name='blinkcond_record_type']");
            if (1 > selectedRecords.length) {
                recordType.removeAttr('disabled');
            } else {
                recordType.attr('disabled', 'disabled');
            }
        }
    }

    removeRecordRow = function (element, removeRecordId) {
        $(element).closest('tr').remove();
        updateRecordIds(removeRecordId);
    }
})()