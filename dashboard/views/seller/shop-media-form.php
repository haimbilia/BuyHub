<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $shopLogoFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopLogoFrm->setFormTagAttribute('class', 'form');
    $shopLogoFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopLogoFrm->developerTags['fld_default_col'] = 12;
    $ratioFld = $shopLogoFrm->getField('ratio_type');
    $ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
    $fld = $shopLogoFrm->getField('shop_logo');
    $fld->addFieldTagAttribute('class', 'btn btn-sm');
    $fld->addFieldTagAttribute('onChange', 'logoPopupImage(this)');

    $shopBannerFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopBannerFrm->setFormTagAttribute('class', 'form');
    $shopBannerFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopBannerFrm->developerTags['fld_default_col'] = 12;
    $screenFld = $shopBannerFrm->getField('slide_screen');
    $screenFld->addFieldTagAttribute('class', 'prefDimensions-js');
    $fld = $shopBannerFrm->getField('shop_banner');
    $fld->addFieldTagAttribute('class', 'btn  btn-sm');
    $fld->addFieldTagAttribute('onChange', 'bannerPopupImage(this)');

    $shopBackgroundImageFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopBackgroundImageFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopBackgroundImageFrm->developerTags['fld_default_col'] = 12;
    $fld = $shopBackgroundImageFrm->getField('shop_background_image');
    $fld->addFieldTagAttribute('class', 'btn btn-sm');
    $shopLayout= SHOP::TEMPLATE_ONE;
?>

<div class="card-body">
    <div class="row">
    <div id="mediaResponse"></div>
    <div class="col-md-6">
        <div class="preview">
        <h5><?php echo Labels::getLabel('LBL_Banner_Setup', $siteLangId); ?></h5>
          <small class="form-text text-muted preferredDimensions-js"><?php echo sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '2000 x 500'); ?></small>
           <div class="gap"></div>
            <?php echo $shopBannerFrm->getFormHtml();?>
           <div class="row">
               <div class="col-md-12">
                    <ul class="uploaded-media" id="banner-image-listing">                       
                    </ul>
                </div>   
           </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="preview">
        <h5><?php echo Labels::getLabel('LBL_Logo_Setup', $siteLangId); ?></h5>
            <small class="form-text text-muted logoPreferredDimensions-js"><?php echo sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '150 x 150'); ?></small>
            <div class="gap"></div>
            <?php echo $shopLogoFrm->getFormHtml();?>
            <div  class="row">
               <div class="col-md-12">
                    <ul class="uploaded-media" id="logo-image-listing">                       
                    </ul>
                </div>   
            </div>           
        </div>
    </div>
</div>

</div>
 
<script>
$('input[name=banner_min_width]').val(2000);
$('input[name=banner_min_height]').val(500);
$('input[name=logo_min_width]').val(150);
$('input[name=logo_min_height]').val(150);
var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
var aspectRatio = 4 / 1;
$(document).on('change','.prefDimensions-js',function(){
    var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
    var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

    if($(this).val() == screenDesktop)
    {
        $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
        $('input[name=banner_min_width]').val(2000);
        $('input[name=banner_min_height]').val(500);
        aspectRatio = 4 / 1;
    }
    else if($(this).val() == screenIpad)
    {
        $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
        $('input[name=banner_min_width]').val(1024);
        $('input[name=banner_min_height]').val(360);
        aspectRatio = 128 / 45;
    }
    else{
        $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
        $('input[name=banner_min_width]').val(640);
        $('input[name=banner_min_height]').val(360);
        aspectRatio = 16 / 9;
    }
});

$(document).on('change','.prefRatio-js',function(){
    if($(this).val() == ratioTypeSquare)
    {
        $('input[name=logo_min_width]').val(150);
        $('input[name=logo_min_height]').val(150);
		$('.logoPreferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '150 x 150'));
    } else {
        $('input[name=logo_min_width]').val(150);
        $('input[name=logo_min_height]').val(85);
		$('.logoPreferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '150 x 85'));
    }
});
</script>
