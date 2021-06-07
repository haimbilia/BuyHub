<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="more-sellers">
    <?php if (count($product['moreSellersArr']) > 0) { ?>
        <h6><?php echo Labels::getLabel('LBL_MORE_SELLERS', $siteLangId); ?></h6>
    <?php } ?>
    <ul class="responsive-table scroll scroll-y <?php echo (count($product['moreSellersArr']) ? 'moreSellerRows--js' : ''); ?>">
        <?php
        $sellers[0]['isActive'] = true;
        include('more-sellers-rows.php');
        ?>
    </ul>

    <?php
    if (count($product['moreSellersArr']) > 0) { ?>
        <script>
            $(document).ready(function() {
                moreSellerRows('<?php echo $product['selprod_code']; ?>',
                    <?php echo $product['selprod_user_id']; ?>);
            });
        </script>
    <?php } ?>
</div>