

if (getCookie("screenWidth") != screen.width) {
    $.ajax({ url: fcom.makeUrl('Custom', 'updateScreenResolution', [screen.width, screen.height], siteConstants.webrootfront) });
}

/*Ripple*/
$('[ripple]').on('click', function (e) {
    var rippleDiv = $('<div class="ripple" />'),
        rippleOffset = $(this).offset(),
        rippleY = e.pageY - rippleOffset.top,
        rippleX = e.pageX - rippleOffset.left,
        ripple = $('.ripple');

    rippleDiv.css({
        top: rippleY - (ripple.height() / 2),
        left: rippleX - (ripple.width() / 2),
        background: $(this).attr("ripple-color")
    }).appendTo($(this));

    window.setTimeout(function () {
        rippleDiv.remove();
    }, 1500);
});

markNavActive = function (ele) {
    if (!ele.hasClass("active")) {
        ele.addClass("active");
    }

    $(ele).closest('.dropdownJs').find(".menuLinkJs").click();
};

/*Tabs*/
$(document).ready(function () {
    $(".tabs-content-js").hide();
    $(".tabs--flat-js li:first").addClass("is-active").show();
    $(".section").find(".tabs-content-js:first").show();
    $(".menuLinkJs.collapsed").attr('aria-expanded', false);
    $(".tabs--flat-js li").click(function () {
        $(this).parent().find("li").removeClass("is-active");
        $(this).addClass("is-active");
        $(".tabs-content-js").hide();
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn();
        return false;
        setSlider();
    });

    /* if (CONF_ENABLE_GEO_LOCATION && CONF_MAINTENANCE == 0 && (getCookie('_ykGeoDisabled') != 1 || className == 'CheckoutController' || className == 'CartController')) {
        accessLocation();
    } */

    /* Active Sidebar Link. */
    var uri = window.location.pathname.replace(/^\/|\/$/g, "");

    $(".sidebarMenuJs .navLinkJs").each(function () {
        var attr = $(this).attr("href");
        var href = '';
        if (typeof attr !== 'undefined' && attr !== false) {
            var href = attr.replace(/^\/|\/$/g, "");
        }

        if (uri == href) {
            markNavActive($(this));
        }
    });

    $(".navLinkJs.active:not(.noCollapseJs)").closest('ul').addClass('show').siblings('.menuLinkJs').addClass('active').removeClass('collapsed');
    /* Active Sidebar Link. */
});

$(document).on('afterClose.facebox', $('.location-permission').closest("#facebox"), function () {
    setCookie('_ykGeoDisabled', 1, 0.5);
});

$("document").ready(function () {
    $('.parents--link').click(function () {
        $(this).parent().toggleClass("is--active");
        $(this).parent().find('.childs').toggleClass("opened");
    });
    /* for Dashbaord Links form */
});

// Wait for window load
$(window).on('load', function () {
    // Animate loader off screen
    $(".pageloader").remove();
    setSelectedCatValue();
});

$(document).ready(function () {
    /* for footer */
    if ($(window).width() < 576) {
        /* FOR FOOTER TOGGLES */
        $('.toggle__trigger-js').click(function () {
            if ($(this).hasClass('is-active')) {
                $(this).removeClass('is-active');
                $(this).siblings('.toggle__target-js').slideUp(); return false;
            }
            $('.toggle__trigger-js').removeClass('is-active');
            $(this).addClass("is-active");
            $('.toggle__target-js').slideUp();
            $(this).siblings('.toggle__target-js').slideDown();
        });
    }

    /* for footer accordion */
    $(function () {
        $('.accordion_triger').on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).next()
                    .stop()
                    .slideUp(300);
            } else {
                $(this).addClass('active');
                $(this).next()
                    .stop()
                    .slideDown(300);
            }
        });
    });


    /* for cart area */
    $('.cart').on('click', function () {
        if ($('html').hasClass('toggled-user')) {
            $('.dropdown__trigger-js').parent('.dropdown').removeClass("is-active");
            $("html").removeClass("toggled-user");
        }
    });
    $('html').click(function () {
        if ($('.collection__container').hasClass('open-menu')) {
            $('.open-menu').parent().toggleClass('is-active');
            $('.open-menu').toggleClass('open-menu');
        }
    });

    $('.cart').click(function (e) {
        e.stopPropagation();
    });


});

