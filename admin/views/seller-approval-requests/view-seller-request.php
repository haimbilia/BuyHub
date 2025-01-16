<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_User_Details', $siteLangId); ?>
    </h5>
</div>
<main class="mainJs">
    <div class="modal-body form-edit pd-0">
        <div class="form-edit-body loaderContainerJs">
            <form class="modal-body form pd-0">
                <h3 class="h3 mb-3"><?php echo Labels::getLabel('LBL_Profile_Information', $siteLangId); ?></h3>

                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">

                        <span class="lable"><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></span>
                        <span class="value"><?php echo $supplierRequest['user_name']; ?></span>

                    </li>
                    <li class="list-stats-item">

                        <span class="lable"><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></span>
                        <span class="value"><?php echo $supplierRequest['credential_email']; ?></span>

                    </li>
                    <li class="list-stats-item">

                        <span class="lable"><?php echo Labels::getLabel('LBL_Username', $siteLangId); ?></span>
                        <span class="value"><?php echo $supplierRequest['credential_username']; ?></span>

                    </li>
                </ul>

                <div class="separator separator-dashed my-4"></div>

                <h3 class="h3 mb-3"><?php echo Labels::getLabel('LBL_Seller_Information', $siteLangId); ?></h3>

                <ul class="list-stats list-stats-double">
                    <?php foreach ($supplierRequest['field_values'] as $val) { ?>
                        <li class="list-stats-item <?php if (strlen((string)$val['sfreqvalue_text']) > 40) { ?> list-stats-item-full<?php } ?>">

                            <?php
                            if ($val['sformfield_caption'] != '') {
                                echo '<span class="lable">' . $val['sformfield_caption'] . '</span>';
                            } else {
                                echo '<span class="lable">' . $val['sformfield_identifier'] . '</span>';
                            }
                            ?>

                            <?php
                            if ($val['afile_physical_path'] != '') {
                                echo "<span class='value'><a href='" . UrlHelper::generateUrl('sellerApprovalRequests', 'downloadAttachment', array($supplierRequest['user_id'], $val['sfreqvalue_formfield_id'])) . "'>" . $val['sfreqvalue_text'] . "</a></span>";
                            } else {
                                if ($val['sformfield_type']  == User::USER_FIELD_TYPE_PHONE) {
                                    echo '<span class="value">' . filter_var($val['sfreqvalue_text'], FILTER_SANITIZE_NUMBER_INT) . '</span>';
                                } else {
                                    echo '<span class="value"><span class="default-ltr">' . nl2br($val['sfreqvalue_text']) . '</span></span>';
                                }
                            }
                            ?>

                        </li>
                    <?php } ?>
                </ul>


                <div class="separator separator-dashed my-4"></div>

                <h3 class="h3 mb-3"><?php echo Labels::getLabel('LBL_Additional_Information', $siteLangId); ?></h3>
                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">

                        <span class="lable"><?php echo Labels::getLabel('LBL_Reference_Number', $siteLangId); ?></span>
                        <span class="value"><?php echo $supplierRequest['usuprequest_reference']; ?></span>

                    </li>
                    <li class="list-stats-item">

                        <span class="lable"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></span>
                        <span class="value"><?php echo $reqStatusArr[$supplierRequest['usuprequest_status']]; ?></span>

                    </li>
                    <?php if (!empty($supplierRequest['usuprequest_comments'])) { ?>
                        <li class="list-stats-item list-stats-item-full">

                            <span class="lable"><?php echo Labels::getLabel('LBL_Comments/Reason', $siteLangId); ?></span>
                            <span class="value"><?php echo nl2br($supplierRequest['usuprequest_comments']); ?></span>

                        </li>
                    <?php } ?>
                </ul>


            </form>
        </div>
    </div>
</main>