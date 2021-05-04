<div class="delivery-term">
    <div id="catalogToolTip">
    <h2 class="block-title"><?php echo Labels::getLabel('LBL_Sellers_List', $adminLangId); ?></h2>
        <?php if($adminShip == false) {
                if(!empty($sellerNameArr)) {
                    foreach($sellerNameArr as $sellerName) { ?>
                        <p><?php echo $sellerName; ?></p>
                    <?php } ?>
            <?php }else { ?>
                <p><?php echo Labels::getLabel('LBL_No_Seller_who_shipped_this_product', $adminLangId); ?></p>
            <?php }
        }else {
            if(!empty($notSelShipArr)) {
                foreach($notSelShipArr as $sellerName) { ?>
                    <p><?php echo $sellerName; ?></p>
                <?php } 
            }else { ?>
                <p><?php echo Labels::getLabel('LBL_No_Seller_who_shipped_this_product', $adminLangId); ?></p>
            <?php }
        } ?>
    </div>
</div>
