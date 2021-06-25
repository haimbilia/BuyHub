$(document).ready(function () {
    searchRecords(document.frmSearch);

    $('input[name=\'user_name\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
        'source': function (request, response) {
            $.ajax({
                url: fcom.makeUrl('Users', 'autoCompleteJson'),
                data: { keyword: request['term'], fIsAjax: 1 },
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    response($.map(json, function (item) {
                        return { label: item['name'] + '(' + item['username'] + ')', value: item['name'] + '(' + item['username'] + ')', id: item['id'] };
                    }));
                },
            });
        },
        select: function (event, ul) {
            $("input[name='user_id']").val(ul.item.id);
        }
    });
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeRequests';

    var recordPage = 1;

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

    form = function (badgeReqId) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badgeReqId]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
            if (0 < badgeReqId) {
                reloadRecordsList(badgeReqId, 1);
            }
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
            $(document).trigger('close.facebox');
        });
    };

    searchRecords = function (frm) {
        $(dv).html(fcom.getLoader());
        data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    }

    clearSearch = function () {
        $('input[name="user_id"]').val("");
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    getRecordTypeURL = function () {
        var searchSelector = $("select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $('input[name="breq_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('ShippingProfileProducts', 'autoCompleteProducts');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('Seller', 'sellerProductsAutoComplete');
        }else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Seller', 'getShopDetail', [1]);
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $('input[name="breq_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.suggestions;
        } else if (RECORD_TYPE_SHOP == recordType) {
            return [data.shopData];
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        var selector = $("select.recordIds--js");
        selector.select2({
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: langLbl.layoutDirection,
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
                return result.name || result.value;
            },
            templateSelection: function (result) {
                return result.name || result.value;
            }
        }).on('select2:selecting', function (e) {
            var badgeType = $('input[name="badge_type"]').val();
            var recordType = $('input[name="breq_record_type"]').val();
            var position = 0;
            if (0 < $('select[name="blinkcond_position"]').length) {
                position = $('select[name="blinkcond_position"]').val();
            }

            // fcom.ajax(fcom.makeUrl(controller, 'isUnique', [badgeType, recordType, e.params.args.data.id, position]), '', function (t) {
                /* var resp = JSON.parse(t);
                if (1 > resp.status) {
                    selector.val('').trigger('change');
                    $.systemMessage(resp.msg, 'alert--danger');
                    return false;
                } */

                var recordIds = $("input[name='record_ids']");
                var JSONObj = [e.params.args.data.id];
                var badgeLinkRecordIds = recordIds.val();
                if ('' != badgeLinkRecordIds) {
                    JSONObj = JSON.parse(badgeLinkRecordIds);
                    if (JSONObj.includes(e.params.args.data.id)) {
                        selector.val('').trigger('change');
                        $.systemMessage(langLbl.alreadySelected, 'alert--danger');
                        return false;
                    }
                    JSONObj.push(e.params.args.data.id);
                }
                recordIds.val(JSON.stringify(JSONObj));
                setTimeout(function () {
                    selector.val('').trigger('change');
                }, 200);
                var htm = '<tr><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="fas fa-times"></i></a></id><td>' +( e.params.args.data.value || e.params.args.data.name) + '</td></tr>';
                var tbl = "";
                if (1 > $('table.recordListing--js').length) {
                    var tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody></tbody></table>';
                    $('.recordsContainer--js').html(tbl);
                }
                $('.recordListing--js').append(htm);
            // });
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        });
    }


    updateRecordIds = function (removeRecordId = 0) {
        var selectedRecords = $("input[name='record_ids']").val();
        if ('' != selectedRecords && 'undefined' != typeof selectedRecords) {
            selectedRecords = $.parseJSON(selectedRecords);
            if (removeRecordId) {
                var index = selectedRecords.indexOf(removeRecordId);
                if (index > -1) {
                    selectedRecords.splice(index, 1);
                }
                $("input[name='record_ids']").val(JSON.stringify(selectedRecords));
            }
        }
    }

    removeRecordRow = function (element, removeRecordId) {
        $(element).closest('tr').remove();
        updateRecordIds(removeRecordId);
        var badgeReqId = $('input[name="breq_id"]').val();
        fcom.updateWithAjax(fcom.makeUrl(controller, 'unlinkRecord', [badgeReqId, removeRecordId]), '', function (t) {
            reloadRecordsList(badgeReqId);
        });
    }

    getRecordType = function (element) {
        var recordType = $('input[name="breq_record_type"]');
        var oldValue = $(element).data('oldvalue');
        if (oldValue != element.value) {
            $('select.recordIds--js, input[name="record_ids"]').val("").trigger('change');
            $('.recordsContainer--js').html("");
            $(element).data('oldvalue', element.value);
        }

        if ("" == element.value) {
            recordType.val("");
            return false;
        }

        fcom.ajax(fcom.makeUrl('BadgeLinkConditions', 'getRecordType', [element.value]), '', function (t) {
            var res = $.parseJSON(t);
            recordType.val(res.recordType);
        });
    }

    reloadRecordsList = function (badgeReqId, page) {
        $(".recordsContainer--js").html(fcom.getLoader());
        var data = 'page=' + page;
        fcom.ajax(fcom.makeUrl(controller, 'records', [badgeReqId]), data, function (t) {
            $(".recordsContainer--js").html(t);
        });
    };
})();