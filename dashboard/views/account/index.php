<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
 <div class="content-wrapper content-space">
    <?php 
        $data = [
            'headingLabel' => Labels::getLabel('LBL_BUYER_DASHBOARD_PAGE', $siteLangId),
            'siteLangId' => $siteLangId
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
	<div class="content-body">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title"><?php echo Labels::getLabel('LBL_Buyer_dashboard_page',$siteLangId); ?></h5>
			</div>
		</div>
	</div>
  </div>
</main>
