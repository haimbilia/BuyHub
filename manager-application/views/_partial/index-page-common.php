<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$actionButtons = isset($actionButtons) ? $actionButtons : true;
$listingLabel = isset($listingLabel) ? $listingLabel : "";
?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon">
                                <i class="ion-android-star"></i></span>
                            <h5><?php echo $headingLabel; ?></h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <span class="pagebody--js">
                    <div id="otherTopForm--js"></div>
                    <?php if (!empty($frmSearch)) { ?>
                        <section class="section searchform_filter">
                            <div class="sectionhead searchHead--js">
                                <h4> <?php echo Labels::getLabel('LBL_Search...', $adminLangId); ?></h4>
                            </div>
                            <div class="sectionbody space togglewrap" style="display:none;">
                                <?php echo  $frmSearch->getFormHtml(); ?>
                            </div>
                        </section>
                    <?php } ?>
                    <div id="otherMidForm--js"></div>
                    <section class="section listingSection--js">
                        <div class="sectionhead">
                            <h4><?php echo $listingLabel; ?></h4>
                            <?php
                            if ($canEdit && isset($data) && is_array($data) && 0 < count($data)) {
                                if (true === $actionButtons) {
                                    $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
                                } else { ?>
                                    <ul class="actions actions--centered">
                                        <li class="droplink">
                                            <a href="javascript:void(0)" class="button small green" title="<?php echo Labels::getLabel('LBL_EDIT', $adminLangId); ?>">
                                                <i class="ion-android-more-horizontal icon"></i>
                                            </a>
                                            <div class="dropwrap">
                                                <?php $this->includeTemplate('_partial/action-links.php', $data, false); ?>
                                            </div>
                                        </li>
                                    </ul>
                                <?php }
                            } ?>
                        </div>
                        <div class="sectionbody">
                            <div class="tablewrap">
                                <div id="listing"> <?php echo Labels::getLabel('LBL_Processing...', $adminLangId); ?> </div>
                            </div>
                        </div>
                    </section>
                </span>
                <span class="editRecord--js"></span>
            </div>
        </div>
    </div>
</div>