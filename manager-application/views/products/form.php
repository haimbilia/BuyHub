<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frm->setFormTagAttribute('class', 'form');

?>

<main class="main mainJs">
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false);
        $frm->setFormTagAttribute('id', 'addProductfrm');      
        $frm->setFormTagAttribute('onsubmit', 'setup($(\'#addProductfrm\'));return false;');
        echo $frm->getFormTag(); ?>
        <div class="add-stock">
            <div class="add-stock-column column-nav">
                <div class="sticky-top">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="stock-nav">
                                <ul>
                                    <li class="stock-nav-item is-active">
                                        <a class="stock-nav-link" href="#basic-details">
                                            <i class="stock-nav-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="">
                                                <h6 class="stock-nav-title">
                                                    Basic details</h6>
                                                <span class="stock-nav-desc"> Add general details about
                                                    the
                                                    product
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="stock-nav-item">
                                        <a class="stock-nav-link" href="#variants-options">
                                            <i class="stock-nav-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="">
                                                <h6 class="stock-nav-title">
                                                    Variants and options</h6>
                                                <span class="stock-nav-desc"> Add options like Color,
                                                    size
                                                    etc for your product</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="stock-nav-item">
                                        <a class="stock-nav-link" href="#media">
                                            <i class="stock-nav-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="">
                                                <h6 class="stock-nav-title">
                                                    Media</h6>
                                                <span class="stock-nav-desc"> Attach media files for the
                                                    product </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="stock-nav-item">
                                        <a class="stock-nav-link" href="#specifications">
                                            <i class="stock-nav-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="">
                                                <h6 class="stock-nav-title">
                                                    Specifications</h6>
                                                <span class="stock-nav-desc"> Product Specifications are
                                                    added in this section </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="stock-nav-item">
                                        <a class="stock-nav-link" href="#tax-shipping">
                                            <i class="stock-nav-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="">
                                                <h6 class="stock-nav-title">
                                                    Tax and Shipping</h6>
                                                <span class="stock-nav-desc"> Add Tax and Shipping
                                                    details
                                                    from this section </span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="add-stock-column column-main">
                <div class="add-stock-column-head">
                    <div class="add-stock-column-head-label">
                        <h2 class="h2">Add Product</h2>
                        <span class="text-muted"> <span class="required"></span> required
                            information</span>
                    </div>

                    <?php 
                    $fld =  $frm->getField('lang_id');                    
                    if(null != $fld ){
                        $fld->setfieldTagAttribute('class','form-control form-select select-language');                        
                    ?> 
                    <div class="add-stock-column-head-action">
                        <div class="input-group">
                            <?php 
                                echo $fld->getHtml(); 
                                $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');                             
                                if (!empty($translatorSubscriptionKey) && $siteLangId != CommonHelper::getDefaultFormLangId()) {
                                    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
                                    $langFld->htmlAfterField = '<div class="input-group-append">
                                                                    <a href="javascript:void(0);" onclick="editLangData(' . $recordId . ', ' . $lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </div>';
                                }                               
                            ?>
                        </div>
                    </div>
                    <?php } ?>

                </div>

                <div class="card" id="basic-details">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Basic Details </h3>
                            <span class="text-muted">Add basic details about your product</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            echo HtmlHelper::getFieldHtml($frm, 'product_type', 12);
                            echo HtmlHelper::getFieldHtml($frm, 'product_identifier', 12, [], 'Lorem ipsum dolor sit amet consectetur adipisicing elit');
                            echo HtmlHelper::getFieldHtml($frm, 'product_name', 12, [], 'Lorem ipsum dolor sit amet consectetur adipisicing elit');
                            echo HtmlHelper::getFieldHtml($frm, 'product_brand_id', 6, ['id' => 'product_brand_id'], '', ['label' => Labels::getLabel('FRM_ADD_BRAND', $siteLangId), 'attr' => ['href' => 'javascript:void(0)', 'onclick' => 'addBrand()', 'class' => 'link']]);
                            echo HtmlHelper::getFieldHtml($frm, 'ptc_prodcat_id', 6, ['id' => 'ptc_prodcat_id'], '', ['label' => Labels::getLabel('FRM_ADD_CATEGORY', $siteLangId), 'attr' => ['href' => 'javascript:void(0)', 'onclick' => 'addCategory()', 'class' => 'link']]);
                            echo HtmlHelper::getFieldHtml($frm, 'product_model', 6);
                            echo HtmlHelper::getFieldHtml($frm, 'product_min_selling_price', 6);                            
                            $fld = $frm->getField('product_warranty');
                            if (null !== $fld) {
                            ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php
                                        $warrantTypes = Product::getWarrantyUnits($siteLangId);
                                        ?>
                                        <label class="label"><?php echo $fld->getCaption(); ?></label>
                                        <div class="input-group">
                                            <?php echo $fld->getHtml(); ?>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-gray dropdown-toggle warrantyTypeButtonJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
                            echo HtmlHelper::getFieldHtml($frm, 'product_description', 12);
                            echo $frm->getFieldHtml('product_id');
                            $frm->getField('product_warranty_unit')->setfieldTagAttribute('id', 'product_warranty_unit');
                            echo $frm->getFieldHtml('product_warranty_unit');
                            ?>
                        </div>
                    </div>

                </div>
                <div class="card" id="variants-options">
                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse" data-target="#stock-block1" aria-expanded="false" aria-controls="stock-block1">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Variants and options
                            </h3>
                            <span class="text-muted">Add options like Color, size
                                etc for your product</span>
                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                    </div>
                    <div class="card-body show" id="stock-block1">


                        <div class="form-group row justify-content-between">
                            <div class="col">
                                <label class="label">This product has multiple options,
                                    like different sizes or colors</label>
                            </div>
                            <div class="col-auto">
                                <ul class="list-radio">
                                    <li>
                                        <label class="radio"><input type="radio" checked="checked" name="radio7" value="1">
                                            Yes
                                        </label>
                                    </li>
                                    <li>

                                        <label class="radio"><input type="radio" name="radio7" value="0">
                                            No
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <table class="table table-variants">
                            <tbody>
                                <tr>

                                    <td width="25%"><select name="optionsSelect" class="form-control">
                                            <option disabled="disabled" value="">
                                                Select Option</option>
                                            <option value="1">Color</option>
                                            <option value="2">Size</option>
                                            <option value="3">Carat</option>
                                            <option value="4">Clarity</option>
                                            <option value="5">Strap</option>
                                        </select></td>
                                    <td> <input class=" form-tagify" name='tags' value='Red, Green, Blue' autofocus>
                                    </td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>

                                    </td>
                                </tr>
                                <tr>

                                    <td><select name="optionsSelect" class="form-control">
                                            <option value="">
                                                Size</option>
                                            <option value="1">Color</option>
                                            <option value="2">Size</option>
                                            <option value="3">Carat</option>
                                            <option value="4">Clarity</option>
                                            <option value="5">Strap</option>
                                        </select></td>
                                    <td> <input class="form-tagify" name='tags' value='Small, , Medium, Large, XL, XXL' autofocus>
                                    </td>
                                    <td class="align-right">
                                        <ul class="actions">



                                            <li>
                                                <a href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>

                                    </td>
                                </tr>
                                <tr>

                                    <td><select name="optionsSelect" class="form-control">
                                            <option value="">
                                                Select Option</option>
                                            <option value="1">Color</option>
                                            <option value="2">Size</option>
                                            <option value="3">Carat</option>
                                            <option value="4">Clarity</option>
                                            <option value="5">Strap</option>
                                        </select></td>
                                    <td> <input class=" form-tagify" name='tags' value='Lorem, Lorem2, Lorem5' autofocus>
                                    </td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="separator separator-dashed my-4"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Variant</th>
                                    <th>EAN/UPC code</th>
                                    <th class="align-right">
                                        <a class="link disabled" disabled="disabled">Undo</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Red / Small </td>
                                    <td><input class="form-control" type="text" placeholder=""></td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a title="Copy to all" href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Red / Small </td>
                                    <td><input class="form-control" type="text" placeholder=""></td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a title="Copy to all" href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Red / Small </td>
                                    <td><input class="form-control" type="text" placeholder=""></td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a title="Copy to all" href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Red / Small </td>
                                    <td><input class="form-control" type="text" placeholder=""></td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a title="Copy to all" href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Red / Small </td>
                                    <td><input class="form-control" type="text" placeholder=""></td>
                                    <td class="align-right">
                                        <ul class="actions">
                                            <li>
                                                <a title="Copy to all" href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="separator separator-dashed my-4"></div>

                        <div class="form-group mb-0">
                            <label class="label">Select Default Product Variant</label>
                            <select name="default" data-vv-as="Default" data-vv-validate-on="none" class="form-control" aria-required="true" aria-invalid="false">
                                <option disabled="disabled" value="">Select
                                </option>
                                <option value="0"><span>red / small</span></option>
                                <option value="1"><span>red / medium</span></option>
                                <option value="2"><span>red / large</span></option>
                                <option value="3"><span>green / small</span></option>
                                <option value="4"><span>green / medium</span></option>
                                <option value="5"><span>green / large</span></option>
                                <option value="6"><span>blue / small</span></option>
                                <option value="7"><span>blue / medium</span></option>
                                <option value="8"><span>blue / large</span></option>
                            </select>


                        </div>


                    </div>





                </div>
                <div class="card" id="media">
                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse" data-target="#stock-block2" aria-expanded="false" aria-controls="stock-block2">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Media
                            </h3>
                            <span class="text-muted">Attach media files for the product </span>
                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                    </div>
                    <div class="card-body show" id="stock-block2">
                        <div class="dropzone dropzone-custom">
                            <div class="dropzone-upload">
                                <div class="file-upload">
                                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                </div>
                                <div class="needsclick">
                                    <h3 class="dropzone-msg-title">click here to upload</h3>
                                </div>
                            </div>
                            <input class="dropzone-input" type="file">
                        </div>

                        <span class="form-text text-muted  pt-2"> File type must be a .jpg, .gif or .png
                            smaller than 2MB and at least
                            800x800 in 1:1 aspect ratio</span>

                        <div class="mt-5">
                            <h6 class="h6 mb-3">Uploaded media</h6>
                            <ul class="uploaded-stocks">
                                <li>
                                    <div class="uploaded-stocks-item" data-ratio="1:1">
                                        <img data-toggle="tooltip" data-placement="top" title="product-1.jpg" class="uploaded-stocks-img" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg">
                                        <div class="uploaded-stocks-actions">
                                            <ul class="actions">
                                                <li>
                                                    <a href="#" title="Edit">

                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="uploaded-stocks-item" data-ratio="1:1">
                                        <img data-toggle="tooltip" data-placement="top" title="product-1.jpg" class="uploaded-stocks-img" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg">
                                        <div class="uploaded-stocks-actions">
                                            <ul class="actions">
                                                <li>
                                                    <a href="#" title="Edit">

                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="uploaded-stocks-item" data-ratio="1:1">
                                        <img data-toggle="tooltip" data-placement="top" title="product-1.jpg" class="uploaded-stocks-img" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product5.jpg">
                                        <div class="uploaded-stocks-actions">
                                            <ul class="actions">
                                                <li>
                                                    <a href="#" title="Edit">

                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="uploaded-stocks-item" data-ratio="1:1">
                                        <img data-toggle="tooltip" data-placement="top" title="product-1.jpg" class="uploaded-stocks-img" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg">
                                        <div class="uploaded-stocks-actions">
                                            <ul class="actions">
                                                <li>
                                                    <a href="#" title="Edit">

                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="uploaded-stocks-item" data-ratio="1:1">
                                        <img data-toggle="tooltip" data-placement="top" title="product-1.jpg" class="uploaded-stocks-img" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg">
                                        <div class="uploaded-stocks-actions">
                                            <ul class="actions">
                                                <li>
                                                    <a href="#" title="Edit">

                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <span class="form-text text-muted pt-2">Pay attention to the quality of
                                pictures
                                you add, comply with the
                                background color standards. Notice that the product shows all the
                                details</span>
                        </div>
                    </div>
                </div>
                <div class="card" id="specifications">
                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse" data-target="#specifications-block" aria-expanded="false" aria-controls="specifications-block">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Specifications
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
                                            <?php echo Labels::getLabel('FRM_SPECIFICATION_NAME', $siteLangId); ?>
                                        </label>
                                        <input type="text" name="sp_label"  id="sp_label"value="" data-required="1" >
                                        <span class="form-text text-muted">Lorem ipsum dolor sit,
                                            amet consectetur adipisicing elit. </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label"> 
                                            <?php echo Labels::getLabel('FRM_SPECIFICATION_VALUE', $siteLangId); ?>
                                        </label>
                                        <input type="text" name="sp_value" id="sp_value" value="" data-required ="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">
                                            <?php echo Labels::getLabel('FRM_SPECIFICATION_GROUP', $siteLangId); ?>
                                        </label>                                   
                                        <input type="text" name="sp_group" id="sp_group" value="" data-required ="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label"></label> 
                                        <input type="hidden" name="sp_id" id="sp_id" value="0" data-required ="0">
                                        <button type="button" class="btn btn-brand btn-wide" onclick="addSpecification()">
                                            <?php echo Labels::getLabel('BTN_ADD', $siteLangId); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-4"></div>
                        <div id="specificationsListJs">
                        </div>                        
                    </div>
                </div>
                <div class="card" id="tax-shipping">
                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse" data-target="#stock-block4" aria-expanded="false" aria-controls="stock-block4">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Tax and Shipping
                            </h3>
                            <span class="text-muted">Add Tax and Shipping details from
                                this
                                <span class="input-helper"></span>section</span>
                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                    </div>
                    <div class="card-body show" id="stock-block4">
                        <div class="row">
                        <?php 
                            echo HtmlHelper::getFieldHtml($frm, 'ptt_taxcat_id', 12, ['id' => 'ptt_taxcat_id'], '', ['label' => Labels::getLabel('FRM_ADD_TAX_CATEGORY', $siteLangId), 'attr' => ['href' => 'javascript:void(0)', 'onclick' => 'addTaxCategory()', 'class' => 'link']]);      
                            echo HtmlHelper::getFieldHtml($frm, 'product_fulfillment_type', 6); 
                            echo HtmlHelper::getFieldHtml($frm, 'ps_from_country_id', 6,['id' => 'ps_from_country_id']);      
                            echo HtmlHelper::getFieldHtml($frm, 'product_ship_package', 6);
                            echo HtmlHelper::getFieldHtml($frm, 'product_weight_unit', 6);
                            echo HtmlHelper::getFieldHtml($frm, 'product_weight', 6);    
                            echo HtmlHelper::getFieldHtml($frm, 'shipping_profile', 6);         
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-stock-column column-actions">
                <div class="sticky-top">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-brand btn-block"><?php echo Labels::getLabel('FRM_SAVE', $siteLangId); ?></button>                           
                            <div class="mt-3">
                                <?php 
                                    $fld = $frm->getField('product_active');                                      
                                    HtmlHelper::configureSwitchForCheckbox($fld);
                                    if(null !=  $fld){ 
                                        echo $fld->getHtml();              
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
                                if(null !=  $fld){                                         
                                    $caption =  $fld->getCaption();   
                                    $fld->changeCaption('');                   
                                ?>                            
                                <li>                                    
                                    <label class="checkbox">
                                    <?php echo$fld->getHtml(); ?>
                                        <span>
                                            <strong><?php echo $caption;?></strong>
                                            <span class="text-muted">
                                                <?php echo Labels::getLabel('FRM_MARK_THIS_PRODUCT_AS_FEATURED_INFO', $siteLangId); ?>                                               
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <?php } ?>
                                <?php 
                                    $fld = $frm->getField('product_cod_enabled');
                                    if(null !=  $fld){     
                                        if(!$codEnabled){
                                            $fld->addFieldTagAttribute('disabled', 'disabled');
                                        }  
                                        $caption =  $fld->getCaption();   
                                        $fld->changeCaption('');                                   
                                ?>
                                <li>
                                    <label class="checkbox">
                                        <?php echo $fld->getHtml(); ?>
                                        <span>
                                            <strong><?php echo $caption; ?></strong>
                                            <?php if(!$codEnabled){ ?>                                      
                                            <div class="alert alert-solid-brand mt-4" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i>
                                                </div>
                                                <div class="alert-text text-xs">
                                                     <?php echo Labels::getLabel('MSG_DISCLAIMER', $siteLangId);?>: <?php echo Labels::getLabel('MSG_COD_OPTION_IS_DISABLED_IN_PAYMENT_GATEWAY_SETTINGS', $siteLangId);?>
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <span class="text-muted">
                                                <?php echo Labels::getLabel('FRM_PRODUCT_COD_INFO', $siteLangId); ?>                                               
                                            </span>
                                            <?php  } ?>
                                        </span>
                                    </label>
                                </li>
                                <?php } ?>                              
                            </ul>
                        </div>
                    </div>
                    <?php 
                    $fld = $frm->getField('product_tags');
                    if(null != $fld){
                        $fld->addFieldTagAttribute('class', 'form-tagify');
                        $fld->addFieldTagAttribute('id', 'product_tags');                        
                    ?>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">Tags</h3>
                                <span class="text-muted">
                                    <?php echo Labels::getLabel('FRM_PRODUCT_TAG_INFO', $siteLangId); ?> 
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
        </form>
    </div>
</main>
<?php echo $frm->getExternalJS(); ?>
<script>  
    var canEditTags = <?php echo $canEditTags ? 1 : 0;?>;
    var tagsEditErr = '<?php echo Labels::getLabel('ERR_NOT_AUTHORIZED_TO_ADD_TAGS', $siteLangId); ?>'; 
    $(function() {
        prodSpecifications();
    });
  
</script>