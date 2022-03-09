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
                            <span class="timeline-v4__item-text">
                                <span class="tag"><?php echo $detail['slog_title'];  ?></span>
                            </span>
                            <?php if (!empty($detail['slog_type'])) { ?>
                                <span class="timeline-v4__item-text">
                                    <b><?php echo Labels::getLabel('LBL_Type', $siteLangId); ?>:</b> <?php echo  $types[$detail['slog_type']]; ?>
                                </span>
                            <?php } ?>
                            <?php if (!empty($detail['slog_module_type'])) { ?>
                                <span class="timeline-v4__item-text">
                                    <b><?php echo Labels::getLabel('LBL_Module', $siteLangId); ?>:</b> <?php echo $moduleTypes[$detail['slog_module_type']]; ?>
                                </span>
                            <?php } ?>
                            <?php if (!empty($detail['slog_content'])) { ?>
                                <br><span class="timeline-v4__item-text text-break">
                                    <b><?php echo Labels::getLabel('LBL_Content', $siteLangId); ?>:</b> <?php echo $detail['slog_content']; ?>
                                </span>
                            <?php } ?>
                            <?php if (!empty($detail['slog_backtrace'])) { ?>
                                <span class="timeline-v4__item-text text-break">
                                    <?php
                                    $backTrace = json_decode($detail['slog_backtrace']);
                                    if (!empty($backTrace->file)) {
                                        echo '<br><a href="#" class="link link--dark timeline-v4__item-link"><b>' . Labels::getLabel('LBL_FILE', $siteLangId) . " :-</b> " . $backTrace->file . "</a><br>";
                                    }
                                    if (!empty($backTrace->class)) {
                                        echo "<b>" . Labels::getLabel('LBL_CLASS', $siteLangId) . " :-</b> " . $backTrace->class . "<br>";
                                    }
                                    if (!empty($backTrace->function)) {
                                        echo "<b>" . Labels::getLabel('LBL_FUNCTION', $siteLangId) . " :-</b> " . $backTrace->function . "<br>";
                                    }
                                    if (!empty($backTrace->line)) {
                                        echo "<b>" . Labels::getLabel('LBL_LINE', $siteLangId) . " :-</b> " . $backTrace->line . "<br>";
                                    }
                                    ?>
                                </span>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>