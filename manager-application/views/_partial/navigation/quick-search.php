<div class="quick-search">
    <form method="get" class="form form--quick-search">
        <div class="quick-search__form">
            <input id="quickSearch" type="search" class="form-control" placeholder="<?php echo Labels::getLabel('LBL_GO_TO..', $adminLangId); ?>">
        </div>
        <div class="quick-search__wrapper">
            <ul class="list list--search-result navMenuItems" style="display: none;">
                <li>
                    <h6 class="title">Catalog</h6>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">Branrds</a>
                    </div>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">Products</a>
                    </div>
                </li>
                <li>
                    <h6 class="title">CMS</h6>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">Country</a>
                    </div>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">State</a>
                    </div>

                </li>
                <li>
                    <h6 class="title">Settings</h6>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">settings</a>
                    </div>
                </li>
                <li>
                    <h6 class="title">SEO</h6>
                    <div class="search-result">
                        <span class="search-result__icon">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                </use>
                            </svg>
                        </span>
                        <a class="search-result__link" href="javascript:;">Meta Tags</a>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>