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
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['ratingtype_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['ratingtype_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'ratingtype_type':
                $td->appendElement('plaintext', array(), $types[$row[$key]], true);
                break;
            case 'ratingtype_name':
                $name = array_key_exists('ratingtype_name', $row) && !empty($row[$key]) ? $row[$key] . ' (' . $row['ratingtype_identifier'] . ')' : $row['ratingtype_identifier'];

                if (array_key_exists('ratingtype_active', $row) && applicationConstants::YES == $row['ratingtype_default']) {
                    $name .= ' <span class="badge badge-brand badge-inline badge-pill">' . Labels::getLabel('LBL_DEFAULT', $siteLangId) . '</span>';
                }
                $infoLabel = '';
                switch ($row['ratingtype_id']) {
                    case RatingType::TYPE_PRODUCT:
                        $infoLabel = Labels::getLabel('LBL_PRODUCT_RATING_TYPE_TOOLTIP_INFO', $siteLangId);
                        break;
                    case RatingType::TYPE_SHOP:
                        $infoLabel = Labels::getLabel('LBL_SHOP_RATING_TYPE_TOOLTIP_INFO', $siteLangId);
                        break;
                    case RatingType::TYPE_DELIVERY:
                        $infoLabel = Labels::getLabel('LBL_DELIVERY_RATING_TYPE_TOOLTIP_INFO', $siteLangId);
                        break;
                }
                if (!empty($infoLabel)) {
                    $name .= ' <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-placement="top" title="' . $infoLabel . '"></i>';
                }
                $td->appendElement('plaintext', array(), $name, true);
                break;
            case 'ratingtype_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['ratingtype_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['ratingtype_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span class="input-helper"></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['ratingtype_id']
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
