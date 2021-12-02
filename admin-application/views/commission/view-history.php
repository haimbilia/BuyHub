<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="col-sm-12">
    <h1><?php echo Labels::getLabel('LBL_Commission_History', $adminLangId); ?></h1>
    <div class="tabs_nav_container responsive flat">
        <div class="tabs_panel_wrap">
            <div class="tabs_panel">
                <?php
                $arr_flds = array(
                    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
                    'csh_commsetting_prodcat_id' => Labels::getLabel('LBL_Category', $adminLangId),
                    'csh_commsetting_user_id' => Labels::getLabel('LBL_Seller', $adminLangId),
                    'csh_commsetting_product_id' => Labels::getLabel('LBL_Product', $adminLangId),
                    'csh_commsetting_fees' => Labels::getLabel('LBL_Fees_[%]', $adminLangId),
                    'csh_added_on' => Labels::getLabel('LBL_Added_On', $adminLangId),
                );
                $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
                $th = $tbl->appendElement('thead')->appendElement('tr');
                foreach ($arr_flds as $val) {
                    $e = $th->appendElement('th', array(), $val);
                }

                $serialNo = ($page > 1) ? ($page - 1) * $pageSize : 0;
                foreach ($arrListing as $sn => $row) {
                    $serialNo++;
                    $tr = $tbl->appendElement('tr');

                    foreach ($fields as $key => $val) {
                        $td = $tr->appendElement('td');
                        switch ($key) {
                            case 'listSerial':
                                $td->appendElement('plaintext', array(), $serialNo);
                                break;
                            case 'csh_commsetting_prodcat_id':
                                $td->appendElement('plaintext', array(), CommonHelper::displayText($row['prodcat_name']), true);
                                break;
                            case 'csh_commsetting_user_id':
                                $td->appendElement('plaintext', array(), CommonHelper::displayText($row['vendor']), true);
                                break;
                            case 'csh_commsetting_product_id':
                                $td->appendElement('plaintext', array(), CommonHelper::displayText($row['product_name']), true);
                                break;
                            case 'csh_commsetting_added_on':
                                $td->appendElement('plaintext', array(), FatDate::format($row[$key]), true);
                                break;
                            case 'csh_commsetting_fees':
                                $td->appendElement('plaintext', array(), CommonHelper::numberFormat($row[$key]), true);
                                break;
                            default:
                                $td->appendElement('plaintext', array(), CommonHelper::displayText($row[$key]), true);
                                break;
                        }
                    }
                }
                if (count($arrListing) == 0) {
                    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Record_Found', $adminLangId));
                }
                echo $tbl->getHtml();
                $postedData['page'] = $page;
                echo FatUtility::createHiddenFormFromData($postedData, array(
                    'name' => 'frmHistorySearchPaging'
                ));
                $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToHistoryPage', 'adminLangId' => $adminLangId);
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
                ?>
            </div>
        </div>
    </div>
</div>