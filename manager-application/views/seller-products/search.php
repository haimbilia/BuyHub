<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['selprod_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="brandIds[]" value=' . $row['selprod_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'selprod_title':
                $variantStr = ($row['selprod_title'] != '') ? $row['selprod_title'] . '<br/>' : '';
                if (is_array($row['options']) && count($row['options'])) {
                    foreach ($row['options'] as $op) {
                        $variantStr .= $op['option_name'] . ': ' . $op['optionvalue_name'] . '<br/>';
                    }
                }
                $td->appendElement('plaintext', array(), $variantStr, true);
                if ($canViewProducts) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'onclick' => 'redirectfunc("' . UrlHelper::generateUrl('Products') . '", ' . $row['selprod_product_id'] . ')'), $row['product_name'], true);
                } else {
                    $td->appendElement('plaintext', array(), $row['product_name'], true);
                }
                break;
            case 'user':
                if ($canViewUsers) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'onclick' => 'redirectfunc("' . UrlHelper::generateUrl('Users') . '", ' . $row['selprod_user_id'] . ')'), '<strong>' . Labels::getLabel('LBL_N:', $adminLangId) . ' </strong>' . $row['user_name'], true);
                } else {
                    $td->appendElement('plaintext', array(), '<strong>' . Labels::getLabel('LBL_N:', $adminLangId) . ' </strong>' . $row['user_name'], true);
                }
                $userDetail = '<br/><strong>' . Labels::getLabel('LBL_Email:', $adminLangId) . ' </strong>' . $row['credential_email'] . '<br/>';
                $td->appendElement('plaintext', array(), $userDetail, true);
                break;
            case 'selprod_price':
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true), true);
                break;
            case 'selprod_available_from':
                $td->appendElement('plaintext', array(), FatDate::format($row[$key], false), true);
                break;
            case 'selprod_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['selprod_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<label class="switch switch-sm switch-icon switch-inline">
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['selprod_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span class="input-helper"></span>
                                    
                                </label>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['selprod_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = ['onclick'=>'editRecord('.$row['selprod_id'].', false, "modal-dialog-vertical-md")'];
                    $data['deleteButton'] = [];
                    
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
