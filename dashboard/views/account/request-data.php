<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
 <div class="content-wrapper content-space">
    <?php 
    $data = [
        'headingLabel' => Labels::getLabel('Lbl_Request_My_Data', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
	<div class="content-body">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title"><?php echo Labels::getLabel('Lbl_Request_My_Data',$siteLangId);?></h5>
			</div>
			<div class="card-body ">
				<div class="row">
					<div class="col-md-8" id="requestDataFrmBlock">
						<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
</main>