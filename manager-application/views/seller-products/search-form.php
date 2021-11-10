<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$userFld = $frmSearch->getField('user_id');
$userFld->addFieldtagAttribute('id', 'user_id');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

/* Extra Field */
$userNameFld = $frmSearch->getField('user_name');
if (null != $userNameFld) {
    $userNameFld->addFieldtagAttribute('class', 'form-control');
}
/* Extra Field */

echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a class="btn btn-link collapsed" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Advanced
                    Search</a>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="separator separator-dashed my-4"></div>
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo $userFld->getCaption(); ?></label>
                        <?php echo $frmSearch->getFieldHtml('user_id'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label">
                            <?php $fld = $frmSearch->getField('prodcat_id');
                            echo $fld->getCaption(); ?>
                        </label>
                        <?php echo $frmSearch->getFieldHtml('prodcat_id'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"></label>
                        <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>
<script type="text/javascript">
    $("document").ready(function() {
        select2('user_id', fcom.makeUrl('Users', 'autoComplete'), {
            user_is_seller: 1,
            credential_active: 1,
            credential_verified: 1
        });
    });
</script>