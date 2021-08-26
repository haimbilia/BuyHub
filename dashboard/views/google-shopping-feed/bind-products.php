<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');?>

<main id="main-area" class="main"   >
    <input type='hidden' name='adsBatchId' value="<?php echo $adsBatchId; ?>">
    <div class="content-wrapper content-space">
        <?php 
            $batchName = AdsBatch::getAttributesById($adsBatchId, 'adsbatch_name');
            $str = Labels::getLabel('LBL_ADD_PRODUCTS_TO_{BATCH}', $siteLangId);
            $data = [
                'headingLabel' =>  CommonHelper::replaceStringData($str, ['{BATCH}' => $batchName]),
                'siteLangId' => $siteLangId,
                'otherButtons' => [
                    [
                        'attr' => [
                            'onclick' => 'window.history.back();',
                            'title' => Labels::getLabel('LBL_BACK', $siteLangId)
                        ],
                        'label' => Labels::getLabel('LBL_BACK', $siteLangId)
                    ]
                ]
            ];
            $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div class="content-body">
            <?php if(!isset($bindProductForm) || true === $bindProductForm) { ?>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="bindProductForm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
						<div class="card-header">
                            <div class="card-title"></div>
							<div class="btn-group">
								<a class="btn btn-outline-brand btn-sm formActionBtn-js disabled" title="<?php echo Labels::getLabel('LBL_UNLINK', $siteLangId); ?>" onclick="unlinkproducts(<?php echo $adsBatchId; ?>)" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_UNLINK', $siteLangId); ?></a>
							</div>
						</div>
                        <div class="card-body">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                            <span class="gap"></span>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</main>

