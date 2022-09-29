<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$frm->setFormTagAttribute('class', 'form');

$displayDigitalDownloadAddBtn = $productData['product_type'] == Product::PRODUCT_TYPE_DIGITAL && $frm->getField('product_type')->value == Product::PRODUCT_TYPE_DIGITAL;
$displayDigitalDownloadList = $displayDigitalDownloadAddBtn && 1 > $productData['product_attachements_with_inventory'];
?>
<main class="main mainJs" <?php echo CommonHelper::getLayoutDirection() != $formLayout ? 'dir="' . $formLayout . '"' : ''; ?>>
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false);
        $frm->setFormTagAttribute('id', 'addProductfrm');
        $frm->setFormTagAttribute('onsubmit', 'setup($(\'#addProductfrm\'));return false;');
        echo $frm->getFormTag(); ?>
        <?php if (1 > $tourStep) { ?>
            <div class="add-stock" id="productWrapper">
                <?php require_once(CONF_THEME_PATH . 'products/form-left.php'); ?>
                <?php require_once(CONF_THEME_PATH . 'products/form-right.php'); ?>
            </div>
        <?php } else { ?>
            <div class="onboarding">
                <?php require_once(CONF_THEME_PATH . 'getting-started/left-nav.php'); ?>
                <div class="onboarding-main">
                    <?php require_once(CONF_THEME_PATH . 'products/form-right.php'); ?>
                </div>
            </div>
        <?php } ?>
        </form>
    </div>
    <table class="hide" id="variantCloneJs">
        <?php echo getVariantUiTr($langId, -1);  ?>
    </table>
    <?php echo $frm->getExternalJS();
    $imgFrm->setFormTagAttribute('class', 'hide');
    $imgFrm->setFormTagAttribute('name', 'hiddenMediaFrm');
    $imgFrm->setFormTagAttribute('id', 'hiddenMediaFrmJs');
    $fld = $imgFrm->getField('prod_image');
    $fld->addFieldTagAttribute('onChange', "loadCropper(this)");
    $fld->addFieldTagAttribute('id', "hiddenMediaFrmFileJs");
    $fld->addFieldTagAttribute('accept', "image/*");
    $fld->addFieldTagAttribute('data-name', Labels::getLabel("FRM_PRODUCT_IMAGE", $siteLangId));
    echo $imgFrm->getFormHtml();

    ?>
    <script>
        var canEditTags = <?php echo $canEditTags ? 1 : 0; ?>;
        var tagsEditErr = '<?php echo Labels::getLabel('ERR_NOT_AUTHORIZED_TO_ADD_TAGS', $langId); ?>';
        var tagifyObjs = {};
        var productOptions = <?php echo json_encode($productOptions); ?>;
        var forAllOptionsLbl = '<?php echo Labels::getLabel('FRM_FOR_ALL_OPTIONS', $langId); ?>';
        var typeDigitalFile = '<?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>';
        var typeDigitalLink = '<?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>';
        var fulfilmentTypePickup = '<?php echo Shipping::FULFILMENT_PICKUP; ?>';
        var prodTypeDigital = '<?php echo Product::PRODUCT_TYPE_DIGITAL; ?>';

        $(function() {
            $('.mainJs').addClass('isLoading');
            $('#productWrapper').prepend(fcom.getLoader());
            prodSpecifications();
            tagifyProducts();
            productDefaultImages();
            var langId = getCurrentFrmLangId();
            select2('product_brand_id', fcom.makeUrl('Brands', 'autoComplete'), {
                brand_active: 1,
                langId: langId
            });
            select2('ptc_prodcat_id', fcom.makeUrl('ProductCategories', 'autoComplete'), {
                langId
            });
            select2('ptt_taxcat_id', fcom.makeUrl('TaxCategories', 'autoComplete'), {
                langId
            });
            select2('product_ship_package', fcom.makeUrl('shippingPackages', 'autoComplete'), {
                langId
            });
            select2('ps_from_country_id', fcom.makeUrl('Countries', 'autoComplete'), {
                langId
            });

            $('#addProductfrm .optionsJs').each(function(index) {
                var selectedOptionData = [];
                if (index in productOptions) {
                    let optionName = productOptions[index]['option_name'];
                    if (productOptions[index]['option_name'] != productOptions[index]['option_identifier']) {
                        optionName += '(' + productOptions[index]['option_identifier'] + ')';
                    }
                    selectedOptionData = [{
                        selected: true,
                        id: productOptions[index]['option_id'],
                        text: optionName,
                        option_is_separate_images: productOptions[index]['option_is_separate_images'],
                    }]
                }
                select2($(this).attr('id'), fcom.makeUrl('Options', 'autoComplete'), optionDataCallback,
                    resetOptionValuesTag,
                    resetOptionValuesTag,
                    '',
                    selectedOptionData
                );
                $(this).data("select2").$container.addClass("custom-select2 custom-select2-width");

            });


            $('#addProductfrm .optionValuesJs').each(function(index) {
                tagifyOptionValue("#" + $(this).attr('id'));
            });


            <?php
            if (isset($isProductAddedByAdmin)  && isset($isSelProdCreatedBySeller)) {
                if ($isProductAddedByAdmin  && !$isSelProdCreatedBySeller) { ?>
                    select2('product_seller_id', fcom.makeUrl('Users', 'autoComplete'), {
                        joinShop: 1,
                        user_is_supplier: 1,
                        langId
                    }, function(e) {
                        getShippingProfileOptions(e.params.args.data.id)
                    });
                <?php } else { ?>
                    $('select[name=\'product_seller_id\']').attr('disabled', true);
            <?php }
            } ?>

            <?php if (0 < $recordId && $displayDigitalDownloadList) { ?>
                getDigitalDownloads(<?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>, <?php echo $recordId; ?>);
                getDigitalDownloads(<?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>, <?php echo $recordId; ?>);
            <?php } ?>
            upcType();
            fixTableColumnWidth();
        });
        
        $(document).ready(function() {
            if (prodTypeDigital == $('.productTypeJs:checked').val() && 0 == $('.attachmentWithInventoryJs:checked').val()) {
                $('.digitalDownloadSectionJS').removeClass('hide');
            } else if (!$('.digitalDownloadSectionJS').hasClass('hide')) {
                $('.digitalDownloadSectionJS').addClass('hide');
            }
        });

        $(document).on('change', '.attachmentWithInventoryJs', function() {
            if (prodTypeDigital == $('.productTypeJs:checked').val()) {
                if (1 == $(this).val()) {
                    $('.digitalDownloadSectionJS').addClass('hide');
                } else {
                    $('.digitalDownloadSectionJS').removeClass('hide');
                }
            }
        });
    </script>
