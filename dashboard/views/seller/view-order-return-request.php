<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<?php
$returnRequestMsgsForm->addHiddenField('', 'isSeller', 1);
$btn = $frmMsg->getField('btn_submit');
if (null != $btn) {
    $btn->addFieldTagAttribute('class', 'btn btn-brand');
}
?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_View_Order_Return_Request', $siteLangId) . ': <span class="number">' . $request['orrequest_reference'] . '</span>',
        'siteLangId' => $siteLangId,
        'headingBackButton' => [
            'href' => UrlHelper::generateUrl('Seller', 'orderReturnRequests'),
            'onclick' => ''
        ]
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-head">
                <h5 class="card-title"><?php echo Labels::getLabel('LBL_Request_Details', $siteLangId); ?></h5>
                <?php if ($canEdit) { ?>
                    <div class="btn-group">
                        <?php if ($canEscalateRequest) { ?>
                            <a class="btn btn-outline-gray btn-sm" onclick="javascript: return confirm('<?php echo Labels::getLabel('MSG_Do_you_want_to_proceed?', $siteLangId); ?>')" href="<?php echo UrlHelper::generateUrl('Account', 'EscalateOrderReturnRequest', array($request['orrequest_id'])); ?>"><?php echo str_replace("{websitename}", FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId), Labels::getLabel('LBL_Escalate_to_{websitename}', $siteLangId)); ?></a>
                        <?php } ?>
                        <?php if ($canApproveReturnRequest) { ?>
                            <a class="btn btn-outline-gray btn-sm" onclick="javascript: return confirm('<?php echo Labels::getLabel('MSG_Do_you_want_to_proceed?', $siteLangId); ?>')" href="<?php echo UrlHelper::generateUrl('Seller', 'approveOrderReturnRequest', array($request['orrequest_id'])); ?>"><?php echo Labels::getLabel('LBL_Approve_Refund', $siteLangId); ?></a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-6">
                        <h5><?php echo Labels::getLabel('LBL_VENDOR_RETURN_ADDRESS', $siteLangId); ?></h5>
                        <div class="row">
                            <div class="col-lg-12 my-4">
                                <ul class="list-stats list-stats-double">
                                    <?php if ($request['op_shop_owner_name'] != '') { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_VENDOR_NAME', $siteLangId); ?></span>
                                            <span class="value"><?php echo $request['op_shop_owner_name']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if ($request['op_shop_name'] != '') { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_SHOP_NAME', $siteLangId); ?></span>
                                            <span class="value"><?php echo $request['op_shop_name']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_name']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_NAME', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['ura_name']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_address_line_1']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_LINE_1', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['ura_address_line_1']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_address_line_2']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_LINE_2', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['ura_address_line_2']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_city']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_CITY', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['ura_city']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['state_name']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_STATE_NAME', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['state_name']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['country_name']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_COUNTRY_NAME', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['country_name']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_zip']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_Zip', $siteLangId); ?></span>
                                            <span class="value"><?php echo $vendorReturnAddress['ura_zip']; ?></span>
                                        </li>
                                    <?php } ?>
                                    <?php if (strlen($vendorReturnAddress['ura_phone']) > 0) { ?>
                                        <li class="list-stats-item">
                                            <span class="label"><?php echo Labels::getLabel('LBL_Phone', $siteLangId); ?></span>
                                            <span class="value"><?php echo ValidateElement::formatDialCode($vendorReturnAddress['ura_phone_dcode']) . $vendorReturnAddress['ura_phone']; ?></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5><?php echo Labels::getLabel('LBL_CUSTOMER_DETAIL', $siteLangId); ?></h5>
                        <div class="row">
                            <div class="col-lg-12 my-4">
                                <ul class="list-stats list-stats-double">
                                    <li class="list-stats-item">
                                        <span class="label"><?php echo Labels::getLabel('LBL_CUSTOMER_NAME', $siteLangId); ?></span>
                                        <span class="value"><?php echo $request['buyer_name']; ?></span>
                                    </li>
                                    <li class="list-stats-item">
                                        <span class="label"><?php echo Labels::getLabel('Lbl_Download_attached_file', $siteLangId); ?></span>
                                        <span class="value">
                                            <a href="<?php echo UrlHelper::generateUrl('Seller', 'downloadAttachedFileForReturn', array($request['orrequest_id'], 0)); ?>">
                                                <svg class="svg" width="18" height="18">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#download">
                                                    </use>
                                                </svg>
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($request)) { ?>
                    <div class="js-scrollable table-wrap table-responsive">
                        <table class="table table-justified">
                            <thead>
                                <tr class="">
                                    <th width="15%"><?php echo Labels::getLabel('LBL_ID', $siteLangId); ?></th>
                                    <th width="20%"><?php echo Labels::getLabel('LBL_Order_Id/Invoice_Number', $siteLangId); ?></th>
                                    <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Return_Qty', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Request_Type', $siteLangId); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $request['orrequest_reference'] /* CommonHelper::formatOrderReturnRequestNumber($request['orrequest_id']) */; ?></td>
                                    <td><?php echo $request['op_invoice_number']; ?>
                                    <td>
                                        <?php echo $this->includeTemplate('_partial/product/product-info-html.php', ['order' => $request, 'siteLangId' => $siteLangId], false, true); ?>
                                    </td>
                                    <td><?php echo $request['orrequest_qty']; ?></td>
                                    <td><?php echo $returnRequestTypeArr[$request['orrequest_type']]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="js-scrollable table-wrap table-responsive">
                        <table class="table table-justified">
                            <thead>
                                <tr class="">
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Reason', $siteLangId); ?></th>
                                    <th><?php echo Labels::getLabel('LBL_Date', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Product_Price', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Tax', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Shipping', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></th>
                                    <th width="15%"><?php echo Labels::getLabel('LBL_Total_Amount', $siteLangId); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $returnDataArr = CommonHelper::getOrderProductRefundAmtArr($request); ?>
                                    <td><?php echo $request['orreason_title']; ?></td>
                                    <td>
                                        <div class="product-profile__description">
                                            <span class=""><?php echo FatDate::format($request['orrequest_date']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo CommonHelper::displayMoneyFormat($returnDataArr['op_prod_price'], true, false); ?></td>
                                    <td>
                                        <?php echo CommonHelper::displayMoneyFormat($returnDataArr['op_refund_tax'], true, false); ?></td>
                                    <td>
                                        <?php echo CommonHelper::displayMoneyFormat($returnDataArr['op_refund_shipping'], true, false); ?></td>
                                    <td><?php echo $requestRequestStatusArr[$request['orrequest_status']]; ?></td>
                                    <td><?php
                                        echo CommonHelper::displayMoneyFormat($returnDataArr['op_refund_amount'], true, false);
                                        if ($request['op_qty'] == $request['orrequest_qty'] && 0 != $request['op_rounding_off']) {
                                            echo ' (' . $request['op_rounding_off'] . ')';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

                <?php echo ($canEdit) ? $returnRequestMsgsForm->getFormHtml() : ''; ?>

                <div class="mt-5 messageListBlock--js">
                    <h5><?php echo Labels::getLabel('LBL_Return_Request_Messages', $siteLangId); ?> </h5>
                    <div id="loadMoreBtnDiv"></div>
                    <ul class="messages-list" id="messagesList"></ul>
                </div>
                <?php if ($canEdit && $request && ($request['orrequest_status'] != OrderReturnRequest::RETURN_REQUEST_STATUS_REFUNDED && $request['orrequest_status'] != OrderReturnRequest::RETURN_REQUEST_STATUS_WITHDRAWN)) {
                    $frmMsg->setFormTagAttribute('onSubmit', 'setUpReturnOrderRequestMessage(this); return false;');
                    $frmMsg->setFormTagAttribute('class', 'form');
                    $frmMsg->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                    $frmMsg->developerTags['fld_default_col'] = 12; ?>
                    <div class="messages-list">
                        <ul>
                            <li>
                                <div class="msg_db">
                                    <div class="avtar"><img src="<?php echo UrlHelper::generateFileUrl('Image', 'user', array($logged_user_id, ImageDimension::VIEW_THUMB, 1), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo $logged_user_name; ?>" title="<?php echo $logged_user_name; ?>"></div>
                                </div>
                                <div class="msg__desc">
                                    <span class="msg__title"><?php echo $logged_user_name; ?></span>
                                    <?php echo $frmMsg->getFormHtml(); ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>