<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

foreach ($arrListing as $sn => $row) {
    $serialNo = ($sn + 1);
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['collection_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'dragdrop':
                $td->appendElement('plaintext', $tdAttr, '<svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#drag">
                                                            </use>
                                                        </svg>', true);
                break;
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="collection_ids[]" value='.$row['collection_id'].'><i class="input-helper"></i></label>', true);
                break;
            case 'collection_name':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
            case 'collection_type':
                $td->appendElement('plaintext', $tdAttr, Collections::getTypeArr($siteLangId)[$row[$key]]);
                break;
            case 'collection_layout_type':
                $td->appendElement('plaintext', $tdAttr, '<div class="layout-type"><svg class="svg" width="50" height="30">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-layout.svg#collection-layout-'.$row[$key].'">
                </use>
            </svg></div>', true);
                //$td->appendElement('plaintext', $tdAttr, Collections::getLayoutTypeArr($siteLangId)[$row[$key]]);
                break;

            case 'collection_active':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['collection_id'], $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['collection_id']
                ];
                if ($canEdit) {
                    $data['editButton'] = [
                        'onclick' => 'collectionForm(' . $row['collection_type'] . ', ' . $row['collection_layout_type'] . ', ' . $row['collection_id'] . ');'
                    ];
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