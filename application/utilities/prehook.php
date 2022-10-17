<?php

define('CONF_FORM_ERROR_DISPLAY_TYPE', Form::FORM_ERROR_TYPE_AFTER_FIELD);
define('CONF_FORM_REQUIRED_STAR_WITH', Form::FORM_REQUIRED_STAR_WITH_CAPTION);
define('CONF_FORM_REQUIRED_STAR_POSITION', Form::FORM_REQUIRED_STAR_POSITION_AFTER);

FatApplication::getInstance()->setControllersForStaticFileServer(array('images', 'img', 'fonts', 'templates', 'innovas', 'assetmanager'));

$innova_settings = array(
    'width' => '730', 'height' => '400', 'arrStyle' => '[["body",false,"","min-height:250px;"]]',  'groups' => ' [
    ["group1", "", ["Bold", "Italic", "Underline", "FontName", "ForeColor", "TextDialog", "RemoveFormat"]],
    ["group2", "", ["Bullets", "Numbering", "JustifyLeft", "JustifyCenter", "JustifyRight"]],
    ["group3", "", ["LinkDialog", "ImageDialog", "YoutubeDialog", "Table", "TableDialog"]],
    ["group5", "", ["Undo", "Redo", "SourceDialog"]]]',
    'fileBrowser' => '"' . CONF_WEBROOT_URL . 'innova/assetmanager/asset_php"'
);

FatApp::setViewDataProvider('_partial/cart-summary.php', array('Common', 'cartSummary'));
/* offcanvas Forms */
FatApp::setViewDataProvider('_partial/footer-part/headerSearchFormArea.php', array('Common', 'headerSearchFormArea'));
FatApp::setViewDataProvider('_partial/headerUserArea.php', array('Common', 'headerUserArea'));
FatApp::setViewDataProvider('_partial/headerNavigation.php', array('Navigation', 'headerNavigation'));
FatApp::setViewDataProvider('_partial/headerLanguageArea.php', array('Common', 'headerLanguageArea'));
FatApp::setViewDataProvider('_partial/custom/header-breadcrumb.php', array('Common', 'setHeaderBreadCrumb'));
FatApp::setViewDataProvider('_partial/footerNewsLetterForm.php', array('Common', 'footerNewsLetterForm'));
FatApp::setViewDataProvider('_partial/headerTopNavigation.php', array('Navigation', 'headerTopNavigation'));
FatApp::setViewDataProvider('_partial/footer-part/mobile-header-top-navigation.php', array('Navigation', 'headerTopNavigation'));
FatApp::setViewDataProvider('_partial/footerNavigation.php', array('Navigation', 'footerNavigation'));
FatApp::setViewDataProvider('_partial/footerSocialMedia.php', array('Common', 'footerSocialMedia'));
FatApp::setViewDataProvider('_partial/footerTrustBanners.php', array('Common', 'footerTrustBanners'));
FatApp::setViewDataProvider('_partial/footerMetaContent.php', array('Common', 'footerMetaContent'));
// FatApp::setViewDataProvider('_partial/faq-list.php', array('Common', 'faqList'));