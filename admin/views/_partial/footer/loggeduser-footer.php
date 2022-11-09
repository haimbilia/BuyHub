<?php require_once(CONF_THEME_PATH . 'page-language-data/helping-text.php'); ?>
<!-- begin:: Footer -->
<footer class="footer" id="footer">
    <div class="container">
        <div class="copyright">
            <?php $this->includeTemplate('_partial/footer/copyright-text.php', $this->variables, false); ?>
        </div>
    </div>
</footer>
<div class="header-action__target modal fade" id="search-main">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <?php
                $data = [
                    'siteLangId' => $siteLangId,
                    'objPrivilege' => AdminPrivilege::getInstance()
                ];
                $this->includeTemplate('_partial/navigation/quick-search.php', $data, false); ?>

            </div>
            <div class="modal-footer">
                <div class="search-native">
                    <label class="checkbox" for="">
                        <?php
                        $preferences = $_COOKIE['quickSearchCtrlJs'] ?? 0;
                        $str = Labels::getLabel('LBL_PRESS_{KEY}_KEY_FOR_BROWSER_SEARCH', $siteLangId);
                        echo CommonHelper::replaceStringData($str, ['{KEY}' => '<kbd>Ctrl-F</kbd>']); ?>
                        <input type="checkbox" id="quickSearchCtrlJs" <?php echo (0 < $preferences ? 'checked="checked"' : ''); ?> data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_MARK_AS_CHECKED_TO_USE_THE_ONLY_NATIVE_BROWSER_SEARCH', $siteLangId); ?>">
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-action">
    <div class="footer-action__item">
        <a class="footer-action__trigger quickSearchMainJs" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#search-main" title="<?php echo Labels::getLabel('LBL_GLOBAL_SEARCH', $siteLangId); ?>">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-search">
                    </use>
                </svg>
            </span>
        </a>
    </div>
    <div class="footer-action__item">
        <a class="footer-action__trigger" href="<?php echo CONF_WEBROOT_FRONT_URL; ?>" title="<?php echo Labels::getLabel('LBL_VIEW_STORE', $siteLangId); ?>">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                    </use>
                </svg>
            </span>
        </a>
    </div>
    <div class="footer-action__item">
        <a href="#" href="javascript:void(0);" class="footer-action__trigger" data-trigger="sidebar">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#menu">
                    </use>
                </svg>
            </span>
        </a>
    </div>
    <div class="footer-action__item">
        <a class="footer-action__trigger" href="javascript:void(0)" onclick="clearCache()" title="<?php echo Labels::getLabel('LBL_CLEAR_CACHE', $siteLangId); ?>">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-cache">
                    </use>
                </svg>
            </span>
        </a>
    </div>
    <div class="footer-action__item dropdown">
        <a class="footer-action__trigger dropdown-toggle no-after" data-bs-toggle="dropdown" href="javascript:void(0)" onclick="getNotifications(0);" title="<?php echo Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?>">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification">
                    </use>
                </svg>
            </span>
        </a>
        <div class="header-action__target p-0 dropdown-menu dropdown-menu-right dropdown-menu-anim notificationDropMenuJs dropDownMenuBlockClose">
            <div class="header-notification">
                <div class="header-notification__head">
                    <h5><?php echo  Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?> <span class="count hide notifiLinkCountJs"></span></h5>
                    <nav class="nav nav--tabs js-tab">
                        <a class="is-current headerNotificationTabJs" href="javascript:void(0)" onclick="getNotifications(0,this);"><?php echo  Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?></a>
                        <a class="headerNotificationTabJs" href="javascript:void(0)" onclick="getNotifications(1,this);"><?php echo  Labels::getLabel('LBL_SYSTEM_LOGS', $siteLangId); ?></a>
                    </nav>
                </div>
                <div class="header-notification__body">
                    <div class="tab-1 tab-container visible">
                        <div class="scroll-y p-3">
                            <div class="notifications notificationListJS">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-notification__footer">
                    <a href="javascript:void(0)" class="text-link text-link--arrow notifiLinkViewAllJs"><?php echo  Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-action__item dropdown header-account">
        <a class=" dropdown-toggle no-after" data-bs-toggle="dropdown" href="javascript:void(0)">
            <span class="header-account__img">
                <img aria-expanded="false" data-ratio="<?php echo $getProfileImageData[ImageDimension::VIEW_CROPED]['aspectRatio']; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'profileImage', array(AdminAuthentication::getLoggedAdminId(), ImageDimension::VIEW_CROPED, true)) . ($_SESSION[AdminAuthentication::SESSION_ELEMENT_NAME]['admin_updated_on'] ?? time()), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo Labels::getLabel('LBL_ADMIN', $siteLangId); ?>">
            </span>
        </a>
        <div class="footer-action__target p-0 dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
            <div class="header-account__avtar">
                <div class="profile">
                    <div class="profile__img">
                        <img alt="<?php echo Labels::getLabel('LBL_ADMIN', $siteLangId); ?>" data-ratio="<?php echo $getProfileImageData[ImageDimension::VIEW_CROPED]['aspectRatio']; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'profileImage', array(AdminAuthentication::getLoggedAdminId(), ImageDimension::VIEW_CROPED, true)) . ($_SESSION[AdminAuthentication::SESSION_ELEMENT_NAME]['admin_updated_on'] ?? time()), CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                    </div>
                    <div class="profile__detail">
                        <h6>
                            <?php echo  Labels::getLabel('LBL_HI', $siteLangId); ?>,
                            <?php echo AdminAuthentication::getLoggedAdminAttribute('admin_name', true); ?>
                        </h6>
                        <span>
                            <a href="mailto:<?php echo AdminAuthentication::getLoggedAdminAttribute('admin_email', true); ?>"><?php echo AdminAuthentication::getLoggedAdminAttribute('admin_email', true); ?></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="separator m-0"></div>
            <nav class="nav nav--header-account">
                <a href="<?php echo UrlHelper::generateUrl('profile'); ?>">
                    <?php echo  Labels::getLabel('LBL_MY_PROFILE', $siteLangId); ?></a>
                <a href="<?php echo UrlHelper::generateUrl('profile', 'index', ['changePassword']); ?>"><?php echo  Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId); ?></a>
            </nav>
            <div class="separator m-0"></div>
            <nav class="nav nav--header-account">
                <?php if (1 < count($languages)) { ?>
                    <a class="language-selector collapsed" data-bs-toggle="collapse" href="#languages" role="button" aria-expanded="false" aria-controls="languages">
                        <?php echo Labels::getLabel('NAV_LANGUAGES', $siteLangId) ?>
                        <span class="selected-language">
                            <?php echo CommonHelper::getLangCode() ?>
                            <span>
                                <img src="<?php echo CONF_WEBROOT_FRONTEND; ?>images/flags/round/<?php echo CommonHelper::getLangCountryCode() ?>.svg"></span>
                        </span>

                    </a>
                    <div class="languages collapse" id="languages">
                        <?php foreach ($languages as $languageId => $language) { ?>
                            <a class="languages-link <?php echo ($siteLangId == $languageId) ? 'is--active' : ''; ?>" href="" onclick="setSiteDefaultLang(<?php echo $languageId; ?>)"><?php echo $language; ?></a>
                        <?php } ?>
                    </div>
                <?php
                } ?>
                <a href="<?php echo UrlHelper::generateUrl('profile', 'logout'); ?>"><?php echo  Labels::getLabel('LBL_LOGOUT', $siteLangId); ?></a>
            </nav>
        </div>
    </div>
</div>