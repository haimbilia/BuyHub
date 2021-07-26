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

$(document).on('change', formClass + '[name="blinkcond_record_type"]', function () {
    if ("" == $(this).val() && REC_COND_MANUAL == $(formClass + ".recCond--js").val()) {
        $(this).val(RECORD_TYPE_SELLER_PRODUCT);
        return;
    }
    var recordNameSelector = $(formClass + "select.recordIds--js");
    if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
    $(formClass + "select.recordIds--js").val('').trigger('change');
});

$(document).on('change', formClass + 'select[name="blinkcond_position"]', function () {
    var badgeSection = $('.badgeImageSection--js .badges');
    if (RIGHT == $(this).val()) {
        badgeSection.addClass('badges-right');
        if (badgeSection.hasClass('badges-left')) {
            badgeSection.removeClass('badges-left')
        }
    } else if (LEFT == $(this).val() && badgeSection.hasClass('badges-right')) {
        badgeSection.addClass('badges-left');
        if (badgeSection.hasClass('badges-right')) {
            badgeSection.removeClass('badges-right')
        }
    }
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinkConditions';

    hideSearchFormFilter = function (blinkcond_id) {
        $(".listingSection--js, .searchform_filter").show();
        if (1 > blinkcond_id) {
            $(".listingSection--js, .searchform_filter").hide();
        }
    }

    clearForm = function () {
        $(formClass + "input[name='blinkcond_from_date'], " + formClass + "input[name='blinkcond_to_date'], " + formClass + "input[name='blinkcond_condition_from'], " + formClass + "input[name='blinkcond_condition_to']").val("");
        var sellerSelctor = $(formClass + "select[name='seller'], " + formClass + "input[name='blinkcond_user_id']");
        if (0 < sellerSelctor.length && '' == $(formClass + "input[name='blinkcond_id']").val()) {
            sellerSelctor.val("").trigger('change');
            $(formClass + "select[name='seller']").removeAttr('disabled');
        }
    };

    badgeForm = function (blinkcond_id, badgeId) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_BADGE, badgeId, blinkcond_id]), '', function (t) {
            // $('.pagebody--js').hide();
            $('#otherTopForm--js').html(t);

            bindBadgeNameSelect2();
            bindRecordsSelect2();
            bindSellerSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_AUTO) {
                $(formClass + 'select[name="blinkcond_condition_type"]').change();
                var recordNameSelector = $(formClass + 'select.recordIds--js');
                recordNameSelector.closest('.field-set').parent().hide();
                $(formClass + '.linkType--js').hide();
                $('.listingSection--js, .searchform_filter').hide();

            } else {
                $(formClass + ".conditionType--js").hide();
                $(formClass + '[name="blinkcond_record_type"]').trigger('change');

                var conditionSelectors = $(formClass + 'select[name="blinkcond_condition_type"], ' + formClass + 'input[name="blinkcond_condition_from"], ' + formClass + 'input[name="blinkcond_condition_to"]');
                conditionSelectors.attr('data-fatreq', JSON.stringify({ required: false }));

                hideSearchFormFilter(blinkcond_id);
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

    ribbonForm = function (blinkcond_id, badgeId) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_RIBBON, badgeId, blinkcond_id]), '', function (t) {
            // $('.pagebody--js').hide();
            $('#otherTopForm--js').html(t);

            bindBadgeNameSelect2();
            bindRecordsSelect2();
            bindSellerSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_MANUAL) {
                $(formClass + '[name="blinkcond_record_type"]').trigger('change');
                hideSearchFormFilter(blinkcond_id);
            } else {
                $('.listingSection--js, .searchform_filter').hide();
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
        /* $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn(); */
        window.history.back();
    }

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            backToListing();
        });
    };

    bindSellerSelect2 = function () {
        var selector = $(formClass + "select[name='seller']");
        selector.select2({
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
        }).on('select2:selecting', function (e) {
            $(formClass + 'input[name="blinkcond_user_id"]').val(e.params.args.data.id);
        }).on('select2:unselect', function (e) {
            $(formClass + 'input[name="blinkcond_user_id"]').val("");
        });
    }

    getRecordTypeURL = function () {
        var sellerId = $(formClass + 'input[name="blinkcond_user_id"]').val();
        if ("" == sellerId || 1 > sellerId) {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
        
        var searchSelector = $(formClass + "select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $(formClass + '[name="blinkcond_record_type"]').val();
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
        var recordType = $(formClass + '[name="blinkcond_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType || RECORD_TYPE_SHOP == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.products;
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRequestData = function (params) {
        var sellerId = $(formClass + 'input[name="blinkcond_user_id"]').val();
        if ("" == sellerId || 1 > sellerId) {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
        var arr = {keyword: params.term};        
        var recordType = $(formClass + '[name="blinkcond_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            arr['product_seller_id'] = sellerId;
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            arr['selprod_user_id'] = sellerId;
        } else if (RECORD_TYPE_SHOP == recordType) {
            arr['shop_user_id'] = sellerId;
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
        return arr;
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
                    return getRecordTypeURL();
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return getRequestData(params);
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
            var recordType = $(formClass + '[name="blinkcond_record_type"]').val();
            var position = 0;
            if (0 < $(formClass + 'select[name="blinkcond_position"]').length) {
                position = $(formClass + 'select[name="blinkcond_position"]').val();
            }

            $(".listingSection--js, .searchform_filter").show();
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
                    if (JSONObj.includes(e.params.args.data.id)) {
                        selector.val('').trigger('change');
                        $.systemMessage(langLbl.alreadySelected, 'alert--danger');
                        return false;
                    }
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
                    var htm = '<tr class="recordRow--js"><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="icon ion-close"></i></a></id><td>' + e.params.args.data.name + '</td></tr>';
                    var tbl = "";
                    if (1 > $('table.recordListing--js').length) {
                        var tbl = '<table class="table recordListing--js"><tbody></tbody></table>';
                        $('#listing').html(tbl);
                    }
                    $('.recordListing--js').append(htm);
                }
                $(formClass + "select[name='blinkcond_record_type'], " + formClass + "select[name='seller']").attr('disabled', 'disabled');
            });
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        });
    }

    searchRecords = function (form) {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controller, 'records', [$('.formSearch--js input[name="blinkcond_id"]').val()]), fcom.frmData(form), function (res) {
            $(dv).html(res);
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        reloadRecordsList($('.formSearch--js input[name="blinkcond_id"]').val(), 1);
    };

    reloadRecordsList = function (blinkcond_id, page) {
        $(dv).html(fcom.getLoader());
        var data = 'page=' + page;
        fcom.ajax(fcom.makeUrl(controller, 'records', [blinkcond_id]), data, function (t) {
            $(dv).html(t);
            if (1 > $('.recordListing--js .recordRow--js').length) {
                $(".listingSection--js, .searchform_filter").hide();
            }
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
            var recordType = $(formClass + "select[name='blinkcond_record_type'], " + formClass + "select[name='seller']");
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

        if (1 > $('.recordListing--js .recordRow--js').length) {
            $('.listingSection--js').hide();
        }
    }

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
})()

$(document).ready(function () {
    if (TYPE_BADGE == badgeType) {
        badgeForm(blinkcond_id, badgeId);
    } else if (TYPE_RIBBON == badgeType) {
        ribbonForm(blinkcond_id, badgeId);
    } else {
        $.systemMessage(langLbl.invalidRequest, 'alert--danger');
        return false;
    }
});