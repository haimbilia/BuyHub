<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
 <div class="content-wrapper content-space">
    <?php 
        $data = [
            'headingLabel' => Labels::getLabel('LBL_Downloads',$siteLangId),
            'siteLangId' => $siteLangId,         
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tabs ">
                            <ul>
                                <li class="is-active"><a href="javascript:void(0);" onclick="searchBuyerDownloads('', this)"><?php echo Labels::getLabel('LBL_Downloadable_Files', $siteLangId); ?></a></li>
                                <li><a href="javascript:void(0);" onclick="searchBuyerDownloadLinks('', this)"><?php echo Labels::getLabel('LBL_Downloadable_Links', $siteLangId); ?></a></li>
                            </ul>
                        </div>
                        <div id="listing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>
