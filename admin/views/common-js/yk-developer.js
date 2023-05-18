function bindFeatherLight() {
    if (0 < $('.featherLightGalleryJs').length) {
        if ('undefined' == typeof $.fn.featherlightGallery) {
            fcom.displayErrorMessage('Please Include Feather Light JS Library Files.');
            return;
        }

        $('.featherLightGalleryJs').each(function () {
            $(this).find('[data-featherlight]').featherlightGallery({
                previousIcon: '«',
                nextIcon: '»',
                galleryFadeIn: 300,
                openSpeed: 300
            });
        });
    }
}

$(function () {
    if (/ip(hone|od)|ipad/i.test(navigator.userAgent)) {
        $("body").css("cursor", "pointer");
    }

    if ("undefined" == typeof $.cookie("adminSidebar")) {
        $("body").attr("data-sidebar-minimize", "on");
        $('.sidebarOpenerBtnJs').removeClass("active");
    }

    /* Bind Max Length validator. */
    bindMaxLengthValidator();

    $('[data-bs-toggle="popover"]').popover({
        html: true,
        content: function () {
            var content = $(this).attr("data-popover-html");
            if ('undefined' != typeof content) {
                return $(content).html();
            }
            return $(this).attr("data-bs-content");
        },
    });
    /* Bind bootstrap tooltip with ajax elements. */
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    }).on('click', function () {
        setTimeout(() => {
            $(this).tooltip('hide');
        }, 100);
    });

    /* Binding Feather Light gallery */
    bindFeatherLight();
    /* Binding Feather Light gallery */
});

