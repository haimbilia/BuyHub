
backgroundImage = function (recordId, imageType, langId) {
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images'), { recordId, imageType, langId }, function (t) {
        fcom.removeLoader();
        $('#imageListingJs').html(t.html);
    });
};


