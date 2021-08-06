<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$commonHeadData = array(
    'siteLangId' => $siteLangId,
    'siteLangCode' => $siteLangCode,
    'controllerName' => $controllerName,
    'action' => $action,
    'jsVariables' => $jsVariables,
    'cacheTimeStamp' => $cacheTimeStamp,
    'currencySymbolLeft' => $currencySymbolLeft,
    'currencySymbolRight' => $currencySymbolRight,
    'canonicalUrl' => isset($canonicalUrl) ? $canonicalUrl : '',
);

if (isset($socialShareContent) && $socialShareContent != '') {
    $commonHeadData['socialShareContent'] = $socialShareContent;
}

$this->includeTemplate('_partial/header/commonHeadTop.php', $commonHeadData, false);
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
/* ] */
$this->includeTemplate('_partial/header/commonHeadMiddle.php', $commonHeadData, false);
/* This is not included in common head, because, if we are adding any css/js from any controller then that file is not included[ */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
/* ] */

$this->includeTemplate('_partial/header/commonHeadBottom.php', $commonHeadData, false);
?>
<div class="wrapper">
    <div id="header" class="header header-advertiser">
        <?php
        if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl()) {
            $this->includeTemplate('restore-system/top-header.php');
        }
        ?>
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xs-6 d-none d-xl-block d-lg-block hide--mobile">
                        <div class="slogan"><?php // Labels::getLabel('LBL_Multi-vendor_Ecommerce_Marketplace_Solution', $siteLangId);   ?></div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="short-links">
                            <ul>
                                <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?>                          
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-head">
            <div class="container">
                <div class="logo-bar">
                    <div class="logo logo-advertiser">
                        <?php
                        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                        $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        ?>
                        <a href="<?php echo UrlHelper::generateUrl(); ?>">
                            <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?>
                                data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?>
                                src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>"
                                title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>">
                        </a>
                    </div>
                    <div class="short-links">
                        <ul>
                            <?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
                            <li>
                                <div class="dropdown dropdown--user">
                                    <a href="javascript:void(0)" class="sign-in sign-in-popup-js">
                                        <i class="icn icn--login">
                                            <svg class="svg">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"
                                                     href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login">
                                                </use>
                                            </svg>
                                        </i>
                                        <span>
                                            <strong><?php echo Labels::getLabel('LBL_Login_/_Sign_Up', $siteLangId); ?></strong>
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>