(function () {
    var screenHeight = $(window).height() - 100;
    window.onresize = function (event) {
        var screenHeight = $(window).height() - 100;
    };

    $.extend(fcom, {
        processingCounter: 0,
        processingClass: 'processingJs',
        scrollToTop: function (obj) {
            if (typeof obj == undefined || obj == null) {
                $("html, body").animate(
                    {
                        scrollTop: $("html, body").offset().top - 100,
                    },
                    "slow"
                );
            } else {
                $("html, body").animate(
                    {
                        scrollTop: $(obj).offset().top - 100,
                    },
                    "slow"
                );
            }
        },

        resetEditorInstance: function () {
            if (typeof oUtil != "undefined") {
                var editors = oUtil.arrEditor;
                for (x in editors) {
                    eval("delete window." + editors[x]);
                }
                oUtil.arrEditor = [];
            }
        },

        resetEditorWidth: function (width = "100%") {
            if (typeof oUtil != "undefined") {
                oUtil.arrEditor.forEach(function (input) {
                    var oEdit1 = eval(input);
                    $("#idArea" + oEdit1.oName).attr("width", width);
                });
            }
        },

        setEditorLayout: function (lang_id) {
            var editors = oUtil.arrEditor;
            layout = langLbl["language" + lang_id];
            for (x in editors) {
                var oEdit1 = eval(editors[x]);
                if ($("#idArea" + oEdit1.oName).parents(".layout--rtl").length) {
                    $("#idContent" + editors[x])
                        .contents()
                        .find("body")
                        .css("direction", layout);
                    $("#idArea" + oEdit1.oName + ' td[dir="ltr"]').attr("dir", layout);
                }
            }
        },

        getLoader: function (addAsNew) {
            if (typeof addAsNew === 'undefined') {
                $(document.body).css({ cursor: "wait" });
                $(".loaderJs").remove();
            }
            return '<div class="table-processing loaderJs"><div class="spinner spinner--sm spinner--brand"></div></div>';
        },

        getModalBody: function () {
            return '<div class="modal fade" id="modalBoxJs"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalBoxJsLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h6 class="modal-title"></h6><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="table-processing loaderJs"><div class="spinner spinner--sm spinner--brand"></div></div></div><div class="modal-footer"></div></div></div></div>';
        },

        displayProcessing: function () {
            fcom.processingCounter++;
            $.ykmsg.info(langLbl.processing, -1, fcom.processingClass + " " + fcom.processingClass + '-' + fcom.processingCounter);
        },

        closeProcessing: function (counter) {
            var cls = fcom.processingClass;
            if (typeof counter !== "undefined") {
                cls += '-' + counter
            }
            $("." + cls).remove();
            //$.ykmsg.close();
        },

        displaySuccessMessage: function (msg) {
            $.ykmsg.close();
            $.ykmsg.success(msg);
        },

        displayErrorMessage: function (msg) {
            $.ykmsg.close();
            $.ykmsg.error(msg);
        },

        removeLoader: function (cls) {
            $(document.body).css({ cursor: "default" });
            $(".loaderJs").remove();
            $(".submitBtnJs").removeClass("loading");
        },

        getRowSpinner: function () {
            return '<div class="spinner spinner--v2 spinner--sm spinner--brand"></div>';
        },
    });

    clearCache = function () {
        fcom.updateWithAjax(fcom.makeUrl("Home", "clear"), "", function (t) {
            fcom.displaySuccessMessage(t.msg);
            window.location.reload();
        });
    };

    resetQuickSearchResults = function () {
        var ul = '.quickMenujs';
        var li = ul + ' li.navItemJs';
        var searchResult = li + ' .navLinkJs';

        $(ul + " mark").contents().unwrap();
        $(li + ', ' + searchResult).show();
        $(ul + ' li.dropdownJs').show();
        $(ul + ' li.hasNestedChildJs').show();
        $('.noResultsFoundJs').hide();
    };

    quickMenuItemSearch = function (ele, event) {
        event.stopPropagation();
        var ul = '.quickMenujs';
        $(ul + " mark").contents().unwrap();
        var value = ele.val().toLowerCase();
        if (value.length < 1) {
            return;
        }
        var noResults = '.noResultsFoundJs';
        var li = ul + ' li.navItemJs';
        var searchResult = li + ' .navLinkJs';
        $(noResults + ', ' + searchResult).hide();
        $(li).each(function () {
            var liObj = this;
            $(liObj).hide();
            $(".navLinkJs", liObj).each(function () {
                var resultObj = $(this);
                var textEle = resultObj.find('.navTextJs');
                var orignalText = textEle.text();
                var text = orignalText.toLowerCase();
                var textPos = text.indexOf(value.toLowerCase());

                var parentTextEle = resultObj.closest('.dropdownJs').find('.menuTitleJs');
                var orignalParentText = parentTextEle.text();
                var parentText = orignalParentText.toLowerCase();
                var parentTextPos = parentText.indexOf(value.toLowerCase());

                var search = text.search(value);
                var parentSearch = parentText.search(value);
                if (-1 < search || -1 < parentSearch) {
                    resultObj.show();
                    $(liObj).show();

                    var endAt = value.length;
                    if (textPos >= 0) {
                        var filter_text = orignalText.substr(textPos, endAt);
                        var replaceWith = "<mark>" + filter_text + "</mark>";
                        textEle.html(orignalText.replace(filter_text, replaceWith));
                    }

                    if (parentTextPos >= 0) {
                        var filter_text = orignalParentText.substr(parentTextPos, endAt);
                        var replaceWith = "<mark>" + filter_text + "</mark>";
                        parentTextEle.html(orignalParentText.replace(filter_text, replaceWith));
                    }
                }
            });
        });

        $(ul + ' li.dropdownJs').each(function () {
            var liObj = this;
            $(liObj).show();
            if (1 > $('.navItemJs:visible', liObj).length) {
                $(liObj).hide();
            }
        });

        $(ul + ' li.hasNestedChildJs').each(function () {
            var liObj = this;
            $(liObj).show();
            if (1 > $('.navItemJs:visible', liObj).length) {
                $(liObj).hide();
            }
        });

        if (1 > $(li + ":visible").length) {
            $(noResults).show();
        }
    };

    isJson = function (str) {
        try {
            var json = JSON.parse(str);
        } catch (e) {
            return false;
        }
        return json;
    };

    getCountryStates = function (countryId, stateId, dv) {
        fcom.displayProcessing();
        fcom.ajax(
            fcom.makeUrl("Configurations", "getStates", [countryId, stateId]),
            "",
            function (res) {
                var json = JSON.parse(res);
                fcom.closeProcessing();
                $(dv).empty();
                $(dv).append(json.html);
            }
        );
    };

    getStatesByCountryCode = function (
        countryCode,
        stateCode,
        dv,
        idCol = "state_id"
    ) {
        fcom.displayProcessing();
        fcom.ajax(
            fcom.makeUrl("Configurations", "getStatesByCountryCode", [
                countryCode,
                stateCode,
                idCol,
            ]),
            "",
            function (res) {
                var json = JSON.parse(res);
                fcom.closeProcessing();
                $(dv).empty();
                $(dv).append(json.html).change();
            }
        );
    };

    sortObjectByKeys = function (o) {
        return Object.keys(o)
            .sort()
            .reduce((r, k) => ((r[k] = o[k]), r), {});
    };

    stylePhoneNumberFld = function (
        element = "input[name='user_phone']",
        destroy = false
    ) {
        var inputList = document.querySelectorAll(element);
        var country =
            "" == langLbl.defaultCountryCode ||
                "undefined" == typeof langLbl.defaultCountryCode
                ? "in"
                : langLbl.defaultCountryCode;
        inputList.forEach(function (input) {
            if (true == destroy) {
                $(input).removeAttr("style");
                var clone = input.cloneNode(true);
                $(".iti").replaceWith(clone);
            } else {
                if ($(input).hasClass("hasFlag-js")) {
                    return;
                }
                $(input).addClass("hasFlag-js");
                var elementName = $(input).attr("name") + "_dcode";
                var dialCodeElement = $('input[name="' + elementName + '"]');
                if (
                    0 < dialCodeElement.length &&
                    "" != dialCodeElement.val() &&
                    "undefined" != typeof dialCodeElement.val()
                ) {
                    var elementVal = dialCodeElement.val();
                    var countryCodePos = elementVal.indexOf("-");
                    if (0 < countryCodePos) {
                        country = elementVal.substring(
                            countryCodePos + 1,
                            elementVal.length
                        );
                    } else {
                        country = getCountryIso2CodeFromDialCode(parseInt(elementVal));
                    }
                }

                var iti = window.intlTelInput(input, {
                    separateDialCode: true,
                    initialCountry: country,
                });

                var dCode =
                    "+" +
                    iti.getSelectedCountryData().dialCode +
                    "-" +
                    iti.getSelectedCountryData().iso2;
                if (0 < dialCodeElement.length) {
                    if (
                        typeof iti.getSelectedCountryData().dialCode !== "undefined" &&
                        "" == dialCodeElement.val()
                    ) {
                        dialCodeElement.val(dCode);
                    }
                } else {
                    $("<input>")
                        .attr({
                            type: "hidden",
                            name: elementName,
                            value: dCode,
                        })
                        .insertAfter(input);
                }

                input.addEventListener("countrychange", function (e) {
                    if (typeof iti.getSelectedCountryData().dialCode !== "undefined") {
                        var dCode =
                            "+" +
                            iti.getSelectedCountryData().dialCode +
                            "-" +
                            iti.getSelectedCountryData().iso2;
                        if ($('input[name="' + elementName + '"]').length < 1) {
                            fcom.displayErrorMessage($(input).attr("name") + " " + langLbl.dialCodeFieldNotFound);
                            return;
                        }
                        $('input[name="' + elementName + '"]').val(dCode);
                    }
                });
            }
        });
    };

    getCountryIso2CodeFromDialCode = function (dialCode) {
        var countriesData = window.intlTelInputGlobals.getCountryData();
        var countryData = countriesData.filter(function (country) {
            return country.dialCode == dialCode;
        });
        return countryData[0].iso2;
    }

    installJsColor = function () {
        if (0 < $(".jscolor").length) {
            $(".jscolor").each(function () {
                $(this).attr("data-jscolor", "{}");
            });
            jscolor.install();
        }
    };

    bindMaxLengthValidator = function () {
        $('[maxlength]').maxlength({
            alwaysShow: true,
            threshold: 10,
            warningClass: "badge badge-info",
            limitReachedClass: "badge badge-warning",
            placement: 'top',
            message: langLbl.maxLengthValidator
        });
    }
    /*
    $(document).ajaxStart(function () {
        Set loader height and width. 
        if (0 < $(".loaderJs").length) {
            $(".loaderJs").each(function () {
                if (0 < $(this).siblings('table:visible').length) {
                    var selector = $(this).siblings('table');
                } else {
                    var selector = $(this).parent();
                }
                var width = selector.outerWidth();
                var height = selector.outerHeight();

                $(this).css({ 'width': width, 'height': height });
            });
        }
    });
    */

    $(document).ajaxComplete(function () {
        setTimeout((function () {
            if ('undefined' != typeof $.fn.popover) {
                $('[data-bs-toggle="popover"]').popover();
            }
        }), 500);

        /* Bind bootstrap tooltip with ajax elements. */
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        }).on('click', function () {
            setTimeout(() => {
                $(this).tooltip('hide');
            }, 100);
        });

        /* Bind Scoll hand if table width is wider. */
        new ScrollHint(".js-scrollable");

        /* Bind colors with all color fields. */
        installJsColor();

        /* Bind Max Length validator. */
        bindMaxLengthValidator();

        /* Format Phone Number */
        setTimeout(() => {
            stylePhoneNumberFld('.phoneJs');
        }, 200);

        /* Disable Top Action button if no item selected. */
        if (typeof $(".selectItemJs:checked").val() === "undefined") {
            $(".toolbarBtnJs").addClass("btn-outline-gray disabled").removeClass("btn-outline-brand selected");
        }

        /* Binding Feather Light gallery */
        bindFeatherLight();
        /* Binding Feather Light gallery */
    });
})();

