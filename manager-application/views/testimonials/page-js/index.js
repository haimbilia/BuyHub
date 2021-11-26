
backgroundImage = function (recordId, imageType, langId) {
    fcom.ajax(fcom.makeUrl(controllerName, 'images' ), {recordId, imageType, langId}, function (t) {	
        $('#imageListingJs').html(t);
    });
};


// deleteBackgroundImage = function (recordId, afileId ,type, langId) {
//     if (!confirm(langLbl.confirmDelete)) { return; }
//     console.log(recordId, afileId ,type, langId);
//     fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), {recordId, afileId, type, langId}, function (t) {
//         backgroundImage(recordId, 'THUMB' ,langId);
//         reloadList();
//         $('.resetModalFormJs').click();
//     });
// };    


// mediaForm = function(recordId, imageType, langId, slideScreen) {
//     alert('hi');
//     // backgroundImage(recordId, 'THUMB' ,langId);
// }