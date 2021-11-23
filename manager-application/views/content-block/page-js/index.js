

 backgroundImage = function (recordId, imageType, langId) {
    fcom.ajax(fcom.makeUrl('ContentBlock', 'images', [recordId, imageType, langId]), '', function (t) {	
        $('#imageListingJs').html(t);
    });
};


deleteBackgroundImage = function (recordId, afileId ,type, langId) {
    if (!confirm(langLbl.confirmDelete)) { return; }
    fcom.updateWithAjax(fcom.makeUrl('ContentBlock', 'removeMedia', [recordId, afileId, type, langId]), '', function (t) {
        backgroundImage(recordId, 'THUMB' ,langId);
        reloadList();
    });
};    


$(document).on('change', '#imageLanguageJs', function() {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="epage_id"]').val();
    backgroundImage(recordId, 'THUMB',lang_id);
});

mediaForm = (recordId, imageType, langId, slideScreen) => {
    backgroundImage(recordId, 'THUMB' ,langId);
}