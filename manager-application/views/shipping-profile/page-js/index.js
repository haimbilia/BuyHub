 
(function () {
    deleteRecord = function (shippingProfileId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'id=' + shippingProfileId;
        fcom.updateWithAjax(fcom.makeUrl('shippingProfile', 'deleteRecord'), data, function () {
            reloadList();
        });
    };

})(); 