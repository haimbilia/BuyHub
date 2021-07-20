$(document).ready(function () {
    searchRecords(document.frmSearch);
});

$(document).on('change', '.icon-language-js', function () {
    var badge_id = $("input[name='badge_id']").val();
    if ('' == badge_id) { badge_id = 0; }
    badgeImages(badge_id, 'icon', 0, $(this).val());
});

(function () {
    var dv = '#listing';
    var controller = 'Badges';

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

    backToListing = function () {
        searchRecords(document.frmSearch);
        $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn();
    }

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    deleteRecord = function (e, badge_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (badge_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badgeIds[]=' + badge_id;
        fcom.ajax(fcom.makeUrl(controller, 'deleteSelected'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                reloadList();
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    /* Badge Request [ */
    addBadgeReqForm = function (badgeReqId, badgeId) {
        fcom.ajax(fcom.makeUrl(controller, 'badgeReqForm', [badgeReqId, badgeId]), '', function (t) {
            $('.pagebody--js').hide();
            var editRecordEle = $('.editRecord--js');
            if (1 > editRecordEle.parents('.card-body').length && 1 > editRecordEle.parents('.card').length) {
                $('.editRecord--js').html('<div class="card"><div class="card-body">' + t + '</div></div>');
            } else if (1 > editRecordEle.parents('.card-body').length) {
                $('.editRecord--js').html('<div class="card-body">' + t + '</div>');
            } else {
                $('.editRecord--js').html(t);
            }
            
            bindRecordsSelect2();
            updateRecordIds();
            $("select[name='breq_blinkcond_id']").trigger('change');
            if (0 < badgeReqId) {
                reloadRecordsList(badgeReqId, 1);
            }
            $('input[name="blinkcond_from_date"], ' + 'input[name="blinkcond_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
        });
    };


    setupBadgeReq = function (frm) {
        if (!$(frm).validate()) return;

        let formData = new FormData(frm);
        $.ajax({
            url: fcom.makeUrl(controller, 'setupBadgeReq'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.mbsmessage(langLbl.processing, false, 'alert--process');
            },
            success: function (ans) {
                var className = (ans.status == 1 ? 'alert--success' : 'alert--danger');
                $.mbsmessage(ans.msg, true, className);
                if (1 > ans.status) {
                    return false;
                }
                backToListing();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    };

    getRecordTypeURL = function () {
        var searchSelector = $("select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $('[name="breq_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete',[],siteConstants.webrootfront);
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('Seller', 'sellerProductsAutoComplete');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Seller', 'getShopDetail', [1]);
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $('[name="breq_record_type"]').val();
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
            var position = 0;
            if (0 < $('select[name="blinkcond_position"]').length) {
                position = $('select[name="blinkcond_position"]').val();
            }

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
            var htm = '<tr><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="fa fa-times"></i></a></id><td>' + (e.params.args.data.value || e.params.args.data.name) + '</td></tr>';
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
        var recordType = $('[name="breq_record_type"]');
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

        fcom.ajax(fcom.makeUrl(controller, 'getRecordType', [element.value]), '', function (t) {
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
})()
