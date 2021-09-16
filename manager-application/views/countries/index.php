<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$keyword  = $frmSearch->getField('keyword');
$keyword->addFieldtagAttribute('class', 'form-control');
$keyword->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_Search', $adminLangId));

$submit  = $frmSearch->getField('btn_submit');
$submit->addFieldtagAttribute('class', 'btn btn-brand btn-block');

$btn_clear = $frmSearch->getField('btn_clear');
$btn_clear->addFieldtagAttribute('class', 'btn btn-link');
$btn_clear->addFieldtagAttribute('onclick', 'clearSearch();');
?>
<main class="main mainJs">    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frmSearch->getFormTag(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $frmSearch->getFieldHTML('keyword'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_submit'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_clear'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo $frmSearch->getFieldHTML('sortBy');
                echo $frmSearch->getFieldHTML('sortOrder');
                echo $frmSearch->getFieldHTML('reportColumns');
                echo $frmSearch->getFieldHTML('pageSize');
                echo $frmSearch->getExternalJS(); ?>
                </form>
                <div class="card" id="listing">
                    <?php echo Labels::getLabel('LBL_Processing...', $adminLangId); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var controllerName = '<?php echo str_replace('Controller', '', FatApp::getController()); ?>';
    getHelpCenterContent(controllerName);
</script>