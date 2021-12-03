<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$fields = array(
    'user' => Labels::getLabel('LBL_USER', $siteLangId),
    'orrmsg_date' => Labels::getLabel('LBL_DATE', $siteLangId),
    'orrmsg_msg' => Labels::getLabel('LBL_COMMENT', $siteLangId)
);

if (1 > $rowsOnly) {
    $tbl = new HtmlElement('table', ['class' => 'table']);
    $thead = $tbl->appendElement('thead', ['class' => 'tableHeadJs'])->appendElement('tr');
    $tbody = $tbl->appendElement('tbody');
    /* Headings */
    foreach ($fields as $key => $val) {
        $td = $thead->appendElement('th', ['data-field' => $key]);
        $td->appendElement('span')->appendElement('plaintext', [], $val, true);
    }
} else {
    $tbody = new HtmlElement('tbody');
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($messagesList as $sn => $row) {
    /* Body */
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'user':
                $img = '<img width="40" height="40" title="' . $row['msg_user_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'User', array($row['orrmsg_from_user_id'], 'THUMB', 1), CONF_WEBROOT_FRONT_URL) . '" alt = "' . $row['msg_user_name'] . '" >';
                
                $name = '<a class="user-profile_title" href="javascript:void(0)" onclick="redirectUser(' . $row['orrmsg_from_user_id'] . ')">' . $row['msg_user_name'] . ' (' . $row['msg_username'] . ')</a>';
                $email = $row['msg_user_email'];

                if ($row['orrmsg_from_admin_id']) {
                    $name = $row['admin_name'] . ' (' . $row['admin_username'] . ')';
                    $email = $row['admin_email'];
                    $img = '<img width="40" height="40" title="' . $row['admin_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'siteAdminLogo', array($siteLangId)) . '" alt = "' . $row['admin_name'] . '" >';
                }

                $html = '<div class="user-profile">
                            <figure class="user-profile_photo">
                                ' . $img . '
                            </figure>
                            <div class="user-profile_data">
                                ' . $name . '
                                <span class="text-muted fw-bold">' .$email . '</span>
                            </div>
                        </div>';
                $td->appendElement('plaintext', [], $html, true);
                break;
            case 'orrmsg_date':
                $td->appendElement('plaintext', [], HtmlHelper::formatDateTime($row['orrmsg_date'], true), true);
                break;
            case 'orrmsg_msg':
                $data = ['siteLangId' => $siteLangId];

                if ($canEdit) {
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'title' => Labels::getLabel('MSG_CLICK_TO_VIEW_COMMENTS', $siteLangId),
                                'data-toggle' => 'modal',
                                'data-target' => '#modal' . $row['orrmsg_id']
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#comment">
                                            </use>
                                        </svg>'
                        ]
                    ];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $modalHtml = HtmlHelper::getModalStructure("modal" . $row['orrmsg_id'], Labels::getLabel('LBL_COMMENT', $siteLangId), nl2br($row['orrmsg_msg']));
                $td->appendElement('plaintext', [], $modalHtml . $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
        }
    }

    $serialNo++;
}

if (count($messagesList) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
} else if (1 > $rowsOnly) {
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmRecordSearchPaging'));
}

if (1 > $rowsOnly) {
    echo $tbl->getHtml();
} else {
    echo $tbody->getHtml();
}