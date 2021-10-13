<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="importExportUlJs">
    <li class="settings-inner-item <?php echo !empty($action) && $action == 'export' ? 'is-active' : ''; ?>">
        <a class="settings-inner-link" href="javascript:void(0)" onClick="loadForm('export', this)">
            <i class="settings-inner-icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                    </use>
                </svg>
            </i>
            <div class="">
                <h6 class="settings-inner-title"><?php echo Labels::getLabel('LBL_EXPORT', $adminLangId); ?></h6>
                <span class="settings-inner-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit est quos </span>
            </div>
        </a>
    </li>
    <li class="settings-inner-item <?php echo !empty($action) && $action == 'import' ? 'is-active' : ''; ?>">
        <a class="settings-inner-link" href="javascript:void(0)" onClick="loadForm('import', this)">
            <i class="settings-inner-icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                    </use>
                </svg>
            </i>
            <div class="">
                <h6 class="settings-inner-title"><?php echo Labels::getLabel('LBL_IMPORT', $adminLangId); ?></h6>
                <span class="settings-inner-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit est quos </span>
            </div>
        </a>
    </li>
    <li class="settings-inner-item <?php echo !empty($action) && $action == 'bulk_media' ? 'is-active' : ''; ?>">
        <a class="settings-inner-link" href="javascript:void(0)" onClick="loadForm('bulk_media', this)">
            <i class="settings-inner-icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                    </use>
                </svg>
            </i>
            <div class="">
                <h6 class="settings-inner-title"><?php echo Labels::getLabel('LBL_ADD_MEDIA_TO_SERVER', $adminLangId); ?></h6>
                <span class="settings-inner-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit est quos </span>
            </div>
        </a>
    </li>
    <li class="settings-inner-item <?php echo !empty($action) && $action == 'settings' ? 'is-active' : ''; ?>">
        <a class="settings-inner-link" href="javascript:void(0)" onClick="loadForm('settings', this)">
            <i class="settings-inner-icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                    </use>
                </svg>
            </i>
            <div class="">
                <h6 class="settings-inner-title"><?php echo Labels::getLabel('LBL_SETTINGS', $adminLangId); ?></h6>
                <span class="settings-inner-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit est quos </span>
            </div>
        </a>
    </li>
</ul>