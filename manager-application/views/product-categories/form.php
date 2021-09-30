<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
$prodCatFrm->setFormTagAttribute('class', 'web_form');
$prodCatFrm->setFormTagAttribute('id', 'frmProdCategory');
$prodCatFrm->setFormTagAttribute('onsubmit', 'setupCategory(); return(false);');

$activeFld = $prodCatFrm->getField('prodcat_active');

$activeFld->setOptionListTagAttribute('class', 'list-inline-checkboxes');
$activeFld->developerTags['rdLabelAttributes'] = array('class' => 'radio');
$activeFld->developerTags['rdHtmlAfterRadio'] = '<i class="input-helper"></i>';

$statusFld = $prodCatFrm->getField('prodcat_status');
if (null != $statusFld) {
    $statusFld->setOptionListTagAttribute('class', 'list-inline-checkboxes');
    $statusFld->developerTags['rdLabelAttributes'] = array('class' => 'radio');
    $statusFld->developerTags['rdHtmlAfterRadio'] = '<i class="input-helper"></i>';
}

$iconLangFld = $prodCatFrm->getField('icon_lang_id');
$iconLangFld->addFieldTagAttribute('class', 'icon-language-js');

$iconFld = $prodCatFrm->getField('cat_icon');
$iconFld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
$iconFld->addFieldTagAttribute('onChange', 'iconPopupImage(this)');
$iconFld->htmlAfterField = '<small class="text--small">' . sprintf(Labels::getLabel('LBL_This_will_be_displayed_in_%s_on_your_store', $adminLangId), '60*60') . '</small>';

$bannerFld = $prodCatFrm->getField('cat_banner');
$bannerFld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
$bannerFld->addFieldTagAttribute('onChange', 'bannerPopupImage(this)');
$bannerFld->htmlAfterField = '<small class="text--small" class="preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $adminLangId), '2000 x 500') . '</small>';

$bannerLangFld = $prodCatFrm->getField('banner_lang_id');
$bannerLangFld->addFieldTagAttribute('class', 'banner-language-js');

$screenFld = $prodCatFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('class', 'prefDimensions-js');

/* $btn = $prodCatFrm->getField('btn_submit');
$btn->setFieldTagAttribute('class', "btn-clean btn-sm btn-icon btn-secondary");

$btn = $prodCatFrm->getField('btn_discard');
$btn->addFieldTagAttribute('onClick', "discardForm()");
$btn->setFieldTagAttribute('class', "btn-clean btn-sm btn-icon btn-secondary"); */

