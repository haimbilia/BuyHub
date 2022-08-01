<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg-gray">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
                <div class="col-xs-10 panel__right--full">
                    <div class="card">
                        <div class="card-head">
                            <h4>
                                <?php echo Labels::getLabel('LBL_Category_banners', $siteLangId); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="box box--white  p-4">
                                <div class="box__head">
                                    <h5><?php echo Labels::getLabel('LBL_Banners_listing', $siteLangId); ?></h5>
                                </div>
                                <div class="box__body" id="listing">
                                    <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>