$(document).ready(function () {
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

        $("#orderStatuses > tbody").sortable({
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'orderStatuses[]=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl('OrderStatus', 'setOrderStatusesOrder'), value, function (res) {
                            fcom.removeLoader();
                            $.ykmsg.close();
                            var ans = JSON.parse(res);
                            if (ans.status == 1) {
                                $.ykmsg.success(ans.msg);
                                return;
                            }
                            $.ykmsg.error(ans.msg);
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                    }
                );
            },
        });
        $("#orderStatuses > tbody").disableSelection();
    }

})();