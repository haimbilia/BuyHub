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
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['banner_id'], $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'banner_img':
                $uploadedTime = AttachedFile::setTimeParam($row['banner_updated_on']);
                $img = '<img src="' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP), CONF_WEBROOT_FRONT_URL) . $uploadedTime . '" />';
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
if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

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

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0);',
            'onclick' => 'bannerForm(' . $collectionId . ', 0)',
            'title' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId)
        ],
        'label' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
        'isActive' => false,
        'isDisabled' => false,
    ],
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerLangForm(' . $collectionId . ', 0,' . array_key_first($languages) . ')',
            'title' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        'isActive' => false
    ],
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerMediaForm(' . $collectionId . ', 0)',
            'title' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
        'isActive' => false
    ]
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