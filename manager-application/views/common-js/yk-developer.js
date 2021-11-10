$(document).ready(function () {
    if (/ip(hone|od)|ipad/i.test(navigator.userAgent)) {
        $("body").css("cursor", "pointer");
    }
});


(function () {
    var screenHeight = $(window).height() - 100;
    window.onresize = function (event) {
        var screenHeight = $(window).height() - 100;
    };

    $.extend(fcom, {
        scrollToTop: function (obj) {
            if (typeof obj == undefined || obj == null) {
                $('html, body').animate({
                    scrollTop: $('html, body').offset().top - 100
                }, 'slow');
            } else {
                $('html, body').animate({
                    scrollTop: $(obj).offset().top - 100
                }, 'slow');
            }
        },

        resetEditorInstance: function () {
            if (typeof oUtil != 'undefined') {
                var editors = oUtil.arrEditor;
                for (x in editors) {
                    eval('delete window.' + editors[x]);
                }
                oUtil.arrEditor = [];
            }
        },

        resetEditorWidth: function (width = "100%") {
            if (typeof oUtil != 'undefined') {
                (oUtil.arrEditor).forEach(function (input) {
                    var oEdit1 = eval(input);
                    $("#idArea" + oEdit1.oName).attr("width", width);
                });
            }
        },

        setEditorLayout: function (lang_id) {
            var editors = oUtil.arrEditor;
            layout = langLbl['language' + lang_id];
            for (x in editors) {
                var oEdit1 = eval(editors[x]);
                if ($('#idArea' + oEdit1.oName).parents(".layout--rtl").length) {
                    $('#idContent' + editors[x]).contents().find("body").css('direction', layout);
                    $('#idArea' + oEdit1.oName + ' td[dir="ltr"]').attr('dir', layout);
                }
            }
        },

        getLoader: function () {
            $(document.body).css({ 'cursor': 'wait' });
            $('.loaderJs').remove();
            return '<div class="table-processing loaderJs"><div class="spinner spinner--sm spinner--brand"></div></div>';
        },

        getModalBody: function () {
            return '<div class="modal fade" id="modalBoxJs"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalBoxJsLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h6 class="modal-title"></h6><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="table-processing loaderJs"><div class="spinner spinner--sm spinner--brand"></div></div></div><div class="modal-footer"></div></div></div></div>';
        },

        removeLoader: function (cls) {
            $(document.body).css({ 'cursor': 'default' });
            $('.loaderJs').remove();
            $('.submitBtnJs').removeClass('loading');
        },

        getRowSpinner: function () {
            return '<div class="spinner spinner--v2 spinner--sm spinner--brand"></div>';
        },
    });

    clearCache = function () {
        // $(document.body).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Home', 'clear'), '', function (t) {
            window.location.reload();
        });
    };

    quickMenuItemSearch = function (e) {
        var value = e.val().toLowerCase();
        if (value.length < 1) {
            return;
        }
        $(".navMenuItems li").find('h6').hide();
        $(".navMenuItems li").find('.search-result').hide();

        $(".navMenuItems li .search-result").each(function () {
            if ($(this).find('a').text().toLowerCase().search(value) > -1) {
                $(this).parent('li').find('h6').show();
                $(this).show();
                $('.navMenuItems').show();
            } else {
                $(this).hide();
                $('.navMenuItems').show();
            }
        });

        $(".navMenuItems li").each(function () {
            if ($(this).find('h6').text().toLowerCase().search(value) > -1) {
                $(this).show();
                $(this).find('h6').show();
                $(this).find('.search-result').show();
                $('.navMenuItems').show();
            }
        });
    };

    isJson = function (str) {
        try {
            var json = JSON.parse(str);
        } catch (e) {
            return false;
        }
        return json;
    }


    getCountryStates = function (countryId, stateId, dv) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Configurations', 'getStates', [countryId, stateId]), '', function (res) {
            $.ykmsg.close();
            $(dv).empty();
            $(dv).append(res);
        });
    };

    getStatesByCountryCode = function (countryCode, stateCode, dv, idCol = 'state_id') {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Configurations', 'getStatesByCountryCode', [countryCode, stateCode, idCol]), '', function (res) {
            $.ykmsg.close();
            $(dv).empty();
            $(dv).append(res).change();
        });
    };

    sortObjectByKeys = function (o) {
        return Object.keys(o).sort().reduce((r, k) => (r[k] = o[k], r), {});
    }

})();

