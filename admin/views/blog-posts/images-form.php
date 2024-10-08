<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('post_image');
$fld->value = '<div id="imageListingJs"></div>';
$fld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), $imageDimension['width'].'*'.$imageDimension['height']) . '</span>';;


$langFld = $frm->getField('lang_id');
$langFld->addFieldTagAttribute('onchange', 'loadImages(' . $recordId . ', this.value);');
$langFld->addFieldTagAttribute('id', 'postMediaLangId');

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];

$formTitle = Labels::getLabel('LBL_BLOG_POST_SETUP', $siteLangId);
$generalTab['attr']['onclick'] = 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")';
$langTabExtraClass = "modal-dialog-vertical-md";

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    $('input[name=min_width]').val(<?php echo $imageDimension['width'];?>);
    $('input[name=min_height]').val(<?php echo $imageDimension['height'];?>);  
    $(function() {
        $("#sortable").sortable({
            stop: function() {
                var mysortarr = new Array();
                $(this).find('li').each(function() {
                    mysortarr.push($(this).attr("id"));
                });
                var post_id = $('#imageFrm input[name=post_id]').val();
                var sort = mysortarr.join('-');
                data = '&post_id=' + post_id + '&ids=' + sort;
                fcom.updateWithAjax(fcom.makeUrl('BlogPosts', 'setImageOrder'), data, function(t) {
                    fcom.displaySuccessMessage(t.msg);
                    mediaForm(post_id);
                });
            }
        }).disableSelection();
        $('#postMediaLangId').trigger('change');
    });
</script>