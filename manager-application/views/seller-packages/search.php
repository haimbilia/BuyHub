<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = count($arrListing);
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    if ($row['spackage_active'] != applicationConstants::ACTIVE) {
        $tr->setAttribute("class", " nodrag nodrop");
    }
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="' . SellerPackages::DB_TBL_PREFIX . 'ids[]" value=' . $row[SellerPackages::DB_TBL_PREFIX . 'id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'spackage_identifier':
                if ($row[SellerPackages::DB_TBL_PREFIX . 'name'] != '') {
                    $td->appendElement('plaintext', array(), $row[SellerPackages::DB_TBL_PREFIX . 'name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'spackage_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row[SellerPackages::DB_TBL_PREFIX . 'id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch--sm switch--icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row[SellerPackages::DB_TBL_PREFIX . 'id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row[SellerPackages::DB_TBL_PREFIX . 'id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                    /* $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "searchPlans(" . $row[SellerPackages::DB_TBL_PREFIX . 'id'] . ")",
                                'title' => Labels::getLabel('LBL_Settings', $adminLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-setting">
                                            </use>
                                        </svg>'
                        ]
                    ]; */
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $serialNo--;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields)
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $adminLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}