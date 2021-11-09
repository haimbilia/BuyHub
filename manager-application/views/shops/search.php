<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['shop_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="shop_ids[]" value=' . $row['shop_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'shop_identifier':
                $td->appendElement('plaintext', array(), $row['shop_name'], true);
                $td->appendElement('br', array());
                $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                break;
            case 'shop_featured':
                $td->appendElement('plaintext', array(), applicationConstants::getYesNoArr($siteLangId)[$row[$key]], true);
                break;
            case 'shop_supplier_display_status':
                $td->appendElement('plaintext', array(), applicationConstants::getOnOffArr($siteLangId)[$row[$key]], true);
                break;
            case 'shop_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['shop_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['shop_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span class="input-helper"></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
             case 'numOfReports':
                if ($canViewShopReports) {
                    $td->appendElement('a', array('target' => '_blank', 'href' => UrlHelper::generateUrl('ShopReports', 'index', array($row['shop_id']))), $row[$key]);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'numOfReviews':
                if ($canViewShopReports) {
                    $td->appendElement('a', array('target' => '_blank', 'href' => UrlHelper::generateUrl('ProductReviews', 'index', array($row['shop_user_id']))), $row[$key]);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'numOfProducts':
                if ($canViewSellerProducts) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectfunc("' . UrlHelper::generateUrl('SellerProducts') . '", ' . $row['shop_user_id'] . ')'), $row[$key]);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['shop_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = []; 
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
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