
<div class="row">
    <div class="col-md-9">
        <div class="form-group">
            <div class="">
                <?php
                $pNameFld = $frm->getField('shipprofile_name');
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

