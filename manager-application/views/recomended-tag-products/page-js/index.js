(function () {
    saveData = function (tagId, productId, element, value) {
        var data = 'tag_id=' + tagId + '&product_id=' + productId + '&' + element + '=' + value;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (ans) {
            reloadList();
        });
    }
})();
