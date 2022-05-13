
(function () {
    backgroundImage = function (recordId, imageType, langId) {
        fcom.updateWithAjax(fcom.makeUrl('ContentBlock', 'images' ), {recordId, imageType, langId}, function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $('#imageListingJs').html(t.html);
        });
    };


    deleteBackgroundImage = function (recordId, afileId ,type, langId) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('ContentBlock', 'removeMedia'), {recordId, afileId, type, langId}, function (t) {
            fcom.displaySuccessMessage(t.msg);
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
    };

    resetToDefaultContent =  function(){
		var agree  = confirm(langLbl.confirmReplaceCurrentToDefault);
		if( !agree ){ return false; }		
		oUtil.obj.putHTML( $("#editor_default_content").html() );
	};
})();