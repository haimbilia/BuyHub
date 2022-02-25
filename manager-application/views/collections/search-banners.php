<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fields = array(
    'listSerial' => Labels::getLabel('LBL_SR._NO', $siteLangId),
    'banner_title' => Labels::getLabel('LBL_TITLE', $siteLangId),
    'banner_img' => Labels::getLabel('LBL_IMAGE', $siteLangId),
    'banner_target' => Labels::getLabel('LBL_TARGET', $siteLangId),
    'banner_active' => Labels::getLabel('LBL_STATUS', $siteLangId),
    'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $siteLangId),
);
if (!$canEdit) {
    unset($fields['action']);
}

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-dashed'));
$th = $tbl->appendElement('thead')->appendElement('tr');
$tbody = $tbl->appendElement('tbody');

foreach ($fields as $val) {
    $e = $th->appendElement('th', array(), $val);
}

foreach ($arrListing as $sn => $row) {
    $serialNo = $sn + 1;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'banner_target':
                $td->appendElement('plaintext', $tdAttr, $linkTargetsArr[$row[$key]], true);
                break;
            case 'banner_title':
                $title = ($row['banner_title'] != '') ? $row['banner_title'] : $row['promotion_name'];
                $td->appendElement('plaintext', $tdAttr, $title, true);
                break;
            case 'banner_active':
                $statusAct = ($canEdit) ? 'toggleBannerStatus(event, this, ' . $row['banner_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon" data-bs-toggle="tooltip" data-placement="top">
                            <label>
                                <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['banner_id'] . '" ' . $checked . ' onclick="' . $statusAct . '">
                                <span class="input-helper"></span>
                            </label>
                        </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'banner_img':
                $uploadedTime = AttachedFile::setTimeParam($row['banner_updated_on']);
                $imagebannerDimensions = ImageDimension::getData(ImageDimension::TYPE_BANNER, ImageDimension::VIEW_THUMB);
                $img = '<img data-aspect-ratio = "'.$imagebannerDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'].'" src="' . UrlHelper::generateFullUrl('Banner', 'BannerImage', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime . '" />';
                $td->appendElement('plaintext', $tdAttr, $img, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['banner_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [
                        'onclick' => "bannerForm(" . $collectionId . "," . $row['banner_id'] . ")"
                    ];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
}
include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);

$displayLangTab = false;

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'banners(' . $collectionId . ')',
        'title' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    'isActive' => true
];
$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => 'bannerForm(' . $collectionId . ', 0)',
        'title' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
    'isActive' => false,
    'isDisabled' => false,
];

if (!empty($languages)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerLangForm(' . $collectionId . ', 0,' . array_key_first($languages) . ')',
            'title' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        'isActive' => false
    ];
}

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'bannerMediaForm(' . $collectionId . ', 0)',
        'title' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    'isActive' => false
];

$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);

/* Mark all other tabs disabled. */
$disabled = 'disabled';
/* ^^^^^^^^^^^^ */

require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $tbl->getHtml(); ?>
</div>
</div>