<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
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
                $disabled = $class = "";
                if ($row['ratingtype_id'] == RatingType::TYPE_PRODUCT) {
                    $class = 'disabled';
                    $disabled = "disabled='disabled'";
                }
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs ' . $class . '" type="checkbox" ' . $disabled . ' name="record_ids[]" value=' . $row['ratingtype_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'ratingtype_type':
                $txt = $types[$row[$key]] ?? '';
                $td->appendElement('plaintext', array(), $txt, true);
                break;
            case 'ratingtype_name':
                $name = $row[$key];
                if (array_key_exists('ratingtype_active', $row) && applicationConstants::YES == $row['ratingtype_default']) {
                    $name .= HtmlHelper::getStatusHtml(HtmlHelper::INFO, Labels::getLabel('LBL_DEFAULT', $siteLangId));
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
                $title = ($row['ratingtype_id'] == RatingType::TYPE_PRODUCT) ? Labels::getLabel('LBL_PRODUCT_RATING_TYPE_TOOLTIP_INFO', $siteLangId) : '';
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['ratingtype_id'], $row[$key], (!$canEdit || $row['ratingtype_id'] == RatingType::TYPE_PRODUCT), $title);
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

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
