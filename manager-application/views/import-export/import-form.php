<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onSubmit', 'importFile("importData",' . $actionType . '); return false;');
<<<<<<< HEAD
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <!-- Closing tag must be added inside the files who include this file. -->
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link " href="javascript:void(0)" onclick="getInstructions('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_INSTRUCTIONS', $adminLangId); ?>">
                <?php echo Labels::getLabel('LBL_INSTRUCTIONS', $adminLangId); ?>
            </a>

            <a class="nav-link active" href="javascript:void(0)" onclick="importForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_Content', $adminLangId); ?>">
                <?php echo Labels::getLabel('LBL_Content', $adminLangId); ?>
            </a>
            <?php if ($displayMediaTab) { ?>
                <a class="nav-link" href="javascript:void(0)" onclick="importMediaForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_Media', $adminLangId); ?>">
                    <?php echo Labels::getLabel('LBL_Media', $adminLangId); ?>
                </a>

            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand  submitBtnJs">
                    <?php
                    echo Labels::getLabel('LBL_IMPORT', $adminLangId);
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>
=======
$activeContentTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/import-form.php');
>>>>>>> dcb74d5c219c2cc219cb2515001a6e3cc7e94a8f
