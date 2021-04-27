<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <?php echo $downloadFrm->getFormTag(); ?>
            <div class="row">
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('download_type');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('download_type'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-downloadable-links-fld-js">
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('product_downloadable_link');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('product_downloadable_link'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row language-id-fld-js">
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('lang_id');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('lang_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row downloadable-file-fld-js">
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('downloadable_file');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('downloadable_file'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row preview-file-fld-js">
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('preview_file');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('preview_file'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="field-set">
                    <div class="caption-wraper"><label class="field_label"></label></div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php 
                            echo $downloadFrm->getFieldHtml('product_id'); 
                            echo $downloadFrm->getFieldHtml('btn_submit'); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php echo $downloadFrm->getExternalJS(); ?>
    </div>
</div>
<script>
    var DIGITAL_DOWNLOAD_FILE = <?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>;
    var DIGITAL_DOWNLOAD_LINK = <?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>;
    $("select[name='download_type']").change(function() {
        if ($(this).val() == DIGITAL_DOWNLOAD_FILE) {
            $(".product-downloadable-links-fld-js").hide();
            $(".submit_button").hide();
            $(".language-id-fld-js").show();
            $(".downloadable-file-fld-js").show();
            $(".preview-file-fld-js").show();
            $(".filesList").show();
        } else {
            $(".language-id-fld-js").hide();
            $(".downloadable-file-fld-js").hide();
            $(".preview-file-fld-js").hide();
            $(".filesList").hide();
            $(".product-downloadable-links-fld-js").show();
            $(".submit_button").show();
        }
    });
    $("select[name='product_download_attachements_with_inventory']").change(function() {
        if ($(this).val() == <?php echo applicationConstants::YES; ?>) {
            $(".others_frm_elem").hide();
        } else {
            $(".others_frm_elem").show();
        }
    });
</script>