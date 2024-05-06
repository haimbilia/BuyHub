if (getCookie("screenWidth") != screen.width) {
	$.ajax({ url: fcom.makeUrl('Custom', 'updateScreenResolution', [screen.width, screen.height]) });
}

var Dashboard = function () {
	var menuChangeActive = function (el) {
		var hasSubmenu = $(el).hasClass("has-submenu");
		$(global.menuClass + " .is-active").removeClass("is-active");
		$(el).addClass("is-active");
	};
	var sidebarChangeWidth = function () {

		var $menuItemsTitle = $("li .menu-item__title");
		if ($("body").hasClass('sidebar-is-reduced')) {
			$("body").removeClass('sidebar-is-reduced').addClass('sidebar-is-expanded');
			$("<div class='sidebar-overlay--js'></div>").appendTo("body");
			var visibility = 1;
		} else {
			$("body").removeClass('sidebar-is-expanded').addClass('sidebar-is-reduced');
			$("div.sidebar-overlay--js").remove();
			var visibility = 0;
		}
		$.ajax({ url: fcom.makeUrl('Custom', 'setupSidebarVisibility', [visibility], siteConstants.webrootfront) });
		/* $("body").toggleClass("sidebar-is-reduced sidebar-is-expanded"); */
		$(".hamburger-toggle").toggleClass("is-opened");
		setTimeout(function () {
			unlinkSlick();
			// slickWidgetScroll();
		}, 500);
	};
	return {
		init: function init() {
			$(document).on("click", ".js-hamburger, .sidebar-overlay--js", sidebarChangeWidth);
			$(document).on("click", ".js-menu li", function (e) {
				menuChangeActive(e.currentTarget);
			});
		}
	};
}();
Dashboard.init();

$(document).on('click', '#showPass', function () {
	var passInput = $("#password");
	if ('' == passInput.val()) {
		return;
	}

	if (passInput.attr('type') === 'password') {
		passInput.attr('type', 'text');
		$(this).addClass('field-password-show');
	} else {
		passInput.attr('type', 'password');
		$(this).removeClass('field-password-show');
	}
});


$(document).on('click', '.menu-toggle ', function () {
	if (!$(this).parent().hasClass("is--active") && $(".collections-ui").hasClass("is--active")) {
		$(".collections-ui").removeClass("is--active")
		$(".menu-toggle").removeClass("cross");
		$('html').removeClass("nav-active");
	}
	$(this).parent().toggleClass("is--active");
	$('html').toggleClass("nav-active");
	$(this).toggleClass("cross");
});

/* Expand/collapse/accordion */
$(document).on('click', '.js-acc-triger', function (e) {
	e.preventDefault();
	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$(this).next().stop().slideUp(300);
	} else {
		$(this).addClass('active');
		$(this).next().stop().slideDown(300);
	}
});

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

/*Tabs*/
$(function () {
	$(".tabs-content-js").hide();
	$(".tabs--flat-js li:first").addClass("is-active").show();
	$(".section").find(".tabs-content-js:first").show();
	$(".tabs--flat-js li").on('click', function () {
		$(this).parent().find("li").removeClass("is-active");
		$(this).addClass("is-active");
		$(".tabs-content-js").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});

	if (CONF_ENABLE_GEO_LOCATION && className != 'CheckoutController' && className != 'CartController') {
		googleAddressAutocomplete('ga-autoComplete-header');
		googleAddressAutocomplete('ga-autoComplete-mobile');
	}

});

/* for search form */
$(document).on('click', '.toggle--search-js', function () {
	$(this).toggleClass("is--active");
	$('html').toggleClass("is--form-visible");
});

$(document).on('click', '.toggle--search', function () {
	setTimeout(function () { $(".search--keyword--js").focus(); }, 500);
});

$(document).ready(function () {
	markCatLinkActive();
	$('.parents--link').on('click', function () {
		$(this).parent().toggleClass("is--active");
		$(this).parent().find('.childs').toggleClass("opened");
	});
	/* for Dashbaord Links form */
});

