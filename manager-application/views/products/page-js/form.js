(function () {
addBrand = function () {        
    fcom.resetEditorInstance();   
    $.ykmodal(fcom.getLoader());
    fcom.ajax(fcom.makeUrl('Brands', "form"), "", function (t) {
        $.ykmodal(t);
        fcom.removeLoader();
    });
};

addCategory = function () {        
    fcom.resetEditorInstance();   
    $.ykmodal(fcom.getLoader());
    fcom.ajax(fcom.makeUrl('ProductCategories', "form"), "", function (t) {
        $.ykmodal(t);
        fcom.removeLoader();
    });
};


select2('product_brand_id',fcom.makeUrl('Brands', 'autoComplete'),{brand_active: 1});
select2('ptc_prodcat_id',fcom.makeUrl('ProductCategories', 'autoComplete'));

addTagData = function(e){
   var rt_id = e.detail.tag.id;
            var ratingtype_name = e.detail.tag.title;
            var prodCatId = $("input[name='prodcat_id']").val();
            if (rt_id == '') {
                if (1 > canEditRating) {
                    $.ykmsg.error(ratingEditErr);
                    e.detail.tag.remove();
                    return;
                }
                if (!confirm(langLbl.addNewRatingType)) {
                    return;
                }  
            }    
}

removeTagData = function(e){ 
    var tag_id = e.detail.tag.id;      
    fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), 'product_id='+product_id+'&tag_id='+tag_id, function(t) {});
    tagifyProducts();
}

getTagsAutoComplete = function(e){
    var keyword = e.detail.value;
    var list = [];
    fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), {keyword:keyword}, function(t) {          
        var ans = $.parseJSON(t);
        for (i = 0; i < ans.length; i++) {            
            list.push({
                "id" : ans[i].id,
                "value" : ans[i].tag_identifier, 
            });
        }
        tagify.settings.whitelist = list;
        tagify.loading(false).dropdown.show.call(tagify, keyword);
    });        
}

tagifyProducts = function() {
    var element = '#product_tags';
    if ('undefined' !== typeof $(element).attr('disabled')) {
        return;
    }
    $(element).siblings( ".tagify" ).remove();
    tagify = new Tagify(document.querySelector(element), {
       whitelist : [],
       delimiters : "#",
       editTags : false,
    }).on('add', addTagData).on('remove', removeTagData).on('input', getTagsAutoComplete);  
};
tagifyProducts();

addBlogPostCategory = function(e) {
    var bpcId = e.detail.tag.id;
    if ('' == bpcId) {
        e.detail.tag.remove();
        return false;
    }
}

getCategories = function(e) {
    var keyword = e.detail.value;
    var list = [];
    fcom.ajax(fcom.makeUrl('BlogPosts', 'getCategories'), {
        keyword: keyword
    }, function(t) {
        tagify.settings.whitelist = JSON.parse(t);
        tagify.loading(false).dropdown.show.call(tagify, keyword);
    });
}


tagifyCategories();

})();

$(document).on('click', '.warrantyTypeJs', function(event) {
    let type = $(this).data('type');  
    $(this).closest('div').siblings('.warrantyTypeButtonJs').text($(this).text());
    $("#product_warranty_type").val(type);
});
