<?php defined('SYSTEM_INIT') or die('Invalid Usage');

if ($languages && count($languages) > 1) { ?>
    <li class="dashboard-menu-item">
        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-language" aria-expanded="true" aria-controls="collapseOne" title="">
            <span class="dashboard-menu-icon">
                <svg class="svg" width="18" height="18">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#language">
                    </use>
                </svg>
            </span>
            <span class="dashboard-menu-head">
                <?php echo Labels::getLabel("LBL_LANGUAGE", $siteLangId); ?>
            </span>
            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
            </i>
        </button>
        <ul class="menu-sub menu-sub-accordion collapse" id="nav-language" aria-labelledby="" data-parent="#dashboard-menu">
            <?php foreach ($languages as $langId => $language) { ?>
                <li class="menu-sub-item <?php echo ($siteLangId == $langId) ? 'is-active' : ''; ?>">
                    <a class="menu-sub-link" href="javascript:void(0);" onClick="setSiteDefaultLang(<?php echo $langId; ?>)">
                        <span class="menu-sub-title">
                            <?php echo $language['language_name']; ?>
                        </span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php }

if ($currencies && count($currencies) > 1) { ?>
    <li class="dashboard-menu-item">
        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-currency" aria-expanded="true" aria-controls="collapseOne" title="">
            <span class="dashboard-menu-icon">
                <svg class="svg" width="18" height="18">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#currency">
                    </use>
                </svg>
            </span>
            <span class="dashboard-menu-head">
                <?php echo Labels::getLabel("LBL_CURRENCY", $siteLangId); ?>
            </span>
            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
            </i>
        </button>
        <ul class="menu-sub menu-sub-accordion collapse" id="nav-currency" aria-labelledby="" data-parent="#dashboard-menu">
            <?php foreach ($currencies as $currencyId => $currency) { ?>
                <li class="menu-sub-item <?php echo ($siteCurrencyId == $currencyId) ? 'is-active' : ''; ?>">
                    <a class="menu-sub-link" href="javascript:void(0);" onClick="setSiteDefaultCurrency(<?php echo $currencyId; ?>)">
                        <span class="menu-sub-title">
                            <?php echo $currency; ?>
                        </span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>