$(document).ready(function () {
    var profileId = $('input[name="profile_id"]').val();
    searchZone(profileId);
    searchProductsSection(profileId);

});
(function () {
    var prodListing = '#product-listing--js';
    var shipListing = '#shipping--js';
    var zoneListing = '#listing-zones';

    setupProfile = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        var profileId = $('input[name="shipprofile_id"]').val();
        fcom.updateWithAjax(fcom.makeUrl('shippingProfile', 'setup'), data, function (t) {
            if (t.status == 1) {
                if (profileId <= 0) {
                    window.location.replace(fcom.makeUrl('shippingProfile', 'form', [t.profileId]));
                }
            }
        });
    };
    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmProductSearchPaging;
        $(frm.page).val(page);
        var profileId = $('input[name="profile_id"]').val();
        searchProducts(profileId, frm);
    };

    reloadListProduct = function () {
        var frm = document.frmProductSearchPaging;
        var profileId = $('input[name="profile_id"]').val();
        searchProducts(profileId, frm);
    };

    searchRecords = function (frm) {
        searchProducts(0, frm);
    }

    searchProducts = function (profileId, form) {
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }

        $(prodListing).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('shippingProfileProducts', 'search', [profileId]), data, function (res) {
            res = $.parseJSON(res);
            $(prodListing).html(res.html);
            fcom.removeLoader();
        });
        $(shipListing).html('');
    };

    searchProductsSection = function (profileId) {
        var dv = '#product-section--js';
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('shippingProfileProducts', 'index', [profileId]), '', function (res) {
            res = $.parseJSON(res);
            fcom.removeLoader();
            $(dv).html(res.html);
            searchProducts(profileId);
        });
        fcom.removeLoader();
    };

    clearSearch = function (profileId, frm) {
        document.frmRecordSearch.reset();
        searchProducts(profileId, frm);
    };

    loadLangData = function (autoFillLangData = 0) {
        var frm = $('#frmShippingProfile');
        if (frm) {
            data = fcom.frmData(frm);
        }
        if (0 < autoFillLangData) {
            data += '&autoFillLangData=1';
        }

        fcom.updateWithAjax(fcom.makeUrl('shippingProfile', 'ProfileNameForm'), data, function (res) {
            fcom.removeLoader();
            $('#profile-name-form').html(res.html);
        });
    };

    profileProductForm = function (profileId) {
        fcom.updateWithAjax(fcom.makeUrl('shippingProfileProducts', 'form', [profileId]), '', function (t) {
            $.ykmodal(t.html, true, '');
            fcom.removeLoader();
        });
    };

    setupProfileProduct = function (frm) {
        if (!$(frm).validate())
            return;
        if ($('input[name="shipprofile_id"]').val() <= 0) {
            fcom.displayErrorMessage(langLbl.saveProfileFirst);
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('shippingProfileProducts', 'setup'), data, function (t) {
            var profileId = $('input[name="profile_id"]').val();
            searchProducts(profileId);
            document.frmProfileProducts.reset();
            closeForm();
        });
    };

    removeProductFromProfile = function (productId) {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('shippingProfileProducts', 'removeProduct', [productId]), '', function (t) {
            var profileId = $('input[name="profile_id"]').val();
            searchProducts(profileId);
            
        });
    }

    searchZone = function (profileId, scrollToNew = false) {
        $(zoneListing).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ShippingZones', 'search', [profileId]), '', function (res) {
            res = $.parseJSON(res);
            fcom.removeLoader();
            $(zoneListing).html(res.html);
            if (true == scrollToNew) {
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: $(".zoneRates-js:last").offset().top
                    }, 1000);
                }, 500);
            }
        });
        fcom.removeLoader();
        //searchProductsSection(profileId);
    };

    zoneForm = function (profileId, zoneId) {
        if ($('input[name="shipprofile_id"]').val() <= 0) {
            $.ykmsg.error(langLbl.saveProfileFirst);
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ShippingZones', 'form', [profileId, zoneId]), '', function (t) {
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
    };


    setupZone = function (frm) {
        if ($('input[name="rest_of_the_world"]:checked').length < 1 && $('input[name="shiploc_zone_ids[]"]:checked').length < 1 && $('input[name="c_id[]"]:checked').length < 1 && $('input[name="s_id[]"]:checked').length < 1) {
            fcom.displayErrorMessage(langLbl.minimumOneLocationRequired);
            return;
        }
        /* if (!$(frm).validate()) return; */

        $('.country--js input[type="checkbox"]:checked').each(function () {
            var countryId = $(this).closest('.country--js').data('countryid');
            if ($('.country_' + countryId + ' .state--js').length == $('.country_' + countryId + ' .state--js:not(:disabled)').length) {
                $('.country_' + countryId + ' .state--js').prop('disabled', true);
            } else {
                $(this).prop('checked', false);
            }
        });
        /* if (!$(frm).validate()) return; */
        /*var data = fcom.frmData(frm);*/
        var data = $(frm).serialize();
        fcom.updateWithAjax(fcom.makeUrl('shippingZones', 'setup'), data, function (t) {
            var profileId = $('input[name="profile_id"]').val();
            setTimeout(() => {
                searchZone(profileId, true);
                searchProductsSection(profileId);
            }, 500);
        });
    };

    deleteZone = function (zoneId) {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }

        fcom.updateWithAjax(fcom.makeUrl('shippingZones', 'deleteZone', [zoneId]), '', function (t) {
            var profileId = $('input[name="profile_id"]').val();
            searchZone(profileId);
            searchProductsSection(profileId);
        });
    };

    modifyRateFields = function (status) {
        if (status == 1) {
            $('input[name="is_condition"]').val(1);
            $('.add-condition--js').hide();
            $('.remove-condition--js').show();
            $('.condition-field--js').removeClass('hide');
        } else {
            $('input[name="is_condition"]').val(0);
            $('.remove-condition--js').hide();
            $('.add-condition--js').show();
            $('.condition-field--js').addClass('hide');
        }
        $('input[name="is_condition"]').trigger('change');
    };

    addEditShipRates = function (zoneId, rateId) {
        fcom.updateWithAjax(fcom.makeUrl('shippingZoneRates', 'form', [zoneId, rateId]), '', function (t) {
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });

    };

    setupRate = function (frm) {
        if (!$(frm).validate())
            return;
        $("input[name='btn_submit']").attr('disabled', 'disabled');
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('shippingZoneRates', 'setup'), data, function (t) {
            $("input[name='btn_submit']").removeAttr('disabled');
            var profileId = $('input[name="profile_id"]').val();
            searchZone(profileId);
            if (t.langId > 0) {
                editRateLangForm(t.zoneId, t.rateId, t.langId);
                return;
            }
            searchProductsSection(profileId);
            $.ykmodal.close();
        });
    };

    editRateLangForm = function (zoneId, rateId, langId) {
        fcom.updateWithAjax(fcom.makeUrl('shippingZoneRates', 'langForm', [zoneId, rateId, langId]), '', function (t) {
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
    };

    setupLangRate = function (frm) {
        if (!$(frm).validate())
            return;
        $("input[name='btn_submit']").attr('disabled', 'disabled');
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('shippingZoneRates', 'langSetup'), data, function (t) {
            $("input[name='btn_submit']").removeAttr('disabled');
            var profileId = $('input[name="profile_id"]').val();
            searchZone(profileId);
            if (t.langId > 0) {
                editRateLangForm(t.zoneId, t.rateId, t.langId);
                return;
            }
            searchProductsSection(profileId);
            $.ykmodal.close();
        });
    };

    deleteRate = function (rateId) {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }

        fcom.updateWithAjax(fcom.makeUrl('shippingZoneRates', 'deleteRate', [rateId]), '', function (t) {
            var profileId = $('input[name="profile_id"]').val();
            searchZone(profileId);
            
        });
    }

    getZoneLocation = function (zoneId) {
        $.ajax({
            url: fcom.makeUrl('ShippingZones', 'getLocations', [zoneId, 1]),
            data: { fIsAjax: 1 },
            dataType: 'json',
            type: 'post',
            success: function (res) {
                $('.country--js input[type="checkbox"]').prop('checked', false);
                if (res != '' || res != [] || res != undefined) {
                    $(res).each(function (index, item) {
                        var stateId = item.shiploc_state_id;
                        var countryId = item.shiploc_country_id;
                        var zoneId = item.shiploc_zone_id;
                        if (zoneId == -1) {
                            $('.checkbox_zone_-1').prop('checked', true);
                        }
                        if (stateId == -1) {
                            $('.checkbox_country_' + countryId).prop('checked', true);
                            $('.country_' + countryId + ' input[type="checkbox"]').prop('checked', true);
                        }
                    });
                }
            },
        });
    }

    selectCountryStates = function (countryid) {
        if ($(".checkbox_country_" + countryid).is(":checked")) {
            var selectedStates = $('.country_' + countryid + ' input[type="checkbox"]:not(:disabled');
            selectedStates.prop('checked', true);
            $('.selectedStateCount--js_' + countryid).html(selectedStates.length);
            $('input[name="rest_of_the_world"]').prop('checked', false);
        } else {
            $('.country_' + countryid + ' input[type="checkbox"]:not(:disabled').prop('checked', false);
            var val = $(".checkbox_country_" + countryid).val();
            $('.selectedStateCount--js_' + countryid).html(0);
        }
    }
})();

