<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
//CommonHelper::printArray($arrListing,1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $splPriceId = $row['splprice_id'];
    $selProdId = $row['selprod_id'];
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    $tr->setAttribute('id', $splPriceId);

    $editListingFrm = new Form('editListingFrm-' . $splPriceId, array('id' => 'editListingFrm-' . $splPriceId));
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="selprod_ids[]" value=' . $splPriceId . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'product_name':
                $str = $this->includeTemplate('_partial/product/product-info-card.php', ['selProdId' => $selProdId, 'siteLangId' => $siteLangId, 'sellerName' => $row['credential_username']], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'selprod_price':
                $price = CommonHelper::displayMoneyFormat($row[$key], true, true);
                $td->appendElement('plaintext', $tdAttr, $price, true);
                break;
            case 'credential_username':
                $href = "javascript:void(0)";
                $onclick = 'redirectUser(' . $row['user_id'] . ')';
                $str = $this->includeTemplate('_partial/user/user-info-card.php', [
                    'user' => $row,
                    'siteLangId' => $siteLangId,
                    'href' => $href,
                    'onclick' => $onclick,
                ], false, true);
                $td->appendElement('plaintext', array(), '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'splprice_start_date':
            case 'splprice_end_date':
                $date = date('Y-m-d', strtotime($row[$key]));
                $attr = array(
                    'readonly' => 'readonly',
                    'placeholder' => $val,
                    'data-selprodid' => $selProdId,
                    'data-id' => $splPriceId,
                    'data-oldval' => $date,
                    'data-price' => $row['selprod_price'],
                    'id' => $key . '-' . $splPriceId,
                    'class' => 'dateJs splPriceColJs hide sp-input',
                );
                $editListingFrm->addDateField($val, $key, $date, $attr);
                $td->appendElement('div', array("class" => 'editColJs contenteditable', "contenteditable" => "true", "data-bs-toggle" => "tooltip", "data-bs-toggle" => "tooltip", "data-placement" => "top", "title" => Labels::getLabel('LBL_Click_To_Edit', $siteLangId)), $date, true);
                $td->appendElement('plaintext', $tdAttr, $editListingFrm->getFieldHtml($key), true);
                break;
            case 'splprice_price':
                $input = '<input type="text" data-price="' . $row['selprod_price'] . '" data-id="' . $splPriceId . '" value="' . $row[$key] . '" data-selprodid="' . $selProdId . '" name="' . $key . '" data-oldval="' . $row[$key] . '" data-displayoldval="' . CommonHelper::displayMoneyFormat($row[$key], true, true) . '" class="splPriceColJs hide sp-input"/>';
                $td->appendElement('div', array("class" => 'editColJs contenteditable', "contenteditable" => "true", "data-bs-toggle" => "tooltip", "data-placement" => "top", "title" => Labels::getLabel('LBL_Click_To_Edit', $siteLangId)), CommonHelper::displayMoneyFormat($row[$key], true, true), true);
                $td->appendElement('plaintext', $tdAttr, $input, true);
                if ($row['selprod_price'] > $row[$key]) {
                    $discountPrice = $row['selprod_price'] - $row[$key];
                    $discountPercentage = round(($discountPrice / $row['selprod_price']) * 100, 2);
                    $discountPercentage = $discountPercentage . "% " . Labels::getLabel('LBL_off', $siteLangId);
                    $td->appendElement('div', array("class" => 'ml-3 percentValJs'), $discountPercentage, true);
                }
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $splPriceId
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
