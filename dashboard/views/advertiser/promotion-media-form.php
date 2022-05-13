<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($mediaFrm, 6);
$mediaFrm->setFormTagAttribute('class', 'form form--horizontal');
$mediaFrm->setFormTagAttribute('onsubmit', 'setupPromotionMedia(this); return(false);');

$uploadfld = $mediaFrm->getField('banner_html');
$uploadfld->developerTags['colWidthValues'] = [null, '12', null, null];
$uploadfld->value = '<span id="bannerHtml"></span>';

$langFld = $mediaFrm->getField('lang_id');
$langFld->addFieldTagAttribute('class', 'banner-language-js');

$screenFld = $mediaFrm->getField('banner_screen');
$screenFld->addFieldTagAttribute('class', 'banner-screen-js');

$preferredDimensionsStr = '<span class="form-text text-muted uploadimage--info" ></span>';

$uploadfld->htmlAfterField = $preferredDimensionsStr;
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PROMOTION_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link" href="javascript:void(0);" title="<?php echo Labels::getLabel('NAV_GENERAL', $siteLangId); ?>" onclick="promotionForm(<?php echo $recordId; ?>)"><?php echo Labels::getLabel('NAV_GENERAL', $siteLangId); ?></a>
            <?php if(0 < count($languages)){ ?>
            <a class="nav-link " href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='promotionLangForm(" . $recordId . "," . array_key_first($languages) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>  
            <?php } ?>        
            <?php if ($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES) { ?>
                <a class="nav-link active"  href="javascript:void(0)" <?php if ($recordId > 0) { ?> onclick="promotionMediaForm(<?php echo $recordId; ?>)" <?php } ?>><?php echo Labels::getLabel('LBL_Media', $siteLangId); ?></a>
            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <div class="row" id="promotionsChildBlockJs">
            <div class="col-md-12">
                <?php echo $mediaFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>    
</div>
<script>

    $(document).off('change', '.banner-screen-js').on('change', '.banner-screen-js', function() {
        var promotionType = <?php echo $promotionType ?>;
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if (promotionType == <?php echo Promotion::TYPE_SLIDES ?>) {
            if ($(this).val() == screenDesktop) {            
                $('input[name=banner_min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['width'];?>);
                $('input[name=banner_min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['height'];?>);               
            } else if ($(this).val() == screenIpad) {               
                $('input[name=banner_min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['width'];?>);
                $('input[name=banner_min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_TABLET]['height'];?>);
                
            } else {              
                $('input[name=banner_min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_MOBILE]['width'];?>);
                $('input[name=banner_min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_MOBILE]['height'];?>);                
            }
            $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, $('input[name=banner_min_width]').val() +' * '+ $('input[name=banner_min_height]').val()));
        } else if (promotionType == <?php echo Promotion::TYPE_BANNER ?>) {
            var deviceType = $(this).val();
            fcom.ajax(fcom.makeUrl('Advertiser', 'getBannerLocationDimensions', [<?php echo $recordId; ?>, deviceType]), '', function(t) {
                var ans = $.parseJSON(t);
                $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, ans.bannerWidth + ' * ' + ans.bannerHeight));
                $('input[name=banner_min_width]').val(ans.bannerWidth);
                $('input[name=banner_min_height]').val(ans.bannerHeight);                
            });
        }
        var screen_id = $(this).val();
        var promotion_id = $("input[name='promotion_id']").val();
        var lang_id = $(".banner-language-js").val();
        images(promotion_id, lang_id, screen_id);

    });
    $('.banner-screen-js').trigger('change');
</script>