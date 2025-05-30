<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php
        if ($fbLoginUrl != '') {
            $msg = Labels::getLabel("LBL_Please_authenticate_your_account", $siteLangId);
            $msg .= ' <a href="' . $fbLoginUrl . '">' . Labels::getLabel("LBL_Click_here_to_authenticate", $siteLangId) . '</a>';
            echo $msg;
        }

        if (!empty($friendList)) { ?>
            <div class="btn-group">
                <a href="javascript:void(0);" onclick="shareAndEarn(<?php echo $selprod_id; ?>);" class="btn btn-outline-gray btn-sm"><?php echo Labels::getLabel("LBL_Share_and_Earn", $siteLangId) ?></a>
            </div>
        <?php $arr_flds = array(
                'sn' => Labels::getLabel('LBL_S.No', $siteLangId),
                'name' => Labels::getLabel('LBL_Name', $siteLangId),
                'id' => Labels::getLabel('LBL_Select', $siteLangId),
            );
            $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
            $th = $tbl->appendElement('thead')->appendElement('tr');
            foreach ($arr_flds as $val) {
                $e = $th->appendElement('th', array(), $val);
            }

            $sr_no = 0;
            foreach ($friendList as $list) {
                $sr_no++;
                $tr = $tbl->appendElement('tr', array('class' => ''));

                foreach ($arr_flds as $key => $val) {
                    $td = $tr->appendElement('td');

                    switch ($key) {
                        case 'sn':
                            $td->appendElement('plaintext', array(), $sr_no, true);
                            break;
                        case 'id':
                            $td->appendElement('plaintext', array(), '<input type="checkbox" class="shareEarn-Js" name="friends[]" value="' . $list['id'] . '">', true);
                            break;
                        case 'name':
                            $td->appendElement('plaintext', array(), $list['name'], true);
                            break;
                    }
                }
            }
            echo $tbl->getHtml();
        }
        ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>