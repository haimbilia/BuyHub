$(document).ready(function () {
    bindSortable();
    $(document).on('change', '.orderStatusClassJs', function () {
        $(this).css("color", $('option:selected', this).css("color"));
    });
});

$(document).ajaxComplete(function () {
    bindSortable();
});

(function () {
    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }

        $("#listingTableJs > tbody").sortable({
            handle: '.handleJs',
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
    }

    editRecord = function (recordId) {
        data = "recordId=" + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t.html, false);
            $.ykmsg.close();
            fcom.removeLoader();

            if (0 < $('.orderStatusClassJs').length) {
                $('.orderStatusClassJs option').each(function () {
                    $(this).attr('class', 'label ' + $(this).text());
                });
                $('.orderStatusClassJs').css("color", $('.orderStatusClassJs option:selected').css("color"));
            }
        });
    };
})();