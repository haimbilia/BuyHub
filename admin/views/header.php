<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$includeDropZone = isset($includeDropZone) ? $includeDropZone : false;
if (isset($includeEditor) && $includeEditor == true) {
    $extendEditorJs = 'true';
} else {
    $extendEditorJs = 'false';
    $includeEditor = false;
}

$commonHeadData = array(
    'siteLangId' => $siteLangId,
    'jsVariables' => $jsVariables,
    'extendEditorJs' => $extendEditorJs,
    'includeEditor' => $includeEditor,
    'layoutDirection' => CommonHelper::getLayoutDirection()
);

$this->includeTemplate('_partial/header/common-head.php', $commonHeadData, false);

echo $this->writeMetaTags();
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE, true, false);
$commonHeadHtmlData = array(
    'bodyClass'         =>   isset($bodyClass) ? $bodyClass : '',
    'includeEditor'        =>   $includeEditor,
    'includeDropZone'        =>   $includeDropZone
);
$this->includeTemplate('_partial/header/common-header-html.php', $commonHeadHtmlData, false);

if ($isAdminLogged) {
    $this->includeTemplate('_partial/header/logged-user-header.php', $commonHeadData, false);
}