// Wait for window load
$(window).on('load', function () {
	/* Animate loader off screen */
	$(".pageloader").remove();
	setSelectedCatValue();
});

$(function () {
	/*common drop down function  */
	$('.dropdown__trigger-js').each(function () {
		$(this).on('click', function () {
			if ($('body').hasClass('toggled_left')) {
				$('.navs_toggle').removeClass("active");
				$('body').removeClass('toggled_left');
			}
			if ($('html').hasClass('toggled-user')) {
				$('.dropdown__trigger-js').parent('.dropdown').removeClass("is-active");
				$("html").removeClass("toggled-user");
			} else {
				$(this).parent('.dropdown').toggleClass("is-active");
				$("html").toggleClass("toggled-user");
			}


			return false;
		});
	});
	$('html, .common_overlay').on('click', function () {
		if ($('.dropdown').hasClass('is-active')) {
			$('.dropdown').removeClass('is-active');
			$('html').removeClass('toggled-user');
		}
	});
	$('.dropdown__target-js').on('click', function (e) {
		e.stopPropagation();
	});

	$('.collections-ui').on('click', '.collection__container', function (e) {
		e.stopPropagation();
	});

	/* for footer */
	if ($(window).width() < 576) {
		/* FOR FOOTER TOGGLES */
		$('.js-footer-group-head').on('click', function () {
			if ($(this).hasClass('is-active')) {
				$(this).removeClass('is-active');
				$(this).siblings('.js-footer-nav').slideUp(); return false;
			}
			$('.js-footer-group-head').removeClass('is-active');
			$(this).addClass("is-active");
			$('.js-footer-nav').slideUp();
			$(this).siblings('.js-footer-nav').slideDown();
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
	$('html').on('click', function () {
		if ($('.collection__container').hasClass('open-menu')) {
			$('.open-menu').parent().toggleClass('is-active');
			$('.open-menu').toggleClass('open-menu');
		}
	});

	$('.cart').on('click', function (e) {
		e.stopPropagation();
	});


});

/*back-top*/
$(function () {
	/* hide #back-top first */
	$(".back-to-top").hide();

	/* fade in #back-top */
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('.back-to-top').fadeIn();
			} else {
				$('.back-to-top').fadeOut();
			}
		});
		/* scroll body to 0px on click */
		$('.back-to-top').on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	$('.switch-button').on('click', function () {
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

	if ('undefined' != typeof $.fn.popover) {
		$('[data-bs-toggle="popover"]').popover();
	}
	/* Bind bootstrap tooltip with ajax elements. */
	$('[data-bs-toggle="tooltip"]').tooltip({
		trigger: 'hover'
	}).on('click', function () {
		setTimeout(() => {
			$(this).tooltip('hide');
		}, 100);
	});
});


$(document).ajaxComplete(function () {
	markCatLinkActive();
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
			$(elem).append('<a class="read_more_toggle closed"  onClick="bindChangeToggle(this);"><span class="ink animate"></span> <span class="read_more">View More</span></a>');
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
			.replace(/\s+/g, '-')           /* Replace spaces with - */
			.replace(/[^\w\-]+/g, '')       /* Remove all non-word chars */
			.replace(/\-\-+/g, '-')         /* Replace multiple - with single - */
			.replace(/^-+/, '')             /* Trim - from start of text */
			.replace(/-+$/, '');
		if ($("#" + is_slugify).val() == 0) {
			$("#" + str_val_id).val(str).keyup();
			/* $("#" + str_val_id).val(str); */
			$("#" + caption).html(siteConstants.webroot + str);
		}
	};

	getSlugUrl = function (obj, str, extra, pos) {
		if (typeof pos == undefined || pos == null) {
			pos = 'pre';
		}
		var str = str.toString().toLowerCase()
			.replace(/\s+/g, '-')           /* Replace spaces with - */
			.replace(/[^\w\-]+/g, '')       /* Remove all non-word chars */
			.replace(/\-\-+/g, '-')         /* Replace multiple - with single - */
			.replace(/^-+/, '')             /* Trim - from start of text */
			.replace(/-+$/, '');
		if (extra && pos == 'pre') {
			str = extra + '-' + str;
		} if (extra && pos == 'post') {
			str = str + '-' + extra;
		}
		$(obj).next().html(siteConstants.webroot + str);
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

/*Google reCaptcha V3  */
function googleCaptcha(updateToken = false) {
	updateToken = ('undefined' == typeof updateToken ? false : updateToken);
	$("body").addClass("captcha");
	var inputObj = $("form input[name='g-recaptcha-response']");
	if ('' != inputObj.val() && false === updateToken) { return; }

	var submitBtn = inputObj.parent("form").find('input[type="submit"]');
	submitBtn.attr({ "disabled": "disabled", "type": "button" });

	var counter = 0;
	var checkToken = setInterval(function () {
		counter++
		if (5 == counter) {
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
					if (1 == counter) {
						fcom.displayErrorMessage(error);
					}
					return;
				}
			});
		}
	}, 1000);
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
	$(document).trigger('close.facebox');
	displayGeoAddress(address);
}

function setCookie(cname, cvalue, canSetCookie = true, exdays = 365, callback = '') {
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
	if (0 < $("#ga-autoComplete-header").length) {
		$("#ga-autoComplete-header").val(address);
		$(".geo-location-selected").text(address);
	}
}

function googleAddressAutocomplete(elementId = 'ga-autoComplete', field = 'formatted_address', saveCookie = true, callback = 'googleSelectedAddress') {
	if (1 > $("#" + elementId).length) {
		/* var msg = (langLbl.fieldNotFound).replace('{field}', elementId + ' Field');
		fcom.displayErrorMessage(msg); */
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
	window.addEventListener('scroll', () => google.maps.event.trigger(autocomplete, 'resize'));

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
		}

		if (0 < $("#facebox #" + elementId).length) {
			$(document).trigger('close.facebox');
		}
		if (eval("typeof " + callback) == 'function') {
			window[callback](data);
		}

		$("body").removeClass("loaded");
		location.reload();
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

	geocodeAddress(geocoder, map, infowindow, { 'location': latlng });

	document.getElementById('postal_code').addEventListener('blur', function () {
		var sel = document.getElementById('shop_country_code');
		var country = sel.options[sel.selectedIndex].text;

		var sel = document.getElementById('shop_state');
		var state = sel.options[sel.selectedIndex].text;

		address = document.getElementById('postal_code').value;
		address = country + ' ' + state + ' ' + address;
		geocodeAddress(geocoder, map, infowindow, { 'address': address });
	});

	document.getElementById('shop_state').addEventListener('change', function () {
		var sel = document.getElementById('shop_country_code');
		var country = sel.options[sel.selectedIndex].text;

		var sel = document.getElementById('shop_state');
		var state = sel.options[sel.selectedIndex].text;

		address = country + ' ' + state;

		geocodeAddress(geocoder, map, infowindow, { 'address': address });
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
			console.log('Geocode was not successful for the following reason: ' + status);
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
		/* data['lat'] = pos.lat();
		data['lng'] = pos.lng(); */
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

		$('#shop_country_code option').each(function () {
			if (this.text == data.country) {
				$('#shop_country_code').val(this.value);
				var state = 0;
				$('#shop_state option').each(function () {
					if (this.value == data.state_code || this.text == data.state || this.text == data.locality) {
						return state = this.value;
					}
				});
				getStatesByCountryCode(this.value, state, '#shop_state', 'state_code');
				return false;
			}
		});
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

function HTMLMarker(lat, lng, pointerText, content, isDefault) {
	this.lat = lat;
	this.lng = lng;
	this.pos = new google.maps.LatLng(lat, lng);
	this.content = content;
	this.pointerText = pointerText;
	this.isDefault = isDefault;
}

var map;
var searchAsMapMove = false;
var dragenMapListener;
var infowindow;
var mapMarker = [];
var customMarker = [];

function initMutipleMapMarker(markers, elementId, centeredLat, centeredLng, dragendCallback) {
	/*  
	 * centeredLat and centeredLng - map center point
	 * markers object sample
	 markers = [{ lat: 11,lng: 11,content:'<div>Bondi Beach</div>' }];
	 */

	if (centeredLat == '' || centeredLng == '') {
		centeredLat = 0;
		centeredLng = 0;
	}

	if (!$.isNumeric(centeredLat) || !$.isNumeric(centeredLat)) {
		console.warn('user location not set');
		return;
	}

	if (typeof markers != 'object') {
		console.log(markers);
		console.warn('Invalid markers passed');
		return;
	}
	map = new google.maps.Map(document.getElementById(elementId), {
		zoom: 10,
		center: new google.maps.LatLng(centeredLat, centeredLng),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	new google.maps.Marker({
		position: new google.maps.LatLng(centeredLat, centeredLng),
		map: map,
		title: langLbl.currentSearchLocation,
		icon: fcom.makeUrl() + 'images/pin3.png',
	});
	infowindow = new google.maps.InfoWindow();
	createMarkers(markers);
	/* hide loader */
	map.addListener('idle', function () {
		$('.map-loader.is-loading').hide();
	});

	if (typeof dragendCallback == 'function') {
		if (searchAsMapMove) {
			addDragendListiner(map, dragendCallback);
		}

		const centerControlDiv = document.createElement("div");
		centerControlDiv.setAttribute('class', 'map-drag-input-wrapper');
		centerControlDiv.style.clear = "both";

		const labelTag = document.createElement("label");
		labelTag.setAttribute('class', 'checkbox radioinputs');

		const iTag = document.createElement("i");
		iTag.setAttribute('class', 'input-helper');
		labelTag.appendChild(iTag);

		const inputHtml = document.createElement("INPUT");
		inputHtml.setAttribute("type", "checkbox");
		if (searchAsMapMove == true) {
			inputHtml.setAttribute("checked", "checked");
		}
		inputHtml.id = "mapSearchAsMove";
		labelTag.appendChild(inputHtml);

		const spanTag = document.createElement("span");
		iTag.setAttribute('class', 'lb-txt');
		spanTag.appendChild(document.createTextNode(langLbl.searchAsIMoveTheMap));
		labelTag.appendChild(spanTag);

		centerControlDiv.appendChild(labelTag);

		inputHtml.addEventListener("click", (e) => {
			infowindow.close();
			var targetElement = event.target || event.srcElement;
			if (targetElement.checked == true) {
				addDragendListiner(map, dragendCallback);
			} else {
				removeDragendListiner(map, dragendCallback);
			}
		});

		centerControlDiv.style.paddingTop = "10px";
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
	}

	HTMLMarker.prototype = new google.maps.OverlayView();
	HTMLMarker.prototype.onRemove = function () {
		this.div.parentNode.removeChild(this.div);
	}
	HTMLMarker.prototype.onAdd = function () {
		this.div = document.createElement('DIV');
		this.div.className = "float-price " + (this.isDefault == 1 ? 'float-brand' : '');
		this.div.style.position = 'absolute';
		this.div.innerHTML = this.pointerText;
		var panes = this.getPanes();
		panes.overlayImage.appendChild(this.div);
		var me = this;
		google.maps.event.addDomListener(this.div, 'click', function () {
			infowindow.setContent(me.content);
			infowindow.setPosition(new google.maps.LatLng(me.lat, me.lng));
			infowindow.open(map);
		});
	}
	HTMLMarker.prototype.draw = function () {
		var overlayProjection = this.getProjection();
		var position = overlayProjection.fromLatLngToDivPixel(this.pos);
		var panes = this.getPanes();
		this.div.style.left = position.x + 'px';
		this.div.style.top = position.y + 'px';
	}
};

function addDragendListiner(map, dragendCallback) {
	if (typeof dragendCallback == 'function') {
		dragenMapListener = map.addListener("dragend", () => {
			dragendCallback(map);
		});
	}

}

function removeDragendListiner(map, dragendCallback) {
	if (typeof dragendCallback == 'function') {
		google.maps.event.removeListener(dragenMapListener);
	}
}

function createMarkers(markers) {
	$.each(markers, function (index, marker) {
		if (!("lat" in marker) || !("lng" in marker) || !("content" in marker)) {
			console.log(marker);
			console.warn('Invalid marker passed');
			return;
		}
		if (marker['lat'] != '' || marker['lng'] != '') {

			var newMarker = new google.maps.Marker({
				position: new google.maps.LatLng(marker['lat'], marker['lng']),
				map: map,
				//title: marker['title'],
				icon: fcom.makeUrl() + 'images/pin.png',
				refId: index
			});

			google.maps.event.addListener(newMarker, 'click', (function (newMarker, index) {
				return function () {
					infowindow.close();
					infowindow.setContent(marker['content']);
					infowindow.open(map, newMarker);
				}
			})(newMarker, index));
			mapMarker[index] = newMarker;
		}

	});
}

function clearMarkers() {
	$.each(mapMarker, function (index, marker) {
		if (typeof marker != 'undefined') {
			marker.setMap(null);
		}
	});
}

function createCustomMarkers(customMarkers) {
	$.each(customMarkers, function (index, marker) {
		customMarker[index] = new HTMLMarker(marker.lat, marker.lng, marker.amount, marker.content, marker.isDefault);
		customMarker[index].setMap(map);
	});
}

function clearMoreSellerMarkers() {
	$.each(customMarker, function (index, marker) {
		customMarker[index].setMap(null);
	});
}

let sidebarHtml = '';
function openMobileMenu() {
	if ('' == sidebarHtml) {
		fcom.ajax(fcom.makeUrl("Category", "sidebarCategoriesList"), '',
			function (res) {
				sidebarHtml = res.html;
				$('.categoriesJs').html(res.html);
				markCatLinkActive();
			}, { 'fOutMode': 'json' }
		);
	}
}

function markCatLinkActive() {
	var uri = window.location.pathname.replace(/^\/|\/$/g, "");
	$(".sidebarNavLinksJs").each(function () {
		$(this).find(".groupingLinkJs").each(function () {
			var attr = $(this).attr("href");
			var href = '';
			if (typeof attr !== 'undefined' && attr !== false) {
				var href = attr.replace(/^\/|\/$/g, "");
			}
			if (uri == href) {
				$(this).parent().addClass('active');
				$(this).siblings('.collapseBtnJs').attr('aria-expanded', 'true');
				if (0 < $(this).siblings().length) {
					$(this).parent().siblings('.collapseJs').addClass('show');
				}
				$(this).parents('.collapseJs').addClass('show');
			}
		});
	});
}

function requestForQuoteFn(selprodId) {
	let rfqQuat = $('.productQty-js').val();
	fcom.displayProcessing();
	fcom.ajax(fcom.makeUrl("RequestForQuotes", "form"), 'selprodId=' + selprodId + '&rfqQuat=' + rfqQuat,
		function (res) {
			fcom.closeProcessing();
			if (!res.status) {
				if (typeof res.displayLoginForm != 'undefined' && res.displayLoginForm == 1) {
					loginPopUpBox(true);
					return;
				}
				fcom.displayErrorMessage(res.msg);
			}
			var date = new Date();
			date.setDate(date.getDate() + 1);
			$.ykmodal.element = 'modalRfqJS';
			$.ykmodal(res.html, true, 'modal-lg modal-dialog-scrollable', "modalRfqJS", "", true, 'data-bs-backdrop="static" data-bs-keyboard="false"');
			$(".rfqDeliveryDateJs").datepicker("option", {
				minDate: date,
				onClose: function () {
					$(".modalRfqJS").focus();
				}
			});
		}, { 'fOutMode': 'json' }
	);
}

function saveRfq(frm) {
	let desc = $('textarea[name="rfq_description"]', frm).val();
	if ('undefined' == typeof desc || '' == desc) {
		$(frm).find('.descHeadJs').attr('aria-expanded', 'true');
		$(frm).find('.descHeadJs').removeClass('collapsed');
		$(frm).find('.descBodyJs').addClass('show');
	}

	if (!$(frm).validate()) { return; }

	let addrId = $('.addrIdJs', frm).val();
	if ('undefined' == typeof addrId || '' == addrId || '0' == addrId) {
		addAddress($('.selprodIdJs', frm).val());
		fcom.displayErrorMessage(langLbl.deliveryAddressMandatory);
		return false;
	}

	$('.modalRfqJS .contentBodyJs').addClass('processing-wrap').prepend(fcom.getLoader())

	var data = new FormData();
	data.append('fIsAjax', 1);
	frm.find('select,input[type=hidden],input[type=text],input[type=search],textarea').each(function () {
		data.append(this.name, $(this).val());
	});

	frm.find('input[type=file]').each(function (i, v) {
		data.append(v.name, v.files[0]);
	});
	$.ajax({
		url: fcom.makeUrl('RequestForQuotes', 'save'),
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
			fcom.displaySuccessMessage(t.msg);
			$.ykmodal.close();
			if (t.isGuest) {
				if (0 < t.verificationRequired) {
					resendVerificationLink(t.email);
				}
				setTimeout(() => {
					if ('undefined' != typeof t.redirectUrl) {
						location.href = t.redirectUrl;
					} else {
						location.reload();
					}
				}, 2000);

				/* sendResetPasswordLink(t.email); */
			} else {
				location.href = t.redirectUrl;
			}

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Invalid Response.");
		}
	});
}

function saveMultipleRfq(frm) {
	$(".descriptionJS").each(function () {
		let desc = $(frm).find('textarea').val();
		if ('undefined' == typeof desc || '' == desc) {
			$(frm).find('.descHeadJs').attr('aria-expanded', 'true');
			$(frm).find('.descHeadJs').removeClass('collapsed');
			$(frm).find('.descBodyJs').addClass('show');
		}
	});
	if (!$(frm).validate()) { return; }
	let addrId = $('.addrIdJs', frm).val();
	if ('undefined' == typeof addrId || '' == addrId || '0' == addrId) {
		fcom.displayErrorMessage(langLbl.deliveryAddressMandatory);
		return false;
	}
	$('#sideQuoteJs .rfqBodyJs').addClass('processing-wrap').prepend(fcom.getLoader());
	var data = new FormData();
	data.append('fIsAjax', 1);
	data.append('fOutMode', 'json');
	frm.find('select,input[type=hidden],input[type=text],textarea').each(function () {
		data.append(this.name, $(this).val());
	});

	frm.find('input[type=file]').each(function (i, v) {
		data.append(v.name, v.files[0]);
	});

	data.append('rfq_delivery_date', $('.multipleRfqDateJs').val());

	fcom.displayProcessing();
	$.ajax({
		url: fcom.makeUrl('RequestForQuotes', 'saveMultiple'),
		type: "POST",
		data: data,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (t) {
			fcom.removeLoader();
			if (t.status == 0) {
				if (typeof t.displayLoginForm != 'undefined' && t.displayLoginForm == 1) {
					$('#sideQuoteJs').modal('hide');
					loginPopUpBox(true);
					return;
				}
				fcom.displayErrorMessage(t.msg);
				return;
			}
			fcom.displaySuccessMessage(t.msg);
			$('#sideQuoteJs').modal('hide');
			if (t.isGuest) {
				if (0 < t.verificationRequired) {
					resendVerificationLink(t.email);
				}
				setTimeout(() => {
					if ('undefined' != typeof t.redirectUrl) {
						location.href = t.redirectUrl;
					} else {
						location.reload();
					}
				}, 2000);
				$('span.cartQuantity').html(0);
				cart.loadCartSummary();
			} else {
				location.href = t.redirectUrl;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Invalid Response.");
		}
	});
}
function addAddress(selprodId = 0) {
	/*  if (1 > selprodId) {
		 $('#sideQuoteJs').modal('hide');
	 } */
	$.ykmodal.element = 'modalAddressJS';
	$.ykmodal(fcom.getLoader(), false);
	fcom.ajax(fcom.makeUrl("RequestForQuotes", "addAddress"), 'selprod_id=' + selprodId, function (ans) {
		fcom.removeLoader();
		$.ykmodal(ans, false, 'modal-lg  modal-dialog-scrollable', "modalAddressJS", "", true, 'data-bs-backdrop="static" data-bs-keyboard="false"');
	});
};
function saveAddress(frm, selprodId, rfq = false) {
	if (!$(frm).validate()) { return; }
	var data = fcom.frmData(frm);

	$.ykmodal(fcom.getLoader());
	let contName = "Addresses";
	let webroot = siteConstants.webroot_dashboard;
	if (rfq) {
		contName = 'RequestForQuotes';
		data += '&getHtml=1';
		webroot = siteConstants.webrootfront;
	} else {
		data += '&isDefault=' + (confirm(langLbl.confirmDefault) ? 1 : 0) + '&getHtml=1';
	}
	fcom.updateWithAjax(fcom.makeUrl(contName, "setUpAddress", [], webroot), data, function (ans) {
		fcom.removeLoader();
		/*  if ('undefined' != typeof selprodId && 0 < selprodId) { */
		// requestForQuoteFn(selprodId);
		let formId = $('.addressSectionJs').data('formId');
		$('.addressSectionJs').html(ans.html);
		$('.addrIdJs').val(ans.addr_id);
		$('.addressSectionJs').find('.addressListingJs').attr('data-form', formId);
		$.ykmodal.close();
		/*   } */
	});
};

$(document).ready(function () {
	$(document).on('click', '.selectedAddressJs', function () {
		if ($(this).hasClass('list-open')) {
			$('.addressListingJs').fadeOut();
		} else {
			$('.addressListingJs').fadeIn();
		}
		$(this).toggleClass('list-open');
	});
	$(window).click(function (event) {
		var target = $(event.target);
		if (!target.closest('.addressMenuJs').length && $('.addressListingJs').is(":visible")) {
			$('.addressListingJs').fadeOut();
			$('.selectedAddressJs').removeClass('list-open');
		}
	});
	$(document).on('click', '.addressItemJs', function () {
		let parent = $(this).closest('.addressListingJs');
		let form = parent.data('form');
		let sibling = parent.siblings('.selectedAddressJs');
		sibling.find('.btnDropdownContentJs').html($(this).find('.addressItemContentJs').html());
		if (sibling.find('.custom-menu-dropdown-data').length) {
			sibling.find('.custom-menu-dropdown-data').removeClass('custom-menu-dropdown-data').addClass('custom-menu-content');
		}
		$('.addressListingJs').fadeOut();
		sibling.removeClass('list-open');
		$('#' + form + ' .addrIdJs').val($(this).data('id'));
	});
});

$(function () {
	$(document).on('change', '.rfqDocumentJs', function () {
		var rowId = $(this).data('rowId');
		var nameEle = $('.rfqFileNameJs' + rowId);
		if ('undefined' == typeof rowId) {
			nameEle = $('.rfqFileNameJs');
		}
		nameEle.text($(this).val());
	});
})
