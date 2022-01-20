 <?php
    echo $frm->getFormTag();
    ?>
 <div class="row">
     <div class="col-md-9">
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
     <div class="col-md-3">
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
     <div class="col-md-12">
         <?php if (!empty($languages) && count($languages) > 1) { ?>
             <div class="" data-isdefaulthidden="1">
                 <h6 class="dropdown-toggle-custom" data-bs-toggle="collapse" data-bs-target="#lang-data" aria-expanded="false" aria-controls="lang-data">
                     <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                     <i class="dropdown-toggle-custom-arrow"></i>
                 </h6>
                 <div class="collapse" id="lang-data">
                     <div class="row">
                         <?php
                            foreach ($languages as $langId => $data) {
                                if ($siteDefaultLangId == $langId) {
                                    continue;
                                }
                                $layout = Language::getLayoutDirection($langId);
                            ?>
                             <div class="col-md-6 layout--<?php echo $layout; ?>">
                                 <div class="form-groupx">
                                     <label class="label">
                                         <?php
                                            $fld = $frm->getField('shipprofile_name[' . $langId . ']');
                                            echo $fld->getCaption();
                                            ?>
                                     </label>
                                     <?php echo $fld->getHtml(); ?>

                                 </div>
                             </div>
                         <?php } ?>
                     </div>

                 </div>


             </div>
         <?php } ?>
     </div>
 </div>
 </form>
 </form>
 <?php echo $frm->getExternalJs(); ?>