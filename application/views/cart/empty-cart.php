<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="block-empty m-auto text-center">
    <img class="block__img" width="200" height="200" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty-cart.svg" alt="">
    <h3>
        <?php echo Labels::getLabel('LBL_Your_Shopping_Bag_is_Empty', $siteLangId); ?></h3>

    <a href="<?php echo UrlHelper::generateUrl('Home'); ?>" class="btn btn-outline-brand btn-wide">
        <?php echo Labels::getLabel('LBL_Go_To_Homepage', $siteLangId); ?>
    </a>
    <?php if ($EmptyCartItems) { ?>
        <ul class="browse-more mt-4">
            <?php
            $counter = 1;
            foreach ($EmptyCartItems as $item) {
                $itemUrl = str_replace('{SITEROOT}', UrlHelper::generateFullUrl(), $item['emptycartitem_url']);
                $itemUrl = str_replace('{siteroot}', UrlHelper::generateFullUrl(), $itemUrl);
            ?>
                <li>
                    <a target="<?php echo $item['emptycartitem_url_is_newtab'] ? "_blank" : "_self" ?>" href="<?php echo $itemUrl; ?>"><?php echo $item['emptycartitem_title']; ?></a> <?php echo ($counter < count($EmptyCartItems)) ? '' : ''; ?>
                </li>
            <?php
                $counter++;
            } ?>
        </ul>
    <?php }    ?>
</div>
<script>
    $(function() {
        $(".hide_on_no_product").hide();
    });
</script>