<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$theDay = '';
$count = 1;
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['utxn_date'], $siteLangId);
    if ($theDay != $headTitle) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        }
?>
        <div class="rowJs" data-reference="<?php echo date('Y-m-d', strtotime($row['utxn_date'])); ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items ulJs">
            <?php } ?>
            <?php
            $credit = FatUtility::float($row['utxn_credit']);
            $debit = FatUtility::float($row['utxn_debit']);
            $amt = ((!empty($credit) && $credit > 0) ? $credit : $debit);
            $amtClass = ((!empty($credit) && $credit > 0) ? 'badge badge-success' : 'badge badge-danger');
            $amtLiClass = ((!empty($credit) && $credit > 0) ? 'plus' : 'minus');
            $amtType = ((!empty($row['utxn_credit']) && $row['utxn_credit'] > 0) ? Labels::getLabel('LBL_CREDIT', $siteLangId) : Labels::getLabel('LBL_DEBIT', $siteLangId));
            ?>
            <li class="timeline-v4__item  <?php echo $amtLiClass; ?>">
                <div class="d-flex justify-content-between">
                    <span class=" <?php echo $amtClass; ?>">
                        <?php
                        echo CommonHelper::displayMoneyFormat($amt, true);
                        ?>
                    </span>
                    <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['utxn_date'])); ?></span>

                </div>

                <div class="timeline-v4__item-desc">
                    <ul class="list-stats list-stats-double mt-4">
                        <li class="list-stats-item "><span class="lable"><?php echo Labels::getLabel('LBL_Transaction_Id', $siteLangId); ?></span> <span class="value"><?php echo CommonHelper::displayText($row['utxn_id']); ?></span></li>
                        <li class="list-stats-item"><span class="lable"><?php echo Labels::getLabel('LBL_Transaction_TYPE', $siteLangId); ?></span> <span class="value"><?php echo $amtType; ?></span></li>
                        <li class="list-stats-item list-stats-item-full"><span class="lable"><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></span> <span class="value"><?php echo CommonHelper::displayText(ucfirst($row['utxn_comments'])); ?></span></li>
                    </ul>
                </div>
            </li>
        <?php
        if (count($arrListing) == $count) {
            echo '</ul></div>';
        }
        $count++;
    }
        ?>