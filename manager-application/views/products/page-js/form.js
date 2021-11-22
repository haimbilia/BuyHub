(function () {


    $('#addProductfrm').find('input,select').each(function(){      
        if($(this).data('fatreq') == undefined){           
            $(this).data('fatreq',{"required":false});            
        } 
        if($(this).attr('name') == undefined){           
            $(this).attr('name','');            
        }
           
    });

    select2('product_brand_id', fcom.makeUrl('Brands', 'autoComplete'), { brand_active: 1 });
    select2('ptc_prodcat_id', fcom.makeUrl('ProductCategories', 'autoComplete'));
    select2('ptt_taxcat_id', fcom.makeUrl('Tax', 'autoComplete'));
    select2('ps_from_country_id', fcom.makeUrl('Countries', 'autoComplete'));

    setup = function (frm) { 
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('Products', 'setup'), data, function (res) {
           
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
        fcom.ajax(fcom.makeUrl('Tax', "form"), "", function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
    addTagData = function (e) {
        let rt_id = e.detail.tag.id;
        let tag_name = e.detail.tag.title;
        if (rt_id == '') {
            if (1 > canEditTags) {
                $.ykmsg.error(tagsEditErr);
                e.detail.tag.remove();
                return;
            }
        }
    }

    removeTagData = function (e) {
        var tag_id = e.detail.tag.id;
        fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), 'product_id=' + product_id + '&tag_id=' + tag_id, function (t) { });
        tagifyProducts();
    }

    getTagsAutoComplete = function (e) {
        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), { keyword: keyword }, function (t) {
            var ans = $.parseJSON(t);
            for (i = 0; i < ans.length; i++) {
                list.push({
                    "id": ans[i].id,
                    "value": ans[i].tag_identifier,
                });
            }
            tagify.settings.whitelist = list;
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

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
        }).on('dropdown:select', addTagData).on('remove', removeTagData).on('input', getTagsAutoComplete);
    };
    tagifyProducts();

    addSpecifiction = function () {

        let label = $('#sp_label').val();
        let value = $('#sp_value').val();
        let group = $('#sp_group').val();
        if(!validateSpeficationForm()){
            return;
        } 

        let html  = '<tr>';
        html  += '<td>'+label+'<input type="hidden" value="specifications[]["label"]" /> </td>';
        html  += '<td>'+value+'<input type="hidden" value="specifications[]["value"]" /> </td>';
        html  += '<td>'+group+'<input type="hidden" value="specifications[]["group"]" /> </td>';
        html +='<td class="align-right">'+
                '<a href="javascript:void(0)"  onclick="$(this).closest(\'tr\').remove()">'+
                '<svg class="svg" width="18" height="18">'+
                    '<use xlink:href="'+siteConstants.webroot+'images/retina/sprite-actions.svg#delete">'+
                    '</use>'+
                '</svg>'+
                '</a>'+
            '</td>';
        html  += '<tr>';

        $('#specificationsTableBodyJs').append(html);
       
    };
    validateSpeficationForm = function () {
        let validate = true;
        $('#specificationsFormJs input').each(function () {          
            if($(this).data('change-event-bind') != 1 ){
                $("input").change(function(){
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
    }


})();

$(document).on('click', '.warrantyTypeJs', function (event) {
    let type = $(this).data('type');
    $(this).closest('div').siblings('.warrantyTypeButtonJs').text($(this).text());
    $("#product_warranty_type").val(type);
});
