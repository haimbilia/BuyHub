$(document).ready(function() {
    bindSortable();
});
$(document).ajaxComplete(function() {
    bindSortable();
});

bindSortable = function() {
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
                    data += 'record_ids[]=' + order[i];
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
                            $.ykmsg.success(ans.msg);
                            return;
                        }
                        $.ykmsg.error(ans.msg);
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


deleteMedia = function (recordId, afileId ,fileType, langId, slideScreen) {
    if (!confirm(langLbl.confirmDelete)) { return; }
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), {recordId, afileId, fileType, langId, slideScreen}, function (t) {
        loadImages(recordId, 'THUMB' , slideScreen, langId);
        reloadList();
        $('.resetModalFormJs').click();
    });
};    

mediaForm = function (recordId, langId = 0, slide_screen = 1) {
    if (false === checkControllerName()) {
        return false;
    }

    fcom.updateWithAjax(fcom.makeUrl(controllerName, "media", [recordId, langId, slide_screen]), "",
        function (t) {
            fcom.removeLoader();
            $.ykmodal(t.html, !$.ykmodal.isSideBarView());
        }
    );
};

loadImages = function (recordId, imageType, slide_screen, langId) {
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images' ), {recordId, imageType, langId, slide_screen}, function (t) {	
        fcom.removeLoader();
        $('#imageListingJs').html(t.html);
    });
};
$(document).on('change', '#imageLanguageJs', function(e) {
    e.stopPropagation();
    let langId = $(this).val();
    let recordId = $(this).closest("form").find('input[name="slide_id"]').val();
    let slideScreen = $(this).closest("form").find('[name="slide_screen"]').val();
    loadImages(recordId, 'THUMB', slideScreen, langId);
});


