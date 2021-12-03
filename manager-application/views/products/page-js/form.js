(function () {
   
    setup = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Products', 'setup'), data, function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);
        });
    };

    langForm = function (autoFillLangData = 0) {
        let productId = $("#addProductfrm input[name='product_id']").val();
        let langId = $("#addProductfrm [name='lang_id']").val();
        $('.mainJs').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Products', 'form', [productId]), { langId, autoFillLangData }, function (res) {
            $('.mainJs').replaceWith(res);
            fcom.removeLoader();
        });

    };

    productType = function (el) {
        let productId = $("#addProductfrm input[name='product_id']").val();
        let langId = $("#addProductfrm [name='lang_id']").val();
        let productType = $(el).val();
        $('.mainJs').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Products', 'form', [productId, productType]), { langId }, function (res) {
            $('.mainJs').replaceWith(res);
            fcom.removeLoader();
        });

    };

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
    addTaxCategory = function () {
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('TaxCategories', "form"), "", function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
    addTagData = function (e) {
        let rt_id = e.detail.data.id;
        if (rt_id == '') {
            if (1 > canEditTags) {
                $.ykmsg.error(tagsEditErr);
                e.detail.tag.remove();
                return;
            }
        }

    };

    removeTagData = function (e) {
        var tag_id = e.detail.tag.id;
        fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), 'product_id=' + product_id + '&tag_id=' + tag_id, function (t) { });
        tagifyProducts();
    };

    getTagsAutoComplete = function (e) {

        let keyword = e.detail.value;
        let langId = $("#addProductfrm [name='langId']").val();
        var list = [];
        fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), { keyword, langId }, function (t) {
            var ans = $.parseJSON(t);         
            for (i = 0; i < ans.length; i++) {  
                list.push({
                    "id": ans[i].tag_id,
                    "value": ans[i].tag_name,
                });
            }
            tagify.settings.whitelist = list;
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    };

    tagifyProducts = function () {
        var element = '#product_tags';
        if ('undefined' !== typeof $(element).attr('disabled')) {
            return;
        }
        $(element).siblings(".tagify").remove();
        tagify = new Tagify(document.querySelector(element), {
            whitelist: [],
            delimiters: "#",
            editTags: false,
        }).on('add', addTagData).on('remove', removeTagData).on('input', getTagsAutoComplete);
    };

    addSpecification = function () {

        let appendEle = $('#specificationsListJs');

        let label = $('#sp_label').val();
        let value = $('#sp_value').val();
        let group = $('#sp_group').val();
        let prodSpecId = parseInt($('#sp_id').val());
        if (prodSpecId == NaN) {
            prodSpecId = 0;
        }
        if (!validateSpeficationForm()) {
            return;
        }

        let rowCount = appendEle.find('tr').length;

        let html = '<tr data-id="' + prodSpecId + '">';
        html += '<td class="nameJs">' + label + '<input type="hidden" name="specifications[' + rowCount + '][name]" value="' + label + '"  data-fatreq="{&quot;required&quot;:false}"/> </td>';
        html += '<td class="valueJs">' + value + '<input type="hidden" name="specifications[' + rowCount + '][value]" value="' + value + '" data-fatreq="{&quot;required&quot;:false}" /> </td>';
        html += '<td class="groupJs">' + group + '<input type="hidden" name="specifications[' + rowCount + '][group]"  value="' + group + '" data-fatreq="{&quot;required&quot;:false}" /> </td>';
        html += '<td class="align-right"><ul class="actions">' +
            '<li><input type="hidden" name="specifications[' + rowCount + '][id]" value="' + prodSpecId + '"  data-fatreq="{&quot;required&quot;:false}"/>' +
            '<a href="javascript:void(0)"  onclick="editProdSpec(this)">' +
            '<svg class="svg" width="18" height="18">' +
            '<use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#edit">' +
            '</use>' +
            '</svg>' +
            '</a></li>' +
            '<li>' +
            '<a href="javascript:void(0)" onclick="deleteProdSpec(this)">' +
            '<svg class="svg" width="18" height="18">' +
            '<use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#delete">' +
            '</use>' +
            '</svg>' +
            '</a></li>' +
            '</td>';
        html += '</ul></tr>';

        if (appendEle.find('.editRowJs').length) {
            appendEle.find('.editRowJs').replaceWith(html);
        } else {
            appendEle.find('tbody').append(html);
        }

        appendEle.find('table').removeClass('hide');

        $('#sp_label').val('');
        $('#sp_value').val('');
        $('#sp_group').val('');
        $('#sp_id').val(0);

    };
    validateSpeficationForm = function () {
        let validate = true;
        $('#specificationsFormJs input').each(function () {
            if ($(this).data('change-event-bind') != 1) {
                $("input").change(function () {
                    $(this).siblings('ul').remove();
                });
                $(this).data('change-event-bind', 1);
            }
            $(this).siblings('ul').remove();
            if ($(this).data('required') == 1 && '' == $(this).val()) {
                let caption = $(this).siblings('label').text().trim();
                errorlist = $(document.createElement("ul")).addClass('errorlist').append(
                    $(document.createElement('li')).append($(document.createElement('a')).html(caption + " " + langLbl.isMandatory,).attr({ 'href': 'javascript:void(0);' }))
                );
                $(this).after(errorlist);
                validate = false;
            }
        });

        return validate;
    };

    prodSpecifications = function () {
        var productId = $("#addProductfrm input[name='product_id']").val();
        var langId = $("#addProductfrm [name='lang_id']").val();
        fcom.ajax(fcom.makeUrl('Products', 'prodSpecifications'), { product_id :productId, langId }, function (res) {
            $('#specificationsListJs').html(res);
            if ($('#specificationsListJs').find('table tbody tr').length == 0) {
                $('#specificationsListJs').find('table').addClass('hide');
            }
        });
    };

    editProdSpec = function (el) {
        let trEle = $(el).closest('tr');
        let prodSpecId = parseInt(trEle.data('id'));
        if (prodSpecId == NaN) {
            prodSpecId = 0;
        }

        let label = trEle.find('.nameJs').text();
        let value = trEle.find('.valueJs').text();
        let group = trEle.find('.groupJs').text();
        trEle.siblings().removeClass('editRowJs');
        trEle.addClass('editRowJs');

        $('#sp_label').val(label);
        $('#sp_value').val(value);
        $('#sp_group').val(group);
        $('#sp_id').val(prodSpecId);
    };


    deleteProdSpec = function (el) {
        let prodSpecId = $(el).closest('tr').data('id');
        if (1 > prodSpecId) {
            $(el).closest('tr').remove();
            if ($('#specificationsListJs').find('table tbody tr').length == 0) {
                $('#specificationsListJs').find('table').addClass('hide');
            }
            return;
        }

        fcom.updateWithAjax(fcom.makeUrl('Products', 'deleteProdSpec'), { prodSpecId }, function (t) {
            prodSpecifications();
        });
    };

    getShippingProfileOptions = function (userId) { 
        let langId = getCurrentFrmLangId();
        fcom.updateWithAjax(fcom.makeUrl('Products', 'getShippingProfileOptions'), { userId, langId }, function (t) {
            if(t.shippingApiActive == 1){
                $('#shipping_profile').attr('disabled', true );
            }else{
                $('#shipping_profile').attr('disabled', false )
                .html('');
                $.each(t.shipProfileArr,function (id,name){
                    $('#shipping_profile').append(`<option value="${id}">
                            ${name}
                    </option>`);
                });
            }            
        });
    };

    getCurrentFrmLangId = function (){
        return $("#addProductfrm [name='lang_id']").val();
    };

    imagesForm =  function (productId = 0){
        if (false === checkControllerName()) {
            return false;
        }     
        $.ykmodal(fcom.getLoader());     
        fcom.ajax(fcom.makeUrl(controllerName, "imagesForm",[productId]),'', function (t) {
            $.ykmodal(t);
            productImages(productId);
            fcom.removeLoader();
        });
    };

    productImages = function( product_id,option_id = 0,lang_id = 0){
        fcom.ajax(fcom.makeUrl('Products', 'images', [product_id,option_id,lang_id]), '', function(t) {
            $('#imageupload_div').html(t);
        });
    };

    /** on option select/deselect */
    resetOptionValuesTag = function (e){
        let index = $(e.target.closest('.rowJs')).find('input.optionValuesJs').data('index'); 
        if(index in tagifyObjs){
            tagifyObjs[index].settings.whitelist = [];
            tagifyObjs[index].removeAllTags();
        }
    }

    getOptionValues = function(e) {         
        let optionId = $(e.detail.tagify.DOM.originalInput).closest('.rowJs').find('.optionsJs').val();
        if(optionId  == null){         
            e.detail.tagify.settings.whitelist = [];
            e.detail.tagify.removeAllTags();
            return;
        }

        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('OptionValues', 'autoComplete'), {
            keyword: keyword,
            optionId :optionId,
            langId : getCurrentFrmLangId()
        }, function(t) {
            var ans = JSON.parse(t); 
            $(ans['results']).each(function(id,val){
                list.push({
                    "id": val.id,
                    "value": val.text,
                });
            }); 
            e.detail.tagify.settings.whitelist = list;
            e.detail.tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }
    
    tagifyOptionValue = function(element) {          
        let index = $(element).data('index');
        $(element).siblings(".tagify").remove();
        var tagify = new Tagify(document.querySelector(element), {
            whitelist : [],
            delimiters : "#",
            dropdown: {
                closeOnSelect: false,
                enabled: 0, 
                classname: "tags-look",             
            },                
            enforceWhitelist : true,
            skipInvalid:true,
        }).on('input', getOptionValues).on('focus', getOptionValues);
        tagifyObjs[index] = tagify;
    };    

})();