/*ripple effect*/
$(function () {
    var ink, d, x, y;
    $(".ripplelink, .slick-arrow").click(function (e) {
        if ($(this).find(".ink").length === 0) {
            $(this).prepend("<span class='ink'></span>");
        }
        ink = $(this).find(".ink");
        ink.removeClass("animate");

        if (!ink.height() && !ink.width()) {
            d = Math.max($(this).outerWidth(), $(this).outerHeight());
            ink.css({ height: d, width: d });
        }
        x = e.pageX - $(this).offset().left - ink.width() / 2;
        y = e.pageY - $(this).offset().top - ink.height() / 2;
        ink.css({ top: y + 'px', left: x + 'px' }).addClass("animate");
    });
});



/*back-top*/
$(document).ready(function () {

    $('.switch-button').click(function () {
        $(this).toggleClass("is--active");
        if ($(this).hasClass("buyer") && !$(this).hasClass("is--active")) {
            window.location.href = fcom.makeUrl('seller', '', [], siteConstants.webrootfront);
        } if ($(this).hasClass("seller") && $(this).hasClass("is--active")) {
            window.location.href = fcom.makeUrl('buyer', '', [], siteConstants.webrootfront);
        }
    });

    var t;
    $('a.loadmore').on('click', function (e) {
        e.preventDefault();
        clearTimeout(t);
        $(this).toggleClass('loading');
        t = setTimeout(function () {
            $('a.loadmore').removeClass("loading")
        }, 2500);
    });

});



/*  like animation  */
$(document).ready(function () {
    var debug = /*true ||*/ false;
    var h = document.querySelector('.heart-wrapper-Js');

    /*   function toggleActivate(){
        h.classList.toggle('is-active');
      }   */

    if (debug) {
        var elts = Array.prototype.slice.call(h.querySelectorAll(':scope > *'), 0);
        var activated = false;
        var animating = false;
        var count = 0;
        var step = 1000;

        function setAnim(state) {
            elts.forEach(function (elt) {
                elt.style.animationPlayState = state;
            });
        }

        h.addEventListener('click', function () {
            if (animating) return;
            if (count > 27) {
                h.classList.remove('is-active');
                count = 0;
                return;
            }
            if (!activated) h.classList.add('is-active') && (activated = true);

            animating = true;

            setAnim('running');
            setTimeout(function () {
                setAnim('paused');
                animating = false;
            }, step);
        }, false);

        setAnim('paused');
        elts.forEach(function (elt) {
            elt.style.animationDuration = step / 1000 * 27 + 's';
        });
    }
});

$(function () {
    var elem = "";
    var settings = {
        mode: "toggle",
        limit: 2,
    };
    var text = "";
    $.fn.viewMore = function (options) {
        $.extend(settings, options)
        text = $(this).html();
        elem = this;
        initialize();
    };

    function initialize() {
        total_li = $(elem).children('ul').children('li').length;
        limit = settings.limit;
        extra_li = total_li - limit;
        if (total_li > limit) {
            $(elem).children('ul').children('li:gt(' + (limit - 1) + ')').hide();
            $(elem).append('<a class="read_more_toggle closed"  onclick="bindChangeToggle(this);"><span class="ink animate"></span> <span class="read_more">View More</span></a>');
        }
    }
});

function bindChangeToggle(obj) {
    if ($(obj).hasClass('closed')) {
        $(obj).find('.read_more').text('.. View Less');
        $(obj).removeClass('closed');
        $('#accordian').children('ul').children('li').show();
    } else {
        $(obj).addClass('closed');
        $(obj).find('.read_more').text('.. View More');
        $('#accordian').children('ul').children('li:gt(0)').hide();
    }
}

