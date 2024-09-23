<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$messageDetail = current($threadListing);
$doNotshowMessages = $doNotshowMessages ?? false;
$imageUserDimensions = ImageDimension::getData(ImageDimension::TYPE_USER, ImageDimension::VIEW_THUMB);
?>
<?php if (empty($messageDetail)) { ?>
    <div class="col-md-9">
        <div class="card card-stretch mb-0">
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
    // $fromEmail = $messageDetail['message_from_email'];
    // $fromPhoneNo =  !empty($messageDetail['message_from_user_phone']) ? ValidateElement::formatDialCode($messageDetail['message_from_user_phone_dcode']) . $messageDetail['message_from_user_phone'] : '';
    $toUserName = $messageDetail['message_to_name'];
    if ($messageDetail['thread_started_by'] == $messageDetail['message_to_user_id']) {
        $fromUserId = $messageDetail['message_to_user_id'];
        $fromUserUpdatedOn = $messageDetail['message_to_user_updated_on'];
        $fromUserName = $messageDetail['message_to_name'];
        // $fromEmail = $messageDetail['message_to_email'];
        // $fromPhoneNo =  !empty($messageDetail['message_to_user_phone']) ? ValidateElement::formatDialCode($messageDetail['message_to_user_phone_dcode']) . $messageDetail['message_to_user_phone'] : '';
        $toUserName = $messageDetail['message_from_name'];
    }

    $uploadedTime = AttachedFile::setTimeParam($fromUserUpdatedOn);

    $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$fromUserId, ImageDimension::VIEW_THUMB, true], CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
?>

    <div class="communication-content threadJs" data-thread-id="<?php echo $messageDetail['thread_id'] ?>">
        <div class="card card-stretch mb-0">
            <div class="card-head">
                <div class="card-head-label">
                    <div class="card-head-title d-flex align-items-center">
                        <div class="user user-md user-circle">
                            <img data-aspect-ratio="<?php echo $imageUserDimensions[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>" src="<?php echo $userImageUrl; ?>" alt="<?php echo $fromUserName; ?>">
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
                            <?php $class = ($row['thread_started_by'] == $row['message_from_user_id']) ? 'from' : 'to'; ?>
                            <div class="message-wrap message-wrap--<?php echo $class; ?>">
                                <div class="message-avtar">
                                    <a class="user user-circle" href="javascript:void(0)" onclick="redirectUser(<?php echo $row['message_from_user_id'];?>)">
                                        <?php
                                        $rowUploadedTime = AttachedFile::setTimeParam($row['message_from_user_updated_on']);

                                        $rowUserImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$row['message_from_user_id'], ImageDimension::VIEW_THUMB, true], CONF_WEBROOT_FRONT_URL) . $rowUploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                        ?>
                                        <img data-aspect-ratio="<?php echo $imageUserDimensions[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>" src="<?php echo $rowUserImageUrl; ?>" alt="<?php echo $row['message_from_name']; ?>">
                                    </a>
                                </div>
                                <div class="message-detail">
                                    <div class="message">
                                        <?php 

                                        if(!empty($searchkeyword)){
                                            echo str_ireplace($searchkeyword, "<mark>" . $searchkeyword . "</mark>", nl2br($row['message_text']));
                                        }else{
                                            echo nl2br($row['message_text']); 
                                        }
                                        ?>
                                    </div>
                                    <span class="time"> <?php if ($row['thread_started_by'] != $row['message_from_user_id']) { ?>
                                            <?php echo $toUserName; ?> -
                                        <?php } ?>
                                        <?php echo date('H:i', $msgTimeStamp); ?></span>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>