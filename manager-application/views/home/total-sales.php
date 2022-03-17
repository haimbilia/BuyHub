<ul class="list-stats list-stats-inline">   
    <li class="list-stats-item">
        <span class="label">
            <i class="dot" style="background-color:#f05b4f;"></i>
            <?php echo Labels::getLabel('LBL_ORDER_SALES', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas"></i>
            <?php echo CommonHelper::displayMoneyFormat($orderSalesStats["totalsales"], true, true); ?></span>
    </li>
    <li class="list-stats-item">       
        <span class="label">
            <i class="dot" style="background-color: #f4c63d;"></i>
            <?php echo Labels::getLabel('LBL_SALES_EARNINGS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas"></i>
            <?php echo CommonHelper::displayMoneyFormat($orderSalesStats["totalcommission"], true, true); ?>
        </span>
    </li>
    <li class="list-stats-item">        
        <span class="label"> <i class="dot" style="background-color:#008000;"></i><?php echo Labels::getLabel('LBL_NEW_USERS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas"></i>
            <?php echo $userSignupStats; ?></span>
    </li>
    <li class="list-stats-item">       
        <span class="label"> <i class="dot" style="background-color:#d17905;"></i>
            <?php echo Labels::getLabel('LBL_NEW_SHOPS', $siteLangId); ?></span>
        <span class="value">
            <i class="icn fas"></i>
            <?php echo $shopsSignupStats['shopSignups']; ?>
        </span>

    </li>
</ul>