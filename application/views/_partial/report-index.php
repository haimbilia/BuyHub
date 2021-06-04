<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo $pageTitle; ?></h2>
            </div>
            <div class="col-auto">
                <?php
                $actionButtons = [
                    'adminLangId' => $siteLangId,
                    'otherButtons' => [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'exportReport()',
                                'class' => 'btn btn-outline-brand btn-sm',
                                'title' => Labels::getLabel('LBL_Export', $siteLangId)
                            ],
                            'label' => Labels::getLabel('LBL_Export', $siteLangId)
                        ],
                    ]
                ] + $actionButtons;
                $this->includeTemplate('_partial/action-buttons.php', $actionButtons, false); ?>
            </div>
        </div>
        <div class="content-body">

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="replaced">
                                <?php
                                echo $frmSearch->getFormHtml();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="listing-tbl" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>