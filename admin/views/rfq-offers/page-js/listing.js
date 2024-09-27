(function () {
    bindUserSelect2 = function (element, obj = []) {
        /* let productId = $('input[name="rfq_product_id"]').val();
        obj['product_id'] = productId; */
        let rfqId = $('input[name="offer_rfq_id"]').val();
        obj['rfq_id'] = rfqId;
        obj['rfq_assigned_only'] = 1;
        select2(element, fcom.makeUrl('RequestForQuotes', 'getSellersByProductId'), obj);
    }

    getSellersSelect2 = function (element, obj = []) {
        /* let productId = $('input[name="rfq_product_id"]').val();
        obj['product_id'] = productId; */
        let rfqId = $('input[name="offer_rfq_id"]').val();
        obj['rfq_id'] = rfqId;
        /* isGlobal variable declared inside form */
        select2(element, fcom.makeUrl('RfqOffers', 'getSellers'), obj);
    }

    /* view = function (rfqId) {
         fcom.updateWithAjax(fcom.makeUrl(controllerName, 'view', [rfqId]), [], function (ans) {
             fcom.closeProcessing();
             fcom.removeLoader();
             $.ykmodal(ans.html, false, 'modal-lg');
         });
     };*/

    addNew = function (rfqId) {
        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "rfqId=" + rfqId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    counter = function (recordId, rfqId) {
        data = "offer_counter_offer_id=" + recordId + '&rfqId=' + rfqId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId, rfqId) {
        data = "recordId=" + recordId + '&rfqId=' + rfqId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    view = function (rfqId, offerId) {
        data = "offerId=" + offerId + '&rfqId=' + rfqId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "view"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
    accept = function (offerId, rfqId) {
        if (!confirm(langLbl.areYouSure)) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "accept", [offerId, rfqId]), '', function (t) {
            fcom.closeProcessing();
            reloadList();
        });
    }

    reject = function (offerId, rfqId) {
        if (!confirm(langLbl.areYouSure)) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "reject", [offerId, rfqId]), '', function (t) {
            fcom.closeProcessing();
            reloadList();
        });
    }

    viewShippingRates = function (rfqId, sellerId, primaryOfferId) {
        var data = 'rfq_id=' + rfqId + '&seller_id=' + sellerId + '&rlo_primary_offer_id=' + primaryOfferId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getShippingRates"), data, function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if ('' != t.html && 'undefined' != typeof t.html) {
                $.ykmodal(t.html, true);
            } else {
                fcom.displayErrorMessage(langLbl.noRecordFound);
            }
        });
    }

    viewComments = function (offerId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "viewComments", [offerId]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(t.html, true);
        });
    }

    attachmentForm = function (primaryOfferId, onlyWithAttachments = 1) {
        let data = 'rom_primary_offer_id=' + primaryOfferId + '&only_with_attachments=' + onlyWithAttachments;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "attachmentForm"), data, function (t) {
            searchRecords(document.frmRecordSearch); /* this is just to refresh attachment and message buttons that all messages are read. */
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(t.html);
        });
    }
    attachmentListing = function (primaryOfferId) {
        attachmentForm(primaryOfferId, 1);
    }

    saveAttachment = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = new FormData();
        data.append('fIsAjax', 1);
        frm.find('input[type=hidden],textarea,input[type=text]').each(function () {
            data.append(this.name, $(this).val());
        });

        frm.find('input[type=file]').each(function (i, v) {
            data.append(v.name, v.files[0]);
        });

        frm.find('input[type=checkbox]').each(function (i, v) {
            data.append(v.name, (this.checked ? 1 : 0));
        });

        $('.contentBodyJs').prepend(fcom.getLoader());
        $.ajax({
            url: fcom.makeUrl(controllerName, 'uploadAttachment'),
            type: "POST",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (t) {
                fcom.removeLoader();
                if (t.status == 0) {
                    fcom.displayErrorMessage(t.msg);
                    return;
                }
                $('.messageChatBodyJs').find('.noRecordFoundJs').remove();
                $('.messageChatBodyJs').append(t.html);
                if (0 < $('.romDateJs' + t.romDate).length) {
                    $('.romDateJs' + t.romDate + ':last').remove();
                }
                $('.btnAttachmentsJs').removeClass('active');
                $('.btnSubmitJs').attr('disabled', 'disabled');
                $(".modalFormJs").get(0).reset();
                $('.btnSccessJs').addClass('active');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error Occurred.");
            }
        });
    };
    loadmore = function (primaryOfferId, pageNo) {
        let data = 'rom_primary_offer_id=' + primaryOfferId + '&page=' + pageNo;
        $(".messageChatBodyJs").prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "loadMoreAttachments"), data, function (t) {
            searchRecords(document.frmRecordSearch);
            fcom.closeProcessing();
            fcom.removeLoader();
            $('.lastRowJs').remove();
            if ('' != t.html) {
                $(".messageChatBodyJs").prepend(t.html);
            }
        });
    }


    deleteRecord = function (recordId, subRecordId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'recordId=' + recordId + "&subRecordId=" + subRecordId;
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "deleteRecord"),
            data,
            function (t) {
                fcom.displaySuccessMessage(t.msg);
                reloadList();
            }
        );
    };
})();

$(document).ready(function () {
    $(document).on('click', '.showMoreJs', function () {
        let rowId = $(this).data('rowId');
        $('.lessContent' + rowId + 'Js').hide();
        $('.moreContent' + rowId + 'Js').show();
    });
    $(document).on('click', '.showLessJs', function () {
        let rowId = $(this).data('rowId');
        $('.moreContent' + rowId + 'Js').hide();
        $('.lessContent' + rowId + 'Js').show();
    });

    $(document).on('keyup', 'input[name="offer_quantity"], input[name="offer_price"], input[name="offer_cost"]', function () {
        let qty = $('input[name="offer_quantity"]').val();
        let ofrPrice = $('input[name="offer_price"]').val();
        let ofrCost = $('input[name="offer_cost"]').val();

        if (('' != ofrPrice || '' != ofrCost) && '' != qty && 0 < qty) {
            if ('' != ofrPrice && 0 < ofrPrice) {
                $('.opPerUnitJs').text(langLbl.total + ': ' + (ofrPrice * qty).toFixed(2));
            }
            if ('' != ofrCost && 0 < ofrCost) {
                $('.ocPerUnitJs').text(langLbl.total + ': ' + (ofrCost * qty).toFixed(2));
            }
        }

        if ('' == ofrPrice || '' == ofrCost || '' == qty) {
            if ('' == qty) {
                $('.opPerUnitJs, .ocPerUnitJs').text(langLbl.total + ': 0.00');
            }
            if ('' == ofrPrice) {
                $('.opPerUnitJs').text(langLbl.total + ': 0.00');
            }
            if ('' == ofrCost) {
                $('.ocPerUnitJs').text(langLbl.total + ': 0.00');
            }
        }
    });

    $(document).on('keyup', '.chatTextareaJs', function () {
        if ('' != $(this).val()) {
            $('.btnSubmitJs').removeAttr('disabled');
        } else {
            $('.btnSubmitJs').attr('disabled', 'disabled');
        }
    });

    $(document).on('click', '.btnSccessJs', function () {
        if ($(this).find('.buyerAccessInputJs:checked').length) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });

    $(document).on('change', '.attachmentFileInputJs', function () {
        if ('' != $(this).val()) {
            $('.btnAttachmentsJs').addClass('active');
        } else {
            $('.btnAttachmentsJs').removeClass('active');
        }
    });

    bindUserSelect2('rfqSellersJs');
});