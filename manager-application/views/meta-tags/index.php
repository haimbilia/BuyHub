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
                                <?php echo Labels::getLabel('LBL_META_TAGS_MANAGEMENT', $siteLangId); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <ul class="metaTypesJs">
                                <?php foreach ($tabsArr as $tabMetaType => $metaDetail) {
                                    $tabsId = 'tabJs-' . $tabMetaType; ?>

                                <li
                                    class="settings-inner-item <?php echo $tabsId; ?> <?php echo ($activeTab == $tabMetaType) ? 'is-active' : '' ?>">
                                    <a class="settings-inner-link" href="javascript:void(0)"
                                        onClick='searchRecords("<?php echo $tabMetaType; ?>")'>
                                        <i class="settings-inner-icn">
                                            <svg class="svg" width="20" height="20">
                                                <use
                                                    xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-extension">
                                                </use>
                                            </svg>
                                        </i>
                                        <div>
                                            <h6 class="settings-inner-title"><?php echo $metaDetail['name']; ?></h6>
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
            <div class="col-md-8">
                <div id="metaTagsListing">
                    <?php require_once(CONF_THEME_PATH . 'meta-tags/search.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
var controllerName = '<?php echo $controller; ?>';
getHelpCenterContent(controllerName);
</script>