function setSelectedCatValue(id) {
    var currentId = 'category--js-' + id;
    var e = document.getElementById(currentId);
    if (e != undefined) {
        var catName = e.text;
        $(e).parent().siblings().removeClass('is-active');
        $(e).parent().addClass('is-active');
        $('#selected__value-js').html(catName);
        $('#selected__value-js').closest('form').find('input[name="category"]').val(id);
        $('.dropdown__trigger-js').parent('.dropdown').removeClass("is-active");
    }
}

function setQueryParamSeperator(urlstr) {
    if (urlstr.indexOf("?") > -1) {
        return '&';
    }
    return '?';
}

function animation(obj) {
    if ($(obj).val().length > 0) {
        if (!$('.submit--js').hasClass('is--active'))
            $('.submit--js').addClass('is--active');
    } else {
        $('.submit--js').removeClass('is--active');
    }
}

(function () {
    Slugify = function (str, str_val_id, is_slugify, caption) {
        var str = str.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');
        if ($("#" + is_slugify).val() == 0) {
            $("#" + str_val_id).val(str).keyup();
            //$("#" + str_val_id).val(str);
            $("#" + caption).html(siteConstants.webroot + str);
        }
    };

    getSlugUrl = function (obj, str, extra, pos) {
        if (typeof pos == undefined || pos == null) {
            pos = 'pre';
        }
        var str = str.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');
        if (extra && pos == 'pre') {
            str = extra + '-' + str;
        } if (extra && pos == 'post') {
            str = str + '-' + extra;
        }
        $(obj).next().html(siteConstants.webrootfront + str);
    };

    getIdentifier = function (obj) {
        $(obj).next().html(langLbl.systemIdentifier + " : " + obj.value);
    };
})();

/* scroll tab active function */
moveToTargetDiv('.tabs--scroll ul li.is-active', '.tabs--scroll ul', langLbl.layoutDirection);

$(document).on('click', '.tabs--scroll ul li', function () {
    if ($(this).hasClass('fat-inactive')) { return; }
    $(this).closest('.tabs--scroll ul li').removeClass('is-active');
    $(this).addClass('is-active');
    moveToTargetDiv('.tabs--scroll ul li.is-active', '.tabs--scroll ul', langLbl.layoutDirection);
});

function moveToTargetDiv(target, outer, layout) {
    var out = $(outer);
    var tar = $(target);
    //var x = out.width();
    //var y = tar.outerWidth(true);
    var z = tar.index();
    var q = 0;
    var m = out.find('li');

    for (var i = 0; i < z; i++) {
        q += $(m[i]).outerWidth(true) + 4;
    }

    $('.tabs--scroll ul').animate({
        scrollLeft: Math.max(0, q)
    }, 800);
    return false;
}

