<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
var  productId  =  <?php echo $productId ;?>
</script>
<main id="main-area" class="main"   >
	<div class="content-wrapper content-space">
        <?php 
            $data = [
                'headingLabel' => Labels::getLabel('LBL_Product_Setup', $siteLangId),
                'siteLangId' => $siteLangId,
            ];

            $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
		<div class="content-body">
			<div class="card">
				<div class="card-body ">
					<div id="listing"></div>
				</div>
			</div>
		</div>
	</div>
</main>