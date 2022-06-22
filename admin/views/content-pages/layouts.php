<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
	<h5 class="modal-title">
		<?php echo Labels::getLabel('LBL_CONTENT_PAGES_LAYOUTS_INSTRUCTIONS', $siteLangId); ?>
	</h5>
</div>
<div class="modal-body form-edit layoutsJs">
	<div class="form-edit-body loaderContainerJs">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="shop-template">
					<figure class="thumb--square"><img width="400px;" src="<?php echo CONF_WEBROOT_URL; ?>images/cms_layouts/layout-1.jpg" /></figure>
					<p><span class="badge badge-info"><?php echo Labels::getLabel('LBL_LAYOUT_1', $siteLangId); ?></span></p>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="shop-template padding20">
					<figure class="thumb--square"><img width="400px;" src="<?php echo CONF_WEBROOT_URL; ?>images/cms_layouts/layout-2.jpg" /></figure>
					<p><span class="badge badge-info"><?php echo Labels::getLabel('LBL_LAYOUT_2', $siteLangId); ?></span></p>
				</div>
			</div>
		</div>
	</div>
</div>