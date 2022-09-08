<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$downloadFrm->addFormTagAttribute('class', 'form form--horizontal');
$downloadFrm->setFormTagAttribute('id', 'frmDownload');

$fld = $downloadFrm->getField('product_downloadable_link');
$fld->addFieldTagAttribute('class', 'product_downloadable_link');

$fld = $downloadFrm->getField('product_preview_link');
$fld->addFieldTagAttribute('class', 'product_preview_link');

$fld = $downloadFrm->getField('attachement_upload_btn');
$fld->addFieldTagAttribute('onclick', 'saveDownloadFiles();');
$fld->addFieldTagAttribute('class', 'btn btn-brand');
$fld->addFieldTagAttribute('id', 'attachement_upload_btn');

$fld = $downloadFrm->getField('attachment_link_btn');
$fld->addFieldTagAttribute('id', 'attachment_link_btn');
$fld->addFieldTagAttribute('class', 'btn btn-brand');
$fld->addFieldTagAttribute('onclick', 'saveDownloadLinks(); return false;');

$restBtn = $downloadFrm->getField('reset');
$restBtn->addFieldTagAttribute('onclick', 'resetForm(); return false;');
$restBtn->addFieldTagAttribute('class', 'btn btn-outline-gray');

if (false == $canDo) {
    $fld = $downloadFrm->getField('product_downloadable_link');
    $downloadFrm->removeField($fld);
    $fld = $downloadFrm->getField('product_preview_link');
    $downloadFrm->removeField($fld);
    $fld = $downloadFrm->getField('attachment_link_btn');
    $downloadFrm->removeField($fld);

    $fld = $downloadFrm->getField('downloadable_file');
    $downloadFrm->removeField($fld);
    $fld = $downloadFrm->getField('preview_file');
    $downloadFrm->removeField($fld);
    $fld = $downloadFrm->getField('attachement_upload_btn');
    $downloadFrm->removeField($fld);
}

?>
<div class="row justify-content-center">
    <div class="col-md-12" id="digital_download_formss">
        <?php echo $downloadFrm->getFormTag(); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">
                        <?php $fld = $downloadFrm->getField('download_type');
                        echo $fld->getCaption();
                        ?><span class="spn_must_field">*</span>
                    </label>
                    <?php echo $downloadFrm->getFieldHtml('download_type'); ?>
                </div>
            </div>
            <?php $fld = $downloadFrm->getField('option_comb_id');
            if ($fld) {
            ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">
                            <?php $fld = $downloadFrm->getField('option_comb_id');
                            echo $fld->getCaption();
                            ?> <span class="spn_must_field">*</span>
                        </label>
                        <?php echo $downloadFrm->getFieldHtml('option_comb_id'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">
                        <?php
                        $fld = $downloadFrm->getField('lang_id');
                        echo $fld->getCaption();
                        ?>
                    </label>
                    <?php echo $downloadFrm->getFieldHtml('lang_id'); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <?php if (true == $canDo) { ?>
                <?php if (true === $showFldAttachWithExistingOrders) { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <?php
                                $fld = $downloadFrm->getField('attach_with_existing_orders');
                                echo $fld->getCaption();
                                ?>
                            </label>
                            <?php echo $downloadFrm->getFieldHtml('attach_with_existing_orders'); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-4 attach-links-js">
                    <div class="form-group">

                        <label class="form-label">
                            <?php
                            $fld = $downloadFrm->getField('product_downloadable_link');
                            echo $fld->getCaption();
                            ?>
                        </label>
                        <?php echo $downloadFrm->getFieldHtml('product_downloadable_link'); ?>
                    </div>
                </div>
                <div class="col-md-4 attach-links-js">
                    <div class="form-group">
                        <label class="form-label">
                            <?php
                            $fld = $downloadFrm->getField('product_preview_link');
                            echo $fld->getCaption();
                            ?>
                        </label>
                        <?php echo $downloadFrm->getFieldHtml('product_preview_link'); ?>
                    </div>
                </div>
                <div class="col-md-4 text-left attach-links-js">
                    <div class="form-group">
                        <label class="form-label"></label>
                        <?php
                        echo $downloadFrm->getFieldHtml('attachment_link_btn');
                        ?>
                    </div>
                </div>
                <div class="col-md-4 downloadable_file_input attach-files-js">
                    <div class="form-group">
                        <label class="form-label">
                            <?php $fld = $downloadFrm->getField('downloadable_file');
                            $fld->addFieldTagAttribute('class', 'downloadable_file');
                            echo $fld->getCaption();
                            ?>
                        </label>
                        <?php echo $downloadFrm->getFieldHtml('downloadable_file'); ?>
                    </div>
                </div>
                <div class="col-md-4 attach-files-js">
                    <div class="form-group">
                        <label class="form-label">
                            <?php $fld = $downloadFrm->getField('preview_file');
                            $fld->addFieldTagAttribute('class', 'downloadable_file');
                            echo $fld->getCaption();
                            ?>
                        </label>
                        <?php echo $downloadFrm->getFieldHtml('preview_file'); ?>
                    </div>
                </div>
                <div class="col-md-4 text-left attach-files-js">
                    <div class="form-group">
                        <label class="form-label"></label>
                        <?php
                        echo $downloadFrm->getFieldHtml('attachement_upload_btn');
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if (!$canDo) { ?>
            <?php echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_YOU_CAN_NOT_ATTACH_FILES_WITH_INVENTORY.', $siteLangId)); ?>
            <div class="attach-links-js p-0">
                <?php HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_YOU_CAN_NOT_ADD_LINKS_WITH_INVENTORY.', $siteLangId)); ?>
            </div>
        <?php } ?>
        <?php
        echo $downloadFrm->getFieldHtml('record_id');
        echo $downloadFrm->getFieldHtml('dd_link_id');
        echo $downloadFrm->getFieldHtml('dd_link_ref_id');
        echo $downloadFrm->getFieldHtml('is_preview');
        echo $downloadFrm->getFieldHtml('ref_file_id');
        ?>
        </form>
        <?php echo $downloadFrm->getExternalJS(); ?>
    </div>
    <script>
        var selprod_id = <?php echo $selProdId; ?>;
        var DIGITAL_DOWNLOAD_FILE = <?php echo applicationConstants::DIGITAL_DOWNLOAD_FILE; ?>;
        var DIGITAL_DOWNLOAD_LINK = <?php echo applicationConstants::DIGITAL_DOWNLOAD_LINK; ?>;
        $("select[name='download_type']").change(function() {
            if ($(this).val() == DIGITAL_DOWNLOAD_FILE) {
                $(".attach-links-js").hide();
                $(".attach-files-js").show();
                $(".filesList").show();
            } else {
                $(".attach-files-js").hide();
                $(".filesList").hide();
                $(".attach-links-js").show();
            }
        });
        $("select[name='product_attachements_with_inventory']").change(function() {
            if ($(this).val() == <?php echo applicationConstants::YES; ?>) {
                $(".others_frm_elem").hide();
            } else {
                $(".others_frm_elem").show();
            }
        });

        $(document).ready(function() {
            $("select[name='download_type']").trigger('change');

            $("select[name='option_comb_id']").on('change', function() {
                getDigitalDownloads();
            });

            $("select[name='download_type']").on('change', function() {
                getDigitalDownloads();
            });

            $("select[name='lang_id']").on('change', function() {
                getDigitalDownloads();
            });
        });
    </script>