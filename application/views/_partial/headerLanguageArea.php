<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$hasMultipleLangs = ($languages && count($languages) > 1);
$hasMultipleCurrencies = ($currencies && count($currencies) > 1);

$showDefalultLi =  (false === $hasMultipleLangs && false === $hasMultipleCurrencies);

if ($hasMultipleLangs || $hasMultipleCurrencies) { ?>

    <div class="dropdown dropdown-lang">
        <button type="button" class="btn btn-outline-gray btn-icon btn-language" onclick="showLanguageDropdown()">
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
        </button>        
    </div>

<?php } ?>