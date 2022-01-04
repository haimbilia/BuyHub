$(window).on('load', function () {
    bindSortable();
});
$(document).ajaxComplete(function () {
    bindSortable();
});


(function () {
    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }

        $(".listingTableJs tbody.listingRecordJs").sortable({
            handle: '.handleJs',
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'currencyIds[' + (i+1) + ']=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl(controllerName, 'updateOrder'), value, function (res) {
                            $.ykmsg.close();
                            fcom.removeLoader();
                            var ans = JSON.parse(res);
                            if (ans.status != 1) {
                                $.ykmsg.error(ans.msg);
                                return;
                            }
                            $.ykmsg.success(ans.msg);
                            reloadList();
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                    }
                );
            },
        });
    };

    updateCurrencyRates = function (converterClass) {
        if (!confirm(langLbl.updateCurrencyRates)) {
            return false;
        }
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(converterClass, 'update'), '', function (res) {
            $.ykmsg.close();
            var ans = $.parseJSON(res);
            if (ans.status != 1) {
                $.ykmsg.danger(ans.msg);
                return false;   
            }
            $.ykmsg.success(ans.msg);
            reloadList();
        });
    };
})();