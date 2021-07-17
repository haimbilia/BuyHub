
<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Info_regarding_this_page',$siteLangId) ;?></h5>
</div>
<div class="modal-body">
    <div id="catalogToolTip">
        <?php 
        $obj = new Extrapage();
        switch ($type) {
            case Extrapage::MARKETPLACE_PRODUCT_INSTRUCTIONS:
                $pageData = $obj->getContentByPageType(Extrapage::MARKETPLACE_PRODUCT_INSTRUCTIONS, $siteLangId);
                break;
            case Extrapage::SELLER_INVENTORY_INSTRUCTIONS:
                $pageData = $obj->getContentByPageType(Extrapage::SELLER_INVENTORY_INSTRUCTIONS, $siteLangId);
                break;
            case Extrapage::PRODUCT_REQUEST_INSTRUCTIONS:
                $pageData = $obj->getContentByPageType(Extrapage::PRODUCT_REQUEST_INSTRUCTIONS, $siteLangId);
                break;
        }
        echo isset($pageData['epage_content']) && !empty($pageData['epage_content']) ? $pageData['epage_content'] : $pageData['epage_default_content'];
        ?>
    </div>
</div>