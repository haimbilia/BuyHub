<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$frm->setFormTagAttribute('class', 'form');
$displayDigitalDownloadAddBtn = false;
$displayDigitalDownloadList = false;
$shippingProfileId = $frm->getField('shipping_profile') ? $frm->getField('shipping_profile')->value : 0;

if (0 < $recordId) {
    $displayDigitalDownloadAddBtn = $productData['product_type'] == Product::PRODUCT_TYPE_DIGITAL && $frm->getField('product_type')->value == Product::PRODUCT_TYPE_DIGITAL  && 1 > $productData['product_seller_id'];
    $displayDigitalDownloadList = $displayDigitalDownloadAddBtn && 1 > $productData['product_attachements_with_inventory'];
}

?>
<main class="main mainJs" dir="<?php echo $formLayout; ?>">
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false);
        $frm->setFormTagAttribute('id', 'addProductfrm');
        $frm->setFormTagAttribute('onsubmit', 'setup($(\'#addProductfrm\'));return false;');
        echo $frm->getFormTag(); ?>
        <?php if (1 > $tourStep) { ?>
            <div class="add-stock">
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
        var tempImageType = '<?php echo AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP; ?>';
        var typeDigitalFile = '<?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>';
        var typeDigitalLink = '<?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>';
        var fulfilmentTypePickup = '<?php echo Shipping::FULFILMENT_PICKUP; ?>';
        var shippingProfileId = '<?php echo $shippingProfileId; ?>';

        $(function() {
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
            select2('ps_from_country_id', fcom.makeUrl('Countries', 'autoComplete'), {
                langId
            });

            $('#addProductfrm .optionsJs').each(function(index) {
                var selectedOptionData = [];
                if (index in productOptions) {
                    let optionName = productOptions[index]['option_name'];
                    if(productOptions[index]['option_name'] != productOptions[index]['option_identifier']){
                        optionName += '('+productOptions[index]['option_identifier']+')';
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
                $(this).data("select2").$container.addClass("w-100");

            });


            $('#addProductfrm .optionValuesJs').each(function(index) {
                tagifyOptionValue("#" + $(this).attr('id'));
            });

            getShippingProfileOptions(<?php echo $frm->getField('product_seller_id')->value; ?>);

            <?php if ($isProductAddedByAdmin  && !$isSelProdCreatedBySeller) { ?>
                select2('product_seller_id', fcom.makeUrl('Users', 'autoComplete'), {
                    joinShop: 1,
                    user_is_supplier: 1,
                    langId
                }, function(e) {
                    getShippingProfileOptions(e.params.args.data.id)
                });
            <?php } else { ?>
                $('select[name=\'product_seller_id\']').attr('disabled', true);
            <?php } ?>

            upcType();
            <?php if (0 < $recordId && $displayDigitalDownloadList) { ?>
                getDigitalDownloads(<?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>, <?php echo $recordId; ?>);
                getDigitalDownloads(<?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>, <?php echo $recordId; ?>);
            <?php } ?>
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

    return <<<HTML
    <tr class="rowJs">
        <td width="30%">
            <select class="optionsJs" id="options$i" name="options[]" class="form-control" placeholder="$optionLabel"> 
            </select>
        </td>
        <td width="50%">
            <input class="form-tagify optionValuesJs" id="optionValues$i" data-index="$i" name="optionValues[]" value='$tagData'>
        </td>
        <td class="align-right" width="20%">
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