$(function () {
	searchShops(document.frmSearchShops);
});

(function () {
	var dv = '#listing';
	var currPage = 1;

	reloadListing = function () {
		searchShops(document.frmSearchShops);
	};

	searchShops = function (frm, append) {
		if (typeof append == undefined || append == null) {
			append = 0;
		}

		var data = fcom.frmData(frm);
		$(dv).prepend(fcom.getLoader());

		fcom.updateWithAjax(fcom.makeUrl('Shops', 'search'), data, function (ans) {
			fcom.closeProcessing();
			fcom.removeLoader();
			if (append == 1) {
				$(document.frmSearchShopsPaging).remove();
				$(dv).find('.loader-yk').remove();
				$(dv).append(ans.html);
			} else {
				$(dv).html(ans.html);
			}
			if (CONF_ENABLE_GEO_LOCATION) {
				if (typeof map == 'undefined') {
					initMutipleMapMarker(markers, 'shopMap--js', getCookie('_ykGeoLat'), getCookie('_ykGeoLng'), dragCallback);
				} else {
					clearMarkers();
					createMarkers(markers);
				}
			} else {
				$("#loadMoreBtnDiv").html(ans.loadMoreBtnHtml);
				$("#favShopCount").html(ans.totalRecords);
			}
		});
	};

	goToShopSearchPage = function (page) {
		goToLoadMore(page, 0);
	}

	goToLoadMore = function (page, append = 1) {
		if (typeof page == 'undefined' || page == null) {
			page = 1;
		}
		append = 'undefined' == typeof append ? 1 : append;
		
		currPage = page;
		var frm = document.frmSearchShopsPaging;
		$(frm.page).val(page);
		searchShops(frm, append);
	};

	unFavoriteShopFavorite = function (shopId, e) {
		toggleShopFavorite(shopId);
		$(e).attr('onclick', 'markShopFavorite(' + shopId + ',this)');
		$(e).html(langLbl.favoriteToShop);
		//reloadListing();
	};

	markShopFavorite = function (shopId, e) {
		toggleShopFavorite(shopId);
		$(e).attr('onclick', 'unFavoriteShopFavorite(' + shopId + ',this)');
		console.log(e);
		$(e).html(langLbl.unfavoriteToShop);
		//reloadListing();
	};
	dragCallback = function (dragendMap) {
		canSetCookie = true;
		codeLatLng(dragendMap.getCenter().lat(), dragendMap.getCenter().lng(), function (data) {
			displayGeoAddress(setGeoAddress(data));
			if (typeof dragTimeOutEvent != "undefined") {
				clearTimeout(dragTimeOutEvent);
			}
			dragTimeOutEvent = setTimeout(function () { reloadListing(); }, 1000);
		});
	};
})();

$(document).on('mouseover mouseout', '#mapShops--js > li', function (e) {
	let shopId = $(this).data('shopid');
	$.each(mapMarker, function (index, marker) {
		if (typeof marker != 'undefined') {
			let iconImage = fcom.makeUrl() + 'images/pin.png';
			if (marker['refId'] == shopId && e.type == 'mouseover') {
				iconImage = fcom.makeUrl() + 'images/pin2.png';
			}
			marker.setIcon(iconImage);
		}
	});
})