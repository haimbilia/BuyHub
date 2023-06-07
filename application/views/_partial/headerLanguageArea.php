<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$hasMultipleLangs = ($languages && count($languages) > 1);
$hasMultipleCurrencies = ($currencies && count($currencies) > 1);

$showDefalultLi =  (false === $hasMultipleLangs && false === $hasMultipleCurrencies);

if ($hasMultipleLangs || $hasMultipleCurrencies) { ?>

    <div class="dropdown dropdown-lang">
        <button type="button" class="btn btn-outline-gray btn-dropdown dropdown-toggle-custom btn-icon btn-language" data-bs-toggle="dropdown">
            <?php if ($hasMultipleLangs) {
                if ($languages[$siteLangId]['language_country_code']) { ?>
                    <img width="14" height="14" class="svg" alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId); ?>" src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo FatApp::getConfig('CONF_COUNTRY_FLAG_TYPE', FatUtility::VAR_STRING, 'round'); ?>/<?php echo $languages[$siteLangId]['language_country_code'] . '.svg'; ?>">
                <?php } ?>
                <span>
                    <span class="language-name">
                        <?php echo $languages[$siteLangId]['language_name']; ?></span>
                <?php }

            echo ($hasMultipleLangs && $hasMultipleCurrencies) ? '/' : '';

            if ($hasMultipleCurrencies) {
                echo (CommonHelper::getCurrencySymbolRight()) ? CommonHelper::getCurrencySymbolRight() : CommonHelper::getCurrencySymbolLeft(); ?>
                    <span class="currency-name">
                        <?php echo $currencies[CommonHelper::getCurrencyId()]; ?>
                    </span>
                <?php } ?>
                </span>
                <i class="dropdown-toggle-custom-arrow"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim">
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
        </div>
    </div>

<?php } ?>