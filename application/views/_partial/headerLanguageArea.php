<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$hasMultipleLangs = ($languages && count($languages) > 1);
$hasMultipleCurrencies = ($currencies && count($currencies) > 1);

$showDefalultLi =  (false === $hasMultipleLangs && false === $hasMultipleCurrencies);

if ($hasMultipleLangs || $hasMultipleCurrencies) { ?>
<li>
    <div class="dropdown">
        <a class="dropdown-toggle no-after" data-toggle="dropdown" href="javascript:void(0)">
            <?php if ($hasMultipleLangs) {
                if ($languages[$siteLangId]['language_country_code']) { ?>
            <img class="icon--img" alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId); ?>"
                src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo FatApp::getConfig('CONF_COUNTRY_FLAG_TYPE', FatUtility::VAR_STRING, 'round'); ?>/<?php echo $languages[$siteLangId]['language_country_code'] . '.svg'; ?>">
            <?php } ?>
            <span><?php echo $languages[$siteLangId]['language_name']; ?></span>
            <?php }
            
            echo ($hasMultipleLangs && $hasMultipleCurrencies) ? '/' : '';

            if ($hasMultipleCurrencies) {
                echo (CommonHelper::getCurrencySymbolRight()) ? CommonHelper::getCurrencySymbolRight() : CommonHelper::getCurrencySymbolLeft(); ?>
            <span><?php echo $currencies[$siteCurrencyId]; ?></span>
            <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim">
            <div class="select-lang-currency">
                <?php if ($hasMultipleLangs) { ?>
                <h6>
                    <?php echo Labels::getLabel('LBL_Select_Language', $siteLangId); ?>
                </h6>
                <ul>
                    <?php foreach ($languages as $langId => $language) { ?>
                    <li class="<?php echo ($siteLangId == $langId) ? ' is-active' : ''; ?>"><a class=""
                            href="javascript:void(0);"
                            onClick="setSiteDefaultLang(<?php echo $langId; ?>)"><?php if ($language['language_country_code']) { ?>
                            <img class="icon--img"
                                alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId); ?>"
                                src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo FatApp::getConfig('CONF_COUNTRY_FLAG_TYPE', FatUtility::VAR_STRING, 'round'); ?>/<?php echo $language['language_country_code'] . '.svg'; ?>">
                            <?php } ?> <?php echo ' ' . $language['language_name']; ?></a></li>
                    <?php } ?>
                </ul>
                <?php }
                
                echo ($hasMultipleLangs && $hasMultipleCurrencies) ? '<div class="space"></div>' : '';
                
                if ($hasMultipleCurrencies) { ?>
                <h6>
                    <?php echo Labels::getLabel('LBL_Select_Currency', $siteLangId); ?>
                </h6>
                <ul>
                    <?php foreach ($currencies as $currencyId => $currency) { ?>
                    <li class="<?php echo ($siteCurrencyId == $currencyId) ? ' is-active' : ''; ?>">
                        <a class="dropdown-item nav__link" href="javascript:void(0);"
                            onClick="setSiteDefaultCurrency(<?php echo $currencyId; ?>)"> <?php echo $currency; ?></a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</li>
<?php } ?>