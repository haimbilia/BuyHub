(function () {
addBrand = function () {        
    fcom.resetEditorInstance();   
    $.ykmodal(fcom.getLoader());
    fcom.ajax(fcom.makeUrl('Brands', "form"), "", function (t) {
        $.ykmodal(t);
        fcom.removeLoader();
    });
};

select2('product_brand_id',fcom.makeUrl('Brands', 'autoComplete'),{brand_active: 1});
//select2('ptc_prodcat_id',fcom.makeUrl('Brands', 'autoComplete'),{brand_active: 1});


var pills = [{id:0, text: "red"}, {id:1, text: "blue"}]; 
$('#ptc_prodcat_id').select2({
    placeholder: "Select a pill",
    data: pills 
});

$('#ptc_prodcat_id').on("select2:open", function (e) { 
    
   

});



})();