var map;
var marker;
var geocoder;
var infowindow;
/* Initialize the map. */
function initMap(lat = 40.72, lng = -73.96, elementId = "map") {
    var lat = parseFloat(lat);
    var lng = parseFloat(lng);
    var latlng = { lat: lat, lng: lng };
    var address = "";
    if (1 > $("#" + elementId).length) {
        return;
    }

    if (typeof google !== 'object' || typeof google.maps !== 'object') { return; }

    map = new google.maps.Map(document.getElementById(elementId), {
        zoom: 12,
        center: latlng,
    });
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();

    var sel = document.getElementById("geo_country_code");
    var country = sel.options[sel.selectedIndex].text;
    if (country != null || country != "") {
        address = country;
    }

    var sel = document.getElementById("geo_state_code");
    var state = sel.options[sel.selectedIndex].text;
    if (state != null || state != "") {
        address = address + " " + state;
    }

    var zip = document.getElementById("geo_postal_code");
    if (zip != null) {
        address = address + " " + zip.value;
    }

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: address,
        draggable: true,
    });
    google.maps.event.addListener(marker, 'dragend', function () {
        geocoder.geocode(
            { latLng: marker.getPosition() },
            function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    geocodeSetData(results);
                }
            }
        );
    });

    document
        .getElementById("geo_postal_code")
        .addEventListener("blur", function () {
            var sel = document.getElementById("geo_country_code");
            var country = sel.options[sel.selectedIndex].text;

            address = document.getElementById("geo_postal_code").value;
            address = country + " " + address;

            geocodeAddress(geocoder, map, infowindow, { address: address });
        });

    document
        .getElementById("geo_state_code")
        .addEventListener("change", function () {
            var sel = document.getElementById("geo_country_code");
            var country = sel.options[sel.selectedIndex].text;

            var sel = document.getElementById("geo_state_code");
            var state = sel.options[sel.selectedIndex].text;

            address = country + " " + state;

            geocodeAddress(geocoder, map, infowindow, { address: address });
        });

    document
        .getElementById("geo_country_code")
        .addEventListener("change", function () {
            var sel = document.getElementById("geo_country_code");
            var country = sel.options[sel.selectedIndex].text;

            geocodeAddress(geocoder, map, infowindow, { address: country });
        });
}

