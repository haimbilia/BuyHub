<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <button class="float-btn" type="button" data-trigger="card-aside">
                    <svg class="svg" width="20" height="20">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#nav">
                        </use>
                    </svg>
                </button>
                <div class="card  sticky-sidebar card-aside" id="card-aside" data-close-on-click-outside="card-aside">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <?php echo Labels::getLabel('LBL_IMPORT_EXPORT', $siteLangId); ?>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="btn btn-gray card-aside-close" data-target-close="card-aside">
                                <svg class="svg" width="24" height="24">
                                    <use
                                        xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#close">
                                    </use>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <?php
                            $this->includeTemplate('import-export/_partial/top-navigation.php', ['siteLangId' => $siteLangId, 'action' => $action], false); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card" id="tabData"></div>
            </div>
        </div>
    </div>
</main>
