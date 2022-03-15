<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
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
                $str = $this->includeTemplate('_partial/product/product-info-card.php', ['selProdId' => $selProdId, 'siteLangId' => $siteLangId,'shopName'=>$row['shop_name']], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'selprod_price':
                $price = CommonHelper::displayMoneyFormat($row[$key], true, true);
                $td->appendElement('plaintext', $tdAttr, $price, true);
                break;
            case 'splprice_start_date':
            case 'splprice_end_date':
                $date = date('Y-m-d', strtotime($row[$key]));
                $fldAttr = array(
                    'placeholder' => $val,
                    'readonly' => 'readonly',
                    'class' => 'field--calender inputDateJs hide',
                    'name' => $key,
                    'data-selprod-id' => $selProdId,
                    'data-price' => $row['selprod_price'],
                    'data-id' => $splPriceId,
                    'data-value' => $date,
                    'data-formated-value' => $date,
                );

                $attr = ['class' => 'dateJs contenteditable click-to-edit', 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Labels::getLabel('LBL_CLICK_TO_EDIT', $siteLangId)];
                $td->appendElement('div', $attr, $date, true);
                $editListingFrm->addDateField($val, $key, $date, $fldAttr);
                $td->appendElement('plaintext', array(), $editListingFrm->getFieldHtml($key), true);
                break;
            case 'splprice_price':
                $editable = $canEdit ? 'true' : 'false';
                $div = $td->appendElement('div', ['class' => 'edit-price']);
                $splPrice = CommonHelper::displayMoneyFormat($row[$key], true, true);

                $div->appendElement('div', [
                    "class" => 'click-to-edit',
                    'name' => $key,
                    'data-selprod-id' => $selProdId,
                    'data-price' => $row['selprod_price'],
                    'data-id' => $splPriceId,
                    'data-value' => $row[$key],
                    'data-formated-value' => $splPrice,
                    'contentEditable' => $editable,
                    'data-bs-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'onblur' => 'updateValues(this)',
                    'onfocus' => 'showOrignal(this)',
                    'title' => Labels::getLabel('LBL_CLICK_TO_EDIT', $siteLangId)
                ], $splPrice, true);
                if ($row['selprod_price'] > $row[$key]) {
                    $discountPrice = $row['selprod_price'] - $row[$key];
                    $discountPercentage = round(($discountPrice / $row['selprod_price']) * 100, 2);
                    $discountPercentage = $discountPercentage . "% " . Labels::getLabel('LBL_off', $siteLangId);
                    $div->appendElement('div', array("class" => 'percentValJs badge badge-success'), $discountPercentage, true);
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

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
