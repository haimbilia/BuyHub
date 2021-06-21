<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$downloadFrm->addFormTagAttribute('class', 'web_form');
$downloadFrm->setFormTagAttribute('id', 'frmDownload');

$fld = $downloadFrm->getField('product_downloadable_link');
$fld->addFieldTagAttribute('class', 'product_downloadable_link');

$fld = $downloadFrm->getField('product_preview_link');
$fld->addFieldTagAttribute('class', 'product_preview_link');

$fld = $downloadFrm->getField('attachement_upload_btn');
$fld->addFieldTagAttribute('onclick', 'saveDownloadFiles();');
$fld->addFieldTagAttribute('id', 'attachement_upload_btn');

$fld = $downloadFrm->getField('attachment_link_btn');
$fld->addFieldTagAttribute('id', 'attachment_link_btn');
$fld->addFieldTagAttribute('onclick', 'saveDownloadLinks(); return false;');

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

<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Custom_Catalog_Request', $adminLangId); ?>
        </h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a <?php echo ($preqId) ? "onClick='productForm( " . $preqId . ", 0 );'" : ""; ?> href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_General', $adminLangId); ?>
                            </a>
                        </li>
                        <?php /*
                        <li><a <?php echo ($preqId) ? "onClick='sellerProductForm(" . $preqId . ");'" : ""; ?>
                                href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_Inventory/Info', $adminLangId); ?>
                            </a>
                        </li> */ ?>
                        <li>
                            <a <?php echo (0 < $preqId) ? "onclick='customCatalogSpecifications( " . $preqId . " );'" : ""; ?> href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_Specifications', $adminLangId); ?>
                            </a>
                        </li>
                        <li class="<?php echo (0 == $preqId) ? 'fat-inactive' : ''; ?>">
                            <a href="javascript:void(0);" <?php echo (0 < $preqId) ? "onclick='productLangForm(" . $preqId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                                <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
                            </a>
                        </li>
                        <?php if (count($productOptions) > 0) { ?>
                            <li><a <?php echo ($preqId) ? "onClick='customEanUpcForm(" . $preqId . ");'" : ""; ?> href="javascript:void(0);">
                                    <?php echo Labels::getLabel('LBL_EAN/UPC_setup', $adminLangId); ?></a>
                            </li>
                        <?php } ?>
                        <li><a class="active" <?php echo ($preqId) ? "onClick='productDownloads(" . $preqId . ", 0, 1);'" : ""; ?> href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_Downloads', $adminLangId); ?></a>
                        </li>
                        <li>
                            <a <?php echo ($preqId) ? "onClick='updateStatusForm( " . $preqId . ");'" : ""; ?> href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_Change_Status', $adminLangId); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel">
                            <div class="row justify-content-center">
                                <div class="col-md-12" id="digital_download_formss">
                                    <?php echo $downloadFrm->getFormTag(); ?>
                                        <div class="row">
                                            <div class="col-md-4">
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
                                            <?php $fld = $downloadFrm->getField('option_comb_id');
                                            if ($fld) {
                                            ?>
                                                <div class="col-md-4">
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
                                            <div class="col-md-4">
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
                                        <div class="attach-links-js">
                                            <?php if(true == $canDo) { ?>
                                                <div class="row">
                                                    <div class="col-md-4">
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
                                                    <div class="col-md-4">
                                                        <div class="field-set">
                                                            <div class="caption-wraper">
                                                                <label class="field_label">
                                                                    <?php 
                                                                    $fld = $downloadFrm->getField('product_preview_link');
                                                                    echo $fld->getCaption();
                                                                    ?>
                                                                </label>
                                                            </div>
                                                            <div class="field-wraper">
                                                                <div class="field_cover">
                                                                <?php echo $downloadFrm->getFieldHtml('product_preview_link'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-left">
                                                        <div class="field-set">
                                                            <div class="caption-wraper"><label class="field_label"></label></div>
                                                            <div class="field-wraper">
                                                                <div class="field_cover">
                                                                    <?php echo $downloadFrm->getFieldHtml('attachment_link_btn');
                                                                    $restBtn = $downloadFrm->getField('reset');
                                                                    $restBtn->setFieldTagAttribute('onclick', 'resetForm(); return false;');
                                                                    echo $downloadFrm->getFieldHtml('reset');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="attach-files-js">
                                            <?php if(true == $canDo) { ?>
                                                <div class="row">
                                                    <div class="col-md-4 downloadable_file_input">
                                                        <div class="field-set">
                                                            <div class="caption-wraper">
                                                                <label class="field_label">
                                                                    <?php $fld = $downloadFrm->getField('downloadable_file');
                                                                    $fld->addFieldTagAttribute('class', 'downloadable_file');
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
                                                    <div class="col-md-4">
                                                        <div class="field-set">
                                                            <div class="caption-wraper">
                                                                <label class="field_label">
                                                                    <?php $fld = $downloadFrm->getField('preview_file');
                                                                    $fld->addFieldTagAttribute('class', 'downloadable_file');
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
                                                    <div class="col-md-4 text-left">
                                                        <div class="field-set">
                                                            <div class="caption-wraper"><label class="field_label"></label></div>
                                                            <div class="field-wraper">
                                                                <div class="field_cover">
                                                                    <?php
                                                                    echo $downloadFrm->getFieldHtml('attachement_upload_btn');
                                                                    $restBtn = $downloadFrm->getField('reset');
                                                                    $restBtn->setFieldTagAttribute('onclick', 'resetForm(); return false;' );
                                                                    echo $downloadFrm->getFieldHtml('reset');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php echo $downloadFrm->getFieldHtml('preq_id'); ?>
                                        <?php echo $downloadFrm->getFieldHtml('dd_link_id'); ?>
                                        <?php echo $downloadFrm->getFieldHtml('dd_link_ref_id'); ?>
                                        <?php echo $downloadFrm->getFieldHtml('is_preview'); ?>
                                        <?php echo $downloadFrm->getFieldHtml('ref_file_id'); ?>
                                    </form>
                                    <?php echo $downloadFrm->getExternalJS(); ?>
                                </div>
                                <!-- <div class="col-md-12" id="digital_download_list" class="dd-list"></div> -->
                                <div class="col-md-12" class="dd-list"><div class="row" id="digital_download_list"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
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

    $(document).ready(function(){
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