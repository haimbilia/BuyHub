$(document).ready(function () {
    bindSortable();
});

$(document).ajaxComplete(function () {
    bindSortable();
});

(function () {
    addNewPlan = function (spackageId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    editPlanRecord = function (spackageId, spPlanId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId, spPlanId: spPlanId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }

        $("#listingTableJs > tbody").sortable({
            handle: '.handleJs',
            helper: fixWidthHelper,
            start: fixPlaceholderStyle,
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'planId[' + (i + 1) + ']=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl(controllerName, 'updateOrder'), value, function (res) {
                            fcom.removeLoader();
                            fcom.closeProcessing();
                            var ans = $.parseJSON(res);
                            if (ans.status == 1) {
                                reloadList();
                                fcom.displaySuccessMessage(ans.msg);
                                return;
                            }
                            fcom.displayErrorMessage(ans.msg);
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        fcom.closeProcessing();
                    }
                );
            },
        });
    }
})();
