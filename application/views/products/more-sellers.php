<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="more-sellers <?php echo (count($product['moreSellersArr']) ? 'moreSellerRows--js' : ''); ?>">
    <li class="more-sellers-head"><?php echo Labels::getLabel('LBL_SELLERS', $siteLangId); ?></li>
    <?php
        $sellers[0]['isActive'] = true;
        include('more-sellers-rows.php'); 
    ?>
</ul>
<?php if (count($product['moreSellersArr']) > 0) { ?>
    <script>
        $(function () {
            moreSellerRows('<?php echo $product['selprod_code']; ?>', <?php echo $product['selprod_user_id']; ?>);
        });
    </script>
<?php } ?>