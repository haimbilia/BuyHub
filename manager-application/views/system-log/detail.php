<div class="sectionbody space">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <h3 class="form__heading"><?php echo Labels::getLabel('LBL_Log_details', $adminLangId); ?></h3>
            <?php if(!empty($detail['slog_title'])){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                           <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Title', $adminLangId); ?></h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                            <?php echo $detail['slog_title'];  ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div>   
            <?php } ?>
             <?php if(!empty($detail['slog_content'])){ ?>
             <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <h3 class="mb-4">
                                <?php echo Labels::getLabel('LBL_Content', $adminLangId); ?>
                            </h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $detail['slog_content']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(!empty($detail['slog_type'])){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                           <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Type', $adminLangId); ?></h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                            <?php echo $types[$detail['slog_type']];  ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div> 
             <?php } ?>
             <?php if(!empty($detail['slog_module_type'])){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                           <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Module', $adminLangId); ?></h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                            <?php echo $moduleTypes[$detail['slog_module_type']];  ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div> 
             <?php } ?>
             <?php if(!empty($detail['slog_backtrace'])){ ?>
             <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                           <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Backtrace', $adminLangId); ?></h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                            <?php $backTrace = json_decode($detail['slog_backtrace']);
                                if(!empty($backTrace->file)){
                                    echo "<b>File :-</b> ".$backTrace->file."<br>";
                                }
                                if(!empty($backTrace->line)){
                                    echo "<b>Line :-</b> ".$backTrace->line."<br>";
                                }
                                if(!empty($backTrace->function)){
                                    echo "<b>Function :-</b> ".$backTrace->function."<br>";
                                }
                                if(!empty($backTrace->class)){
                                    echo "<b>Class :-</b> ".$backTrace->class."<br>";
                                }
                             ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div> 
            <?php } ?>
            <?php if(!empty($detail['slog_created_at'])){ ?>            
             <div class="row">
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                           <h3 class="mb-4"><?php echo Labels::getLabel('LBL_Datetime', $adminLangId); ?></h3>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                            <?php echo FatDate::format($detail['slog_created_at']);  ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div> 
            <?php } ?>
            
            
        </div>
    </div>
</div>