function geocodeAddress(geocoder, resultsMap, infowindow, address) {
    geocoder.geocode(address, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            if (marker && marker.setMap) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location,
                draggable: true,
            });
            geocodeSetData(results);
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode(
                    { latLng: marker.getPosition() },
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            geocodeSetData(results);
                        }
                    }
                );
            });
        } else {
            fcom.displayErrorMessage(
                "Geocode was not successful for the following reason: " + status
            );
        }
    });
}

function bytesToSize(bytes) {
    var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    if (bytes == 0) return "0 Byte";
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

function geocodeSetData(results) {
    if (null == document.getElementById("lat") || null == document.getElementById("lng")) {
        return false;
    }
    document.getElementById("lat").value = marker.getPosition().lat();
    document.getElementById("lng").value = marker.getPosition().lng();
    if (results[0]) {
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
        var address_components = results[0].address_components;
        var data = {};
        data["formatted_address"] = results[0].formatted_address;
        if (0 < address_components.length) {
            var addressComponents = address_components;
            for (var i = 0; i < addressComponents.length; i++) {
                var key = address_components[i].types[0];
                var value = address_components[i].long_name;
                data[key] = value;
                if ("country" == key) {
                    data["country_code"] = address_components[i].short_name;
                    data["country"] = value;
                } else if ("administrative_area_level_1" == key) {
                    data["state_code"] = address_components[i].short_name;
                    data["state"] = value;
                } else if ("administrative_area_level_2" == key) {
                    data["city"] = value;
                } else if ("locality" == key) {
                    data["city"] = value;
                }
            }
        }
        $("#geo_postal_code").val(data.postal_code);
        if (data.hasOwnProperty("city")) {
            $("#geo_city").val(data.city);
        } else {
            $("#geo_city").val(data.state);
        }

        $("#geo_country_code option").each(function () {
            if (this.text == data.country) {
                $("#geo_country_code").val(this.value);
                var state = 0;
                $("#geo_state_code option").each(function () {
                    if (this.value == data.state_code || this.text == data.state) {
                        return (state = this.value);
                    }
                });
                getStatesByCountryCode(
                    this.value,
                    state,
                    "#geo_state_code",
                    "state_code"
                );
                return false;
            }
        });
    }
}

/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "#quickSearchJs", function () {
    if ("" == $(this).val()) {
        resetQuickSearchResults();
    }
});

