<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$messageDetail = current($threadListing);

$fromUserId = $messageDetail['message_from_user_id'];
$fromUserUpdatedOn = $messageDetail['message_from_user_updated_on'];
$fromUserName = $messageDetail['message_from_name'];
if ($messageDetail['thread_started_by'] == $messageDetail['message_to_user_id']) {
    $fromUserId = $messageDetail['message_to_user_id'];
    $fromUserUpdatedOn = $messageDetail['message_to_user_updated_on'];
    $fromUserName = $messageDetail['message_to_name'];
}

$add = current((new Address())->getData(Address::TYPE_USER, $fromUserId, 1));
$uploadedTime = AttachedFile::setTimeParam($fromUserUpdatedOn);
$userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$fromUserId, 'thumb', true], CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
?>

<div class="col-md-6 threadJs" data-thread-id="<?php echo $messageDetail['thread_id'] ?>">
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
                                <?php echo $row['message_text']; ?>
                            </div>
                            <span class="time"><?php echo date('H:i', $msgTimeStamp); ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 userJs">
    <div class="card mb-0 h-100">
        <div class="card-body">
            <div class="message__user">
                <div class="user user-circle">
                    <img src="<?php echo $userImageUrl; ?>" alt="<?php echo $messageDetail['message_from_name']; ?>">
                </div>
                <h3 class="message__user-name"><?php echo $messageDetail['message_from_name']; ?></h3>
                <ul class="list__group">
                    <li class="list__group-item">
                        <div class="list__group-icon">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-mail">
                                </use>
                            </svg>
                        </div>
                        <div class="list__group-title">
                            <h4><?php echo $messageDetail['message_from_email']; ?></h4>
                        </div>
                    </li>

                    <li class="list__group-item">
                        <div class="list__group-icon">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-phone">
                                </use>
                            </svg>
                        </div>
                        <div class="list__group-title">
                            <h4>
                                <?php
                                if (!empty($messageDetail['message_from_user_phone'])) {
                                    echo ValidateElement::formatDialCode($messageDetail['message_from_user_phone_dcode']) . $messageDetail['message_from_user_phone'];
                                } else {
                                    echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId);
                                }
                                ?>
                            </h4>
                        </div>
                    </li>

                    <?php
                    $address = (!empty($add['addr_address1'])) ? $add['addr_address1'] . ', ' : '';
                    $address .= (!empty($add['add_address2'])) ? $add['addr_address2'] : '';

                    $address .= (!empty($add['addr_city'])) ? $add['addr_city'] . ', ' : '';
                    $address .= (!empty($add['state_name'])) ? $add['state_name'] . ', ' : '';
                    $address .= (!empty($add['addr_zip'])) ? $add['addr_zip'] . ', ' : '';
                    $address .= (!empty($add['country_name'])) ? $add['country_name'] : '';
                    ?>
                    <li class="list__group-item">
                        <div class="list__group-icon">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-map">
                                </use>
                            </svg>
                        </div>
                        <div class="list__group-title">
                            <h4>
                                <?php
                                if (!empty($address)) {
                                    echo $address;
                                } else {
                                    echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId);
                                }
                                ?>
                            </h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>