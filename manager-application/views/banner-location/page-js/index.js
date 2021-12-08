displayImageInFacebox = function(str) {
    $.ykmodal(`<image width='800px;' src='${str}' />`, true);
}

redirectToList = function (bannerLocationId) {
    redirectfunc(fcom.makeUrl('Banners', 'list'), {banner_location_id: bannerLocationId});
}