$(document).on("keyup", "#quickSearchJs", function (e) {
    if ("" == $(this).val()) {
        resetQuickSearchResults();
        return;
    }

    quickMenuItemSearch($(this), e);
});

$(document).on("shown.bs.modal", "#search-main", function () {
    if (0 < $("#quickSearchJs").length) {
        $("#quickSearchJs").focus();
    }
});


$(window).keydown(function (e) {
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) {
        if ($("#search-main").is(':visible')) {
            $("#search-main").modal("hide");
            return;
        }
        $("#search-main").modal("show");
        e.preventDefault();
    }
});

$(document).on("click", ".sidebarOpenerBtnJs", function () {
    if ($(this).hasClass('active')) {
        $.cookie('adminSidebar', 0, { expires: 30, path: siteConstants.rooturl });
        $("body").attr("data-sidebar-minimize", "on");
        $(this).removeClass("active");
        $(this).attr('title', langLbl.clickToExpand);

    } else {
        $.cookie('adminSidebar', 1, { expires: 30, path: siteConstants.rooturl });
        $("body").attr("data-sidebar-minimize", "off");
        $(this).addClass("active");
        $(this).attr('title', langLbl.clickToHide);
    }
    $('#sidebar').addClass("animating");
    setInterval(function () { $('#sidebar').removeClass("animating"); }, 2000);
});