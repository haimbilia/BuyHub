addNewFaq = faqCatId =>  {
    fcom.resetEditorInstance();
    let data = {faqCatId};

    /* Uncheck all if checked. */
    $(".selectAllJs, .selectItemJs").prop("checked", false)

    $.ykmodal(fcom.getLoader(), false, '');
    fcom.ajax(fcom.makeUrl('Faq', 'form'), data, function (t) {
        $.ykmodal(t, false, '');
        fcom.removeLoader();
    });
};


$(document).ready(function() {
    bindSortable();
});
$(document).ajaxComplete(function() {
    bindSortable();
});

function bindSortable() {
    if (1 > $('[data-field="dragdrop"]').length) {
        return;
    }

    $("#orderStatuses > tbody").sortable({
        update: function(event, ui) {
            fcom.displayProcessing();
            $('.listingTableJs').prepend(fcom.getLoader());

            var order = $(this).sortable('toArray');
            var data = '';
            const bindData = new Promise((resolve, reject) => {
                for (let i = 0; i < order.length; i++) {
                    data += 'faqs[]=' + order[i];
                    if (i + 1 < order.length) {
                        data += '&';
                    }
                }
                resolve(data);
            });
            bindData.then(
                function(value) {
                    fcom.ajax(fcom.makeUrl('Faq', 'updateOrder'), value, function(res) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                        var ans = $.parseJSON(res);
                        if (ans.status == 1) {
                            $.ykmsg.success(ans.msg);
                            return;
                        }
                        $.ykmsg.error(ans.msg);
                    });
                },
                function(error) {
                    fcom.removeLoader();
                    $.ykmsg.close();
                }
            );
        },
    });
    $("#orderStatuses > tbody").disableSelection();
}


editRecord = (recordId, faqCatId) => {
    fcom.resetEditorInstance();
    $.ykmodal(fcom.getLoader());
    data = {recordId, faqCatId};
    console.log(data);
    fcom.ajax(fcom.makeUrl('Faq', 'form'), data, function (t) {
        $.ykmodal(t);
        fcom.removeLoader();
    });
};