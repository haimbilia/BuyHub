<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$allAccessfrm->developerTags['colClassPrefix'] = 'col-md-';
$allAccessfrm->developerTags['fld_default_col'] = 12; ?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon">
                            <i class="ion-android-star"></i></span>
                            <h5><?php echo Labels::getLabel('LBL_Manage', $siteLangId); ?> <?php echo $data['admin_username'];?> <?php echo Labels::getLabel('LBL_User_Permission', $siteLangId); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                            <?php echo $frm->getFormHtml();?>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo Labels::getLabel('LBL_Admin_User_Listing', $siteLangId); ?> : <?php echo $data['admin_username'];?></h4>
                    </div>
                    <div class="sectionbody space">
                        <?php echo $allAccessfrm->getFormHtml(); ?>
                    </div>
                </section>
                <section class="section">
                    <div class="sectionbody">
                        <div class="tablewrap">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
