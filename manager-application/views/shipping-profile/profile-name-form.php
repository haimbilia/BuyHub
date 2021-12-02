<div class="form-edit-body loaderContainerJs">
    <?php
    echo $frm->getFormTag();
    ?> 
    <div class="row">
        <div class="col-md-6" >
            <div class="form-group"> 
                <div class="">
                    <?php
                    $pNameFld = $frm->getField('shipprofile_name[' . $siteDefaultLangId . ']');
                    $pNameFld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Customers_will_not_see_this", $siteLangId) . "</span>";
                    $pNameFld->addFieldTagAttribute('class', 'form-control');
                    echo $pNameFld->getHtml();
                    ?>
                </div>
            </div>
        </div> 
        <div class="col-md-6" >
            <div class="form-group"> 
                <div class="">
                    <?php
                    echo $frm->getFieldHtml('shipprofile_id');
                    echo $frm->getFieldHtml('shipprofile_user_id');
                    $btn = $frm->getField('btn_submit');
                    $btn->addFieldTagAttribute('class', 'btn btn-brand');
                    echo $frm->getFieldHtml('btn_submit');
                    ?>
                </div>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-6" >
            <?php if (!empty($languages) && count($languages) > 1) { ?>
                <div class="accordians_container accordians_container-categories my-3" data-isdefaulthidden="1" >
                    <div class="accordian_panel">
                        <span class="accordian_title accordianhead" id="collapse1">
                            <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                        </span>                                                  
                        <div class="accordian_body accordiancontent">
                            <div class="p-4 mb-4 bg-gray rounded">
                                <div class="row">
                                    <?php
                                    foreach ($languages as $langId => $data) {
                                        if ($siteDefaultLangId == $langId) {
                                            continue;
                                        }
                                        $layout = Language::getLayoutDirection($langId);
                                        ?>
                                        <div class="col-md-6 layout--<?php echo $layout; ?>">
                                            <div class="field-set">
                                                <div class="caption-wraper">
                                                    <label class="field_label">
                                                        <?php
                                                        $fld = $frm->getField('shipprofile_name[' . $langId . ']');
                                                        echo $fld->getCaption();
                                                        ?>                       
                                                    </label>
                                                </div>
                                                <div class="field-wraper">
                                                    <div class="field_cover">
                                                        <?php echo $fld->getHtml(); ?>                         
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                      
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</form> 
</form>
<?php echo $frm->getExternalJs(); ?>
</div>