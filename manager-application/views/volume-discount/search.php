<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $volDiscountId = $row['voldiscount_id'];
    $selProdId = $row['selprod_id'];

    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    $tr->setAttribute('id', $volDiscountId);

    $editListingFrm = new Form('editListingFrm-' . $volDiscountId, array('id' => 'editListingFrm-' . $volDiscountId));
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="selprod_ids[]" value=' . $volDiscountId . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'product_name':
                $str = $this->includeTemplate('_partial/product/product-info-card.php', ['selProdId' => $selProdId, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'credential_username':
                $href = "javascript:void(0)";
                $onclick = 'redirectUser(' . $row['user_id'] . ')';
                $str = $this->includeTemplate('_partial/user/user-info-card.php', [
                    'user' => $row,
                    'extraClass' => 'user-profile-sm',
                    'displayEmail' => false,
                    'userTitleClass' => 'text-muted',
                    'siteLangId' => $siteLangId,
                    'href' => $href,
                    'onclick' => $onclick,
                ], false, true);
                $td->appendElement('plaintext', array(), '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'voldiscount_min_qty':
            case 'voldiscount_percentage':
                $div = $td->appendElement('div', ['class' => 'text-nowrap d-flex']);
                $input = '<input type="text" data-id="' . $volDiscountId . '" value="' . $row[$key] . '" data-selprodid="' . $selProdId . '" name="' . $key . '" class="volDiscountColJs hide vd-input" data-oldval="' . $row[$key] . '"/>';
                $div->appendElement('div', array("class" => 'editColJs', "data-bs-toggle" => "tooltip", "data-placement" => "top", "title" => Labels::getLabel('LBL_Click_To_Edit', $siteLangId)), $row[$key], true);
                $div->appendElement('plaintext', array(), $input, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $volDiscountId
                ];

                if ($canEdit) {
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
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
