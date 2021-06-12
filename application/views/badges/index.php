<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row ">
            <div class="col">
                <h2 class="content-header-title">
                    <?php echo Labels::getLabel('LBL_BADGES_&_RIBBONS', $siteLangId); ?>
                </h2>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pagebody--js">
                            <div class="tabs">
                                <ul class="tabs_nav-js">
                                    <li class="is-active">
                                        <a class="tabs_001 customCatalogReq--js" rel="tabs_001" href="javascript:void(0)" onClick="searchBadges()">
                                            <?php echo Labels::getLabel('LBL_BADGES', $siteLangId); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="tabs_002 brandReq--js" rel="tabs_002" href="javascript:void(0)" onClick="searchRibbons()">
                                            <?php echo Labels::getLabel('LBL_RIBBONS', $siteLangId); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?>
                            </div>
                        </div>
                        <span class="card-body editRecord--js"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>