<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="badgeLinkIds[]" value=' . $row['blinkcond_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', [], $serialNo, true);
                break;
            case 'cond_seller_name':
                $str = $this->includeTemplate('_partial/shop/shop-info-card.php', ['shop' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $htm = BadgeLinkCondition::getRecordTypeHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', [], $htm, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'position':
                $txt = Badge::RIBB_POS_TRIGHT == $row[$key] ? Labels::getLabel('LBL_TOP_RIGHT', $siteLangId) : Labels::getLabel('LBL_TOP_LEFT', $siteLangId);
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $htm = BadgeLinkCondition::getConditionTypeHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', [], $htm, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to':
                $lbl = $row[$key];
                if (!empty($lbl) && (!in_array($row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'],[BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS,BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP]))) {
                    $lbl = $row[$key] . '%';
                }
                $td->appendElement('plaintext', [], (!empty($lbl) ? $lbl : Labels::getLabel('LBL_N/A', $siteLangId)), true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'from_date':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'to_date':
                $lbl = (1 > strtotime($row[$key]) ? Labels::getLabel('LBL_N/A', $siteLangId) : HtmlHelper::formatDateTime($row[$key], true, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())));
                $td->appendElement('plaintext', [], $lbl, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']
                ];

                if ($canEdit) {
                    $recordType = $row['blinkcond_record_type'];
                    $triggerType = $row['badge_trigger_type'];
                    $data['editButton'] = [
                        'onclick' => 'editConditionRecord(' . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'] . ', ' . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id'] . ')'
                    ];

                    $attr = [
                        'class' => 'disabled',
                        'title' => Labels::getLabel('ERR_NOT_ALLOWED_TO_DELETE_THIS_RECORD_AS_BADGE_REQUEST_ADDED', $siteLangId),
                        'onclick' => 'javascript:void(0);',
                    ];
                    $badgeRequested =  BadgeRequest::getAttributesByConditionId($row['blinkcond_id'], 'breq_id');
                    if ($badgeRequested === false) {
                        $attr = [];
                    }
                    $data['deleteButton'] = $attr;
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
