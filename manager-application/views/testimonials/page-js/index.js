
backgroundImage = function (recordId, imageType, langId) {
    fcom.ajax(fcom.makeUrl(controllerName, 'images' ), {recordId, imageType, langId}, function (t) {	
        $('#imageListingJs').html(t);
    });
};


