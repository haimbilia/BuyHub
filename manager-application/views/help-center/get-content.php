<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
    <span class="help_label"><?php echo Labels::getLabel('LBL_HELP', $adminLangId); ?></span>
</button>

<div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vertical" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo $record[HelpCenter::DB_TBL_PREFIX . 'title']; ?>
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
                              <div class="data">
                                <h6>
                                    <?php echo $record[HelpCenter::DB_TBL_PREFIX . 'description']; ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>