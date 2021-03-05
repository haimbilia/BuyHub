<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => '#',   
    'plugin_identifier' => Labels::getLabel('LBL_PLUGIN', $siteLangId),
    'ps_active' => Labels::getLabel('LBL_Status', $siteLangId),
);
if ($canEdit) {
    $arr_flds = array_merge($arr_flds, array('action' => ''));
}

$tableClass = '';
if (0 < count($arr_listing)) {
    $tableClass = "table-justified";
}

$tbl = new HtmlElement(
        'table',
        array('width' => '100%', 'class' => 'table ' . $tableClass, 'id' => 'options')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i>' . $val . '</label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}

$sr_no = 0;
foreach ($arr_listing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['plugin_id']);

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'plugin_identifier':
                $htm = '';
                if (!empty($defaultPluginId) && $row['plugin_id'] == $defaultPluginId) {
                    $htm = ' <span class="badge badge--unified-brand badge--inline badge--pill">' . Labels::getLabel('LBL_DEFAULT', $siteLangId) . '</span>';
                }

                if (!empty($row['plugin_name'])) {
                    $td->appendElement('plaintext', array(), $row['plugin_name'] . $htm, true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key] . $htm, true);
                }
                break;
            case 'ps_active':
                $active = "";
                if (applicationConstants::ACTIVE == $row['ps_active']) {
                    $active = 'checked';
                }
                $str = '<label class="toggle-switch" for="switch' . $row['plugin_id'] . '"><input ' . $active . ' type="checkbox" value="' . $row['plugin_id'] . '" id="switch' . $row['plugin_id'] . '" onclick="toggleStatus(this,' . ($row['plugin_active'] > 0 ? 0 : 1) . ')"/><div class="slider round"></div></label>';

                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class" => "actions"));
                $li = $ul->appendElement("li");
                $li->appendElement(
                        'a',
                        array(
                            'href' => 'javascript:void(0)',
                            'class' => 'button small green', 'title' => Labels::getLabel('LBL_Edit', $siteLangId),
                            "onclick" => "editSettingForm('" . $row['plugin_code'] . "')"),
                        '<i class="fa fa-edit"></i>',
                        true
                );

                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
echo $tbl->getHtml();
if (count($arr_listing) == 0) {
    $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
}
?>

