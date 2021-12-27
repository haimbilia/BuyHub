<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?> 
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_User_Details', $siteLangId); ?>           
    </h5>
</div> 
<main class="mainJs">
    <div class="modal-body form-edit pd-0">   
        <div class="form-edit-body loaderContainerJs">   
            <form class="modal-body form pd-0">
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="form-group"><h3 class="h3"><?php echo Labels::getLabel('LBL_Profile_Information', $siteLangId); ?></h3></div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></label>
                            <div class=""><?php echo $supplierRequest['user_name']; ?></div> 
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></label>
                            <div class=""><?php echo $supplierRequest['credential_email']; ?></div> 
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Username', $siteLangId); ?></label>
                            <div class=""><?php echo $supplierRequest['credential_username']; ?></div> 
                        </div>
                    </div>  
                    <div class="col-md-12">
                        <div class="form-group"><h3 class="h3"><?php echo Labels::getLabel('LBL_Seller_Information', $siteLangId); ?></h3></div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Reference_Number', $siteLangId); ?></label>
                            <div class=""><?php echo $supplierRequest['usuprequest_reference']; ?></div> 
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></label>
                            <div class=""><?php echo $reqStatusArr[$supplierRequest['usuprequest_status']]; ?></div> 
                        </div>
                    </div> 
                    <?php if (!empty($supplierRequest['usuprequest_comments'])) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label"><?php echo Labels::getLabel('LBL_Comments/Reason', $siteLangId); ?></label>
                                <div class=""><?php echo nl2br($supplierRequest['usuprequest_comments']); ?></div> 
                            </div>
                        </div>  
                    <?php } ?>
                    <div class="col-md-12">
                        <div class="form-group"><h3 class="h3"><?php echo Labels::getLabel('LBL_Additional_Information', $siteLangId); ?></h3></div>
                    </div>  
                    <?php foreach ($supplierRequest['field_values'] as $val) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                if ($val['sformfield_caption'] != '') {
                                    echo '<label class="label">' . $val['sformfield_caption'] . '</label>';
                                } else {
                                    echo '<div class="">' . $val['sformfield_identifier'] . '</div>';
                                }
                                ?>

                                <?php
                                if ($val['afile_physical_path'] != '') {
                                    echo "<div><a href='" . UrlHelper::generateUrl('Users', 'downloadAttachment', array($supplierRequest['user_id'], $val['sfreqvalue_formfield_id'])) . "'>" . $val['sfreqvalue_text'] . "</a></div>";
                                } else {
                                    if($val['sformfield_type']  == User::USER_FIELD_TYPE_PHONE){									
                                        echo '<div>'.filter_var($val['sfreqvalue_text'], FILTER_SANITIZE_NUMBER_INT).'</div>';
                                    }else{
                                        echo "<div>" . nl2br($val['sfreqvalue_text']) . '</div>';
                                    }
                                    
                                }
                                ?> 
                            </div>
                        </div>
                    <?php } ?>	 
                </div>  
            </form> 
        </div>
    </div>
</main>