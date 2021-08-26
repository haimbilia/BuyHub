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
        <div class="content-body" id="shopFormBlock">
            <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
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