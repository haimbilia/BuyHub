$(document).on('change', '#addrStateJs', function () {
    if (0 < $(this).val()) {
        $(this).removeClass('error');
    } else {
        $(this).addClass('error');
    }
});

(function () {
    addNew = function () {
        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, 'modal-dialog-vertical-md');
            fcom.removeLoader();
        });
    }

    editRecord = function (id, langId) {
        var data = 'langId=' + langId;
        fcom.updateWithAjax(fcom.makeUrl('PickupAddresses', 'form', [id, langId]), data, function (res) {
            fcom.closeProcessing();
            $.ykmodal(res.html, false, 'modal-dialog-vertical-md');
            fcom.removeLoader();
            var oldLabel = $(".label-js").text();
            $(".label-js").attr("data-listlabel", oldLabel).text(langLbl.pickupAddressForm);
            $(".js-add-pickup-addr").addClass('d-none');
            $(".js-pickup-addr").removeClass('d-none');
            setTimeout(function () {
                $('.fromTime-js').change();
            }, 500);
        });
    };
    setup = function (frm) {
        if (!$(frm).validate())
            return;
        if (1 == $(".availabilityType-js:checked").val()) {
            if (1 > $(".slotDays-js:checked").length) {
                fcom.displayErrorMessage(langLbl.selectTimeslotDay);
                return false;
            }
            /* $(".slotDays-js:checkbox:checked").each(function () {
                var row = $(this).parent('.timeSlotJs');               
                if ('' == row.closest(".fromTime-js option:selected").val() || '' == row.closest(".toTime-js option:selected").val()) {
                    fcom.displayErrorMessage(langLbl.invalidTimeSlot);
                    return false;
                }
            }); */

        } else {
            if ('' == $(".fromTime-js option:selected").val() || '' == $(".toTime-js option:selected").val()) {
                fcom.displayErrorMessage(langLbl.invalidTimeSlot);
                return false;
            }
        }
        $.ykmodal(fcom.getLoader(), false);
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('PickupAddresses', 'setup'), data, function (t) {
            searchRecords();
            $.ykmodal.close();
        });
    };
    getCountryStates = function (countryId, stateId, div, langId) {
        fcom.updateWithAjax(fcom.makeUrl('Shops', 'getStates', [countryId, stateId, langId]), '', function (res) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $(div).empty();
            $(div).append(res.html);
        });
    };

    addRow = function (day) {
        var fromTimeHtml = $(".js-slot-from-" + day).parent().html();
        var toTimeHtml = $(".js-slot-to-" + day).parent().html();
        var count = $(".js-slot-individual .rows").length;
        var toTime = $(".js-slot-to-" + day + ":last").val();

        var rowHtml = '<tr class="rows jsDay-' + day + ' row-' + count + '" data-count=' + count + '><td></td>';
        rowHtml += '<td>' + fromTimeHtml + '</td>';
        rowHtml += '<td>' + toTimeHtml + '</td>';
        rowHtml += '<td class="align-right"><ul class="actions">';
        rowHtml += '<li class="d-none addRowBtn' + day + '-js"><a href="javascript:void(0)" onclick="addRow(' + day + ')" class=""><svg class="svg" width="18" height="18"><use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#add"></use> </svg></a></li>';
        rowHtml += '<li class="btn-remove-row-js" data-day=' + day + '><a href="javascript:void(0)" > <svg class="svg" width="18" height="18"> <use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#delete"> </use></svg></a></li>';
        rowHtml += '</td>';

        var addRowBtn = $('.addRowBtn' + day + '-js');
        if (0 < addRowBtn.length) {
            addRowBtn.addClass('d-none');
        }

        if (0 < $('.addRowBtn' + day + '-js').length) {
            $('.addRowBtn' + day + '-js').addClass('d-none');
        }

        $(".jsDay-" + day).last().after(rowHtml);
        $('.row-' + count + " select").val('').attr('data-row', count);
        $('.row-' + count + " select").find("option").each(function () {
            var toVal = $(this).val();
            if (toVal != '' && toVal <= toTime) {
                $(this).addClass('d-none');
            }
        });
    }

    displayAddRowValues = function (day, ele) {
        var index = $(ele).data('row');
        var rowElement = ".js-slot-individual .row-" + index;
        var frmElement = rowElement + " .js-slot-from-" + day;
        var toElement = rowElement + " .js-slot-to-" + day;
        var fromTime = $(frmElement + " option:selected").val();
        var toTime = $(toElement + " option:selected").val();
        var toElementIndex = $(rowElement).index();
        var nextRowElement = ".js-slot-individual .rows:eq(" + (toElementIndex + 1) + ")";
        var nextFrmElement = nextRowElement + " .js-slot-from-" + day;
        if (0 < $(nextFrmElement).length) {
            $(nextFrmElement + " option").removeClass('d-none');
            var nxtFrmSelectedVal = $(nextFrmElement + ' option:selected').val();
            if (nxtFrmSelectedVal <= toTime) {
                $(".js-slot-from-" + day).each(function () {
                    if (index < $(this).data('row') && $(this).val() <= toTime) {
                        var nxtRow = $(this).data('row');
                        $(this).val("");
                        $(".js-slot-individual .row-" + nxtRow + " .js-slot-to-" + day).val("");
                        $("option", this).each(function () {
                            var optVal = $(this).val();
                            if (optVal != '' && optVal <= toTime) {
                                $(this).addClass('d-none');
                            }
                        });
                    }
                });
            }
            $(nextFrmElement + " option").each(function () {
                var nxtFrmVal = $(this).val();
                if (nxtFrmVal != '' && nxtFrmVal <= toTime) {
                    $(this).addClass('d-none');
                }
            });
        }

        if (fromTime == '' && toTime != '') {
            $(toElement).val("");
            fcom.displayErrorMessage(langLbl.invalidFromTime);
            return false;
        }

        if (toTime != '' && toTime <= fromTime) {
            $(toElement).val('').addClass('error');
            var toTime = $(toElement).children("option:selected").val();
        } else {
            $(toElement).removeClass('error');
        }

        $(toElement + " option").removeClass('d-none');
        $(toElement + " option").each(function () {
            var toVal = $(this).val();
            if (toVal != '' && toVal <= fromTime) {
                $(this).addClass('d-none');
            }
        });
        var toTimeLastOpt = $(toElement + " option:last").val();
        var lastCount = $('.jsDay-' + day).last().data('count');
        if (index < lastCount) {
            $(rowElement).find(".addRowBtn" + day + '-js').addClass('d-none');
        } else if (fromTime != '' && toTime != '' && toTime < toTimeLastOpt) {
            $(rowElement + " .addRowBtn" + day + '-js').removeClass('d-none');
        } else {
            $(rowElement + " .addRowBtn" + day + '-js').addClass('d-none');
        }
    }

    displayFields = function (day, ele) {
        if ($(ele).prop("checked") == true) {
            $(".js-slot-from-" + day).removeAttr('disabled');
            $(".js-slot-to-" + day).removeAttr('disabled');
            displayAddRowValues(day, ele);
        } else {
            $(".js-slot-from-" + day).attr('disabled', 'true');
            $(".js-slot-to-" + day).attr('disabled', 'true');
            $(".jsDay-" + day).find("[name='btn_remove_row']").trigger('click');
        }
    }


    displaySlotTimings = function (ele) {
        var selectedVal = $(ele).val();
        var sundaySelector = '.js-slot-individual .jsDay-' + DAY_SUNDAY;
        if (selectedVal == 2) {
            $('.js-slot-individual .timeSlotJs').addClass('d-none');
            $(sundaySelector + ' .jsWeekDay .weekDaysJs').addClass('d-none');
            $(sundaySelector + ' .jsWeekDay .allDaysJs').removeClass('d-none');
            $(sundaySelector).removeClass('d-none');
            $(sundaySelector + ' .jsWeekDay input').prop("checked", true).trigger('change');
        } else {
            $('.js-slot-individual .timeSlotJs').removeClass('d-none');
            $(sundaySelector + ' .jsWeekDay .weekDaysJs').removeClass('d-none');
            $(sundaySelector + ' .jsWeekDay .allDaysJs').addClass('d-none');
        }
    }

})();

$(document).on("click", ".btn-remove-row-js", function () {
    var day = $(this).data('day');
    $(this).closest('.rows').remove();
    $('.jsDay-' + day + ':last').find('.addRowBtn' + day + '-js').removeClass('d-none');
})
