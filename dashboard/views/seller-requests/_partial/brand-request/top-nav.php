<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$generalTabActive = (isset($generalTabActive) && true === $generalTabActive ? 'active' : '');
$langTabActive = (isset($langTabActive) && true === $langTabActive ? 'active' : '');
$mediaTabActive = (isset($mediaTabActive) && true === $mediaTabActive ? 'active' : '');
?>
<div class="form-edit-head">
    <nav class="nav nav-tabs navTabsJs">
        <a class="nav-link <?php echo $generalTabActive; ?>" href="javascript:void(0);" onclick="addBrandReqForm(<?php echo $brandReqId; ?>);">
            <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
        </a>
        <?php if (0 < count($languages)) { ?>
            <a class="nav-link <?php echo $langTabActive; ?> <?php echo (0 == $brandReqId) ? 'fat-inactive' : ''; ?>" href="javascript:void(0);" <?php echo (0 < $brandReqId) ? "onclick='addBrandReqLangForm(" . $brandReqId . "," . array_key_first($languages) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>
        <?php } ?>

        <a class="nav-link <?php echo $mediaTabActive; ?> <?php echo (0 == $brandReqId) ? 'fat-inactive' : ''; ?>" href="javascript:void(0);" <?php if ($brandReqId > 0) { ?> onclick="brandMediaForm(<?php echo $brandReqId ?>);" <?php } ?>>
            <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
        </a>
    </nav>
</div>