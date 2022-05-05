<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $moduleId => $moduleName) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $moduleId . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'module':
                $td->appendElement('plaintext', $tdAttr, $moduleName, true);
                break;
            case 'action':
                if ($canView) {
                    $listing = AdminPrivilege::getPermissionArr();
                    $options = '';
                    foreach ($listing as $key => $list) {
                        if (in_array($moduleId, AdminPrivilege::getWriteOnlyPermissionModulesArr()) && $key == AdminPrivilege::PRIVILEGE_READ) {
                            continue;
                        }

                        $checked = '';
                        if (isset($userData[$moduleId]) && !empty($userData[$moduleId]) && $userData[$moduleId]['admperm_value'] == $key) {                           
                            $checked = 'checked';
                        }
                        $options .= '<li>
                            <label class="radio">
                            <input type="radio" name="'.$moduleId.'" value="'.$key .'" '.$checked.' onchange="updatePermission(' . $moduleId . ',this.value)">'.$list.'
                            </label>
                        </li>';
                    }
                     
                    $td->appendElement('plaintext', $tdAttr, '<ul class="list-radio justify-content-end">' . $options . '</ul>', true);
                }
                break;
        }
    }
    $serialNo++;
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
