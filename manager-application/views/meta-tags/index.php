<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main">
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row grid-layout">
            <div class="col-lg-4">
                <button class="float-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#card-aside" aria-controls="card-aside">
                    <svg class="svg" width="20" height="20">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#nav">
                        </use>
                    </svg>
                </button>
                <div class="card  offcanvas sticky-sidebar sticky-top  card-aside" tabindex="-1" id="card-aside" aria-labelledby="card-asideLabel">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <?php echo Labels::getLabel('LBL_headings', $siteLangId); ?>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn-close card-aside-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <ul class="metaTypesJs">
                                <?php foreach ($tabsArr as $tabMetaType => $metaDetail) {
                                    $tabsId = 'tabJs-' . $tabMetaType; ?>

                                    <li class="settings-inner-item <?php echo $tabsId; ?> <?php echo ($activeTab == $tabMetaType) ? 'is-active' : '' ?>">
                                        <a class="settings-inner-link" href="javascript:void(0)" onclick='tabSearchRecords("<?php echo $tabMetaType; ?>")'>
                                            <i class="settings-inner-icn">
                                                <svg class="svg" width="20" height="20">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-extension">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div>
                                                <h6 class="settings-inner-title"><?php echo $metaDetail['name']; ?></h6>
                                                <span class="settings-inner-desc"><?php echo $metaDetail['msg'];?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="metaTagsListing">
                    <?php require_once(CONF_THEME_PATH . 'meta-tags/search.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>