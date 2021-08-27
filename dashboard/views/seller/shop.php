<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php
        $data = [
            'headingLabel' => Labels::getLabel('LBL_Shop_Details', $siteLangId),
            'siteLangId' => $siteLangId,
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div class="content-body">
            <?php
            $variables = array('language' => $language, 'siteLangId' => $siteLangId, 'shop_id' => $shop_id, 'action' => $action);
            $this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false);
            ?>
            <div class="card" id="shopFormBlock">
                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        <?php if ($tab == User::RETURN_ADDRESS_ACCOUNT_TAB && !$subTab) { ?>
            returnAddressForm();
        <?php } elseif ($subTab) { ?>
            returnAddressLangForm(<?php echo $subTab; ?>);
        <?php } else { ?>
            shopForm("<?php echo $tab; ?>");
        <?php } ?>
    });
</script>