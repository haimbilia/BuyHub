<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$downloadFrm->addFormTagAttribute('class', 'web_form mt-5');
$downloadFrm->setFormTagAttribute('id', 'frmDownload');

$fld = $downloadFrm->getField('product_downloadable_link');
$fld->addFieldTagAttribute('id', 'product_downloadable_link');

$fld = $downloadFrm->getField('btn_submit');
$fld->addFieldTagAttribute('id', 'btn_submit');
$fld->addFieldTagAttribute('onclick', 'saveDownloadLinks(); return false;');

?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <?php echo $downloadFrm->getFormTag(); ?>
            <div class="row">
                <?php $fld = $downloadFrm->getField('option_comb_id');
                if ($fld) {
                ?>
                    <div class="col-md-6">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php $fld = $downloadFrm->getField('option_comb_id');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                <?php echo $downloadFrm->getFieldHtml('option_comb_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
            <div class="row attach-links-js">
                <div class="col-md-6 product-downloadable-links-fld-js">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php 
                                $fld = $downloadFrm->getField('product_downloadable_link');
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
            <div class="row attach-files-js">
                <div class="col-md-6 language-id-fld-js">
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
                <div class="col-md-6 downloadable-file-fld-js">
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
                <div class="col-md-6 preview-file-fld-js">
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
            $(".attach-links-js").hide();
            $("#btn_submit").hide();
            $(".attach-files-js").show();
            $(".filesList").show();
        } else {
            $(".attach-files-js").hide();
            $(".filesList").hide();
            $(".attach-links-js").show();
            $("#btn_submit").show();
        }
    });
    $("select[name='product_download_attachements_with_inventory']").change(function() {
        if ($(this).val() == <?php echo applicationConstants::YES; ?>) {
            $(".others_frm_elem").hide();
        } else {
            $(".others_frm_elem").show();
        }
    });

    $(document).ready(function(){
        $("select[name='download_type']").trigger('change');
        
        $("select[name='option_comb_id']").on('change', function() {
            getDigitalDownloads();
        });

        $("select[name='download_type']").on('change', function() {
            getDigitalDownloads();
        });
    });

</script>