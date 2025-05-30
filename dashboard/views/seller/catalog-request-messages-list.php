<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="js-scrollable table-wrap table-responsive">
    <?php
    $arr_flds = array(
        'image' => '',
        'detail' => ''
    );
    $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
    $th = $tbl->appendElement('thead')->appendElement('tr');
    /* foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
} */
    $sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
    foreach ($messagesList as $sn => $row) {

        $sr_no++;
        $tr = $tbl->appendElement('tr');

        foreach ($arr_flds as $key => $val) {
            $td = $tr->appendElement('td');
            switch ($key) {
                case 'image':
                    $td->setAttribute('width', '20%');
                    $img = '<img title="' . $row['msg_user_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'User', array($row['scatrequestmsg_from_user_id'], ImageDimension::VIEW_THUMB, 1), CONF_WEBROOT_FRONTEND) . '" alt = "' . $row['msg_user_name'] . '" >';

                    if ($row['scatrequestmsg_from_admin_id']) {
                        $img = '<img title="' . $row['admin_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONTEND) . '" alt = "' . $row['admin_name'] . '" >';
                    }

                    $td->appendElement('plaintext', array(), $img, true);
                    break;
                case 'detail':
                    $txt = FatDate::format($row['scatrequestmsg_date'], true);

                    if ($row['scatrequestmsg_from_admin_id']) {
                        $txt .= '<br/>' . $row['admin_name'] . ' (' . $row['admin_username'] . ')';
                        $txt .= '<br/>' . $row['admin_email'];
                    } else {
                        $txt .= '<br/>' . $row['msg_user_name'] . ' (' . $row['msg_username'] . ')';
                        $txt .= '<br/>' . $row['msg_user_email'];
                    }

                    if ($row['scatrequestmsg_msg'] != '') {
                        $txt .= '<br/><strong>Comment: </strong>' . nl2br($row['scatrequestmsg_msg']);
                    }
                    $td->appendElement('plaintext', array(), $txt, true);
                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
    }
    echo $tbl->getHtml();
    if (count($messagesList) == 0) {
        $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No messages found');
    } else {
        $postedData['page'] = $page;
        echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmCatalogRequestMsgsSrchPaging'));
    } ?>
</div>