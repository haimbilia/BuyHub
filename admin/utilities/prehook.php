<?php
define('CONF_FORM_ERROR_DISPLAY_TYPE', Form::FORM_ERROR_TYPE_AFTER_FIELD);
define('CONF_FORM_REQUIRED_STAR_WITH', Form::FORM_REQUIRED_STAR_WITH_CAPTION);
define('CONF_FORM_REQUIRED_STAR_POSITION', Form::FORM_REQUIRED_STAR_POSITION_AFTER);

FatApplication::getInstance()->setControllersForStaticFileServer(array('images', 'fonts', 'js', 'img', 'innovas', 'assetmanager'));

$innova_settings  =  array(/* 'width'=>'100%', */
    'height' => '400', 'arrStyle' => '[["body",false,"","min-height:250px;"]]',  'groups' => ' [
    ["group1", "", ["Bold", "Italic", "Underline", "FontName", "ForeColor", "TextDialog", "RemoveFormat"]],
    ["group2", "", ["Bullets", "Numbering", "JustifyLeft", "JustifyCenter", "JustifyRight"]],
    ["group3", "", ["LinkDialog", "ImageDialog", "YoutubeDialog", "Table", "TableDialog"]],
    ["group5", "", ["Undo", "Redo", "SourceDialog"]]]',
    'fileBrowser' => '"' . CONF_WEBROOT_URL . 'innova/assetmanager/asset_php"',
    'css' => '"' . CONF_WEBROOT_URL . 'innovas/styles/default.css"',
    /* 'css'=>'"' . UrlHelper::generateFullUrl ( 'JsCss', 'cssCommon', array (), '', false ) . '&f=' . rawurlencode ( 'style.css' ) */
);
/*["group5", "", ["Undo", "Redo", "FullScreen", "SourceDialog"]]]', */
/* $innova_settings  =  array('width'=>'650', 'height'=>'400','arrStyle'=>'[["body",false,"","min-height:250px;"]]','fileBrowser'=> '"'.CONF_WEBROOT_URL.'innova/assetmanager/asset_php"', 'css'=> '"'.CONF_WEBROOT_URL.'innovas/styles/default.css"' ); */

FatApp::setViewDataProvider('_partial/navigation/left-navigation.php', array('Navigation', 'setLeftNavigationVals'));   
FatApp::setViewDataProvider('_partial/header/header-breadcrumb.php', array('Common', 'setHeaderBreadCrumb'));
FatApp::setViewDataProvider('_partial/header/logged-user-header.php', array('Common', 'setNotificationDetail'));


