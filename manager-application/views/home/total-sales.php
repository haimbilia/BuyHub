<ul class="list-stats list-stats-inline">
    <?php
    $cls = '';
    if ($orderSalesStats["totalsales"] > 0) {
        $cls = 'fa-arrow-up font-success';
    } else if ($orderSalesStats["totalsales"] < 0) {
        $cls = 'fa-arrow-down font-error';
    }
    ?>
    <li class="list-stats-item">
        <span class="label">
            <i class="dot" style="background-color:#f05b4f;"></i>
            <?php echo Labels::getLabel('LBL_ORDER_SALES', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas <?php echo $cls; ?>"></i>
            <?php echo CommonHelper::displayMoneyFormat($orderSalesStats["totalsales"], true, true); ?></span>
    </li>
    <li class="list-stats-item">
        <?php
        $cls = '';
        if ($orderSalesStats["totalcommission"] > 0) {
            $cls = 'fa-arrow-up font-success';
        } else if ($orderSalesStats["totalcommission"] < 0) {
            $cls = 'fa-arrow-down font-error';
        }
        ?>
        <span class="label">
            <i class="dot" style="background-color: #f4c63d;"></i>
            <?php echo Labels::getLabel('LBL_SALES_EARNINGS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas <?php echo $cls; ?>"></i>
            <?php echo CommonHelper::displayMoneyFormat($orderSalesStats["totalcommission"], true, true); ?>
        </span>
    </li>
    <li class="list-stats-item">
        <?php $cls = '';
        if ($userSignupStats > 0) {
            $cls = 'fa-arrow-up font-success';
        } else if ($userSignupStats < 0) {
            $cls = 'fa-arrow-down font-error';
        }
        ?>

        <span class="label"> <i class="dot" style="background-color:#008000;"></i><?php echo Labels::getLabel('LBL_NEW_USERS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas <?php echo $cls; ?>"></i>
            <?php echo $userSignupStats; ?></span>
    </li>
    <li class="list-stats-item">
        <?php $cls = '';
        if ($shopsSignupStats['shopSignups'] > 0) {
            $cls = 'fa-arrow-up font-success';
        } else if ($shopsSignupStats['shopSignups'] < 0) {
            $cls = 'fa-arrow-down font-error';
        }
        ?>
        <span class="label"> <i class="dot" style="background-color:#d17905;"></i>
            <?php echo Labels::getLabel('LBL_NEW_SHOPS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas <?php echo $cls; ?>"></i>
            <?php echo $shopsSignupStats['shopSignups']; ?>
        </span>

    </li>
</ul>