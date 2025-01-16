<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$formOnSubmit = 'saveRecord($("#frmCMSPage")); return(false);';
$fld = $frm->getField('cpage_title');

$fld = $frm->getField('cpage_hide_header_footer');
HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("FRM_HIDE_HEADER_&_FOOTER_FROM_THIS_CONTENT_PAGE", $siteLangId));

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = '<span class="form-text text-muted">' . HtmlHelper::seoFriendlyUrl(UrlHelper::generateFullUrl('Cms', 'View', array($recordId), CONF_WEBROOT_FRONT_URL)) . '</span>';
$fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");

$displayLangTab = false;
$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'editLangData(' . $recordId . ',' . CommonHelper::getDefaultFormLangId() . ', 0, "modal-dialog-vertical-md");',
            'title' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        'isActive' => false
    ]
];

$formTitle = Labels::getLabel('LBL_CONTENT_PAGE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
