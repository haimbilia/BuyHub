<?php
defined('SYSTEM_INIT') or die('Invalid Usage.'); 
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_Sellers_List', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <?php
        $totalRecords = count($arrListing);
        if ($totalRecords == 0) {
            $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId));
        } else {
            ?>
            <div class="timeline-v4 ">
                <?php
                $arr_flds = array(
                    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
                    'user_name' => Labels::getLabel('LBL_Seller_name', $siteLangId),
                    'shop_identifier' => Labels::getLabel('LBL_shop_name', $siteLangId),
                );
                $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table--hovered table-responsive appendRowsJs'));
                $th = $tbl->appendElement('thead')->appendElement('tr');
                foreach ($arr_flds as $key=>$val) {
                    $width = ($key == 'listSerial') ? '10%' : '45%';
                    $e = $th->appendElement('th', array(), $val);
                }
                $serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
                foreach ($arrListing as $sn => $row) {
                    $serialNo++;
                    $tr = $tbl->appendElement('tr');
                    foreach ($arr_flds as $key => $val) {
                        $td = $tr->appendElement('td');
                        switch ($key) {
                            case 'listSerial':
                                $td->appendElement('plaintext', array(), $serialNo);
                                break;
                            case 'user_name':
                                $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectUser(' . $row['user_id'] . ')'), $row[$key]);
                                break;
                            case 'shop_identifier':
                                $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectToShop(' . $row['shop_id'] . ')'), $row[$key]);
                                break;
                            default:
                                $td->appendElement('plaintext', array(), $row[$key], true);
                                break;
                        }
                    }
                }
                if (count($arrListing) == 0) {
                    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $siteLangId));
                }
                echo $tbl->getHtml();
                ?>
            </div>
            <?php
            $lastRecord = current(array_reverse($arrListing));
            $data = [
                'siteLangId' => $siteLangId,
                'postedData' => $postedData,
                'page' => $page,
                'pageCount' => $pageCount,
            ];
            $this->includeTemplate('_partial/load-more-pagination.php', $data);
        }
        ?>
    </div>
</div> 