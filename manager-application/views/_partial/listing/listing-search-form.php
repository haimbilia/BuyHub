<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = isset($keywordPlaceholder) ? $keywordPlaceholder : Labels::getLabel('FRM_SEARCH', $siteLangId);
$onSubmit = $onSubmit ?? 'searchRecords(this); return(false);';

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', $onSubmit);
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
if (null != $keyWordFld) {
    $keyWordFld->addFieldtagAttribute('class', 'form-control');
    $keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);
}

$frmFields = [
    'hidden' => [],
    'advSrchFlds' => [],
];

$i = $x = 0;
$haveExtraFlds = false;
$firstElement = [];
foreach ($frmSearch->getAllFields() as $key => $frmFld) {
    if ('btn_submit' == $frmFld->getName() || 'keyword' == $frmFld->getName()) {
        continue;
    } else if ('hidden' == $frmFld->fldType) {
        $frmFields['hidden'][] = $frmFld->getName();
    } else {
        if (null == $keyWordFld && empty($firstElement) && 'btn_clear' != $frmFld->getName()) {
            $firstElement = [
                'name' => $frmFld->getName(),
                'caption' => $frmFld->getCaption()
            ];
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
}

echo $frmSearch->getFormTag();
foreach ($frmFields['hidden'] as $fldName) {
    echo $frmSearch->getFieldHtml($fldName);
}

if (null != $keyWordFld || $haveExtraFlds || !empty($firstElement)) { ?>
    <div class="card-head">
        <div class="card-head-label">
            <div class="row">
                <?php if (null != $keyWordFld) { ?>
                    <div class="col-md-8">
                        <div class="input-group">
                            <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                            <div class="input-group-append">
                                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-8">
                        <div class="input-group">
                            <?php
                            $fld = $frmSearch->getField($firstElement['name']);
                            $fld->addFieldTagAttribute('class', 'form-control');
                            $fld->addFieldTagAttribute('title', $firstElement['caption']);
                            echo $frmSearch->getFieldHtml($firstElement['name']); ?>
                            <div class="input-group-append">
                                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($haveExtraFlds) { ?>
                    <div class="col-md-3">
                        <a class="btn btn-link" data-toggle="collapse" href="#advanceSearch" aria-expanded="false" aria-controls="advanceSearch">
                            <?php echo Labels::getLabel('BTN_ADVANCE_SEARCH', $siteLangId); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <?php if ($haveExtraFlds) { ?>
                <div class="collapse" id="advanceSearch">
                    <div class="separator separator-dashed my-4"></div>
                    <?php
                    foreach ($frmFields['advSrchFlds'] as $itr => $fldsGroup) { ?>
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
        <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
    </div>
<?php } ?>
</form>
<?php echo $frmSearch->getExternalJS(); ?>