function moveToTargetDivssss(target, outer, layout) {
    var out = $(outer);
    var tar = $(target);
    var z = tar.index();
    var m = out.find('li');

    if (layout == 'ltr') {
        var q = 0;
        for (var i = 0; i < z; i++) {
            q += $(m[i]).outerWidth(true) + 4;
        }
    } else {
        var ulWidth = 0;
        $(outer + " li").each(function () {
            ulWidth = ulWidth + $(this).outerWidth(true);
        });

        var q = 0;
        for (var i = 0; i <= z; i++) {
            q += $(m[i]).outerWidth(true);
        }
        q = ulWidth - q;

        /* var q = out.last().outerWidth(true);
        var q = ulWidth;
        for(var i = z; i > 0; i--){
            q-= $(m[i]).outerWidth(true);
        }   */
    }
    out.animate({
        scrollLeft: Math.max(0, q)
    }, 800);
    return false;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/*Google reCaptcha V3  */
function googleCaptcha() {
    $("body").addClass("captcha");
    var inputObj = $("form input[name='g-recaptcha-response']");
    if ('' != inputObj.val()) { return; }

    var submitBtn = inputObj.parent("form").find('input[type="submit"]');
    fcom.displayProcessing();
    submitBtn.attr({ "disabled": "disabled", "type": "button" });

    var counter = 0;
    var checkToken = setInterval(function () {
        counter++
        /* Check if not loaded until 30 Sec = counter 150. Because it run 5 times in 1 sec. */
        if (150 == counter) {
            fcom.displayErrorMessage(langLbl.invalidGRecaptchaKeys);
            clearInterval(checkToken);
            return;
        }

        if (0 < inputObj.length && 'undefined' !== typeof grecaptcha) {
            grecaptcha.ready(function () {
                try {
                    grecaptcha.execute(langLbl.captchaSiteKey, { action: inputObj.data('action') }).then(function (token) {
                        inputObj.val(token);
                        submitBtn.removeAttr("disabled").attr('type', 'submit');
                        clearInterval(checkToken);
                        $.ykmsg.close();
                    });
                }
                catch (error) {
                    fcom.displayErrorMessage(error);
                    return;
                }
            });
        }
    }, 200); /* 1000 MS = 1 Sec. */
    return;
}

function getLocation() {
    return {
        'lat': getCookie('_ykGeoLat'),
        'lng': getCookie('_ykGeoLng'),
        'countryCode': getCookie('_ykGeoCountryCode'),
        'stateCode': getCookie('_ykGeoStateCode'),
        'zip': getCookie('_ykGeoZip')
    };
}

/* function accessLocation(force = false) {
    var location = getLocation();
    if ("" == location.lat || "" == location.lng || "" == location.countryCode || force) {
        fcom.ajax(fcom.makeUrl('Home', 'accessLocation', [], siteConstants.webrootfront), '', function (t) {
            try {
                var json = $.parseJSON(t);
                if (1 > json.status) {
                    fcom.displayErrorMessage(json.msg);
                }
                $.ykmodal.close();
                return false;
            } catch (exc) {
                $.ykmodal(t);
                googleAddressAutocomplete();
            }
        });
    }
} */

function loadGeoLocation() {
    if (!CONF_ENABLE_GEO_LOCATION) {
        return;
    }

    if (typeof navigator.geolocation == 'undefined') {
        fcom.displayErrorMessage(langLbl.geoLocationNotSupported);
        return false;
    }

    navigator.geolocation.getCurrentPosition(function (position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        codeLatLng(lat, lng, getGeoAddress);
    }, function (error) {
        if (1 == error.code) {
            fcom.displayErrorMessage(error.message);
        }
    });
}

function setGeoAddress(data) {
    var address = '';
    setCookie('_ykGeoLat', data.lat);
    setCookie('_ykGeoLng', data.lng);

    if ('undefined' != typeof data.postal_code) {
        setCookie('_ykGeoZip', data.postal_code);
        address += data.postal_code + ', ';
    }

    if ('undefined' != typeof data.city) {
        address += data.city + ', ';
    }

    if ('undefined' != typeof data.state) {
        setCookie('_ykGeoStateCode', data.state_code);
        address += data.state + ', ';
    }

    if ('undefined' != typeof data.country) {
        setCookie('_ykGeoCountryCode', data.country_code);
        address += data.country + ', ';
    }
    address = address.replace(/,\s*$/, "");

    var formatedAddr = ('undefined' == typeof data.formatted_address) ? '' : data.formatted_address;
    address = ('' == address) ? formatedAddr : address;

    setCookie('_ykGeoAddress', address);

    return address;
}

function getGeoAddress(data) {
    address = setGeoAddress(data);

    displayGeoAddress(address);
}

var canSetCookie = false;
function setCookie(cname, cvalue, exdays = 365) {
    if (false == canSetCookie) {
        return false;
    }
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";domain=" + window.location.hostname + ";path=/";
    if ('' != callback) {
        callback();
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function displayGeoAddress(address) {
    if (0 < $("#js-curent-zip-code").length) {
        $("#js-curent-zip-code").text(address);
    }
}

function googleAddressAutocomplete(elementId = 'ga-autoComplete', field = 'formatted_address', saveCookie = true, callback = 'googleSelectedAddress') {
    canSetCookie = saveCookie;
    if (1 > $("#" + elementId).length) {
        var msg = (langLbl.fieldNotFound).replace('{field}', elementId + ' Field');
        fcom.displayErrorMessage(msg);
        return false;
    }
    var fieldElement = document.getElementById(elementId);
    setTimeout(function () { $("#" + elementId).attr('autocomplete', 'no'); }, 500);
    var options = {
        /* types: ['address'] */
        fields: ["formatted_address", "geometry", "name", "address_components"],
    }

    if (typeof google !== 'object' || typeof google.maps !== 'object') { return; }

    var autocomplete = new google.maps.places.Autocomplete(fieldElement, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        var lat = place['geometry']['location'].lat();
        var lng = place['geometry']['location'].lng();
        var address = '';
        var data = {};
        data['lat'] = lat;
        data['lng'] = lng;
        data['formatted_address'] = place['formatted_address'];
        if (0 < place.address_components.length) {
            var addressComponents = place.address_components;
            for (var i = 0; i < addressComponents.length; i++) {
                var key = place.address_components[i].types[0];
                var value = place.address_components[i].long_name;
                data[key] = value;
                if ('country' == key) {
                    data['country_code'] = place.address_components[i].short_name;
                    data['country'] = value;
                } else if ('administrative_area_level_1' == key) {
                    data['state_code'] = place.address_components[i].short_name;
                    data['state'] = value;
                } else if ('administrative_area_level_2' == key) {
                    data['city'] = value;
                }
            }
            address = setGeoAddress(data);
            if ('' == address) {
                var msg = (langLbl.fieldNotFound).replace('{field}', field);
                fcom.displayErrorMessage(msg);
            }

            $("#" + elementId).val(address);
            displayGeoAddress(address);
        }

        if (0 < $("#facebox #" + elementId).length) {

        }
        if (eval("typeof " + callback) == 'function') {
            window[callback](data);
        }
        return data;
    });
}

function getSelectedCountry() {
    var country = document.getElementById('shop_country_code');
    return country[0].selectedOptions[0].innerText;
}

var map;
var marker;
var geocoder;
var infowindow;
// Initialize the map.
function initMap(lat = 40.72, lng = -73.96, elementId = 'map') {
    var lat = parseFloat(lat);
    var lng = parseFloat(lng);
    var latlng = { lat: lat, lng: lng };
    var address = '';
    if (1 > $("#" + elementId).length) {
        return;
    }

    if (typeof google !== 'object' || typeof google.maps !== 'object') { return; }

    map = new google.maps.Map(document.getElementById(elementId), {
        zoom: 12,
        center: latlng
    });
    geocoder = new google.maps.Geocoder;
    infowindow = new google.maps.InfoWindow;

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

    document.getElementById('postal_code').addEventListener('blur', function () {
        var sel = document.getElementById('shop_country_code');
        var country = sel.options[sel.selectedIndex].text;

        var sel = document.getElementById('shop_state');
        var state = sel.selectedIndex > 0 ? sel.options[sel.selectedIndex].text : '';

        var postalCode = document.getElementById('postal_code').value;
        geocodeAddress(geocoder, map, infowindow, { 'address': `${state} ${postalCode}, ${country}` });
    });

    document.getElementById('shop_state').addEventListener('change', function () {
        var sel = document.getElementById('shop_country_code');
        var country = sel.options[sel.selectedIndex].text;

        var sel = document.getElementById('shop_state');
        var state = sel.selectedIndex > 0 ? sel.options[sel.selectedIndex].text + ',' : '';
        geocodeAddress(geocoder, map, infowindow, { 'address': `${state} ${country}` });
    });

    document.getElementById('shop_country_code').addEventListener('change', function () {
        var sel = document.getElementById('shop_country_code');
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
            fcom.displayErrorMessage(
                "Geocode was not successful for the following reason: " + status
            );
        }
    });
}

function geocodeSetData(results) {
    if (null == document.getElementById("lat") || null == document.getElementById("lng")) {
        return false;
    }
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
                }
            }
        }
        $('#postal_code').val(data.postal_code);

        if ($('#shop_country_code').find("option[value='" + data.country_code + "']").length) {
            var state = $('#shop_state').val() != '' ? $('#shop_state').val() : 0;
            if (undefined != data.state_code) {
                $('#shop_state option').each(function () {
                    if ($(this).val() == data.state_code || this.text == data.state || this.text == data.locality) {
                        state = $(this).val();
                        return false;
                    }
                });
            }
            getStatesByCountryCode(data.country_code, state, '#shop_state', 'state_code');
        }
    }
}

