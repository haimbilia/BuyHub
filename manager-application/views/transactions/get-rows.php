<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$theDay = '';
$count = 1;
$lastDate = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['utxn_date'], $siteLangId);
    $canAddHead = (empty($lastDate) || (!empty($lastDate) && $lastDate != date('Y-m-d', strtotime($row['utxn_date']))));
    if ($theDay != $headTitle && $canAddHead) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        }
?>
        <div class="rowJs" data-reference="<?php echo $row['utxn_date']; ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items">
            <?php } ?>

            <li class="timeline-v4__item minus">
                <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['utxn_date'])); ?></span>
                <div class="timeline-v4__item-desc">
                    <span class="timeline-v4__item-text text-danger">
                        <span class="tag">
                            <?php
                            $credit = FatUtility::float($row['utxn_credit']);
                            $debit = FatUtility::float($row['utxn_debit']);
                            $amt = ((!empty($credit) && $credit > 0) ? $credit : $debit);
                            $amtType = ((!empty($row['utxn_credit']) && $row['utxn_credit'] > 0) ? Labels::getLabel('LBL_CREDIT', $siteLangId) : Labels::getLabel('LBL_DEBIT', $siteLangId));
                            echo CommonHelper::displayMoneyFormat($amt, true);
                            ?> (<?php echo $amtType; ?>)</span>
                    </span>
                    <span class="timeline-v4__item-text">
                        <strong><?php echo Labels::getLabel('LBL_Transaction_Id', $siteLangId); ?></strong> : <?php echo CommonHelper::displayText($row['utxn_id']); ?>
                    </span>
                    <span class="timeline-v4__item-textarea">
                        <strong><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></strong> : <?php echo CommonHelper::displayText(ucfirst($row['utxn_comments'])); ?>
                    </span>
                </div>
            </li>
        <?php
        if (count($arrListing) == $count && $canAddHead) {
            echo '</ul></div>';
        }
        $count++;
    }
        ?>