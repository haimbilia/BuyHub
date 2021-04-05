<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('Buyer', 'setupOrderFeedback'));
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 8;
$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
$btnSubmit->setFieldTagAttribute('disabled', "disabled");
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <div class="content-header row">
            <div class="col">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Order_Feedback', $siteLangId);?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header">

                    <div class="product-card">
                        <div class="product-card__img">
                            <img src="http://localhost/yokart-V8/image/product/7/MEDIUM/0/1591"/>                        
                        </div> 
                        <div class="product-card__detail">
                             <h5 class="card-title">
                                 <?php echo Labels::getLabel('LBL_Product', $siteLangId),' : ',(!empty($opDetail['op_selprod_title']) ? $opDetail['op_selprod_title'] : $opDetail['op_product_name']) ,' ' ; ?>                    
                             </h5>
                             <h6><?php echo Labels::getLabel('LBL_Shop', $siteLangId),' : ', $opDetail['op_shop_name']; ?></h6>
                        </div> 
                    </div>

                    
                </div>
                <div class="card-body ">
                    <div class="rating-listing pb-4">                        
                        <div class="rating">
                            <div class="rating-action" data-rating="4">
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                            </div>
                            <span class="rating__text"> Shipping*</span>
                        </div>      
                        <div class="rating">
                            <div class="rating-action" data-rating="3">
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                            </div>
                            <span class="rating__text">Stock Availability*</span>
                        </div>    
                        <div class="rating">
                            <div class="rating-action" data-rating="2">
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                            </div>
                            <span class="rating__text">Delivery time*</span>
                        </div>    
                        <div class="rating">
                            <div class="rating-action" data-rating="4">
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                                <svg class="icon" width="24" height="24"> <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use></svg>
                            </div>
                            <span class="rating__text">Package Quality*</span>
                        </div>  
                    </div>
                    <form name="frmOrderFeedback" method="post" id="frm_fat_id_frmOrderFeedback" class="form form--horizontal" action="/Yokart-V8/buyer/setup-order-feedback">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                        <label class="field_label">Title<span class="spn_must_field">*</span></label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <input data-field-caption="Title" data-fatreq="{&quot;required&quot;:true}" type="text" name="spreview_title" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                        <label class="field_label">Description<span class="spn_must_field">*</span></label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <textarea data-field-caption="Description" data-fatreq="{&quot;required&quot;:true}" name="spreview_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-8">
                                <div class="field-set">
                                    <div class="field-wraper">
                                        <div class="field_cover">

                                            <div class="file__upload">
                                                <input type="file">
                                                <span class="upload-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <path d="M3 4V1h2v3h3v2H5v3H3V6H0V4zm3 6V7h3V4h7l1.83 2H21a2.006 2.006 0 0 1 2 2v12a2.006 2.006 0 0 1-2 2H5a2.006 2.006 0 0 1-2-2V10zm7 9a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm-3.2-5a3.2 3.2 0 1 0 3.2-3.2A3.2 3.2 0 0 0 9.8 14z" data-name="Path 2486"></path>
                                                    </svg>
                                                </span>
                                                <span>Upload images</span>
                                            </div>


                                             <div class="all-review-media mt-2">
                                                <ul class="review-media-list">
                                                    <li>
                                                        <div class="uploaded-file">
                                                            <span class="uploaded-file__thumb">
                                                              <img src="http://localhost/yokart-V8/image/product/7/MEDIUM/0/1591"/>            
                                                             </span>
                                                            <a href="javascript:void(0);" class="file-remove"></a>
                                                        </div>
                                                    </li> 
                                                    <li>
                                                        <div class="uploaded-file">
                                                            <span class="uploaded-file__thumb">
                                                              <img src="http://localhost/yokart-V8/image/product/7/MEDIUM/0/1591"/>            
                                                             </span>
                                                            <a href="javascript:void(0);" class="file-remove"></a>
                                                        </div>
                                                    </li> 
                                                    <li>
                                                        <div class="uploaded-file">
                                                            <span class="uploaded-file__thumb">
                                                              <img src="http://localhost/yokart-V8/image/product/7/MEDIUM/0/1591"/>            
                                                             </span>
                                                            <a href="javascript:void(0);" class="file-remove"></a>
                                                        </div>
                                                    </li> 
                                                    <li>
                                                        <div class="uploaded-file">
                                                            <span class="uploaded-file__thumb">
                                                              <img src="http://localhost/yokart-V8/image/product/7/MEDIUM/0/1591"/>            
                                                             </span>
                                                            <a href="javascript:void(0);" class="file-remove"></a>
                                                        </div>
                                                    </li> 
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="field-set">                                   
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                        <label class="mb-3"><span class="checkbox"><input data-field-caption="I Agree That My Review, Including My Name, Username, May Be Shared By {website-name} On Its Website And Mobile App To The Public. Further Details Of Which Are Set Out In The Privacy Policy Which I Have Previously Consented" data-fatreq="{&quot;required&quot;:false}" type="checkbox" name="agree" value="1"><i class="input-helper"></i></span>I Agree That My Review, Including My Name, Username, May Be Shared By {website-name} On Its Website And Mobile App To The Public. Further Details Of Which Are Set Out In The Privacy Policy Which I Have Previously Consented</label>

                                            <input class="btn btn-brand" disabled="disabled" data-field-caption="" data-fatreq="{&quot;required&quot;:false}" type="submit" name="btn_submit" value="Send Review">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php //echo $frm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(document).ready(function() {
        // $('.star-rating').barrating({
        //     showSelectedRating: false
        // });
        
        $("input[name='agree']").change(function() {
            if(this.checked) { 
                $("input[name='btn_submit']").removeAttr('disabled');
            }else{
                $("input[name='btn_submit']").attr('disabled', 'disabled');
            }            
        });        
    });
</script>
