<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_INFO_REGARDING_THIS_PAGE', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
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
            if (!empty($pageData)) {
                echo isset($pageData['epage_content']) && !empty(trim(strip_tags($pageData['epage_content']))) ? $pageData['epage_content'] : $pageData['epage_default_content'];
            } else {
                $this->includeTemplate('_partial/no-record-found.php', ['message' => Labels::getLabel('LBL_NO_INSTRUCTIONS_FOUND!')], false);
            }
            ?>
        </div>
    </div>
</div>