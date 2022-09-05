<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<div class="offcanvas offcanvas-top offcanvas-mega-search" tabindex="-1" id="mega-nav-search">
    <?php $headerSrchFrm->getFormTag();
    $headerSrchFrm->setFormTagAttribute('class', ' mega-search-form');

    $keywordFld = $headerSrchFrm->getField('keyword');
    $keywordFld->overrideFldType('search');
    $keywordFld->setFieldTagAttribute('class', 'mega-search-input search--keyword search--keyword--js');
    $keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_I_am_looking_for...', $siteLangId));

    $keywordFld->setFieldTagAttribute('id', 'header_search_keyword');


    $selectFld = $headerSrchFrm->getField('category');
    $selectFld->setFieldTagAttribute('id', 'searched_category');
    ?>

    <div class="mega-search">
        <div class="logo">
            <a href="<?php echo UrlHelper::generateUrl(); ?>">
                <?php
                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>
                <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
            </a>
        </div>
        <div class="mega-search-inner">
            <?php echo $headerSrchFrm->getFormTag(); ?>
            <?php echo $headerSrchFrm->getFieldHTML('keyword'); ?>
            <div id="search-suggestions-js"> </div>
            <?php echo $headerSrchFrm->getFieldHTML('category'); ?>
            </form>
            <?php echo $headerSrchFrm->getExternalJS(); ?>

        </div>
        <button type="button" class="btn btn-close text-reset btn-search-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
</div>