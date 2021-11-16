<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($imagesFrm);
$imagesFrm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$imagesFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');

$fld = $imagesFrm->getField('post_image');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_BLOG_POST_IMAGE", $siteLangId),
        'data-frm'=> $imagesFrm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);

$htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), '1000*563') . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;


$langFld = $imagesFrm->getField('lang_id');
$langFld->addFieldTagAttribute('onchange', 'loadImages(' . $recordId . ', this.value);');

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

$formTitle = Labels::getLabel('LBL_BLOG_POST_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $imagesFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script type="text/javascript">
    $('input[name=min_width]').val(1000);
    $('input[name=min_height]').val(563);
    var aspectRatio = 1000 / 563;
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
                    mediaForm(post_id);
                });
            }
        }).disableSelection();
    });
</script>