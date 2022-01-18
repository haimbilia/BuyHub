<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
    'prodcat_identifier' => Labels::getLabel('LBL_Identifier_Name', $siteLangId),
    'prodcat_active' => Labels::getLabel('LBL_Active', $siteLangId),
    'child_count' => Labels::getLabel('LBL_Subcategories', $siteLangId),
    'action' => Labels::getLabel('LBL_Action', $siteLangId),
);
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive table-scrollable js-scrollable', 'id' => 'prodcat'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['prodcat_id']);

    if ($row['prodcat_active'] == 0) {
        $tr->setAttribute("class", "inactive-tr");
    }
    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'prodcat_active':
                $active = "";
                if ($row['prodcat_active']) {
                    $active = 'checked';
                }
                $statucAct = ($canEdit === true) ? 'toggleStatus(event,this)' : '';
                $str = '<div class="checkbox-switch"><input ' . $active . ' type="checkbox" id="switch' . $row['prodcat_id'] . '" value="' . $row['prodcat_id'] . '" onclick="' . $statucAct . '"/><label for="switch' . $row['prodcat_id'] . '">Toggle</label></div>';
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'child_count':
                if ($row[$key] == 0) {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                } else {
                    $td->appendElement('a', array('href' => UrlHelper::generateUrl('ProductCategories', 'index', array($row['prodcat_id'])), 'title' => Labels::getLabel('LBL_View_Categories', $siteLangId)), $row[$key]);
                }
                break;

            case 'action':
                $ul = $td->appendElement("ul", array("class" => "actions"));
                if ($canEdit) {
                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => UrlHelper::generateUrl('ProductCategories', 'form', array('general', $row['prodcat_id'])), 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Edit', $siteLangId), "onclick" => "editRecord(" . $row['prodcat_id'] . ")"), '<i class="far fa-edit icon"></i>', true);

                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => "javascript:;", 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Delete', $siteLangId), "onclick" => "deleteRecord(" . $row['prodcat_id'] . ")"), '<i class="fa fa-trash  icon"></i>', true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $serialNo++;
}
if (count($arrListing) == 0) {
    $img = '<div class="not-found">
                <img width="100" src="' . CONF_WEBROOT_URL . 'images/retina/no-data-cuate.svg" alt="">
                <h3>' . Labels::getLabel('MSG_SORRY,_NO_RESULT_FOUND_:(') . '</h3>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae amet </p>
            </div>';
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds),
    'class' => 'noRecordFoundJs'), $img, true);
}
echo $tbl->getHtml();

echo isset($pagination) ? html_entity_decode($pagination) : '';
?>
<script>
    $(document).ready(function() {
        var pcat_id = $('#prodcat_parent').val();
        $('#prodcat').tableDnD({
            onDrop: function(table, row) {
                fcom.displayProcessing();
                var order = $.tableDnD.serialize('id');
                order += '&pcat_id=' + pcat_id;
                fcom.ajax(fcom.makeUrl('productCategories', 'update_order'), order, function(res) {
                    $.ykmsg.close();
                    var ans = JSON.parse(res);
                    if (ans.status == 1) {
                        $.ykmsg.success(ans.msg);
                    } else {
                        $.ykmsg.error(ans.msg);
                    }
                });
            }
        });
    });
</script>