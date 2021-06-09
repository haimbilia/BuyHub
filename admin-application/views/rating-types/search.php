<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'ratingtype_name' => Labels::getLabel('LBL_RATING_TYPE', $adminLangId),
    'ratingtype_type' => Labels::getLabel('LBL_TYPE', $adminLangId),
    'ratingtype_active' => Labels::getLabel('LBL_STATUS', $adminLangId),
    'action' => '',
);

if (!$canEdit) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table--hovered table-responsive'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}

$sr_no = 1;
foreach ($arr_listing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                if ($row['ratingtype_id'] != RatingType::TYPE_PRODUCT) {
                    $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="ratingtypeIds[]" value=' . $row['ratingtype_id'] . '><i class="input-helper"></i></label>', true);
                }
                break;
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case 'ratingtype_type':
                $td->appendElement('plaintext', array(), $types[$row[$key]], true);
                break;
            case 'ratingtype_name':
                $name = array_key_exists('ratingtype_name', $row) && !empty($row[$key]) ? $row[$key]  . ' (' . $row['ratingtype_identifier'] . ')' : $row['ratingtype_identifier'];

                if (array_key_exists('ratingtype_active', $row) && applicationConstants::YES == $row['ratingtype_default']) {
                    $name .= ' <span class="badge badge--unified-brand badge--inline badge--pill">' . Labels::getLabel('LBL_DEFAULT', $adminLangId) . '</span>';
                }
                $infoLabel = '';
                switch($row['ratingtype_id']){
                    case RatingType::TYPE_PRODUCT:
                        $infoLabel = Labels::getLabel('LBL_PRODUCT_RATING_TYPE_TOOLTIP_INFO', $adminLangId); 
                    break;
                    case RatingType::TYPE_SHOP:
                        $infoLabel = Labels::getLabel('LBL_SHOP_RATING_TYPE_TOOLTIP_INFO', $adminLangId); 
                    break;
                    case RatingType::TYPE_DELIVERY:
                        $infoLabel = Labels::getLabel('LBL_DELIVERY_RATING_TYPE_TOOLTIP_INFO', $adminLangId);
                    break;
                }
                if(!empty($infoLabel)){
                    $name .=' <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="'.$infoLabel.'"></i>';
                } 

                $td->appendElement('plaintext', array(), $name, true);
                break;
            case 'ratingtype_active':
                if ($row['ratingtype_id'] != RatingType::TYPE_PRODUCT) {
                    $active = "";
                    if (applicationConstants::ACTIVE == $row['ratingtype_active']) {
                        $active = 'checked';
                    }
                    
                    $statusClass = ($canEdit === false) ? 'disabled' : '';
                    $str = '<label class="statustab -txt-uppercase">
                            <input ' . $active . ' type="checkbox" id="switch' . $row['ratingtype_id'] . '" value="' . $row['ratingtype_id'] . '" onclick="toggleStatus(event,this,' . (int) !(applicationConstants::ACTIVE == $row['ratingtype_active']) . ')" class="switch-labels"/>
                            <i class="switch-handles ' . $statusClass . '"></i>';
                } else {
                    $str = Labels::getLabel('LBL_N/A', $adminLangId);
                }
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'action':
                if ($canEdit) {
                    $function = "ratingTypesForm(" . $row['ratingtype_id'] . ")";
                    if (in_array($row['ratingtype_id'], $restrictTypes)) {
                        $function = "ratingTypesLangForm(" . $row['ratingtype_id'] . "," . $adminLangId . ");";
                    }
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Edit', $adminLangId), "onclick" => $function), "<i class='far fa-edit icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', array(), Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no++;
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmRatingTypesSearch', array('id' => 'frmRatingTypesSearch'));
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('RatingTypes', 'toggleBulkStatuses'));
$frm->addHiddenField('', 'status');

echo $frm->getFormTag();
echo $frm->getFieldHtml('status');
echo $tbl->getHtml(); ?>
</form>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmRatingTypesSrchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
