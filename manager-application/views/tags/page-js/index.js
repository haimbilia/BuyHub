(function () {

    languageToggle = function (el) {
        let langId = $(el).val();
        $('.mainJs').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('tags', 'index'), { lang_id: langId }, function (t) {
            $('.mainJs').replaceWith(t);
            fcom.removeLoader();
        });
    }

    addTagData = function (e) {
        var product_id = $(e.detail.tagify.DOM.originalInput).data('product_id');
        var tag_id = e.detail.data.id;
        if (e.detail.data.product_id > 0 && tag_id > 0) {
            bindProductWithTag(e.detail.data.product_id, tag_id);
        } else if (tag_id == undefined) {
            if (1 > canEdit) {
                e.detail.tag.remove();
                return;
            }
            var tag_name = e.detail.data.value;
            var tag_lang_id = $('#tagLangId').val() || 0;
            if (tag_id == undefined || tag_id == '') {
                tag_id = 0;
                fcom.updateWithAjax(fcom.makeUrl('Tags', 'setup'), { tag_id, tag_name, tag_lang_id }, function (t) {
                    tag_id = t.tagId;
                    e.detail.tagify.settings.whitelist.push({ 'id': t.tagId, value: tag_name, product_id: product_id });
                    bindProductWithTag(product_id, tag_id);
                });
            }
        }
    };


    bindProductWithTag = function (product_id, tag_id) {
        fcom.updateWithAjax(fcom.makeUrl('Products', 'updateProductTag'), { product_id, tag_id }, function (t) {
        });
    }

    removeTagData = function (e) {
        let product_id = $(e.detail.tagify.DOM.originalInput).data('product_id');
        if (0 < product_id) {
            let tag_id = e.detail.tag.id;
            fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), { product_id, tag_id }, function (t) {
            });
        }
    }

    getTags = function (e) {
        var keyword = e.detail.value;
        var element = e.detail.tagify.DOM.originalInput;
        var list = [];
        fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), {
            keyword: keyword,
            langId: $('#tagLangId').val() || 0,
        }, function (t) {
            var ans = JSON.parse(t);
            $.each(ans, function (id, tag) {
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
    let isDeletedConfirmed = false;
    TagTagify = function (dir) {
        var input = document.querySelectorAll('.productsTagsJs');
        input.forEach(function (element, index) {
            tagify = new Tagify(element, {
                whitelist: [],
                dropdown: {
                    position: 'input',
                    classname: dir,
                    enabled: 0 // show suggestions dropdown after 1 typed character
                }, hooks: {
                    beforeRemoveTag: function (tags) {
                        return new Promise((resolve, reject) => {
                            if (isDeletedConfirmed == false && !confirm(langLbl.confirmRemove)) {
                                return false;
                            }
                            isDeletedConfirmed = true;
                            resolve();
                        })
                    }
                }

            }).on('input', getTags).on('focus', getTags).on('add', addTagData).on('remove', removeTagData);
        });
    };

})();