<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($images as $image) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']); ?>

    <li class="upload__list-item" id="<?php echo $image['afile_id']; ?>">
        <div class="media">
            <img class="mr-2 product-profile-img" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($image['afile_record_id'], "THUMB",0, $image['afile_id'],$image['afile_lang_id'],$image['afile_type']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $image['afile_name']; ?>" alt="<?php echo $image['afile_name']; ?>" width="50">
        </div>
        <div class="title"><?php echo $image['afile_name'] ?></div>
        <?php if ($canEdit) { ?>
            <div class="action">
                <a href="javascript:void(0);" class="" title="<?php echo Labels::getLabel('FRM_REMOVE_IMAGE', $siteLangId); ?>" onclick="deleteImage(<?php echo $image['afile_record_id']; ?>, <?php echo $image['afile_id']; ?>, <?php echo $image['afile_type']; ?>);"> </a>
            </div>
        <?php }  ?>
        </div>
    </li>
<?php
}
?>

<script type="text/javascript">
    $(function() {
        $("#productImagesJs").sortable({
            stop: function() {
                var mysortarr = new Array();
                $(this).find('li').each(function() {
                    mysortarr.push($(this).attr("id"));
                });
                
                var sort = mysortarr.join('-');
                var lang_id = $('.language-js').val();
                var product_id = $('#image_product_id').val();
                var option_id = $('#image_option_id').val();
                var option_id = $('#image_option_id').val();
                var file_type = $('#image_file_type').val();
                fcom.updateWithAjax(fcom.makeUrl('products', 'setImageOrder'), {
                    product_id,
                    file_type,
                    ids: sort
                }, function(t) {
                    productImages(product_id, file_type, option_id, lang_id);
                });
            }
        }).disableSelection();
    });
</script>