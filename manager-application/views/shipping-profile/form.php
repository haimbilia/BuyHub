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
                    <div class="card-body">  
                        <h5><?php echo Labels::getLabel('LBL_SHIPPING_PROFILE', $siteLangId); ?>
                    </div>
                </div>
                <div class="card"> 
                    <div class="card-head"> 
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_Name', $siteLangId); ?></h3>
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
                                <div class="portlet" id="product-section--js">
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
            </div>
        </div>
    </div>