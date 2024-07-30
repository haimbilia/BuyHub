<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="side-blocksa your-sellers">
    <h5 class="h5"><?php echo Labels::getLabel('LBL_Meet_Your_seller'); ?></h5>
    <div class="side-blocks-body">
        <ul class="more-sellers <?php echo (count($product['moreSellersArr']) ? 'moreSellerRows--js' : ''); ?>">

            <?php
            $sellers[0]['isActive'] = true;
            include ('more-sellers-rows.php');
            ?>
        </ul>
    </div>
</div>
<?php if (count($product['moreSellersArr']) > 0) { ?>
    <script>
        $(function () {
            moreSellerRows('<?php echo $product['selprod_code']; ?>', <?php echo $product['selprod_user_id']; ?>);
        });
    </script>
<?php } ?>