function loadScript(src, callback = '', params = []) {
    if ($('script[src="' + src + '"]').length) {
        callback.apply(this, params);
        return;
    }

    let script = document.createElement('script');
    script.src = src;
    if ('' != callback) {
        script.onload = function () {
            callback.apply(this, params);
        };
    }

    document.head.append(script);
}

/*
expected response
{
  "results": [
    {
      "id": 1,
      "text": "Option 1"
    },
    {
      "id": 2,
      "text": "Option 2"
    }
  ],
  "pageCount" : 3 
}

postdata object| callback function like {record:1}
*/
select2 = function (
    elmId,
    url,
    postdata = {},
    callbackOnSelect = "",
    callbackOnUnSelect = "",
    processResultsCallback = "",
    data = [],
) {
    let ele = $("#" + elmId);
    if (1 > ele.length) {
        return false;
    }

    var obj = ele.closest('.modal').length ? ele.closest('form') : null;
    ele.select2({
        dropdownParent: obj,
        closeOnSelect: ele.data("closeOnSelect") || true,
        data: data,
        dir: langLbl.layoutDirection,
        allowClear: ele.data("allowClear") || true,
        placeholder: ele.attr("placeholder") || "",
        ajax: {
            url: url,
            dataType: "json",
            delay: 250,
            method: "post",
            data: function (params) {
                return $.extend(
                    {
                        keyword: params.term, // search term
                        page: params.page,
                        fIsAjax: 1,
                    },
                    ("function" == typeof postdata ? postdata(ele) : postdata)
                );
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                data.pageCount = data.pageCount || 1;
                if ("function" == typeof processResultsCallback) {
                    return processResultsCallback(data, params, ele);
                }
                return {
                    results: data.results,
                    pagination: {
                        more: params.page < data.pageCount,
                    },
                };
            },
            cache: true,
        },
        minimumInputLength: 0,
        dropdownPosition: "below",
    })
        .on("select2:selecting", function (e) {
            if ("function" == typeof callbackOnSelect) {
                callbackOnSelect(e);
            }
        })
        .on("select2:unselecting", function (e) {
            if ("function" == typeof callbackOnUnSelect) {
                callbackOnUnSelect(e);
            }
        }).on('select2:open', function (e) {
            if (ele.attr('multiple') == undefined) {
                $('#select2-' + elmId + '-results').closest('.select2-dropdown').addClass("custom-select2 custom-select2-single")
            } else {
                $('#select2-' + elmId + '-results').closest('.select2-dropdown').addClass("custom-select2 custom-select2-multiple");
            }
        });

    var select2Selector = ele.data("select2");
    var elementName = ele.attr('name').replace('[]', '');
    if ('undefined' != typeof (select2Selector.dropdown)) {
        $(select2Selector.dropdown.$search).attr('name', elementName + '-select2');
    }

    if ('undefined' != typeof (select2Selector.selection)) {
        $(select2Selector.selection.$search).attr('name', elementName + '-select2');
    }

    if (0 < ele.closest(".advancedSearchJs").length || 0 < ele.closest(".form-group").length) {
        select2Selector.$container.addClass("custom-select2-width");
    }

    if (ele.attr('multiple') != undefined) {
        select2Selector.$container.addClass("custom-select2 custom-select2-multiple");
    } else {
        select2Selector.$container.addClass("custom-select2 custom-select2-single");
    }
};

var autoOpenSideBar = true;
$(document).on("hidden.bs.modal", "#modalBoxJs", function () {
    if (autoOpenSideBar) {
        $.ykmodal.show();
    }
});

loadCropperSkeleton = function (reopenSideBarOnClose = true) {
    autoOpenSideBar = reopenSideBarOnClose;
    $("#modalBoxJs").remove();
    $("body").append(fcom.getModalBody());
    $("#modalBoxJs").modal("show");
    $.ykmodal.close();
};

editDropZoneImages = function (obj) {
    $(obj).closest(".dropzoneContainerJs").find(".dropzoneInputJs").click();
}

