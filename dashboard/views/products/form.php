<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$displayDigitalDownloadAddBtn = false;
$displayDigitalDownloadList = false;
if (0 < $recordId) {
    $displayDigitalDownloadAddBtn = $productData['product_type'] == Product::PRODUCT_TYPE_DIGITAL && $frm->getField('product_type')->value == Product::PRODUCT_TYPE_DIGITAL  && 0 < $productData['product_seller_id'];
    $displayDigitalDownloadList = $displayDigitalDownloadAddBtn && 1 > $productData['product_attachements_with_inventory'];
}
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main class="main mainJs" dir="<?php echo $formLayout; ?>">
    <div class="content-wrapper content-space">
        <?php   
        $frm->setFormTagAttribute('class', 'form'); 
        $frm->setFormTagAttribute('id', 'addProductfrm');
        $frm->setFormTagAttribute('onsubmit', 'setup($(\'#addProductfrm\'));return false;');
        echo $frm->getFormTag(); ?>
        <div class="content-header">
            <div class="content-header-title">
                <h2>Add Product</h2>
                <span class="text-muted"> <span class="required"></span> required
                    information</span>
                    <?php
                    $langFld =  $frm->getField('lang_id');
                    if (0 < $recordId) {
                        $langFld->setfieldTagAttribute('class', 'form-control form-select select-language');
                        $langFld->setfieldTagAttribute('onchange', 'langForm()');
                        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                        if (!empty($translatorSubscriptionKey) && $langId != CommonHelper::getDefaultFormLangId()) {
                            $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
                            $langFld->htmlAfterField = '<div class="input-group-append">
                                                            <a href="javascript:void(0);"  class="btn btn-brand" onclick="langForm(0,1)" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $langId) . '">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                                                    </use>
                                                                </svg>
                                                            </a>
                                                        </div>';
                        }

                    ?>
                        <div class="add-stock-column-head-action">
                            <div class="input-group">
                                <?php
                                echo $langFld->getHtml();
                                ?>
                            </div>
                        </div>
                    <?php } else {
                        echo $langFld->getHtml();
                    } ?>

            </div>
            <!-- <div class="content-header-toolbar">
                <div class="input-group">
                    <select class="form-control form-select select-language">
                        <option value="1" selected="selected">English
                        </option>
                        <option value="2">Arabic</option>
                    </select>
                    <div class="input-group-append">
                        <a href="javascript:void(0)" class="btn btn-brand">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icon-translate">
                                </use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="content-body">        
            <div class="add-stock">           
                <div class="add-stock-column column-main">
                    <div class="card" id="basic-details">
                        <div class="card-header">
                            <div class="card-header-label">
                                <h3 class="card-header-title">Basic Details </h3>
                                <span class="text-muted">Add basic details about your product</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                echo HtmlHelper::getFieldHtml($frm, 'product_type', 12, ['onchange' => 'productType(this)']);
                                //echo HtmlHelper::getFieldHtml($frm, 'product_seller_id', 6, ['id' => 'product_seller_id', 'placeholder' => Labels::getLabel('FRM_SELECT_USER', $langId)]);
                                echo HtmlHelper::getFieldHtml($frm, 'product_identifier', 12, [], '','Lorem ipsum dolor sit amet consectetur adipisicing elit');
                                echo HtmlHelper::getFieldHtml($frm, 'product_name', 12, [], '','Lorem ipsum dolor sit amet consectetur adipisicing elit');
                                echo HtmlHelper::getFieldHtml($frm, 'product_brand_id', 6, ['id' => 'product_brand_id'], '', '', ['label' => FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0) ? Labels::getLabel('FRM_REQUEST_FOR_BRAND', $langId) : Labels::getLabel('FRM_ADD_BRAND', $langId), 'attr' => ['href' => 'javascript:void(0)', 'onclick' => 'addBrandReqForm(0)', 'class' => 'link']]);
                                echo HtmlHelper::getFieldHtml($frm, 'ptc_prodcat_id', 6, ['id' => 'ptc_prodcat_id'], '', '', ['label' => FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0) ? Labels::getLabel('FRM_REQUEST_FOR_CATEGORY', $langId): Labels::getLabel('FRM_ADD_CATEGORY', $langId), 'attr' => ['href' => 'javascript:void(0)', 'onclick' => 'addCategoryReqForm(0)', 'class' => 'link']]);
                                echo HtmlHelper::getFieldHtml($frm, 'product_model', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'product_min_selling_price', 6);
                                $fld = $frm->getField('product_warranty');
                                if (null !== $fld) {
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $warrantTypes = Product::getWarrantyUnits($langId);
                                            ?>
                                            <label class="form-label"><?php echo $fld->getCaption(); ?></label>
                                            <div class="input-group">
                                                <?php echo $fld->getHtml(); ?>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-gray dropdown-toggle warrantyTypeButtonJs" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <?php echo $warrantTypes[$frm->getField('product_warranty_unit')->value] ?? current($warrantTypes); ?>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <?php foreach ($warrantTypes as $type => $name) { ?>
                                                            <a class="dropdown-item warrantyTypeJs" href="javascript:void(0)" data-type="<?php echo $type; ?>"><?php echo $name; ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                echo HtmlHelper::getFieldHtml($frm, 'product_youtube_video', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'product_attachements_with_inventory', 6, [], Labels::getLabel('FRM_PRODUCT_DOWNLOAD_ATTACHEMENTS_AT_INVENTORY_LEVEL_INFO', $langId));
                                echo HtmlHelper::getFieldHtml($frm, 'product_description', 12);
                                echo HtmlHelper::getFieldHtml($frm, 'record_id', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'temp_product_id', 6, ['id' => 'temp_product_id']);
                                echo HtmlHelper::getFieldHtml($frm, 'product_warranty_unit', 6, ['id' => 'product_warranty_unit']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card card-toggle" id="variants-options">
                        <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#stock-block1" aria-expanded="false" aria-controls="stock-block1">
                            <div class="card-header-label">
                                <h3 class="card-header-title">Variants and options
                                </h3>
                                <span class="text-muted">Add options like Color, size
                                    etc for your product</span>
                            </div> <i class="dropdown-toggle-custom-arrow"></i>
                        </div>
                        <div class="card-body show" id="stock-block1">
                            <table class="table table-variants" id="variantsJs">
                                <thead>
                                    <tr>
                                        <th><?php echo Labels::getLabel('FRM_OPTIONS', $langId) ?></th>
                                        <th><?php echo Labels::getLabel('FRM_OPTION_VALUES', $langId) ?></th>
                                        <th class="align-right"><?php echo Labels::getLabel('LBL_ACTION_BUTTONS', $langId) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $optionCount = count($productOptions);
                                    for ($i = 0; $i <=  (1 > $optionCount ? 0 : $optionCount - 1); $i++) {
                                        echo getVariantUiTr($langId, $i, ($productOptions[$i] ?? []));
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="separator separator-dashed my-4"></div>
                            <div class="form-group row justify-content-between">
                                <div class="col">
                                    <label class="label">This product has same EAN/UPC code for all variants</label>
                                </div>
                                <div class="col-auto">
                                    <?php
                                    $fld = $frm->getField('upc_type');
                                    HtmlHelper::configureSwitchForRadio($fld);
                                    $fld->addOptionListTagAttribute('class', 'list-radio');
                                    $fld->addFieldTagAttribute('onchange', 'upcType()');
                                    $fld->addFieldTagAttribute('class', 'upc_type');
                                    echo $fld->getHtml();
                                    ?>
                                </div>
                            </div>
                            <div id="variantsListJs"></div>
                        </div>
                    </div>
                    <div class="card card-toggle" id="media">
                        <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#stock-block2" aria-expanded="false" aria-controls="stock-block2">
                            <div class="card-header-label">
                                <h3 class="card-header-title">Media </h3>
                                <span class="text-muted">Attach media files for the product </span>
                            </div>
                            <div class="card-toolbar">
                                <div class="me-5">
                                    <a href="javascript:void(0)" onclick="imageForm();" class="btn btn-outline-secondary btn-sm">Advance Media</a>
                                </div>
                                <i class="dropdown-toggle-custom-arrow"></i>
                            </div>
                        </div>
                        <div class="card-body show" id="stock-block2">
                            <div>
                                <h6 class="h6 mb-3">Uploaded media</h6>
                                <ul class="uploaded-stocks" id="productDefaultImagesJs">
                                    <li class="browse unsortableJs"><button type="button" class="browse-button" onclick="$('#hiddenMediaFrmFileJs').click();">
                                            <strong> Upload Images(s)</strong>
                                            <span class="text-muted form-text">PNG, JPEG, & WEBP Accepted</span></button></li>
                                </ul>
                                <div class="form-text text-muted pt-2">Pay attention to the quality of
                                    pictures
                                    you add, comply with the
                                    background color standards. Notice that the product shows all the
                                    details</div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-toggle" id="specifications">
                        <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#specifications-block" aria-expanded="false" aria-controls="specifications-block">
                            <div class="card-header-label">
                                <h3 class="card-header-title">Specifications
                                </h3>
                                <span class="text-muted">Product Specifications are added in this

                                    <span class="input-helper"></span>section</span>
                            </div> <i class="dropdown-toggle-custom-arrow"></i>
                        </div>
                        <div class="card-body show" id="specifications-block">
                            <div id="specificationsFormJs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">
                                                <?php echo Labels::getLabel('FRM_SPECIFICATION_NAME', $langId); ?>
                                            </label>
                                            <input type="text" name="sp_label" id="sp_label" value="" data-required="1">
                                            <span class="form-text text-muted">Lorem ipsum dolor sit,
                                                amet consectetur adipisicing elit. </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">
                                                <?php echo Labels::getLabel('FRM_SPECIFICATION_VALUE', $langId); ?>
                                            </label>
                                            <input type="text" name="sp_value" id="sp_value" value="" data-required="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label">
                                                <?php echo Labels::getLabel('FRM_SPECIFICATION_GROUP', $langId); ?>
                                            </label>
                                            <input type="text" name="sp_group" id="sp_group" value="" data-required="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="label"></label>
                                            <input type="hidden" name="sp_id" id="sp_id" value="0" data-required="0">
                                            <button type="button" id="btnAddSpecJs" class="btn btn-brand btn-wide" onclick="addSpecification()" data-updateLbl="<?php echo Labels::getLabel('BTN_UPDATE', $langId); ?>" data-addLbl="<?php echo Labels::getLabel('BTN_ADD', $langId); ?>">
                                                <?php echo Labels::getLabel('BTN_ADD', $langId); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="specificationsListSeprJs" class="separator separator-dashed my-4 hide"></div>
                            <div id="specificationsListJs">
                            </div>
                        </div>
                    </div>
                    <div class="card card-toggle" id="tax-shipping">
                        <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#stock-block4" aria-expanded="false" aria-controls="stock-block4">
                            <div class="card-header-label">
                                <h3 class="card-header-title">Tax and Shipping
                                </h3>
                                <span class="text-muted">Add Tax and Shipping details from
                                    this
                                    <span class="input-helper"></span>section</span>
                            </div> <i class="dropdown-toggle-custom-arrow"></i>
                        </div>
                        <div class="card-body show" id="stock-block4">
                            <div class="row">
                                <?php
                                echo HtmlHelper::getFieldHtml($frm, 'ptt_taxcat_id', 12, ['id' => 'ptt_taxcat_id']);
                                echo HtmlHelper::getFieldHtml($frm, 'product_fulfillment_type', 6, ['id' => 'product_fulfillment_type']);
                                echo HtmlHelper::getFieldHtml($frm, 'product_ship_package', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'product_weight', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'product_weight_unit', 6);
                                echo HtmlHelper::getFieldHtml($frm, 'ps_from_country_id', 6, ['id' => 'ps_from_country_id']);
                                echo HtmlHelper::getFieldHtml($frm, 'shipping_profile', 6, ['id' => 'shipping_profile']);
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($displayDigitalDownloadList) { ?>
                        <div class="card card-toggle" id="digital-files">
                            <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#digital-files-block" aria-expanded="false" aria-controls="stock-block2">
                                <div class="card-header-label">
                                    <h3 class="card-header-title">Digital Files</h3>
                                    <span class="text-muted">Digital Files are added in this section </span>
                                </div>
                                <?php if ($displayDigitalDownloadAddBtn) { ?>
                                    <div class="card-toolbar">
                                        <div class="me-5">
                                            <a href="javascript:void(0)" onclick="digitalDownloadsForm(<?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>);" class="btn btn-outline-secondary btn-sm">Digital Files</a>
                                        </div>
                                        <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-body show" id="digital-files-block">
                                <div id="digitalFilesDefaultListJs">
                                </div>
                            </div>
                        </div>
                        <div class="card card-toggle" id="digital-links">
                            <div class="card-header dropdown-toggle-custom show" data-bs-toggle="collapse" data-bs-target="#digital-links-block" aria-expanded="false" aria-controls="stock-block2">
                                <div class="card-header-label">
                                    <h3 class="card-header-title">Digital Links</h3>
                                    <span class="text-muted">Digital Links are added in this section </span>
                                </div>
                                <?php if ($displayDigitalDownloadAddBtn) { ?>
                                    <div class="card-toolbar">
                                        <div class="me-5">
                                            <a href="javascript:void(0)" onclick="digitalDownloadsForm(<?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>);" class="btn btn-outline-secondary btn-sm">Digital Links</a>
                                        </div>
                                        <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-body show" id="digital-links-block">
                                <div id="digitalLinksDefaultListJs">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="add-stock-column column-actions">
                    <div class="sticky-top">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-brand btn-block"><?php echo Labels::getLabel('FRM_SAVE', $langId); ?></button>
                                <div class="mt-3">
                                    <?php
                                    $fld = $frm->getField('product_active');
                                    if (null !=  $fld) {
                                        HtmlHelper::configureSwitchForCheckbox($fld);
                                        echo '<div class="form-group"><div class="setting-block">' . $fld->getHtml() . '</div></div>';
                                    }
                                    $fld = $frm->getField('product_approved');
                                    $uLangDatafld = $frm->getField('auto_update_other_langs_data');

                                    if (null !=  $fld) {
                                        HtmlHelper::configureSwitchForCheckbox($fld);
                                        echo null ==  $uLangDatafld ? '<div class="setting-block">' . $fld->getHtml() . '</div>' : '<div class="form-group"><div class="setting-block">' . $fld->getHtml() . '</div></div>';
                                    }

                                    if (null !=  $uLangDatafld) {
                                        HtmlHelper::configureSwitchForCheckbox($uLangDatafld);
                                        echo '<div class="setting-block">' . $uLangDatafld->getHtml() . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-featured">
                                    <?php
                                    $fld = $frm->getField('product_featured');
                                    $codFld = $frm->getField('product_cod_enabled');
                                    if (null !=  $fld) {
                                        HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel('FRM_MARK_THIS_PRODUCT_AS_FEATURED_INFO', $langId));
                                        echo null !=  $fld && $codEnabled ? '<li><div class="form-group"><div class="setting-block">' . $fld->getHtml() . '</div></div></li>' : '<li><div class="setting-block">' . $fld->getHtml() . '</div></li>';
                                    }

                                    if (null !=  $codFld && $codEnabled) {
                                        HtmlHelper::configureSwitchForCheckbox($codFld, Labels::getLabel('FRM_PRODUCT_COD_INFO', $langId));
                                        echo '<li><div class="setting-block">' . $codFld->getHtml() . '</div></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        $fld = $frm->getField('product_tags');
                        if (null != $fld) {
                            $fld->addFieldTagAttribute('class', 'form-tagify');
                            $fld->addFieldTagAttribute('id', 'product_tags');
                        ?>
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-label">
                                        <h3 class="card-header-title">Tags</h3>
                                        <span class="text-muted">
                                            <?php echo Labels::getLabel('FRM_PRODUCT_TAG_INFO', $langId); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php echo $fld->getHtml(); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>      
        </div>
        </form>
    </div>
    <table  id="variantCloneJs" class="hidden">
        <?php echo getVariantUiTr($langId, -1);  ?>
    </table>
    <?php echo $frm->getExternalJS();
    $imgFrm->setFormTagAttribute('class', 'hidden');
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

        $(function() {
            prodSpecifications();
            tagifyProducts();
            productDefaultImages();
            var langId = getCurrentFrmLangId();
            select2('product_brand_id', fcom.makeUrl('Brands', 'autoComplete',[],siteConstants.webrootfront), {
                brand_active: 1,
                langId: langId
            });
            select2('ptc_prodcat_id', fcom.makeUrl('Products', 'linksAutocomplete',[],siteConstants.webrootfront), {
                langId
            });
            
            select2('ptt_taxcat_id', fcom.makeUrl('products', 'autoCompleteTaxCategories', [], siteConstants.webrootfront), {
                langId
            });
            select2('ps_from_country_id', fcom.makeUrl('Seller', 'countries_autocomplete',[]), {
                langId
            });

            $('#addProductfrm .optionsJs').each(function(index) {               
                var selectedOptionData = [];
                if (index in productOptions) {
                    selectedOptionData = [{
                        selected: true,
                        id: productOptions[index]['option_id'],
                        text: productOptions[index]['option_name'],
                        option_is_separate_images: productOptions[index]['option_is_separate_images'],
                    }]
                }
                select2($(this).attr('id'), fcom.makeUrl('seller', 'autoCompleteOptions'), optionDataCallback,
                    resetOptionValuesTag,
                    resetOptionValuesTag,
                    '',
                    selectedOptionData
                );                
            });


            $('#addProductfrm .optionValuesJs').each(function(index) {
                tagifyOptionValue("#" + $(this).attr('id'));
            });
           
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
    $deleteClass = $i == 0 ? 'hidden' : '';
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
