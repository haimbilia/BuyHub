<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = isset($keywordPlaceholder) ? $keywordPlaceholder : Labels::getLabel('LBL_SEARCH', $adminLangId);

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');

$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$frmFields = [
    'hidden' => [],
    'advSrchFlds' => [],
];

$i = $x = 0;
$haveExtraFlds = false;
foreach ($frmSearch->getAllFields() as $key => $frmFld) {
    if ('btn_submit' == $frmFld->getName() || 'keyword' == $frmFld->getName()) {
        continue;
    } else if ('hidden' == $frmFld->fldType) {
        $frmFields['hidden'][] = $frmFld->getName();
    } else {
        if ('btn_clear' != $frmFld->getName() && false === $haveExtraFlds) {
            $haveExtraFlds = true;
        }

        $frmFields['advSrchFlds'][$x][] = [
            'name' => $frmFld->getName(),
            'caption' => $frmFld->getCaption()
        ];

        $i++;
        if (3 == $i) {
            $x++;
            $i = 0;
        }
    }
}

echo $frmSearch->getFormTag();
foreach ($frmFields['hidden'] as $fldName) {
    echo $frmSearch->getFieldHtml($fldName);
}
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </div>

            <?php if ($haveExtraFlds) { ?>
                <div class="col-md-2">
                    <a class="btn btn-link" data-toggle="collapse" href="#advanceSearch" aria-expanded="false" aria-controls="advanceSearch">
                        <?php echo Labels::getLabel('LBL_ADVANCE_SEARCH', $adminLangId); ?>
                    </a>
                </div>
            <?php } ?>
        </div>

        <?php if ($haveExtraFlds) { ?>
            <div class="collapse" id="advanceSearch">
                <div class="separator separator-dashed my-4"></div>
                <?php
                foreach ($frmFields['advSrchFlds'] as $fldsGroup) { ?>
                    <div class="row">
                        <?php foreach ($fldsGroup as $frmFld) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label"><?php echo $frmFld['caption']; ?></label>
                                    <?php echo $frmSearch->getFieldHtml($frmFld['name']); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>