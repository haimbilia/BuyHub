<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$fld = $frm->getField('categories');
$fld->addFieldTagAttribute('class', 'tagifyJs');

$fld = $frm->getField('post_identifier');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','brand_id');
getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('post_id');
$fld->setFieldTagAttribute('id', "post_id");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<small class='text--small'>" . UrlHelper::generateFullUrl('Blog', 'postDetail', array($recordId), CONF_WEBROOT_FRONT_URL) . '</small>';
$fld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'postImages(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];

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
            whitelist : [],
            delimiters : "#",
            editTags : false, 
        }).on('add', addBlogPostCategory).on('input', getCategories).on('focus', getCategories);
    };
    tagifyCategories();
</script>