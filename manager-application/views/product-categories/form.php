<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);


$fld = $frm->getField('prodcat_parent');
$fld->setFieldTagAttribute('id', "prodcat_parent");

$fld = $frm->getField('prodcat_active');
$fld->developerTags['cbLabelAttributes'] = ['class' => 'switch switch-sm switch-icon'];

$fld = $frm->getField('auto_update_other_langs_data');
$fld->developerTags['cbLabelAttributes'] = ['class' => 'switch switch-sm switch-icon'];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];
$formTitle = Labels::getLabel('LBL_CATEGORY_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
var canEditRating = <?php echo $canEditRating ? 1 : 0; ?>;
var ratingEditErr = '<?php echo Labels::getLabel('ERR_NOT_AUTHORIZED_TO_ADD_RATING_TYPE', $siteLangId); ?>';
$("document").ready(function() {

    $("#prodcat_parent").select2();
    $("." + $.ykmodal.element).removeAttr('tabindex');
    addRatingType = function(e) {
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
            /*
            var data = 'ratingtype_active=1&ratingtype_id=0&ratingtype_identifier=' + ratingtype_name
            fcom.ajax(fcom.makeUrl('RatingTypes', 'setup'), data, function(t) {
                var ans = JSON.parse(t);
                var newRtId = ans.rtId;
                var dataLang = 'ratingtypelang_ratingtype_id=' + newRtId + '&ratingtype_name=' +
                    ratingtype_name + '&ratingtypelang_lang_id=<?php echo $siteLangId; ?>';
                fcom.ajax(fcom.makeUrl('RatingTypes', 'langSetup'), dataLang, function(t2) {
                    var ans = JSON.parse(t2);
                    fcom.updateWithAjax(fcom.makeUrl('ProductCategories',
                            'updateRatingTypes'), 'prt_prodcat_id=' + prodCatId +
                        '&prt_ratingtype_id=' + newRtId,
                        function(t3) {
                            $('tag[value="' + e.detail.data.value + '"]').attr('id',
                                newRtId);
                        });
                });
            });
            */
        } else {
            /*      
            fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'updateRatingTypes'), 'prt_prodcat_id=' + prodCatId + '&prt_ratingtype_id=' + rt_id, function(t) {});
            */
        }
    }

    removeRatingType = function(e) {
        var rt_id = e.detail.tag.id;
        var prodCatId = $("input[name='prodcat_id']").val();
        if ('' == rt_id || '' == prodCatId) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'removeRatingType'), 'prt_prodcat_id=' +
            prodCatId + '&prt_ratingtype_id=' + rt_id,
            function(t) {});

    }

    getRatingTypeAutoComplete = function(e) {
        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('ProductCategories', 'ratingTypeAutoComplete'), {
            keyword: keyword
        }, function(t) {
            var ans = JSON.parse(t);
            for (i = 0; i < ans.length; i++) {
                list.push({
                    "id": ans[i].id,
                    "value": ans[i].ratingtype_identifier,
                });
            }
            tagify.settings.whitelist = list;
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

    tagifyRatingTypes = function() {
        var element = 'input[name=rating_type]';
        if ('undefined' !== typeof $(element).attr('disabled')) {
            return;
        }
        $(element).siblings(".tagify").remove();
        tagify = new Tagify(document.querySelector('input[name=rating_type]'), {
            whitelist: [],
            delimiters: "#",
            editTags: false,
        }).on('add', addRatingType).on('remove', removeRatingType).on('focus',
            getRatingTypeAutoComplete);
    };
    tagifyRatingTypes();

});
</script>