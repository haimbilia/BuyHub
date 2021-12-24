

backgroundImage = function (recordId, imageType, langId) {
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images' ), {recordId, imageType, langId}, function (t) {	
        fcom.removeLoader();
        $.ykmsg.close();
        $('#imageListingJs').html(t.html);
    });
};


deleteBackgroundImage = function (recordId, afileId ,type, langId) {
    if (!confirm(langLbl.confirmDelete)) { return; }
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), {recordId, afileId, type, langId}, function (t) {
        backgroundImage(recordId, 'THUMB' ,langId);
        reloadList();
        $('.resetModalFormJs').click();
    });
};    


$(document).on('change', '#imageLanguageJs', function() {
    let lang_id = $(this).val();
    let recordId = $(this).closest("form").find('input[name="epage_id"]').val();
    backgroundImage(recordId, 'THUMB',lang_id);
});

mediaForm = function(recordId, imageType, langId, slideScreen) {
    backgroundImage(recordId, 'THUMB' ,langId);
}