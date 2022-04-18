<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('prodcat_identifier');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','prodcat_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val(),'','pre',true)");
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('prodcat_id');
$fld->setFieldTagAttribute('id', "prodcat_id");

$fld = $frm->getField('prodcat_name[' . CommonHelper::getDefaultFormLangId() . ']');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('prodcat_parent');
$fld->setFieldTagAttribute('id', "prodcat_parent");
$fld->setFieldTagAttribute('data-old-parent-id', $fld->value);

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<span class='form-text text-muted'>" . HtmlHelper::seoFriendlyUrl(UrlHelper::generateFullUrl('Category', 'view', [$recordId], CONF_WEBROOT_FRONT_URL)) . '</span>';
$fld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");

$fld = $frm->getField('rating_type');
$fld->setFieldTagAttribute('class', 'custom-tagify');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_TYPE_TO_SEARCH', $siteLangId));
$url = UrlHelper::generateFullUrl('RatingTypes');
$fld->htmlAfterField = '<span class="form-text text-muted"><a href="' . $url . '" target="_blank">' . $url . '</a></span>';

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
            'onclick' => 'catMediaForm(' . $recordId . ')',
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
    $(document).ready(function() {
        $("#prodcat_parent").select2({
                dropdownParent: $("#prodcat_parent").closest('form'),
            })
            .on('select2:open', function(e) {
                $("#prodcat_parent").data("select2").$dropdown.addClass("custom-select2 custom-select2-single");
            })
            .data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");

        $("." + $.ykmodal.element).removeAttr('tabindex');

        addRatingType = function(e) {
            var rt_id = e.detail.tag.id;
            var ratingtype_name = e.detail.tag.title;
            var prodCatId = $("input[name='prodcat_id']").val();
            if (rt_id == '') {
                if (1 > canEditRating) {
                    fcom.displayErrorMessage(ratingEditErr);
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
            if ('' == rt_id || 1 > prodCatId) {
                return;
            }
            fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'removeRatingType'), 'prt_prodcat_id=' +
                prodCatId + '&prt_ratingtype_id=' + rt_id,
                function(t) {
                    fcom.closeProcessing();
                });

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
                        "value": $.trim(ans[i].ratingtype_identifier),
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
                dropdown: {
                    enabled: 0 // show suggestions dropdown after 1 typed character
                },
                delimiters: "#",
                editTags: false,
            }).on('add', addRatingType).on('remove', removeRatingType).on('focus',
                getRatingTypeAutoComplete);
        };
        tagifyRatingTypes();

    });
</script>