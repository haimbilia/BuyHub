<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<button class="help-btn btn btn-light" data-bs-toggle="modal" data-bs-target="#help">
    <span class="help_label"><?php echo Labels::getLabel('LBL_HELP', $siteLangId); ?></span>
</button>

<div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vertical" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo $record[HelpCenter::DB_TBL_PREFIX . 'title']; ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="cms help-data">
                    <?php echo html_entity_decode($pageData['plang_helping_text'], ENT_QUOTES, 'utf-8'); ?>
                </div>
            </div>
        </div>
    </div>
</div>