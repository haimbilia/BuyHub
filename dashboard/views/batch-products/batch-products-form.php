<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Manage_Batch_Products', $siteLangId); ?></h5>
</div>
<div class="modal-body">
	<div class="col-md-12">
		<?php echo $frm->getFormHtml(); ?>
	</div>
	<div id="productsList" class="product-listing" data-view="4">
</div>
<script type="text/javascript">
$("document").ready(function(){
	$('input[name=\'product_name\']').autocomplete_advanced({
		minChars:0,
		autoSelectFirst:false,
		lookup: function (query, done) {
			$.ajax({
				url: fcom.makeUrl('Seller','sellerProductsAutoComplete'),
				data: { keyword: encodeURIComponent(query) },
				dataType: 'json',
				type: 'post',
				success: function(json) {
					done(json);
				}
			});
		},
		triggerSelectOnValidInput: false,
		onSelect: function (suggestion) {
			$('input[name=\'product_name\']').val('');
			updateProductToGroup( <?php echo $prodgroup_id; ?>, suggestion.id );
		}
	});
});
</script>