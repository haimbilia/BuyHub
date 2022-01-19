<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php if (($languages && count($languages) > 1) || ($currencies && count($currencies) > 1)) { ?>

    <li class="dashboard-menu-item">
        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
            <span class="dashboard-menu-icon">
                <svg class="svg" width="18" height="18">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                    </use>
                </svg>
            </span>
            <span class="dashboard-menu-head">
                <?php echo Labels::getLabel("LBL_Language_&_Currency", $siteLangId); ?>
            </span>
            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
            </i>
        </button>
    </li>
    <?php if ($languages && count($languages) > 1) { ?>
        <ul class="menu-sub menu-sub-accordion collapse show" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
            <li class="menu-sub-item">
                <a class="menu-sub-link" href="javascript:void(0)">
                    <span class="menu-sub-title"><?php echo $languages[$siteLangId]['language_name']; ?></span></a>
                <ul class="accordianbody">
                    <?php foreach ($languages as $langId => $language) { ?>
                        <li <?php echo ($siteLangId == $langId) ? 'class="is-active"' : ''; ?>><a href="javascript:void(0);" onClick="setSiteDefaultLang(<?php echo $langId; ?>)"> <?php echo $language['language_name']; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php }
    if ($currencies && count($currencies) > 1) { ?>
            <li class="menu-sub-item">
                <a class="menu-sub-link" title="" href="javascript:void(0)">
                    <span class="menu-sub-title"> <?php echo Labels::getLabel('LBL_Currency', $siteLangId); ?></span></a>
                <ul class="accordianbody">
                    <?php foreach ($currencies as $currencyId => $currency) { ?>
                        <li <?php echo ($siteCurrencyId == $currencyId) ? 'class="is-active"' : ''; ?>><a href="javascript:void(0);" onClick="setSiteDefaultCurrency(<?php echo $currencyId; ?>)"> <?php echo $currency; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        </ul>
    <?php } ?>