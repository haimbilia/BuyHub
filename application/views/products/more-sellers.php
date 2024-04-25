<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="more-sellers <?php echo (count($product['moreSellersArr']) ? 'moreSellerRows--js' : ''); ?>">
    <?php
    $sellers[0]['isActive'] = true;
    $displaySellerId = $product['selprod_user_id'];
    include('more-sellers-rows.php');
    ?>
</ul>
<?php if (count($product['moreSellersArr']) > 0) { ?>
    <script>
        $(function() {
            moreSellerRows('<?php echo $product['selprod_code']; ?>', <?php echo $product['selprod_user_id']; ?>);
        });
    </script>
<?php } ?>