(function () {
    addTagData = function(e){
        console.log(e.detail);
        var product_id = e.detail.data.product_id;
        var tag_id = e.detail.data.id;
        var tag_name = e.detail.data.value;
        if(tag_id == undefined || tag_id == '' ) {
            tag_id = 0;         
            fcom.updateWithAjax(fcom.makeUrl('Tags', 'setup'), {tag_id,tag_name}, function(t) {   
                tag_id = t.tagId;                 
                whitelist.push({'id':t.tagId, value:tag_name});                   
                fcom.updateWithAjax(fcom.makeUrl('Products', 'updateProductTag'), {product_id,tag_id}, function(t3) {
                        var tagifyId = e.detail.tag.__tagifyId;
                        $('[__tagifyid='+tagifyId+']').attr('id', t.tagId);
                    });                
            });
        }else{
            fcom.updateWithAjax(fcom.makeUrl('Products', 'updateProductTag'), {product_id,tag_id}, function(t) { });
        }
    }

    // bindTag = function(e) {
    //     var product_id = e.detail.data.product_id;
    //     if ('undefined' == typeof product_id) {
    //         return;
    //     }

    //     let tag_id = e.detail.data.id;
    //     if ('' == tag_id) {
    //         e.detail.tag.remove();
    //         return false;
    //     }
    //     fcom.ajax(fcom.makeUrl("Products", "updateProductTag"), {product_id,tag_id}, function(t) {});
    // }

    removeTagData = function(e){
        let tag_id = e.detail.tag.id;
        let product_id = $(e.detail.tagify.DOM.originalInput).attr('data-product_id');
        fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), {product_id,tag_id}, function(t) {
        });
    }

    // removeTag = function(tag) {
    //     let product_id = tag.data.product_id;
    //     if ('undefined' == typeof product_id) {
    //         return;
    //     }
    //     let tag_id = tag.data.id;
    //     if ('' == tag_id) {
    //         e.detail.tag.remove();
    //         return false;
    //     }
    //     fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), {product_id,tag_id}, function(t) {
    //         reloadList();
    //     });
    // }

    getTags = function(e) {
        var keyword = e.detail.value;
        var element = e.detail.tagify.DOM.originalInput;
        var list = [];
        fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), {
            keyword: keyword,
            langId: 1,
        }, function(t) {
            var ans = JSON.parse(t);            
            $.each(ans ,function(id ,tag){ 
                list.push({
                    "id": tag.tag_id,
                    "value": tag.tag_name,
                    "product_id": $(element).data('product_id')                
                });
            });
            
            e.detail.tagify.settings.whitelist = list;
            e.detail.tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

    TagTagify = function() {
        var input = document.querySelectorAll('.productsTagsJs');
        input.forEach(function(element, index) {  
         
            if(index == 0){
            tagify = new Tagify(element, {
                // whitelist: [],
                // dropdown: {
                //     position: 'text',
                //     enabled: 1 // show suggestions dropdown after 1 typed character
                // },
                // // hooks: {
                // //     beforeRemoveTag: function(tags) {
                // //         return new Promise((resolve, reject) => {
                // //             if (!confirm("Remove " + tags[0].data.value + "?")) {
                // //                 return false;
                // //             }
                // //             removeTagData(tags[0]);
                // //         })
                // //     }
                // // }
            }).on('input', getTags).on('focus', getTags).on('add', addTagData);
        }
        });
    };





})();