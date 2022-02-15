<?php $inactive = ($selprod_id == 0)?'fat-inactive' : '';	 ?>
<ul>
    <li
        class="<?php echo ($activeTab == 'GENERAL') ? 'is-active' : ''?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
    ?>onclick="sellerProductForm(<?php echo $product_id; ?>,<?php echo $selprod_id; ?>)"<?php
}?>>
            <?php echo Labels::getLabel('LBL_General', $siteLangId);?></a>
    </li>
    <?php /* <li
        class="<?php echo ($activeTab == 'SEO') ? 'is-active' : ''; echo $inactive;?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
        ?>onclick="productSeo(<?php echo $selprod_id; ?>)"<?php
    }?>>
            <?php echo Labels::getLabel('LBL_Seo', $siteLangId);?></a>
    </li>
    <li
        class="<?php echo ($activeTab == 'SPECIAL_PRICE') ? 'is-active' : ''; echo $inactive; ?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
        ?>onclick="sellerProductSpecialPrices(<?php echo $selprod_id; ?>)"<?php
    }?>>
            <?php echo Labels::getLabel('LBL_Special_Price', $siteLangId);?></a>
    </li>
    <li
        class="<?php echo ($activeTab == 'VOLUME_DISCOUNT') ? 'is-active' : ''; echo $inactive;?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
        ?>onclick="sellerProductVolumeDiscounts(<?php echo $selprod_id; ?>)" <?php
    } ?>>
            <?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId);?></a>
    </li>
    <li
        class="<?php echo ($activeTab == 'LINKS') ? 'is-active' : ''; echo $inactive;?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
        ?>onclick="sellerProductLinkFrm(<?php echo $selprod_id; ?>)"<?php
    }?>>
            <?php echo Labels::getLabel('LBL_Links', $siteLangId);?></a>
    </li> */ ?>
    <?php if ($product_type == Product::PRODUCT_TYPE_DIGITAL) {
        ?>
    <li
        class="<?php echo ($activeTab == 'DOWNLOADS') ? 'is-active' : '';
        echo $inactive; ?>">
        <a href="javascript:void(0)" <?php if ($selprod_id > 0) {
            ?>onclick="sellerProductDownloadFrm(<?php echo $selprod_id; ?>)"<?php
        } ?>>
            <?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?></a>
    </li>
    <?php
    }?>
</ul>
