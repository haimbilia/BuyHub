<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$fld = $frm->getField('prodcat_parent');
$fld->setFieldTagAttribute('id', "prodcat_parent");

$fld = $frm->getField('prodcat_active');
HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;   
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;   
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

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

        $("#prodcat_parent").select2({
            dropdownParent: $('.'+$.ykmodal.element)
        });
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
                if (!confirm(addNewRatingType)) {
                    return;
                }               
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