</main>

<?php
function getVariantUiTr($langId, $i, $productOption = [])
{
    $deleteClass = $i == 0 ? 'hide' : '';
    $optionLabel = Labels::getLabel('FRM_SELECT_OPTION', $langId);
    $confWebUrl = CONF_WEBROOT_URL;

    $tagData = [];
    if (!empty($productOption)) {
        foreach ($productOption['optionValues'] as $key => $name) {
            $tagData[] = ['id' => $key, 'value' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8')];
        }
    }
    $tagData = json_encode($tagData);

    $tagifyPlaceholder = Labels::getLabel('FRM_TYPE_TO_SEARCH');

    return <<<HTML
    <tr class="rowJs">
        <td>
            <select class="optionsJs" id="options$i" name="options[]" class="form-control" placeholder="$optionLabel"> 
            </select>
        </td>
        <td>
            <input class="form-tagify optionValuesJs" placeholder='$tagifyPlaceholder' id="optionValues$i" data-index="$i" name="optionValues[]" value='$tagData'>
        </td>
        <td class="align-right">
            <ul class="actions">
                <li class="$deleteClass optionsDeleteJs">
                    <a href="javascript:void(0)" class="">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="{$confWebUrl}images/retina/sprite-actions.svg#delete">
                            </use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="optionsAddJs">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="{$confWebUrl}images/retina/sprite-actions.svg#add">
                            </use>
                        </svg>
                    </a>
                </li>
            </ul>
        </td> 
    </tr>
    HTML;
}
?>