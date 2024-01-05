<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$tourStep = ($tourStep ?? 0);
$actionItemsData = $actionItemsData + [
    'canEdit' => ($canEdit ?? false),
    'tourStep' => ($tourStep ?? 0)
];

$fld = $frmSearch->getField('offer_user_id');
$fld->setFieldTagAttribute('id', 'rfqSellersJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL'));
$autoTableColumWidth = FatUtility::int(($autoTableColumWidth ?? 1)); ?>
<main class="main">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . $actionItemsData['searchFrmTemplate']); ?>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="rfq-product">
                            <div class="plain-card">
                                <div class="plain-card-head">
                                    <div class="plain-card-media">
                                        <?php $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($rfqData['rfq_product_id'], ImageDimension::VIEW_MEDIUM, $selProdId, 0), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                                        <img class="plain-card-img" src="<?php echo $mainImgUrl; ?>" alt="">
                                    </div>
                                </div>
                                <div class="plain-card-body">
                                    <h2 class="plain-card-title"><?php echo $rfqData['rfq_title'] . '<br> ( ' . $rfqData['rfq_number'] . ' )'; ?></h2>
                                    <?php if (!empty($rfqData['sellerProdOptions'])) { ?>
                                        <ul class="list-stats list-stats-popover">
                                            <?php foreach ($rfqData['sellerProdOptions'] as $option) { ?>
                                                <li class="list-stats-item">
                                                    <span class="label"><?php echo $option['option_name']; ?></span>
                                                    <span class="value"><?php echo $option['optionvalue_name']; ?></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="rfq-product-body">
                                <div class="rfq-info">
                                    <h5 class="h5 dropdown-toggle-custom collapsed" data-bs-toggle="collapse" data-bs-target="#rfq-info-block" aria-expanded="false" aria-controls="rfq-info-block">
                                        <?php echo Labels::getLabel('LBL_RFQ_INFO', $siteLangId); ?> <i class="dropdown-toggle-custom-arrow"></i>
                                    </h5>
                                    <div class="collapse" id="rfq-info-block">
                                        <ul class="list-stats list-stats-popover">
                                            <li class="list-stats-item">
                                                <span class="lable"><?php echo Labels::getLabel('LBL_QTY', $siteLangId); ?></span>
                                                <span class="value"><?php echo $rfqData['rfq_quantity'] . ' ' . applicationConstants::getWeightUnitName($siteLangId, $rfqData['rfq_quantity_unit'], true); ?></span>
                                            </li>
                                            <?php if (!empty($rfqData['rfq_delivery_date']) && 0 < strtotime($rfqData['rfq_delivery_date'])) { ?>
                                                <li class="list-stats-item highlighted">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_EXPECTED_DELIVERY_DATE', $siteLangId); ?></span>
                                                    <span class="value"><?php echo FatDate::format($rfqData['rfq_delivery_date']); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($rfqData['user_name'])) { ?>
                                                <li class="list-stats-item">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_Customer_Name', $siteLangId); ?></span>
                                                    <span class="value"><?php echo $rfqData['user_name']; ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($rfqData['credential_email'])) { ?>
                                                <li class="list-stats-item">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_EMAIL', $siteLangId); ?></span>
                                                    <span class="value"><?php echo $rfqData['credential_email']; ?></span>
                                                </li> <?php } ?>
                                            <?php if (!empty($rfqData['addr_phone'])) { ?>
                                                <li class="list-stats-item">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?></span>
                                                    <span class="value"><?php echo ValidateElement::formatDialCode($rfqData['addr_phone_dcode']) . $rfqData['addr_phone']; ?></span>
                                                </li>
                                            <?php } ?>
                                            <li class="list-stats-item">
                                                <span class="label"><?php echo Labels::getLabel('LBL_CONTACT_NAME', $siteLangId); ?></span>
                                                <span class="value"><?php echo $rfqData['addr_name']; ?></span>
                                            </li>
                                            <?php if (!empty($rfqData['addr_name'])) { ?>
                                                <li class="list-stats-item list-stats-item-full">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_DELIVERY_ADDRESS', $siteLangId); ?>:</span>
                                                    <span class="value">
                                                        <strong><?php echo $rfqData['addr_name']; ?></strong>,
                                                        <?php echo $rfqData['addr_address1']; ?>,
                                                        <?php echo (strlen($rfqData['addr_address2']) > 0) ? $rfqData['addr_address2'] . ',' : ''; ?>
                                                        <?php echo (strlen($rfqData['addr_city']) > 0) ? $rfqData['addr_city'] . ',' : ''; ?>
                                                        <?php echo (strlen($rfqData['state_name']) > 0) ? $rfqData['state_name'] . ',' : ''; ?>
                                                        <?php echo (strlen($rfqData['country_name']) > 0) ? $rfqData['country_name'] . ',' : ''; ?>
                                                        <?php echo (strlen($rfqData['addr_zip']) > 0) ? Labels::getLabel('LBL_Zip:', $siteLangId) . $rfqData['addr_zip'] . ',' : ''; ?>
                                                        <?php $dcode = (strlen($rfqData['addr_phone_dcode']) > 0) ? ValidateElement::formatDialCode($rfqData['addr_phone_dcode']) : ''; ?>
                                                        <?php echo (strlen($rfqData['addr_phone']) > 0) ? Labels::getLabel('LBL_Phone:', $siteLangId) . $dcode . $rfqData['addr_phone'] . ',' : ''; ?> </span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($rfqData['rfq_description'])) { ?>
                                                <li class="list-stats-item list-stats-item-full">
                                                    <span class="lable"><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>:</span>
                                                    <span class="value">
                                                        <span class="lessContent<?php echo $rfqData['rfq_id']; ?>Js">
                                                            <?php echo 500 < strlen($rfqData['rfq_description']) ? substr($rfqData['rfq_description'], 0, 500) . ' ... <button class="link-underline showMoreJs" data-row-id="' . $rfqData['rfq_id'] . '">' . Labels::getLabel('LBL_SHOW_MORE') . '</button>' : $rfqData['rfq_description']; ?>

                                                        </span>
                                                        <span class="moreContent<?php echo $rfqData['rfq_id']; ?>Js" style="display:none">
                                                            <?php echo $rfqData['rfq_description'] . ' <button class="link-underline showLessJs" data-row-id="' . $rfqData['rfq_id'] . '">' . Labels::getLabel('LBL_SHOW_LESS') . '</button>'; ?> </span>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <?php
                        $tableId = "listingTableJs";
                        require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                        require_once(CONF_THEME_PATH . $actionItemsData['searchListingPage']);
                        require_once('listing-foot.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>