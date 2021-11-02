<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card sticky-sidebar">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <a class="back" href="<?php echo UrlHelper::generateUrl('Settings'); ?>">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                        </use>
                                    </svg>
                                </a>
                                <?php echo Labels::getLabel('LBL_GENERAL_SETTINGS', $siteLangId); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <ul class="confTypesJs">
                                <?php foreach ($tabs as $formType => $tabName) {                                   
                                ?>
                                <li class="settings-inner-item <?php echo $tabsId; ?> <?php echo ($activeTab == $formType) ? 'is-active' : '' ?>"
                                    data-listType="<?php echo $formType; ?>">
                                    <a class="settings-inner-link" rel="tabJs-<?php echo $formType; ?>" href="javascript:void(0)"
                                        onclick="getForm(<?php echo $formType ?>, <?php echo $defaultLangId ?>);">
                                        <i class="settings-inner-icn">
                                            <svg class="svg" width="20" height="20">
                                                <use
                                                    xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#<?php echo isset($svgIconNames[$formType]) ? $svgIconNames[$formType] : 'icon-system-setting' ?>">
                                                </use>
                                            </svg>
                                        </i>
                                        <div>
                                            <h6 class="settings-inner-title"><?php echo $tabName; ?></h6>
                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Suscipit est quos </span>
                                        </div>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="frmBlockJs">
                <?php require_once(CONF_THEME_PATH . 'configurations/form.php'); ?>
            </div>
        </div>
    </div>
</main>

<script>
    var controllerName = '<?php echo $controller; ?>';
    var YES = <?php echo applicationConstants::YES; ?>;
    var NO = <?php echo applicationConstants::NO; ?>;
    var FORM_MEDIA = <?php echo Configurations::FORM_MEDIA; ?>;
</script>