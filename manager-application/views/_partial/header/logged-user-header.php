<div class="app">
    <?php $this->includeTemplate('_partial/navigation/left-navigation.php'); ?>
    <div class="wrap">
        <header class="main-header mainHeaderJs">
            <div class="container-fluid">
                <div class="main-header-inner">
                    <div class="page-title">
                        <h1>
                            <?php
                            if (array_key_exists('pageTitle', $this->variables)) {
                                echo $this->variables['pageTitle'];
                            } else {
                                echo Labels::getLabel('NAV_DASHBOARD', $siteLangId);
                            } ?>
                        </h1>
                        <?php if (isset($pageData['plang_summary'])) { ?>
                            <span class="page-title-sub"> <?php echo $pageData['plang_summary']; ?> <a href="javascript:void(0)" class="openAlertJs" data-pageid="<?php echo $pageData['plang_id']; ?>" data-name="<?php echo 'alert_' . $pageData['plang_id']; ?>">
                                    <?php if (!empty($pageData['plang_warring_msg']) /* && CommonHelper::isSetCookie('alert_' . $pageData['plang_id']) */) { ?>
                                        <i class="fas fa-exclamation-triangle"></i></a></span>
                        <?php } ?>
                    <?php } ?>

                    </div>
                    <div class="main-header-toolbar">
                        <div class="header-action">
                            <div class="header-action__item">
                                <a class="header-action__trigger" href="<?php echo SiteTourHelper::getUrl(SiteTourHelper::STEP_CONFIGURATION); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-getting-started">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item">
                                <a class="header-action__trigger quickSearchMainJs" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#search-main">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-search">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item">
                                <a class="header-action__trigger" href="<?php echo CONF_WEBROOT_FRONT_URL; ?>" title="<?php echo Labels::getLabel('LBL_VIEW_STORE', $siteLangId); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item">
                                <a class="header-action__trigger" href="javascript:void()" onclick="clearCache()" title="<?php echo Labels::getLabel('LBL_CLEAR_CACHE', $siteLangId); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-cache">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item dropdown">
                                <a class="header-action__trigger dropdown-toggle no-after" data-bs-toggle="dropdown" href="javascript:void();" onclick="getNotifications(0);" title="<?php echo Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                                <div class="header-action__target p-0 dropdown-menu dropdown-menu-right dropdown-menu-anim notificationDropMenuJs">
                                    <div class="header-notification">
                                        <div class="header-notification__head">
                                            <h5><?php echo  Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?> <span class="count hide" id="notifiLinkCount"></span></h5>
                                            <nav class="nav nav--tabs js-tab">
                                                <a class="is-current abc" href="javascript:void(0)" onclick="getNotifications(0,this);"><?php echo  Labels::getLabel('LBL_NOTIFICATIONS', $siteLangId); ?></a>
                                                <a class="abc" href="javascript:void(0)" onclick="getNotifications(1,this);"><?php echo  Labels::getLabel('LBL_LOGS', $siteLangId); ?></a>
                                            </nav>
                                        </div>
                                        <div class="header-notification__body">
                                            <div class="tab-1 tab-container visible">
                                                <div class="scroll-y p-4">
                                                    <div class="notifications" id="notificationList">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="header-notification__footer">
                                            <a id="notifiLinkViewAll" href="javascript:void(0)" class="text-link text-link--arrow"><?php echo  Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action__item dropdown header-account">
                                <a class="dropdown-toggle no-after" data-bs-toggle="dropdown" href="javascript:void(0)">
                                    <span class="header-account__img">
                                        <img aria-expanded="false" src="<?php echo UrlHelper::generateFileUrl('Image', 'profileImage', array(AdminAuthentication::getLoggedAdminId(), 'croped', true)); ?>" alt="">
                                    </span>
                                </a>
                                <div class="header-action__target dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                                    <div class="header-account__avtar">
                                        <div class="profile">
                                            <div class="profile__img">
                                                <img alt="" src="<?php echo UrlHelper::generateFileUrl('Image', 'profileImage', array(AdminAuthentication::getLoggedAdminId(), 'croped', true)); ?>">
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
                                                    <a class="languages-link <?php echo ($siteLangId == $languageId) ? 'is--active' : ''; ?>" href="" onclick="setSiteDefaultLang(<?php echo $languageId; ?>)"><?php echo $language['language_name']; ?></a>
                                                <?php } ?>
                                            </div>
                                        <?php
                                        } ?>
                                        <a href="<?php echo UrlHelper::generateUrl('profile', 'logout'); ?>"><?php echo  Labels::getLabel('LBL_LOGOUT', $siteLangId); ?></a>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($pageData['plang_warring_msg']) && !empty($pageData['plang_warring_msg']) && !CommonHelper::isSetCookie('alert_' . $pageData['plang_id'])) { ?>
                <div class="alert alert-solid-warning fade alertWarningJs show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text"><?php echo nl2br($pageData['plang_warring_msg']); ?></div>
                    <div class="alert-close">
                        <button type="button" class="btn-close closeAlertJs <?php echo 'alert_' . $pageData['plang_id']; ?>" data-bs-dismiss="alert" aria-label="Close" data-name="<?php echo 'alert_' . $pageData['plang_id']; ?>">

                        </button>
                    </div>
                </div>
            <?php } ?>

            <?php if (isset($pageData['plang_recommendations']) && !empty($pageData['plang_recommendations']) && !CommonHelper::isSetCookie('alert_' . $pageData['plang_id'])) { ?>
                <div class="alert alert-solid-info fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text"><?php echo nl2br($pageData['plang_recommendations']); ?></div>
                </div>
            <?php } ?>
        </header>