var map;
var marker;
var geocoder;
var infowindow;
/* Initialize the map. */
function initMap(lat = 40.72, lng = -73.96, elementId = 'map') {
    var lat = parseFloat(lat);
    var lng = parseFloat(lng);
    var latlng = { lat: lat, lng: lng };
    var address = '';
    if (1 > $("#" + elementId).length) {
        return;
    }
    map = new google.maps.Map(document.getElementById(elementId), {
        zoom: 12,
        center: latlng
    });
    geocoder = new google.maps.Geocoder;
    infowindow = new google.maps.InfoWindow;

    var sel = document.getElementById('geo_country_code');
    var country = sel.options[sel.selectedIndex].text;
    if (country != null || country != '') {
        address = country;
    }

    var sel = document.getElementById('geo_state_code');
    var state = sel.options[sel.selectedIndex].text;
    if (state != null || state != '') {
        address = address + ' ' + state;
    }

    var zip = document.getElementById('geo_postal_code');
    if (zip != null) {
        address = address + ' ' + zip.value;
    }

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: address,
        draggable: true,
    });

    google.maps.event.addListener(marker, 'dragend', function () {
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                geocodeSetData(results);
            }
        });
    });

    document.getElementById('geo_postal_code').addEventListener('blur', function () {
        var sel = document.getElementById('geo_country_code');
        var country = sel.options[sel.selectedIndex].text;

        address = document.getElementById('geo_postal_code').value;
        address = country + ' ' + address;

        geocodeAddress(geocoder, map, infowindow, { 'address': address });
    });

    document.getElementById('geo_state_code').addEventListener('change', function () {
        var sel = document.getElementById('geo_country_code');
        var country = sel.options[sel.selectedIndex].text;

        var sel = document.getElementById('geo_state_code');
        var state = sel.options[sel.selectedIndex].text;

        address = country + ' ' + state;

        geocodeAddress(geocoder, map, infowindow, { 'address': address });
    });

    document.getElementById('geo_country_code').addEventListener('change', function () {
        var sel = document.getElementById('geo_country_code');
        var country = sel.options[sel.selectedIndex].text;

        geocodeAddress(geocoder, map, infowindow, { 'address': country });
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
                draggable: true
            });
            geocodeSetData(results);
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        geocodeSetData(results);
                    }
                });
            });
        } else {
            $.ykmsg.error('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function geocodeSetData(results) {
    document.getElementById('lat').value = marker.getPosition().lat();
    document.getElementById('lng').value = marker.getPosition().lng();
    if (results[0]) {
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
        var address_components = results[0].address_components;
        var data = {};
        data['formatted_address'] = results[0].formatted_address;
        if (0 < address_components.length) {
            var addressComponents = address_components;
            for (var i = 0; i < addressComponents.length; i++) {
                var key = address_components[i].types[0];
                var value = address_components[i].long_name;
                data[key] = value;
                if ('country' == key) {
                    data['country_code'] = address_components[i].short_name;
                    data['country'] = value;
                } else if ('administrative_area_level_1' == key) {
                    data['state_code'] = address_components[i].short_name;
                    data['state'] = value;
                } else if ('administrative_area_level_2' == key) {
                    data['city'] = value;
                } else if ('locality' == key) {
                    data['city'] = value;
                }
            }
        }
        $('#geo_postal_code').val(data.postal_code);
        if (data.hasOwnProperty("city")) {
            $('#geo_city').val(data.city);
        } else {
            $('#geo_city').val(data.state);
        }

        $('#geo_country_code option').each(function () {
            if (this.text == data.country) {
                $('#geo_country_code').val(this.value);
                var state = 0;
                $('#geo_state_code option').each(function () {
                    if (this.value == data.state_code || this.text == data.state) {
                        return state = this.value;
                    }
                });
                getStatesByCountryCode(this.value, state, '#geo_state_code', 'state_code');
                return false;
            }
        });
    }
}

$(document).on("search", "#quickSearch", function (e) {
    quickMenuItemSearch($(this));
});

$(document).on("keyup", "#quickSearch", function (e) {
    quickMenuItemSearch($(this));
});

$(window).keydown(function (e) {
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) {
        if (!$('#quickSearchCtrl').is(':checked')) {
            $(".quickSearchMain").trigger('click');
            e.preventDefault();
        }
    }
});
