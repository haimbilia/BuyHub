<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
        'select_all' => Labels::getLabel('LBL_Select_all', $siteLangId),
        'listserial' => Labels::getLabel('LBL_#', $siteLangId),
        'admin_name' => Labels::getLabel('LBL_Full_Name', $siteLangId),
        'admin_username' => Labels::getLabel('LBL_Username', $siteLangId),
        'admin_email' => Labels::getLabel('LBL_Email', $siteLangId),
        'admin_active' => Labels::getLabel('LBL_Status', $siteLangId),
        'action' => '',
    );

if (!$canEdit) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $e = $th->appendElement('th', array(), $val);
    }
}

$sr_no = $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="admin_ids[]" value=' . $row['admin_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'action':
                if ($canEdit) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Edit', $siteLangId), "onclick" => "editAdminUserForm(" . $row['admin_id'] . ")"), "<i class='far fa-edit icon'></i>", true);

                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Change_Password', $siteLangId), "onclick" => "changePasswordForm(" . $row['admin_id'] . ")"), "<i class='ion-locked icon'></i>", true);

                    if ($row['admin_id'] > 1 && $row['admin_id'] != $adminLoggedInId) {
                        $td->appendElement('a', array('href' => UrlHelper::generateUrl('AdminUsers', 'permissions', array($row['admin_id'])), 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Permissions', $siteLangId)), '<i class="fas fa-gavel"></i>', true);
                    }
                }
                break;
            case 'admin_active':
                if ($row['admin_id'] > 1) {
                    $active = "active";
                    if (!$row['admin_active']) {
                        $active = '';
                    }
                    $statucAct = ($canEdit === true) ? 'toggleStatus(this)' : '';
                    $str = '<label id="' . $row['admin_id'] . '" class="statustab ' . $active . '" onclick="' . $statucAct . '">
                          <span data-off="' . Labels::getLabel('LBL_Active', $siteLangId) . '" data-on="' . Labels::getLabel('LBL_Inactive', $siteLangId) . '" class="switch-labels"></span>
                          <span class="switch-handles"></span>
                        </label>';
                    $td->appendElement('plaintext', array(), $str, true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no--;
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $siteLangId));
}

$frm = new Form('frmAdmUsersListing', array('id' => 'frmAdmUsersListing'));
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('AdminUsers', 'toggleBulkStatuses'));
$frm->addHiddenField('', 'status');

echo $frm->getFormTag();
echo $frm->getFieldHtml('status');
echo $tbl->getHtml(); ?>
</form>
