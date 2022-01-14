<div class="product-profile">
    <div class="product-profile__data">
	
		<div class="invoice-number">
			<i class="far fa-file-alt"></i>
			<?php echo $order['op_invoice_number']; ?>
		</div>
		
        <div class="title">
            <?php echo '<a href="' . UrlHelper::generateFullUrl('Products', 'View', array($order['op_selprod_id']), CONF_WEBROOT_FRONT_URL) . '" target="_blank" title="' . $order['op_product_name'] . '">' . CommonHelper::subStringByWords($order['op_selprod_title'], 35) . '</a>';?>
        </div>
		
		<div class="">
			<span class="cancellation-reason">
				<?php echo Labels::getLabel('LBL_REASON', $siteLangId); ?>: <?php echo $order['ocreason_title']; ?>
			</span>
		</div>
        
		<div class="">
			<span class="cancellation-comment">
				<?php echo Labels::getLabel('LBL_COMMENT', $siteLangId); ?>: 
				<?php 
					if (strlen($order['ocrequest_message']) > 25) {
						$htm = substr($order['ocrequest_message'], 0, 22) . "...";
						$htm .= '<button class="btn btn-view" data-bs-toggle="tooltip" data-placement="top"  data-bs-original-title="' . Labels::getLabel('LBL_VIEW_MORE', $siteLangId) . '" onclick="viewComment(' . $order['ocrequest_id'] . ')"><i class="fas fa-eye"></i></button>';
						echo $htm;
					} else {
						echo $order['ocrequest_message'];
					}
				?>
			</span>
		</div>
    </div>
</div>