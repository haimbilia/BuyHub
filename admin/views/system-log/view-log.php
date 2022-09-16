<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_LOG_DETAILS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <div class="timeline-v4 appendRowsJs">
            <div class="rowJs">
                <div class="timeline-v4__item-date">
                    <span class="tag">
                        <?php echo HtmlHelper::getTheDay($detail['slog_created_at'], $siteLangId); ?>
                    </span>
                </div>
                <ul class="timeline-v4__items">
                    <li class="timeline-v4__item">
                        <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($detail['slog_created_at'])); ?></span>
                        <div class="timeline-v4__item-desc">
                            <ul class="list-stats list-stats-double">
                                <li class="list-stats-item">
                                    <span class="lable">
                                        <?php echo Labels::getLabel('LBL_IDENTIFIER', $siteLangId); ?>
                                    </span>
                                    <span class="value"><?php echo $detail['slog_title'];  ?></span>
                                </li>
                                <?php if (!empty($detail['slog_type'])) { ?>
                                    <li class="list-stats-item">
                                        <span class="lable">
                                            <?php echo Labels::getLabel('LBL_Type', $siteLangId); ?>
                                        </span>
                                        <span class="value">
                                            <?php echo  $types[$detail['slog_type']]; ?>
                                        </span>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($detail['slog_module_type'])) { ?>
                                    <li class="list-stats-item">
                                        <span class="lable">
                                            <?php echo Labels::getLabel('LBL_Module', $siteLangId); ?>
                                        </span>
                                        <span class="value">
                                            <?php echo $moduleTypes[$detail['slog_module_type']]; ?>
                                        </span>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($detail['slog_content'])) { ?>
                                    <li class="list-stats-item list-stats-item-full">
                                        <span class="lable">
                                            <?php echo Labels::getLabel('LBL_Content', $siteLangId); ?>
                                        </span>
                                        <span class="value">
                                            <?php echo $detail['slog_content']; ?>
                                        </span>
                                    </li>
                                <?php } ?>
                                <?php if (CONF_DEVELOPMENT_MODE) { ?>
                                    <?php if (!empty($detail['slog_backtrace'])) { ?>
                                        <?php
                                        $backTrace = json_decode($detail['slog_backtrace']);
                                        if (!empty($backTrace->file)) { ?>
                                            <li class="list-stats-item list-stats-item-full">
                                                <span class="lable">
                                                    <?php echo Labels::getLabel('LBL_FILE', $siteLangId) ?>
                                                </span>
                                                <span class="value">
                                                    <a href="#" class="timeline-v4__item-link">
                                                        <?php echo $backTrace->file; ?>
                                                    </a>
                                                </span>
                                            </li>
                                        <?php }
                                        if (!empty($backTrace->class)) { ?>
                                            <li class="list-stats-item">
                                                <span class="lable"><?php echo Labels::getLabel('LBL_CLASS', $siteLangId) ?></span>
                                                <span class="value"><?php echo $backTrace->class; ?></span>
                                            </li>
                                        <?php }
                                        if (!empty($backTrace->function)) { ?>
                                            <li class="list-stats-item">
                                                <span class="lable"><?php echo Labels::getLabel('LBL_FUNCTION', $siteLangId) ?></span>
                                                <span class="value"><?php echo $backTrace->function; ?></span>
                                            </li>
                                        <?php }
                                        if (!empty($backTrace->line)) { ?>
                                            <li class="list-stats-item">
                                                <span class="lable"><?php echo Labels::getLabel('LBL_LINE', $siteLangId) ?></span>
                                                <span class="value"><?php echo $backTrace->line; ?></span>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>