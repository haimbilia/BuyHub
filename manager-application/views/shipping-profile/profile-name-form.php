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
             <div class="accordians_container accordians_container-categories my-3" data-isdefaulthidden="1">
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

 <style>
     .accordians_container-categories span.accordian_title {
         background: #f3f6f8;
         /* color: #333; */
         font-size: 1.1em;
         margin: 0 0 20px;
         padding: 12px 15px;
         border-radius: 5px;
     }

     .accordian_title {
         position: relative;
         font-size: 14px;
         font-weight: 500;
         padding: 15px 45px 15px 20px;
         display: block;
         cursor: pointer;
         border-bottom: 1px solid transparent;
     }

     .accordian_title:before {
         content: "\f218";
         width: 30px;
         height: 30px;
         border-radius: 5px;
         font-size: 16px;
         font-family: "Ionicons";
         position: absolute;
         right: 15px;
         top: 10px;
         text-align: center;
         line-height: 30px;
     }
 </style>
 <script>
     /* for Accordian */
     /* Set default open/close settings */
     $('.accordiancontent').hide(); //Hide/close all containers

     if ($('.accordians_container:first').attr('data-isdefaulthidden') == undefined) {
         $('.accordians_container').find('.accordianhead:first').addClass('active').next().show(); /* Add "active" class to first trigger, then show/open the immediate next container */
     }

     $(document).on('click', '.accordianhead', function() {
         if ($(this).next().is(':hidden')) {
             /* If immediate next container is closed... */
             $(this).parents('.accordians_container:first').find('.accordianhead').removeClass('active').next().slideUp(); /* Remove all .acc_trigger classes and slide up the immediate next container */
             $(this).toggleClass('active').next().slideDown(); /* Add .acc_trigger class to clicked trigger and slide down the immediate next container */
         } else {
             $(this).toggleClass('active').next().slideUp()
         }
         return false; /* Prevent the browser jump to the link anchor */
     });
 </script>