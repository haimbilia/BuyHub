<div class="delivery-term">
    <div id="catalogToolTip">
    <h2 class="block-title"><?php echo Labels::getLabel('LBL_Sellers_List', $adminLangId); ?></h2>
        <?php $arr_flds = array(
            'listserial'    =>    Labels::getLabel('LBL_#', $adminLangId),
            'user_name' => Labels::getLabel('LBL_Seller_name', $adminLangId),
            'shop_identifier' => Labels::getLabel('LBL_shop_name', $adminLangId),
        );
        $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table--hovered table-responsive'));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $val) {
            $e = $th->appendElement('th', array(), $val);
        }
        $sr_no = 1;
        $allSelData = ($adminShip == false) ? $sellerNameArr : $notSelShipArr;
        foreach ($allSelData as $sn => $row) {
            $tr = $tbl->appendElement('tr');
            foreach ($arr_flds as $key => $val) {
                $td = $tr->appendElement('td');
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', array(), $sr_no++);
                        break;
                    case 'user_name':
                        $td->appendElement('plaintext', array(), $sn, true);
                        break;
                    case 'shop_identifier':
                        $td->appendElement('plaintext', array(), $row, true);
                        break;
                    default:
                        $td->appendElement('plaintext', array(), $row[$key], true);
                        break;
                }
            }
        }
        if (count($allSelData) == 0) {
            $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
        }
        echo $tbl->getHtml(); ?>
    </div>
</div>
