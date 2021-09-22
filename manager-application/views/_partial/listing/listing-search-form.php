<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = isset($keywordPlaceholder) ? $keywordPlaceholder : Labels::getLabel('LBL_SEARCH', $adminLangId);

$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 12;

$fld  = $frmSearch->getField('keyword');
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['col'] = 8;
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$submit  = $frmSearch->getField('btn_submit');
$submit->addFieldtagAttribute('class', 'btn btn-brand btn-block');
$submit->developerTags['col'] = 2;
$submit->developerTags['noCaptionTag'] = true;

$btn_clear = $frmSearch->getField('btn_clear');
$btn_clear->addFieldtagAttribute('class', 'btn btn-link');
$btn_clear->addFieldtagAttribute('onclick', 'clearSearch();');
$btn_clear->developerTags['col'] = 2;
$btn_clear->developerTags['noCaptionTag'] = true;

echo $frmSearch->getFormTag(); ?>
<div class="card">
    <div class="card-body">
        <?php echo $frmSearch->getFormHtml(false); ?>
    </div>
</div>
</form>