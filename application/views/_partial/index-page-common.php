<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo $headingLabel; ?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="replaced">
                                <?php
                                $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
                                $frmSearch->setFormTagAttribute('class', 'form');
                                $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
                                $frmSearch->developerTags['fld_default_col'] = 12;

                                $btn = $frmSearch->getField('btn_submit');
                                if (null != $btn) {
                                    $btn->setFieldTagAttribute('class', 'btn btn-brand btn-block');
                                }

                                $btn = $frmSearch->getField('btn_clear');
                                if (null != $btn) {
                                    $btn->setFieldTagAttribute('onClick', 'clearSearch()');
                                    $btn->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
                                }
                                echo $frmSearch->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"></div>
                            <?php
                            if ($canEdit && isset($data) && is_array($data) && 0 < count($data)) {
                                if (true === $actionButtons) {
                                    $this->includeTemplate('_partial/action-buttons.php', $data, false);
                                }
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>