$fld = $prodCatFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    $fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
    $fld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
}
?>
<?php echo $prodCatFrm->getFormTag(); ?>
<div class="sectionbody space">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="form__heading"><?php echo Labels::getLabel('LBL_General', $adminLangId); ?></h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php
                                $fld = $prodCatFrm->getField('prodcat_identifier');
                                echo $fld->getCaption();
                                ?>
                                <span class="spn_must_field">*</span></label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $prodCatFrm->getFieldHtml('prodcat_identifier'); ?>
                                <?php echo $prodCatFrm->getFieldHtml('prodcat_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php
                                $fld = $prodCatFrm->getField('prodcat_name[' . $siteDefaultLangId . ']');
                                echo $fld->getCaption();
                                ?>
                                <span class="spn_must_field">*</span></label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $prodCatFrm->getFieldHtml('prodcat_name[' . $siteDefaultLangId . ']'); ?>
                                <?php echo $prodCatFrm->getFieldHtml('prodcat_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php $fld = $prodCatFrm->getField('parent_category_name');
                                echo $fld->getCaption();
                                ?></label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $prodCatFrm->getFieldHtml('parent_category_name'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php $fld = $prodCatFrm->getField('prodcat_active');
                                echo $fld->getCaption();
                                ?></label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $prodCatFrm->getFieldHtml('prodcat_active'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $prodCatFrm->getField('rating_type')->getCaption(); ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $prodCatFrm->getFieldHtml('rating_type'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (null != $statusFld) { ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="field-set d-flex align-items-center">
                            <div class="caption-wraper w-auto pr-4">
                                <label class="field_label">
                                    <?php echo $statusFld->getCaption(); ?>
                                </label>
                            </div>
                            <div class="field-wraper w-auto">
                                <div class="field_cover">
                                    <?php echo $prodCatFrm->getFieldHtml('prodcat_status'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div id="cropperBox-js"></div>
            <?php $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
            if (!empty($translatorSubscriptionKey) && count($otherLangData) > 0) { ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="field-set">
                            <?php echo $prodCatFrm->getFieldHtml('auto_update_other_langs_data'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="p-4 mb-4 border rounded">
                <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Icon', $adminLangId); ?></h3>
                <div class="row">
                    <?php

                    $fld = $prodCatFrm->getField('icon_lang_id');
                     $iconLang = $fld->fldType;
                    if ($iconLang != 'hidden') {
                    ?>

                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper"><label class="field_label">
                                        <?php
                                        echo $fld->getCaption();
                                        ?>
                                    </label></div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $prodCatFrm->getFieldHtml('icon_lang_id'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                        echo $prodCatFrm->getFieldHtml('icon_lang_id');
                    }
                    ?>

                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label"></label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $prodCatFrm->getFieldHtml('icon_file_type');
                                    echo $prodCatFrm->getFieldHtml('cat_icon'); ?>
                                    <?php
                                    foreach ($mediaLanguages as $key => $data) {
                                        echo $prodCatFrm->getFieldHtml('cat_icon_image_id[' . $key . ']');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="icon-image-listing"></div>
                </div>
                <div class="divider"></div>
                <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Banner', $adminLangId); ?></h3>
                <div class="row">
                <?php

                    $fld = $prodCatFrm->getField('banner_lang_id');
                    $bannerLang = $fld->fldType;
                    if ($bannerLang != 'hidden') {
                    ?>
                    <div class="col-md-3">
                        <div class="field-set">
                            <div class="caption-wraper"><label class="field_label">
                                    <?php 
                                    echo $fld->getCaption();
                                    ?>
                                </label></div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $prodCatFrm->getFieldHtml('banner_lang_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else {
                        echo $prodCatFrm->getFieldHtml('banner_lang_id');
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="field-set">
                            <div class="caption-wraper"><label class="field_label">
                                    <?php $fld = $prodCatFrm->getField('slide_screen');
                                    echo $fld->getCaption();
                                    ?>
                                </label></div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $prodCatFrm->getFieldHtml('slide_screen'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper"><label class="field_label">
                                </label></div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $prodCatFrm->getFieldHtml('banner_file_type');
                                    echo $prodCatFrm->getFieldHtml('cat_banner'); ?>
                                    <?php
                                    foreach ($mediaLanguages as $key => $data) {
                                        foreach ($screenArr as $key1 => $screen) {
                                            echo $prodCatFrm->getFieldHtml('cat_banner_image_id[' . $key . '_' . $key1 . ']');
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="banner-image-listing"></div>
                </div>
            </div>
            <?php if (!empty($otherLangData)) {
                foreach ($otherLangData as $langId => $data) { ?>
                    <div class="accordians_container accordians_container-categories" defaultLang="<?php echo $siteDefaultLangId; ?>" language="<?php echo $langId; ?>" id="accordion-language_<?php echo $langId; ?>" onClick="translateData(this)">
                        <div class="accordian_panel">
                            <span class="accordian_title accordianhead accordian_title" id="collapse_<?php echo $langId; ?>">
                                <?php echo $data . " ";
                                echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
                            </span>
                            <div class="accordian_body accordiancontent" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field-set">
                                            <div class="caption-wraper">
                                                <label class="field_label">
                                                    <?php $fld = $prodCatFrm->getField('prodcat_name[' . $langId . ']');
                                                    echo $fld->getCaption(); ?>
                                                </label>
                                            </div>
                                            <div class="field-wraper">
                                                <div class="field_cover">
                                                    <?php echo $prodCatFrm->getFieldHtml('prodcat_name[' . $langId . ']'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
            <?php if (0 < $productReq) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $prodCatFrm->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $prodCatFrm->getFieldHtml('banner_min_width');
echo $prodCatFrm->getFieldHtml('banner_min_height');
echo $prodCatFrm->getFieldHtml('logo_min_width');
echo $prodCatFrm->getFieldHtml('logo_min_height');
echo $prodCatFrm->getFieldHtml('prodcat_parent');
?>
</form>
<?php echo $prodCatFrm->getExternalJS();

$catAutocompleteArr = [];
foreach ($categories as $catId => $catName) {
    $catAutocompleteArr[] = array(
        'id' => $catId,
        'label' => strip_tags(html_entity_decode($catName, ENT_QUOTES, 'UTF-8'))
    );
}
?>

<script>
    $('input[name=banner_min_width]').val(2000);
    $('input[name=banner_min_height]').val(500);
    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var aspectRatio = 4 / 1;
    $(document).on('change', '.prefDimensions-js', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $('input[name=banner_min_width]').val(2000);
            $('input[name=banner_min_height]').val(500);
            aspectRatio = 4 / 1;
        } else if ($(this).val() == screenIpad) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $('input[name=banner_min_width]').val(1024);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 128 / 45;
        } else {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $('input[name=banner_min_width]').val(640);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 16 / 9;
        }
    });


    $(document).ready(function() {
        var catAutocompleteArr = <?php echo json_encode($catAutocompleteArr);  ?>;
        $('input[name=\'parent_category_name\']').autocomplete({
            minLength: 0,
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            source: catAutocompleteArr,
            select: function(event, ui) {
                $('input[name=\'prodcat_parent\']').val(ui.item.id);
            }
        }).focus(function() {
            $(this).autocomplete('search', $(this).val())
        });

        $('input[name=\'parent_category_name\']').change(function() {
            if ($(this).val() == '') {
                $("input[name='prodcat_parent']").val(0);
            }
        });

    });


    addRatingType = function(e) {
        var rt_id = e.detail.tag.id;
        var ratingtype_name = e.detail.tag.title;
        var prodCatId = $("input[name='prodcat_id']").val();
        if (rt_id == '') {
            if (!confirm(langLbl.addNewRatingType)) {
                return;
            }
            var data = 'ratingtype_active=1&ratingtype_id=0&ratingtype_identifier=' + ratingtype_name
            fcom.ajax(fcom.makeUrl('RatingTypes', 'setup'), data, function(t) {
                var ans = $.parseJSON(t);
                var newRtId = ans.rtId;
                var dataLang = 'ratingtypelang_ratingtype_id=' + newRtId + '&ratingtype_name=' + ratingtype_name + '&ratingtypelang_lang_id=<?php echo $adminLangId; ?>';
                fcom.ajax(fcom.makeUrl('RatingTypes', 'langSetup'), dataLang, function(t2) {
                    var ans = $.parseJSON(t2);
                    fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'updateRatingTypes'), 'prt_prodcat_id=' + prodCatId + '&prt_ratingtype_id=' + newRtId, function(t3) {
                        $('tag[value="' + e.detail.data.value + '"]').attr('id', newRtId);
                    });
                });
            });
        } else {
            fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'updateRatingTypes'), 'prt_prodcat_id=' + prodCatId + '&prt_ratingtype_id=' + rt_id, function(t) {});
        }
        // tagifyRatingTypes();
    }

    removeRatingType = function(e) {
        var rt_id = e.detail.tag.id;
        var prodCatId = $("input[name='prodcat_id']").val();
        if ('' == rt_id || '' == prodCatId) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'removeRatingType'), 'prt_prodcat_id=' + prodCatId + '&prt_ratingtype_id=' + rt_id, function(t) {});
        // tagifyRatingTypes();
    }

    getRatingTypeAutoComplete = function(e) {
        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('ProductCategories', 'ratingTypeAutoComplete'), {
            keyword: keyword
        }, function(t) {
            var ans = $.parseJSON(t);
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
        }).on('add', addRatingType).on('remove', removeRatingType).on('input', getRatingTypeAutoComplete);
    };
    tagifyRatingTypes();
</script>