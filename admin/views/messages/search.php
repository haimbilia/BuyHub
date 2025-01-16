<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$activeIndex = $activeIndex ?? '';

if (1 == $page) {
    $ul = new HtmlElement('ul', ['class' => 'message__list appendRowsJs listingRecordJs']);
}

if (!empty($arrListing)) {
    foreach ($arrListing as $sn => $row) {
        $isActive = $sn === $activeIndex ? ' is-active' : '';
        $attr = ['class' => 'message__list-item' . $isActive . ' listItemJs', 'data-thread-id' => $row['thread_id'], 'onclick' => 'viewThread(this)', 'data-searchkeyword' => $searchkeyword];
        if (1 == $page) {
            $li = $ul->appendElement('li', $attr);
        } else {
            $li = new HtmlElement('li', $attr);
        }

        $fromUserId = $row['message_from_user_id'];
        $fromUserUpdatedOn = $row['message_from_user_updated_on'];
        $fromUserName = $row['message_from_name'];

        $toUserId = $row['message_to_user_id'];
        $toUserUpdatedOn = $row['message_to_user_updated_on'];
        $toUserName = $row['message_to_name'];
        if ($row['thread_started_by'] == $row['message_to_user_id']) {
            $fromUserId = $row['message_to_user_id'];
            $fromUserUpdatedOn = $row['message_to_user_updated_on'];
            $fromUserName = $row['message_to_name'];

            $toUserId = $row['message_from_user_id'];
            $toUserUpdatedOn = $row['message_from_user_updated_on'];
            $toUserName = $row['message_from_name'];
        }


        /* Message From */
        $msgFrom = $li->appendElement('div', ['class' => 'message-from']);

        $uploadedTime = AttachedFile::setTimeParam($fromUserUpdatedOn);
        $imageUserDimensions = ImageDimension::getData(ImageDimension::TYPE_USER, ImageDimension::VIEW_THUMB);
        $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$fromUserId, ImageDimension::VIEW_THUMB, 1], CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

        $img = '<img data-aspect-ratio = "' . $imageUserDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'] . '" src="' . $userImageUrl . '" alt="' . $fromUserName . '">';
        $media = $msgFrom->appendElement('div', ['class' => 'message-media']);
        $media->appendElement('plaintext', [], $img, true);

        $data = $msgFrom->appendElement('div', ['class' => 'message-data']);
        $data->appendElement('h4', ['class' => 'title'], $fromUserName);

        $msg = $row['message_text'];
        $msg = 25 < strlen((string)$msg) ? substr($msg, 0, 25) . ' ...' : $msg;
        $data->appendElement('p', [], $msg);
        /* --------- */

        /* Message to */
        $msgTo = $li->appendElement('div', ['class' => 'message-to']);

        $uploadedTime = AttachedFile::setTimeParam($toUserUpdatedOn);
        $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', [$toUserId, ImageDimension::VIEW_THUMB, 1], CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $img = '<img  data-aspect-ratio = "' . $imageUserDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'] . '" src="' . $userImageUrl . '" alt="' . $toUserName . '">';
        $media = $msgTo->appendElement('div', ['class' => 'message-media']);
        $div = $media->appendElement('div', ['class' => 'user user-sm user-circle']);
        $div->appendElement('plaintext', [], $img, true);
        /* --------- */

        if (1 < $page) {
            echo $li->getHtml();
        }
    }
} else {
    $img = '<div class="not-found">
                <img width="100" src="' . CONF_WEBROOT_URL . 'images/retina/no-data-cuate.svg" alt="">
                <h3>' . Labels::getLabel('MSG_SORRY,_NO_MATCHING_RESULT_FOUND') . '</h3>
                <p> ' . Labels::getLabel('MSG_TRY_CHECKING_YOUR_SPELLING_OR_USER_MORE_GENERAL_TERMS') . ' </p>
            </div>';

    $li = $ul->appendElement('li', ['class' => 'message__list-item'], $img, true);
}

if (1 == $page) {
    echo $ul->getHtml();
}

$lastRecord = current(array_reverse($arrListing));
$data = [
    'siteLangId' => $siteLangId,
    'postedData' => $postedData,
    'page' => $page,
    'pageCount' => $pageCount,
    'callbackFn' => 'resetPaginationSection',
];
$this->includeTemplate('_partial/load-more-pagination.php', $data);
