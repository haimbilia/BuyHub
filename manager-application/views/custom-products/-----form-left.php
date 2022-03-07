<div class="add-stock-column column-nav">
    <div class="sticky-top">
        <div class="card">
            <div class="card-body p-0">
                <div class="stock-nav">
                    <ul>
                        <li class="stock-nav-item is-active">
                            <a class="stock-nav-link" href="#basic-details">
                                <i class="stock-nav-icn">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                        </use>
                                    </svg>
                                </i>
                                <div class="">
                                    <h6 class="stock-nav-title">
                                        <?php echo Labels::getLabel('NAV_BASIC_DETAILS', $siteLangId); ?></h6>
                                    <span class="stock-nav-desc"> <?php echo Labels::getLabel('MSG_MANAGE_PRODUCT_BASIC_INFORMATIONS', $siteLangId); ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="stock-nav-item">
                            <a class="stock-nav-link" href="#variants-options">
                                <i class="stock-nav-icn">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                        </use>
                                    </svg>
                                </i>
                                <div class="">
                                    <h6 class="stock-nav-title">
                                        <?php echo Labels::getLabel('NAV_VARIANTS_&_OPTIONS', $siteLangId); ?></h6>
                                    <span class="stock-nav-desc"> <?php echo Labels::getLabel('MSG_CUSTOMIZE_PRODUCT_VARIENTS_INCLUDING_SIZE_COLOR_ETC', $siteLangId); ?></span>
                                </div>
                            </a>
                        </li>
                        <li class="stock-nav-item">
                            <a class="stock-nav-link" href="#media">
                                <i class="stock-nav-icn">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                        </use>
                                    </svg>
                                </i>
                                <div class="">
                                    <h6 class="stock-nav-title">
                                        <?php echo Labels::getLabel('NAV_MEDIA', $siteLangId); ?></h6>
                                    <span class="stock-nav-desc"> <?php echo Labels::getLabel('MSG_MANAGE_YOUR_PRODUCT_IMAGES_GALLERY', $siteLangId); ?> </span>
                                </div>
                            </a>
                        </li>
                        <li class="stock-nav-item">
                            <a class="stock-nav-link" href="#specifications">
                                <i class="stock-nav-icn">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                        </use>
                                    </svg>
                                </i>
                                <div class="">
                                    <h6 class="stock-nav-title">
                                        <?php echo Labels::getLabel('NAV_SPECIFICATIONS', $siteLangId); ?></h6>
                                    <span class="stock-nav-desc"> <?php echo Labels::getLabel('MSG_MANAGE_PRODUCT_RELATED_SPECIFICATIONS', $siteLangId); ?></span>
                                </div>
                            </a>
                        </li>
                        <li class="stock-nav-item">
                            <a class="stock-nav-link" href="#tax-shipping">
                                <i class="stock-nav-icn">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                        </use>
                                    </svg>
                                </i>
                                <div class="">
                                    <h6 class="stock-nav-title">
                                        <?php echo Labels::getLabel('NAV_TAX_AND_SHIPPING', $siteLangId); ?></h6>
                                    <span class="stock-nav-desc"> <?php echo Labels::getLabel('MSG_SETUP_TAX_AND_SHIPPING_INFORMATION_OF_THE_PRODUCT', $siteLangId); ?> </span>
                                </div>
                            </a>
                        </li>
                        <?php if ($displayDigitalDownloadList) { ?>
                            <li class="stock-nav-item">
                                <a class="stock-nav-link" href="#digital-files">
                                    <i class="stock-nav-icn">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                            </use>
                                        </svg>
                                    </i>
                                    <div class="">
                                        <h6 class="stock-nav-title">
                                            <?php echo Labels::getLabel('NAV_DIGITAL_FILES', $siteLangId); ?></h6>
                                        <span class="stock-nav-desc"><?php echo Labels::getLabel('MSG_MANAGE_PRODUCT_DIGITIAL_FILES', $siteLangId); ?>
                                        </span>
                                    </div>
                                </a>
                            </li>
                            <li class="stock-nav-item">
                                <a class="stock-nav-link" href="#digital-links">
                                    <i class="stock-nav-icn">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                            </use>
                                        </svg>
                                    </i>
                                    <div class="">
                                        <h6 class="stock-nav-title"><?php echo Labels::getLabel('NAV_DIGITAL_LINKS', $siteLangId); ?></h6>
                                        <span class="stock-nav-desc"><?php echo Labels::getLabel('MSG_MANAGE_PRODUCT_DIGITIAL_LINKS', $siteLangId); ?></span>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>