$(document).on('click', '.warrantyTypeJs', function () {
    let type = $(this).data('type');
    $(this).closest('div').siblings('.warrantyTypeButtonJs').text($(this).text());
    $("#product_warranty_unit").val(type);
});

$(document).on('click', '.optionsAddJs', function () {

    let clonedRow = $('#variantsJs .rowJs:first').clone(); 
    let index = clonedRow.find('.optionValuesJs').data('index');
    let newIndex = $('#variantsJs .rowJs').length + 1;
    let optionId = clonedRow.find('.optionsJs').attr('id').replace(index, ""); 
    let newOptionId = optionId + newIndex;  
    clonedRow.find('.optionsJs').attr('id',newOptionId);

    let optionValueId = clonedRow.find('.optionValuesJs').attr('id').replace(index, "");
    let newOptionValueId = optionValueId + newIndex;
    clonedRow.find('.optionValuesJs').attr('id',newOptionValueId);  

    clonedRow.removeClass('hide');
    clonedRow.find('.optionsAddJs').removeClass('hide');     
    clonedRow.insertAfter('#variantsJs .rowJs:last');  

    select2(newOptionId, fcom.makeUrl('Options', 'autoComplete'),{},function(e){           
        resetOptionValuesTag(e);
    },function(e){
        resetOptionValuesTag(e);
    });

    $('#'+newOptionId).data("select2").$container.addClass("w-100");
    tagifyOptionValue("#"+newOptionValueId); 
  
});

$(document).on('click', '.optionsDeleteJs', function () {

    $(this).closest('.rowJs').remove();
  
});




