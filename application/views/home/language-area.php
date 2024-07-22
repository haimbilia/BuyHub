<?php
$hasMultipleLangs = ($languages && count($languages) > 1);
$hasMultipleCurrencies = ($currencies && count($currencies) > 1);
?>
<h2><?php echo Labels::getLabel('LBL_UPDATE_YOUR_SETTINGS', $siteLangId) ?></h2>
<p><?php echo Labels::getLabel('MSG_SET_YOUR_LANGUAGE_&_CURRENCY_PREFERENCE', $siteLangId) ?></p>
<div class="select-lang-currency">
    <?php if ($hasMultipleLangs) { ?>
        <h6 class="h6">
            <?php echo Labels::getLabel('LBL_Select_Language', $siteLangId); ?>
        </h6>
        <ul class="list-options">
            <?php foreach ($languages as $langId => $language) { ?>
                <li class="list-options-item <?php echo ($siteLangId == $langId) ? ' is-active' : ''; ?>">
                    <button class="list-options-link" type="button" role="button" onClick="setSiteDefaultLang(<?php echo $langId; ?>)"><?php if ($language['language_country_code']) { ?>
                            <img width="14" height="14" class="icon" alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId); ?>" src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo FatApp::getConfig('CONF_COUNTRY_FLAG_TYPE', FatUtility::VAR_STRING, 'round'); ?>/<?php echo $language['language_country_code'] . '.svg'; ?>">
                        <?php } ?> <?php echo ' ' . $language['language_name']; ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
    <?php }

    echo ($hasMultipleLangs && $hasMultipleCurrencies) ? '<div class="space"></div>' : '';

    if ($hasMultipleCurrencies) { ?>
        <h6 class="h6">
            <?php echo Labels::getLabel('LBL_Select_Currency', $siteLangId); ?>
        </h6>
        <ul class="list-options">
            <?php foreach ($currencies as $currencyId => $currency) { ?>
                <li class="list-options-item <?php echo (CommonHelper::getCurrencyId() == $currencyId) ? ' is-active' : ''; ?>">
                    <button class="list-options-link" type="button" role="button" onClick="setSiteDefaultCurrency(<?php echo $currencyId; ?>)"> <?php echo $currency; ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>