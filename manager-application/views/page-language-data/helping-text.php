<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($pageData['plang_helping_text']) && !empty($pageData['plang_helping_text'])) { ?>
    <div id="helpCenterJs">
        <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
            <span class="help_label"><?php echo Labels::getLabel('LBL_HELP', $siteLangId); ?></span>
        </button>

        <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
            <div class="modal-dialog modal-dialog-vertical" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?php echo $pageData['plang_title']; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="empty-stats">
                                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                                    <div class="data data--cms">
                                        <?php echo $pageData['plang_helping_text']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>