/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "." + $.ykmodal.element + " input[type='search']", function () {
    if ("" == $(this).val()) {
        $(".continentJs").trigger("keyup");
    }
});
/* Reset result on clear(cross) icon on keyword search field. */

$(document).on('keyup', '.continentJs', function () {
    var filter = $(this).val();
    if (filter.length <= 1) {
        $('.zones--js').find(".filter-country--js").show();
        $('.zones--js').find(".country--js").show();
        $('.zones--js').find(".zone-name--js").show();
        $('.zones--js').find(".zones--js").show();
        $('.zones--js').find(".list-zones li").show();
        return;
    }
    $('.zones--js').find(".zone-name--js").each(function () {
        if ($(this).text().search(new RegExp(filter, "gi")) < 0) {
            $(this).hide();
            $(this).closest('.zones--js').removeClass('li-display');
        } else {
            $(this).show();
            $(this).closest('.zones--js').addClass('li-display');
        }
    });

    $('.zones--js').find(".country--js").each(function () {
        if ($(this).text().search(new RegExp(filter, "gi")) < 0) {
            $(this).closest('.filter-country--js').hide();
            $(this).closest('.filter-country--js').removeClass('li-display');
        } else {
            $(this).closest('.filter-country--js').show();
            $(this).closest('.filter-country--js').addClass('li-display');
        }
    });

    $('.list-zones').find("ul li").each(function () {
        if ($(this).text().search(new RegExp(filter, "gi")) < 0) {
            $(this).hide();
            $(this).removeClass('li-display');
        } else {
            $(this).show();
            $(this).addClass('li-display');
        }
    });

    $('.li-display').each(function () {
        $(this).closest('.zones--js').find('.zone-name--js').show();
        $(this).closest('.zones--js.li-display').find('.filter-country--js').show();
        if ($(this).closest('.zones--js').find('.filter-country--js.li-display .li-display').length > 0) {
            $(this).closest('.zones--js').find('.filter-country--js.li-display .li-display').show();
        } else {
            $(this).closest('.zones--js').find('.filter-country--js.li-display li').show();
        }
    });
});

