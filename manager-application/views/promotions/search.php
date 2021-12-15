<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['promotion_id']]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="promotion_ids[]" value=' . $row['promotion_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'promotion_name':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
            case 'user_name':
                $href = "javascript:void(0)";
                $onclick = 'redirectUser(' . $row['user_id'] . ')';
                $str = $this->includeTemplate('_partial/user/user-info-card.php', [
                    'user' => $row,
                    'siteLangId' => $siteLangId,
                    'href' => $href,
                    'onclick' => $onclick,
                ], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'shop_name':
                if (!empty($row['shop_name'])) {
                    if ($canViewShops) {
                        $td->appendElement('a', array('href' => 'javascript:void(0)', 'onclick' => 'redirectToShop(' . $row['shop_id'] . ')'), $row['shop_name'], true);
                    } else {
                        $td->appendElement('plaintext', $tdAttr, $row['shop_name'], true);
                    }
                }
                break;
            case 'promotion_type':
                $td->appendElement('plaintext', $tdAttr, $typeArr[$row[$key]], true);
                break;
            case 'blocation_promotion_cost':
            case 'banner_promotion_cost':
                $cost = Promotion::getPromotionCostPerClick(FatUtility::int($row['promotion_type']), FatUtility::int($row['blocation_id']));
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($cost, true, true));
                break;
            case 'promotion_budget':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'promotion_approved':
                $td->appendElement('plaintext', $tdAttr, $yesNoArr[$row[$key]], true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['promotion_id']
                ];

                if ($canEdit) {
                    $attr = [];
                    if (1 === count($languages)) {
                        $attr = [
                            'onclick' => 'editRecord(' . $row['promotion_id'] . ')'
                        ];
                    }
                    $data['editButton'] = $attr;
                    $data['deleteButton'] = [];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, FatUtility::int($row[$key]));
                break;
        }
    }
    $serialNo++;
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

if ($printData) {
    echo $tbody->getHtml();
}