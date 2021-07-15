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
    'fileBrowser' => '"' . CONF_WEBROOT_URL . 'innova/assetmanager/asset.php"'
);

FatApp::setViewDataProvider('_partial/buyerDashboardNavigation.php', array('Navigation', 'buyerDashboardNavigation'));
FatApp::setViewDataProvider('_partial/advertiser/advertiserDashboardNavigation.php', array('Navigation', 'advertiserDashboardNavigation'));
FatApp::setViewDataProvider('_partial/seller/sellerDashboardNavigation.php', array('Navigation', 'sellerDashboardNavigation'));
FatApp::setViewDataProvider('_partial/affiliate/affiliateDashboardNavigation.php', array('Navigation', 'affiliateDashboardNavigation'));
FatApp::setViewDataProvider('_partial/topHeaderDashboard.php', array('Navigation', 'topHeaderDashboard'));

FatApp::setViewDataProvider('_partial/headerUserArea.php', array('Common', 'headerUserArea'));
FatApp::setViewDataProvider('_partial/dashboardLanguageArea.php', array('Common', 'headerLanguageArea'));
FatApp::setViewDataProvider('_partial/dashboardTop.php', array('Navigation', 'dashboardTop'));
// FatApp::setViewDataProvider('_partial/userDashboardMessages.php', array('Common', 'userMessages'));
FatApp::setViewDataProvider('_partial/footerNavigation.php', array('Navigation', 'footerNavigation'));
FatApp::setViewDataProvider('_partial/seller/sellerSalesGraph.php', array('Statistics', 'sellerSalesGraph'));