$(document).ready(function () {
    $(document).on('click', 'input[name="rest_of_the_world"]', function () {
        $('.checkbox_container--js input[type="checkbox"]').each(function (index) {
            $(this).prop('checked', false);
        });
    });

    $(document).on('click', '.zone--js', function () {
        var zoneid = $(this).data('zoneid');
        if ($(".checkbox_zone_" + zoneid).is(":checked")) {
            $('.zone_' + zoneid + ' .country--js').each(function () {
                var countryid = $(this).data('countryid');
                $('.checkbox_country_' + countryid + ':not(:disabled)').prop('checked', true);
                selectCountryStates(countryid);
            });
        } else {
            $('.zone_' + zoneid + ' input[type="checkbox"]:not(:disabled)').prop('checked', false);
            $(".zone_" + zoneid + " .statecount--js").each(function (index) {
                var statecount = $(this).data('totalcount');
                $(this).html(0);
            });
        }
    });

    $(document).on('click', '.country--js', function () {
        var countryid = $(this).data('countryid');
        selectCountryStates(countryid);
        if (!$(this).prop("checked")) {
            var zoneId = $(this).find('input').val().split("-")[0];
            $('.checkbox_zone_' + zoneId).prop('checked', false);
        }
    });

    $(document).on('click', '.state--js', function () {
        var val = $(this).val();
        var parentIds = val.split("-");
        var zoneId = parentIds[0];
        var countryId = parentIds[1];
        var stateId = parentIds[2];
        if ($(this).is(":checked") == false) {
            $('.checkbox_country_' + countryId).prop('checked', false);
            $('.checkbox_zone_' + zoneId).prop('checked', false);
        }
        var count = $('.country_' + countryId).find('input[type="checkbox"]:checked').length;
        $('.selectedStateCount--js_' + countryId).html(count);
        $('input[name="rest_of_the_world"]').prop('checked', false);
    });
});

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}