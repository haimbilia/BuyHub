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
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'optionvalues[' + (i+1) + ']=' + order[i];
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
        }).disableSelection();
    };

    optionValueForm = function (optionId, id = 0) {
        var data = "optionvalue_id=" + id + "&option_id=" + optionId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    deleteOptionValueRecord = function (optionId, id) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        var data = "recordId=" + id + "&option_id=" + optionId;
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "deleteRecord"),
            data,
            function () {
                reloadList();
            }
        );
    };

    deleteSelected = function () {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        $("form.actionButtonsJs")
            .attr("action", fcom.makeUrl(controllerName, "deleteSelected"))
            .submit();
    };

    editRecord = function (recordId) {
        if ($('.' + $.ykmodal.element).hasClass("show")) {
            var optionId = $('.' + $.ykmodal.element + ' form input[name="optionvalue_option_id"]').val();
            optionValueForm(optionId, recordId);
        }
        return false;
    };
})();
