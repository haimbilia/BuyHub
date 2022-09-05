<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="js-scrollable table-wrap table-responsive">
    <?php
    $arr_flds = array(
        'listserial' => Labels::getLabel('LBL_#', $siteLangId),
        'ppoint_title' => Labels::getLabel('LBL_Policy', $siteLangId),
        'action' => '',
    );
    $tableClass = '';
    if (0 < count($arrListing)) {
        $tableClass = "table-justified";
    }
    $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table ' . $tableClass));

    $th = $tbl->appendElement('thead')->appendElement('tr');
    foreach ($arr_flds as $val) {
        $e = $th->appendElement('th', array(), $val);
    }

    $sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
    foreach ($arrListing as $sn => $row) {
        $sr_no++;
        $tr = $tbl->appendElement('tr');
        if ($row['ppoint_active'] != applicationConstants::ACTIVE) {
            $tr->setAttribute("class", "fat-inactive");
        }
        foreach ($arr_flds as $key => $val) {
            $td = $tr->appendElement('td');
            switch ($key) {
                case 'listserial':
                    $td->appendElement('plaintext', array(), $sr_no);
                    break;
                case 'ppoint_identifier':
                    if (!empty($row['ppoint_title'])) {
                        $td->appendElement('plaintext', array(), $row['ppoint_title'] . '<br/>(' . $row['ppoint_identifier'] . ')', true);
                    } else {
                        $td->appendElement('plaintext', array(), $row['ppoint_identifier'], true);
                    }
                    break;
                case 'action':
                    $attributes = ($row['sppolicy_ppoint_id']) ? "checked" : "";
                    $fn = (!$row['sppolicy_ppoint_id']) ? 'addPolicyPoint(' . $selprod_id . "," . $row['ppoint_id'] . ')' : 'removePolicyPoint(' . $selprod_id . "," . $row['ppoint_id'] . ')';

                    $attributes .= ' onclick="' . $fn . '"';
                    $str = HtmlHelper::configureSwitchForCheckboxStatic('', $row['ppoint_id'], $attributes);
                    $td->appendElement('plaintext', array(), $str, true);

                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
    }
    echo $tbl->getHtml();
    if (count($arrListing) == 0) {
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    } ?>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmPolicyToLinkSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToNextPolicyToLinkPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
