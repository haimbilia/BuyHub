<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($orderShippingData)) {
?>
	<div class="modal-header">
		<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Shipping', $siteLangId); ?></h5>
	</div>
	<div class="modal-body">
		<ul class="review-block scroll-y" style="max-height:400px;">
			<?php foreach ($orderShippingData as $shipData) { ?>
				<li>
					<div class="review-block__content">
						<div class="shipping-data">
							<ul class="media-more media-more-sm show">

								<?php 
                                foreach ($shipData as $data) {
                                    $uploadedTime = AttachedFile::setTimeParam($data['product_updated_on']);
                                    $imageUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($data['selprod_product_id'], "EXTRA-SMALL", $data['op_selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                    $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($data['selprod_product_id'], "WEBPEXTRA-SMALL", $data['op_selprod_id'], 0, $siteLangId)) . $uploadedTime,   CONF_IMG_CACHE_TIME, '.webp');
                                    ?>
									<li>
										<span class="circle" data-toggle="tooltip" data-placement="top" title="<?php echo $data['op_selprod_title']; ?>" data-original-title="<?php echo $data['op_selprod_title']; ?>">
                                            <?php
                                                $pictureAttr = [
                                                    'webpImageUrl' => $imageWebpUrl,
                                                    'jpgImageUrl' => $imageUrl,
                                                    'alt' => $data['op_selprod_title'],
                                                    'siteLangId' => $siteLangId,
                                                ];
                    
                                                $this->includeTemplate('_partial/picture-tag.php', $pictureAttr); 
                                            ?>
										</span>
									</li>
								<?php } ?>
								<div class="shipping-data_title"><?php echo $data['opshipping_label']; ?></div>
							</ul>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="modal-footer">
		<div class="d-flex">
			<button class="btn btn-outline-brand mleft-auto" type="button" onClick="ShippingSummaryData();"><?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?></button>
		</div>
	</div>
<?php } else { ?>
	<div class="modal-header">
		<h5 class="modal-title"><?php echo Labels::getLabel('LBL_No_Pick_Up_address_added', $siteLangId); ?></h5>
	</div>
<?php } ?>

<script>
	ShippingSummaryData = function() {
		$.facebox.close();
		loadShippingSummaryDiv();
	}
</script>