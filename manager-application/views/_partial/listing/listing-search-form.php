<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = isset($keywordPlaceholder) ? $keywordPlaceholder : Labels::getLabel('FRM_SEARCH', $siteLangId);

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');

if (!$frmSearch->getFormTagAttribute('onsubmit')) {
    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
}
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
if (null != $keyWordFld) {
    $keyWordFld->addFieldtagAttribute('class', 'form-control');
    /* if (!$keyWordFld->getFieldTagAttribute('placeholder')) {
        $keyWordFld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH', $siteLangId));
    } */
    $keyWordFld->setFieldTagAttribute('placeholder', $keywordPlaceholder);
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
if (null != $keyWordFld || $haveExtraFlds || !empty($firstElement)) {
?>
    <div class="card-head">
        <div class="card-head-label">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <?php if (null != $keyWordFld) {
                            echo $frmSearch->getFieldHtml('keyword');
                        } else {
                            echo $frmSearch->getFieldHtml($firstElement['name']);
                        }
                        ?>
                        <?php if ($haveExtraFlds) { ?>
                            <a class="btn advanced-trigger ml-2" data-toggle="collapse" href="#collapseKeyword" aria-expanded="true" aria-controls="collapseKeyword">
                                <svg class="svg" width="22" height="22">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#double-arrow">
                                    </use>
                                </svg>
                            </a>
                        <?php } ?>
                        <div class="input-group-append">
                            <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
    </div>
    <?php if ($haveExtraFlds) { ?>
        <div class="advanced-search collapse" id="collapseKeyword">
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
<?php }
} ?>
</form>
<?php echo $frmSearch->getExternalJS(); ?>