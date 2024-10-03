<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('id', 'frmBlogPostJs');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#frmBlogPostJs"));');
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")');

$fld = $frm->getField('post_author_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('post_published');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$fld = $frm->getField('categories');
$fld->addFieldTagAttribute('class', 'tagifyJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_TYPE_TO_SEARCH', $siteLangId));

$fld = $frm->getField('post_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','brand_id');
getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('post_id');
$fld->setFieldTagAttribute('id', "post_id");

$fld = $frm->getField('urlrewrite_custom');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<span class='form-text text-muted'>" . HtmlHelper::seoFriendlyUrl(UrlHelper::generateFullUrl('Blog', 'postDetail', array($recordId), CONF_WEBROOT_FRONT_URL)) . '</span>';
$fld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");

$fld = $frm->getField('urlrewrite_custom');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];


$fld = $frm->getField('post_comment_opened');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$fld = $frm->getField('post_featured');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];

$generalTab['attr']['onclick'] = 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")';
$langTabExtraClass = "modal-dialog-vertical-md";

$formClassExtra = 'checkboxSwitchJs';
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    addBlogPostCategory = function(e) {
        var bpcId = e.detail.tag.id;
        if ('' == bpcId) {
            e.detail.tag.remove();
            return false;
        }
    }

    getCategories = function(e) {
        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('BlogPosts', 'getCategories'), {
            keyword: keyword
        }, function(t) {
            tagify.settings.whitelist = JSON.parse(t);
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

    tagifyCategories = function() {
        var element = '.tagifyJs';
        if ('undefined' !== typeof $(element).attr('disabled')) {
            return;
        }
        $(element).siblings(".tagify").remove();
        tagify = new Tagify(document.querySelector('.tagifyJs'), {
            whitelist: [],
            dropdown: {
                position: 'text',
                enabled: 0 // show suggestions dropdown after 1 typed character
            },
            delimiters: "#",
            editTags: false,
        }).on('add', addBlogPostCategory).on('input', getCategories).on('focus', getCategories);
    };
    tagifyCategories();
</script>