<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $rfqData['rfq_number']; ?>
    </h5>
</div>
<div class="modal-body form-edit layoutsJs">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item list-stats-item-full">
                <span class="label"><?php echo Labels::getLabel('LBL_PRODUCT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $rfqData['rfq_title']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_REQUESTED_QUANTITY', $siteLangId); ?>:</span>
                <span class="value"><?php echo $rfqData['rfq_quantity'] . ' ' . applicationConstants::getWeightUnitName($siteLangId, $rfqData['rfq_quantity_unit'], true); ?></span>
            </li>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_DELIVERY_DATE', $siteLangId); ?>:</span>
                <span class="value"><?php echo  FatDate::format($rfqData['rfq_delivery_date']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_PROCESSING_STATUS', $siteLangId); ?>:</span>
                <span class="value"><?php echo '<span class="' . RequestForQuote::getBadgeClass($rfqData['rfq_status']) . '">' . $statusArr[$rfqData['rfq_status']] . '</span>'; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_ACCEPTANCE_STATUS', $siteLangId); ?>:</span>
                <span class="value"><?php echo '<span class="' . RequestForQuote::getBadgeClass($rfqData['rfq_approved']) . '">' . $approvalStatusArr[$rfqData['rfq_approved']] . '</span>'; ?></span>
            </li>

            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_REQUESTED_ON', $siteLangId); ?>:</span>
                <span class="value"><?php echo  FatDate::format($rfqData['rfq_added_on']); ?></span>
            </li>
            <li class="list-stats-item list-stats-item-full">
                <span class="label"><?php echo Labels::getLabel('LBL_COMMENT', $siteLangId); ?>:</span>
                <span class="value">
                    <span class="lessContentJs">
                        <?php echo 200 < strlen($rfqData['rfq_description']) ? substr($rfqData['rfq_description'], 0, 200) . ' ... <button class="link-underline showMoreJs">' . Labels::getLabel('LBL_SHOW_MORE') . '</button>' : $rfqData['rfq_description']; ?>
                    </span>
                    <span class="moreContentJs" style="display:none">
                        <?php echo $rfqData['rfq_description'] . ' <button class="link-underline showLessJs">' . Labels::getLabel('LBL_SHOW_LESS') . '</button>'; ?>
                    </span>
                </span>
            </li>
            <?php $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId);
            if (!empty($res) && 0 < $res['afile_id']) { ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class="label"><?php echo Labels::getLabel('LBL_ATTACHMENT', $siteLangId); ?>:</span>
                    <span class="value">
                        <a class="link-underline text-wrap" target="blank" title="<?php echo Labels::getLabel('LBL_DOWNLOAD_FILE', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('RequestForQuotes', 'downloadFile', array($recordId)); ?>">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/sprite.svg#icon-download"></use>
                            </svg>
                            <?php echo $res['afile_name']; ?>
                        </a>
                    </span>
                </li>
            <?php } ?>
            <li class="list-stats-item list-stats-item-full">
                <span class="label"><?php echo Labels::getLabel('LBL_DELIVERY_ADDRESS', $siteLangId); ?>:</span>
                <?php if (!empty($rfqData)) { ?>
                    <span class="value">
                        <strong><?php echo !empty($rfqData['addr_name']) ? $rfqData['addr_name'] . ',' : ''; ?></strong>
                        <?php echo !empty($rfqData['addr_address1']) ? $rfqData['addr_address1'] . ',' : ''; ?>
                        <?php echo !empty($rfqData['addr_address2']) ? $rfqData['addr_address2'] . ',' : ''; ?>
                        <?php echo !empty($rfqData['addr_city']) ? $rfqData['addr_city'] . ',' : ''; ?>
                        <?php echo !empty($rfqData['state_name']) ? $rfqData['state_name'] . ',' : ''; ?>
                        <?php echo !empty($rfqData['country_name']) ? $rfqData['country_name'] . ',' : ''; ?>
                        <?php echo !empty($rfqData['addr_zip']) ? Labels::getLabel('LBL_Zip:', $siteLangId) . $rfqData['addr_zip'] . ',' : ''; ?>
                        <?php $dcode = !empty($rfqData['addr_phone_dcode']) ? ValidateElement::formatDialCode($rfqData['addr_phone_dcode']) : ''; ?>
                        <?php echo !empty($rfqData['addr_phone']) ? Labels::getLabel('LBL_Phone:', $siteLangId) . $dcode . $rfqData['addr_phone'] . ',' : ''; ?>
                    </span>
                <?php } ?>
            </li>
        </ul>
    </div>
</div>