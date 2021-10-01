<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = isset($keywordPlaceholder) ? $keywordPlaceholder : Labels::getLabel('LBL_SEARCH', $adminLangId);

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 12;

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->developerTags['noCaptionTag'] = true;
$keyWordFld->developerTags['col'] = 8;
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$submitBtn = $frmSearch->getField('btn_submit');
$submitBtn->addFieldtagAttribute('class', 'btn btn-brand btn-block');
$submitBtn->developerTags['col'] = 2;
$submitBtn->developerTags['noCaptionTag'] = true;

$clearBtn = $frmSearch->getField('btn_clear');
if (null != $clearBtn) {
    $clearBtn->addFieldtagAttribute('class', 'btn btn-outline-brand');
    $clearBtn->addFieldtagAttribute('onclick', 'clearSearch();');
    $clearBtn->developerTags['col'] = 2;
}

$frmFields = [
    'hidden' => [],
    'advSrchFlds' => [],
];

$i = $x = 0;
foreach ($frmSearch->getAllFields() as $key => $frmFld) {
    if ('submit' == $frmFld->fldType || 'keyword' == $frmFld->getName()) {
        continue;
    } else if ('hidden' == $frmFld->fldType) {
        $frmFields['hidden'][] = $frmFld->getName();
    } else {
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

$haveExtraFlds = (0 < count($frmFields['advSrchFlds']));

echo $frmSearch->getFormTag(); 
    foreach ($frmFields['hidden'] as $fldName) {
        echo $frmSearch->getFieldHtml($fldName);
    }
?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
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