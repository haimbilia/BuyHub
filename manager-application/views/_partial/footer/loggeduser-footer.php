<!-- begin:: Footer -->
<footer class="footer" id="footer">
    <div class="container">
        <div class="copyright">
            <?php $this->includeTemplate('_partial/footer/copyright-text.php', $this->variables, false); ?>
        </div>
    </div>
</footer>

<div class="footer-action">
   
    <div class="footer-action__item">
        <a class="footer-action__trigger" href="javascript:void(0);">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-search">
                    </use>
                </svg>
            </span>
        </a>

    </div>
    <div class="footer-action__item">
        <a class="footer-action__trigger" href="javascript:void(0)" title="View Store">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                    </use>
                </svg>
            </span>
        </a>
    </div> <div class="footer-action__item">
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
        <a class="footer-action__trigger" href="javascript:void(0)" title="Clear Cache">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-cache">
                    </use>
                </svg>
            </span>
        </a>
    </div>
    <div class="footer-action__item dropdown">
        <a class="footer-action__trigger dropdown-toggle no-after" data-toggle="dropdown" href="javascript:void(0)">
            <span class="icon">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-notification">
                    </use>
                </svg>
            </span>
        </a>

    </div>
    <div class="footer-action__item dropdown header-account">
        <a class=" dropdown-toggle no-after" data-toggle="dropdown" href="javascript:void(0)">
            <span class="header-account__img">
                <img aria-expanded="false" src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" alt="">
            </span>
        </a>
        <div class="footer-action__target p-0 dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
            <div class="header-account__avtar">
                <div class="profile">
                    <div class="profile__img">
                        <img alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg">
                    </div>
                    <div class="profile__detail">
                        <h6>Hi, Michael Williams <h6>
                                <a href="#" class="">max@kt.com</a>
                    </div>
                </div>
            </div>
            <div class="separator m-0"></div>
            <nav class="nav nav--header-account">
                <a href="#">View Profile</a>
                <a href="#">Orders</a>
                <a href="#">Change password</a>
            </nav>
            <div class="separator m-0"></div>
            <nav class="nav nav--header-account">
                <a href="#" class="language-selector">
                    Language
                    <span class="selected-language">
                        English
                        <span>
                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/flags/009-australia.svg" alt=""></span>
                    </span>
                    <div class="languages">
                        <span onclick="">English</span>
                        <span onclick="">Arabic</span>
                    </div>
                </a>
                <a href="#">System Setting</a>
                <a href="#">Sign out</a>
            </nav>
        </div>
    </div>
</div>