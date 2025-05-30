<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Messages', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h5 class="card-title"><?php echo Labels::getLabel('LBL_Messages', $siteLangId); ?></h5>
                </div>
                <div class="btn-group"><a href="<?php echo UrlHelper::generateUrl('Account', 'messages'); ?>" class="btn btn-outline-gray btn-sm"><?php echo Labels::getLabel('LBL_Back_to_messages', $siteLangId); ?></a></div>
            </div>
            <div class="card-table">
                <div class="js-scrollable table-wrap table-responsive">
                    <table class="table">
                        <tbody>
                            <tr class="">
                                <th><?php echo Labels::getLabel('LBL_Date', $siteLangId); ?></th>
                                <th><?php echo $threadTypeArr[$threadDetails['thread_type']]; ?></th>
                                <th><?php echo Labels::getLabel('LBL_Subject', $siteLangId); ?></th>
                                <th><?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
                                        echo Labels::getLabel('LBL_Amount', $siteLangId);
                                    } elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT) {
                                        echo Labels::getLabel('LBL_Price', $siteLangId);
                                    } ?>
                                </th>
                                <th>
                                    <?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
                                        echo Labels::getLabel('LBL_Status', $siteLangId);
                                    } ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php echo FatDate::format($threadDetails["thread_start_date"], false); ?> </td>
                                <td>
                                    <div class="product-profile__description">
                                        <?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) { ?>
                                            <span class="product-profile__title"><?php echo $threadDetails["op_invoice_number"]; ?></span>
                                        <?php } elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_SHOP) { ?>
                                            <span class="product-profile__title"><?php echo $threadDetails["shop_name"]; ?></span>
                                        <?php } elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT) { ?>
                                            <span class="product-profile__title"><?php echo $threadDetails["selprod_title"]; ?></span>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td><?php echo $threadDetails["thread_subject"]; ?> </td>
                                <td>
                                    <span class="item__price">
                                        <?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
                                        ?> <?php
                                        } elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_SHOP) {
                                            ?> <?php
                                            } elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT) { ?>
                                            <p><?php echo CommonHelper::displayMoneyFormat($threadDetails['selprod_price']); ?></p>
                                        <?php } ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
                                        echo $threadDetails["orders_status_name"];
                                    } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <?php echo $frmSrch->getFormHtml(); ?> <div id="loadMoreBtnDiv"></div>
                <div id="messageListing" class="messages-list">
                    <ul></ul>
                </div>
                <?php if ($canEditMessages) { ?>
                    <div class="messages-list">
                        <ul>
                            <li>
                                <div class="msg_db">
                                    <?php
                                    if (is_array($shopDetails) && !empty($shopDetails) && $shopDetails['shop_name'] != '' && $shopDetails['shop_id'] > 0) {
                                        $userImgUpdatedOn = $shopDetails['shop_updated_on'];
                                        $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
                                    ?>
                                        <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'shopLogo', array($shopDetails['shop_id'], $siteLangId, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $shopDetails['shop_name']; ?>">
                                    <?php } else {
                                        $userImgUpdatedOn = User::getAttributesById($loggedUserId, 'user_updated_on');
                                        $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
                                    ?>
                                        <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'user', array($loggedUserId, ImageDimension::VIEW_THUMB, true), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $loggedUserName; ?>">
                                    <?php } ?>
                                </div>
                                <div class="msg__desc">
                                    <span class="msg__title">
                                        <?php if (isset($shopDetails) && !empty($shopDetails) && $shopDetails['shop_name'] != '') {
                                            $loggedUserName = $shopDetails['shop_name'] . ' (' . $loggedUserName . ')';
                                        }
                                        echo $loggedUserName; ?>
                                    </span>
                                    <?php
                                    $frm->setFormTagAttribute('onSubmit', 'sendMessage(this); return false;');
                                    $frm->setFormTagAttribute('class', 'form');
                                    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                                    $frm->developerTags['fld_default_col'] = 12;
                                    $submitFld = $frm->getField('btn_submit');
                                    $submitFld->setFieldTagAttribute('class', "btn btn-brand");
                                    echo $frm->getFormHtml(); ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>