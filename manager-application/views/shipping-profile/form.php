<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$frm->setFormTagAttribute('class', 'form form-edit');
$frm->setFormTagAttribute('onsubmit', 'setupProfile(this); return(false);');
?>

<main class="main mainJs">
    <div class="container"> 
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>

        <div class="row"> 
            <div class="col-md-12">  
                <div class="card"> 
                    <div class="card-head"> 
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_PROFILE_Name', $siteLangId); ?></h3>
                        </div> 

                    </div>
                    <div class="card-body">
                        <?php echo $this->includeTemplate('shipping-profile/profile-name-form.php', ['frm' => $frm, 'siteDefaultLangId' => $siteDefaultLangId, 'siteLangId' => $siteLangId, 'languages' => $languages], false, true); ?>
                    </div>  
                </div>
                <div class="card"> 
                    <div class="card-head"> 
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_PRODUCTS', $siteLangId); ?></h3>
                        </div> 

                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <?php if (empty($profileData) || ((isset($profileData['shipprofile_default'])))) { ?>
                                <div class="portlet col-md-12" id="product-section--js">
                                    <div class="portlet__head">
                                        <div class="portlet__head-label">
                                            <h3 class="portlet__head-title"><?php echo Labels::getLabel('LBL_Total_Products', $siteLangId); ?>
                                                : <?php echo $productCount; ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="portlet__body">
                                        <p><span class='form-text text-muted'><?php echo Labels::getLabel('LBL_We_don\'t_show_product_list_in_default_profile._The_products_removed_from_other_profiles_will_automatically_add_in_default_profile', $siteLangId); ?></span>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>  
                </div>


                <div class="card"> 
                    <div class="card-head"> 
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_Shipping_to', $siteLangId); ?></h3>
                        </div> 
                        <div class="card-toolbar">
                            <div class="maintenance-mode">
                                <a class="btn btn-clean btn-sm btn-icon" href="javascript:void(0);" onClick="zoneForm(<?php echo $profile_id; ?>, 0)" title="<?php echo Labels::getLabel("LBL_Edit", $siteLangId); ?>">
                                    <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>'/images/retina/sprite-actions.svg#add">
                                    </use>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <div class="row"> 
                            <input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>">
                            <div id="listing-zones" class="portlet__body col-md-12"></div>
                        </div>
                    </div>  
                </div>


            </div>
        </div>
    </div>