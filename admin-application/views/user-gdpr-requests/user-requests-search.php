<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
    'user' => Labels::getLabel('LBL_User', $adminLangId),
    'ureq_type'    => Labels::getLabel('LBL_Request_Type', $adminLangId),
    'ureq_date' => Labels::getLabel('LBL_Request_Date', $adminLangId),
    'ureq_status'    => Labels::getLabel('LBL_Request_Status', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array());

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'user':
                $userDetail = '<strong>' . Labels::getLabel('LBL_N:', $adminLangId) . ' </strong>' . $row['user_name'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_UN:', $adminLangId) . ' </strong>' . $row['credential_username'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_Email:', $adminLangId) . ' </strong>' . $row['credential_email'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_User_ID:', $adminLangId) . ' </strong>' . $row['user_id'] . '<br/>';
                $td->appendElement('plaintext', array(), $userDetail, true);
                break;
            case 'ureq_date':
                $td->appendElement('plaintext', array(), FatDate::format(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                ));
                break;
            case 'ureq_type':

                $str = $userRequestTypeArr[UserGdprRequest::TYPE_DATA_REQUEST];
                if ($row['ureq_type'] == UserGdprRequest::TYPE_TRUNCATE) {
                    $str = $userRequestTypeArr[UserGdprRequest::TYPE_TRUNCATE];
                }

                $td->appendElement('plaintext', array(), $str, true);

                break;
            case 'ureq_status':
                $str = $userRequestStatusArr[UserGdprRequest::STATUS_PENDING];
                if ($row['ureq_status'] == UserGdprRequest::STATUS_COMPLETE) {
                    $str = $userRequestStatusArr[UserGdprRequest::STATUS_COMPLETE];
                }

                $td->appendElement('plaintext', array(), $str, true);

                break;
            case 'action':
                if ($canEdit) {
                    if ($row['ureq_status'] == UserGdprRequest::STATUS_PENDING) {
                        $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_COMPLETE', $adminLangId), "onclick" => "updateRequestStatus(" . $row['ureq_id'] . "," . UserGdprRequest::STATUS_COMPLETE . ")"), "<i class='far fa-calendar-check'></i>", true);

                        if ($row['ureq_type'] == UserGdprRequest::TYPE_TRUNCATE) {
                            $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Truncate_User_Data', $adminLangId), "onclick" => "truncateUserData(" . $row['user_id'] . "," . $row['ureq_id'] . ")"), "<i class='fas fa-user-times'></i>", true);                            
                        }

                        if( $row['ureq_type'] == UserGdprRequest::TYPE_DATA_REQUEST ){

                            $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_View', $adminLangId), "onclick" => "viewRequestPurpose(" . $row['ureq_id'] . ")"), "<i class='far fa-eye icon'></i>", true);
                            
                        }

                        

                        /* $innerLi=$innerUl->appendElement('li');
						$innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Delete_Request',$adminLangId),"onclick"=>"deleteUserRequest(".$row['ureq_id'].")"),Labels::getLabel('LBL_Delete_Request',$adminLangId), true); */
                    } else {
                        $td->appendElement('plaintext', array(), Labels::getLabel('MSG_N/A', $adminLangId), true);
                    }
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
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}
echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmUserSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>