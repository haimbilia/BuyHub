<div class="app">
    <?php $this->includeTemplate('_partial/header/left-navigation.php') ?>
    <div class="wrap">
        <header class="main-header">
            <div class="container-fluid">
                <div class="main-header-inner">
                    <div class="page-title">
                        <h1>
                            <?php
                            if (array_key_exists('pageTitle', $this->variables)) {
                                echo $this->variables['pageTitle'];
                            } else {
                                echo Labels::getLabel('LBL_Dashboard', $adminLangId);
                            } ?>
                        </h1>
                        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                    </div>
                    <div class="main-header-toolbar">
                        <div class="header-action">
                            <div class="header-action__item">
                                <a class="header-action__trigger quickSearchMain" href="javascript:void(0);" data-toggle="modal" data-target="#search-main">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-search">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                                <div class="header-action__target modal fade" id="search-main">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-5">
                                                <?php
                                                $data = [
                                                    'adminLangId' => $adminLangId
                                                ];
                                                $this->includeTemplate('_partial/navigation/quick-search.php', $data, false); ?>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="search-native">
                                                    <p><label class="" for="">Press <kbd>Ctrl-F</kbd> again to
                                                            use native browser search.
                                                            <input type="checkbox" id="quickSearchCtrl"></label></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action__item">
                                <a class="header-action__trigger" href="<?php echo CONF_WEBROOT_FRONT_URL; ?>" title="<?php echo Labels::getLabel('LBL_VIEW_STORE', $adminLangId); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item">
                                <a class="header-action__trigger" href="javascript:void()" onclick="clearCache()" title="<?php echo Labels::getLabel('LBL_CLEAR_CACHE', $adminLangId); ?>">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-cache">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="header-action__item dropdown">
                                <a class="header-action__trigger dropdown-toggle no-after" data-toggle="dropdown" href="javascript:void();">
                                    <span class="icon">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification">
                                            </use>
                                        </svg>
                                    </span>
                                </a>
                                <div class="header-action__target p-0 dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                    <div class="header-notification">
                                        <div class="header-notification__head">
                                            <h5>Notifications <span class="count">24 reports</span></h5>
                                            <nav class="nav nav--tabs js-tab">
                                                <a class="is-current" href="#tab-1">Alerts</a>
                                                <a href="#tab-2">Updates</a>
                                                <a href="#tab-3">Logs</a>
                                            </nav>
                                        </div>
                                        <div class="header-notification__body">
                                            <div class="tab-1 tab-container visible" id="tab-1">
                                                <div class="scroll-y p-4">
                                                    <div class="notifications">
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                        <div class="notification">
                                                            <div class="notification__img">
                                                                <span class="icon">
                                                                    <svg class="svg" width="20" height="20">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification-alert">
                                                                        </use>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="notification__detail">
                                                                <a href="" class="title">Project Alice</a>
                                                                <div class="summary">Phase 1 development</div>
                                                            </div>
                                                            <span class="notification__time">1 hr</span>
                                                        </div>
                                                        <!--item-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-2 tab-container" id="tab-2">
                                                <div class="scroll-y p-4">
                                                    <div class="update text-center">
                                                        <div class="update__content">
                                                            <h5>Get Pro Access</h5>
                                                            <p>Outlines keep you honest. They stoping you from amazing poorly
                                                                about drive</p>
                                                            <a href="#" class="btn btn-sm btn-primary">Upgrade</a>
                                                        </div>
                                                        <div class="update__img">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/misc/update-img.png" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-3 tab-container" id="tab-3">
                                                <div class="scroll-y p-4">
                                                    <div class="log-list">
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New order</a>
                                                            </div>
                                                            <span class="log__time">Just now</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-danger">500 ERR</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New customer</a>
                                                            </div>
                                                            <span class="log__time">2 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Payment process</a>
                                                            </div>
                                                            <span class="log__time">5 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-warning">300 WRN</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Search query</a>
                                                            </div>
                                                            <span class="log__time">2 days</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New order</a>
                                                            </div>
                                                            <span class="log__time">Just now</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-danger">500 ERR</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New customer</a>
                                                            </div>
                                                            <span class="log__time">2 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Payment process</a>
                                                            </div>
                                                            <span class="log__time">5 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-warning">300 WRN</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Search query</a>
                                                            </div>
                                                            <span class="log__time">2 days</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New order</a>
                                                            </div>
                                                            <span class="log__time">Just now</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-danger">500 ERR</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">New customer</a>
                                                            </div>
                                                            <span class="log__time">2 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-success">200 OK</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Payment process</a>
                                                            </div>
                                                            <span class="log__time">5 hrs</span>
                                                        </div>
                                                        <!--log-->
                                                        <div class="log">
                                                            <span class="badge badge-warning">300 WRN</span>
                                                            <div class="log__detail">
                                                                <a href="#" class="log__title">Search query</a>
                                                            </div>
                                                            <span class="log__time">2 days</span>
                                                        </div>
                                                        <!--log-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="header-notification__footer">
                                            <a href="" class="text-link text-link--arrow">View All </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action__item dropdown header-account">
                                <a class="header-action__trigger dropdown-toggle no-after" data-toggle="dropdown" href="">
                                    <span class="header-account__img">
                                        <img aria-expanded="false" src="<?php echo UrlHelper::generateFileUrl('Image','profileImage',array(AdminAuthentication::getLoggedAdminId(),'croped',true));?>" alt="">
                                    </span>
                                </a>
                                <div class="header-action__target p-0 dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                    <div class="header-account__avtar">
                                        <div class="profile">
                                            <div class="profile__img">
                                                <img alt="" src="<?php echo UrlHelper::generateFileUrl('Image','profileImage',array(AdminAuthentication::getLoggedAdminId(),'croped',true));?>">
                                            </div>
                                            <div class="profile__detail">
                                                <h6><?php echo  Labels::getLabel('LBL_HI', $adminLangId); ?>, <?php echo AdminAuthentication::getLoggedAdminAttribute('admin_name',true);?> <h6>
                                                        <a href="mailto:<?php echo AdminAuthentication::getLoggedAdminAttribute('admin_email',true);?>" ><?php echo AdminAuthentication::getLoggedAdminAttribute('admin_email',true);?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator m-0"></div>
                                    <nav class="nav nav--header-account">
                                        <a href="<?php echo UrlHelper::generateUrl('profile'); ?>"> <?php echo  Labels::getLabel('LBL_MY_PROFILE', $adminLangId); ?></a>                                      
                                        <a href="<?php echo UrlHelper::generateUrl('profile','index',['changePassword']); ?>"><?php echo  Labels::getLabel('LBL_CHANGE_PASSWORD', $adminLangId); ?></a>
                                    </nav>
                                    <div class="separator m-0"></div>
                                    <nav class="nav nav--header-account">
                                        <?php if (1 < count($languages)) {
                                             ?>
                                                <a href="javascript:void(0)" class="language-selector">
                                                    Language
                                                    <span class="selected-language">
                                                        <?php echo CommonHelper::getLangCode() ?>
                                                        <span> 
                                                            <img src="<?php echo CONF_WEBROOT_FRONTEND; ?>images/flags/round/<?php echo CommonHelper::getLangCountryCode() ?>.svg"></span>
                                                    </span>
                                                    <div class="languages">
                                                    <?php foreach ($languages as $langId => $language) { ?>
                                                        <span <?php echo ($adminLangId == $langId) ? 'class="is--active"' : ''; ?> onClick="setSiteDefaultLang(<?php echo $langId; ?>)"><?php echo $language['language_name']; ?></span>                                                       
                                                        <?php } ?>
                                                    </div>
                                                </a>
                                        <?php 
                                        } ?>                                       
                                        <a href="<?php echo UrlHelper::generateUrl('profile','logout'); ?>"><?php echo  Labels::getLabel('LBL_LOGOUT', $adminLangId); ?></a>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>