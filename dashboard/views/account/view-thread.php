<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$messageDetail = current($threadListing);
$doNotshowMessages = $doNotshowMessages ?? false;
?>
<?php if (empty($messageDetail)) { ?>
    <div class="col-md-9">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <div class="not-found">
                    <img width="100" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                    <h3><?php echo Labels::getLabel('MSG_SORRY,_NO_MATCHING_RESULT_FOUND'); ?></h3>
                    <p> <?php echo Labels::getLabel('MSG_TRY_CHECKING_YOUR_SPELLING_OR_USER_MORE_GENERAL_TERMS'); ?> </p>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    $fromUserId = $messageDetail['message_from_user_id'];
    $fromUserUpdatedOn = $messageDetail['message_from_user_updated_on'];
    $fromUserName = $messageDetail['message_from_name'];
    $fromEmail = $messageDetail['message_from_email'];
    $fromPhoneNo =  !empty($messageDetail['message_from_user_phone']) ? ValidateElement::formatDialCode($messageDetail['message_from_user_phone_dcode']) . $messageDetail['message_from_user_phone'] : '';
    $toUserName = $messageDetail['message_to_name'];
    if ($messageDetail['thread_started_by'] == $messageDetail['message_to_user_id'] || $activeTab == "B") {
        $fromUserId = $messageDetail['message_to_user_id'];
        $fromUserUpdatedOn = $messageDetail['message_to_user_updated_on'];
        $fromUserName = $messageDetail['message_to_name'];
        $fromEmail = $messageDetail['message_to_email'];
        $fromPhoneNo =  !empty($messageDetail['message_to_user_phone']) ? ValidateElement::formatDialCode($messageDetail['message_to_user_phone_dcode']) . $messageDetail['message_to_user_phone'] : '';
        $toUserName = $messageDetail['message_from_name'];
    }

    $uploadedTime = AttachedFile::setTimeParam($fromUserUpdatedOn);
    $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$fromUserId, 'thumb', true], CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
?>

    <div class="communication-content threadJs" data-thread-id="<?php echo $messageDetail['thread_id'] ?>">
        <div class="card mb-0 h-100">
            <div class="card-head">
                <div class="card-head-label">
                    <div class="card-head-title d-flex align-items-center">
                        <div class="user user-md user-circle">
                            <img src="<?php echo $userImageUrl; ?>" alt="<?php echo $fromUserName; ?>">
                        </div>
                        <div class="message-user__detail">
                            <h3><?php echo $fromUserName; ?></h3>
                            <p>
                                <b><?php echo Labels::getLabel('LBL_SUBJECT', $siteLangId); ?></b>:
                                <?php echo $messageDetail['thread_subject']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="messages">
                    <?php
                    $lastDate = '';
                    if (false === $doNotshowMessages) {
                        foreach ($threadListing as $sn => $row) {
                            $msgTimeStamp = strtotime($row['message_date']);
                            $date = date('Y-m-d', $msgTimeStamp);
                            if ($lastDate != $date) { ?>
                                <div class="date">
                                    <?php
                                    $lastDate = $date;
                                    echo HtmlHelper::getTheDay($lastDate, $siteLangId);
                                    ?>
                                </div>
                            <?php } ?>
                            <?php
                            $userName = ($row['thread_started_by'] == $row['message_from_user_id']) ? $fromUserName : $toUserName;

                            $class = ($row['thread_started_by'] == $row['message_from_user_id']) ? 'from' : 'to';
                            if ($activeTab == "B") {
                                $class = ($row['thread_started_by'] == $row['message_from_user_id']) ? 'to' : 'from';
                                $userName = ($row['thread_started_by'] == $row['message_from_user_id']) ? $toUserName : $fromUserName;
                            }
                            ?>
                            <div class="message-wrap message-wrap--<?php echo $class; ?>">
                                <div class="message-avtar">
                                    <div class="user user-circle">
                                        <?php
                                        $rowUploadedTime = AttachedFile::setTimeParam($row['message_from_user_updated_on']);
                                        $rowUserImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$row['message_from_user_id'], 'thumb', true], CONF_WEBROOT_FRONT_URL) . $rowUploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                        ?>
                                        <img src="<?php echo $rowUserImageUrl; ?>" alt="<?php echo $row['message_from_name']; ?>">
                                    </div>
                                </div>
                                <div class="message-detail">
                                    <div class="message">
                                        <?php echo nl2br($row['message_text']); ?>
                                    </div>
                                    <span class="time"><?php echo date('H:i', $msgTimeStamp); ?></span>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <?php if (false === $doNotshowMessages) { ?>
                <div class="card-foot p-0">

                    <?php
                    $frm->setFormTagAttribute('onSubmit', 'sendMessage(this); return false;');
                    $frm->setFormTagAttribute('class', 'form message-send');
                    $frm->developerTags['colClassPrefix'] = 'col-md-';
                    $frm->developerTags['fld_default_col'] = 12;

                    $msgFld = $frm->getField('message_text');
                    $msgFld->developerTags['noCaptionTag'] = true;
                    $msgFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_COMMENTS', $siteLangId));
                    $msgFld->setFieldTagAttribute('class', 'message-textarea'); ?>

                    <?php echo $frm->getFormTag(); ?>
                    <?php echo $frm->getFieldHtml('message_thread_id'); ?>

                    <?php echo $frm->getFieldHtml('message_text'); ?>
                    <button class="btn btn-icon btn-send" type="submit">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#submitfly">
                            </use>
                        </svg>
                    </button>
                    </form>
                    <?php echo $frm->getExternalJS(); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="communication-sidebar userJs">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <div class="message__user">
                    <div class="user user-circle">
                        <img src="<?php echo $userImageUrl; ?>" alt="<?php echo $fromUserName; ?>">
                    </div>
                    <h3 class="message__user-name"><?php echo $fromUserName; ?></h3>
                    <ul class="list__group">
                        <li class="list__group-item">
                            <div class="list__group-icon">
                                <svg class="svg" width="20" height="20">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-mail">
                                    </use>
                                </svg>
                            </div>
                            <div class="list__group-title">
                                <h4><?php echo $fromEmail; ?></h4>
                            </div>
                        </li>

                        <?php if (!empty($fromPhoneNo)) { ?>
                            <li class="list__group-item">
                                <div class="list__group-icon">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-phone">
                                        </use>
                                    </svg>
                                </div>
                                <div class="list__group-title">
                                    <h4>
                                        <?php echo $fromPhoneNo; ?>
                                    </h4>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } ?>