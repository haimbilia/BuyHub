$(document).ready(function() {
    bindSortable();
});
$(document).ajaxComplete(function() {
    bindSortable();
});

(function () {
    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }
    
        $("#listingTableJs > tbody").sortable({
            handle: '.handleJs',
            helper: fixWidthHelper,
            start: fixPlaceholderStyle,
            update: function(event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());
    
                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'faqcat[]=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function(value) {
                        fcom.ajax(fcom.makeUrl(controllerName, 'updateOrder'), value, function(res) {
                            fcom.removeLoader();
                            fcom.closeProcessing();
                            var ans = $.parseJSON(res);
                            if (ans.status == 1) {
                                fcom.displaySuccessMessage(ans.msg);
                                return;
                            }
                            fcom.displayErrorMessage(ans.msg);
                        });
                    },
                    function(error) {
                        fcom.removeLoader();
                        fcom.closeProcessing();
                    }
                );
            },
        });
    }

    redirectToList = function (faqCatId) {
        redirectfunc(fcom.makeUrl('Faq', 'list'), {faqCatId});
    }
})();