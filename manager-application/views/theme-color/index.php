<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'setupFontStyle(this); return(false);');

$fld = $frm->getField('btn_clear');
$fld->addFieldTagAttribute('onclick', 'resetToDefault();');

$googleFontFamily = "Poppins";
$fontWeight = FatApp::getConfig('CONF_THEME_FONT_WEIGHT', FatUtility::VAR_STRING, "");
$disabled  = empty($fontWeight) ? 'disabled="disabled"' : '';

$googleFontFamilyUrl = FatApp::getConfig('CONF_THEME_FONT_FAMILY_URL', FatUtility::VAR_STRING, '');
$themeColor = FatApp::getConfig('CONF_THEME_COLOR', FatUtility::VAR_STRING, "#FF3A59");
$themeColorRgb = FatApp::getConfig('CONF_THEME_COLOR_RGB', FatUtility::VAR_STRING, "255,58,89");
$themeColorHsl = FatApp::getConfig('CONF_THEME_COLOR_HSL', FatUtility::VAR_STRING, "351,100%,61%");

$themeColorInverse = FatApp::getConfig('CONF_THEME_COLOR_INVERSE', FatUtility::VAR_STRING, "#ffffff");
$themeColorInverseRgb = FatApp::getConfig('CONF_THEME_COLOR_INVERSE_RGB', FatUtility::VAR_STRING, "255,255,255");
$themeColorInverseHsl = FatApp::getConfig('CONF_THEME_COLOR_INVERSE_HSL', FatUtility::VAR_STRING, "0,0%,100%");
if (!empty($googleFontFamilyUrl)) {
    $googleFontFamily = FatApp::getConfig('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
    $googleFontFamily = str_replace("+", " ", explode('-', $googleFontFamily)[0]);

?>
    <link href="<?php echo $googleFontFamilyUrl; ?>" rel="stylesheet">
<?php
}
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_MANAGE_THEME', $adminLangId); ?></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mr-5">
                                    <?php echo $frm->getFormTag();
                                    if (null != $googleFontFamilyUrl) {
                                        echo $frm->getFieldHtml('CONF_THEME_FONT_FAMILY_URL');
                                    }
                                    ?>
                                    <div class="form">
                                        <?php if (!empty($apiKey)) { ?>
                                            <div class="form-group">
                                                <label class="labeled">
                                                    <label class="label"><?php echo Labels::getLabel('LBL_FONT_FAMILY', $adminLangId); ?>*</label>
                                                    <input type="search" name="CONF_THEME_FONT_FAMILY" placeholder="<?php echo Labels::getLabel('LBL_SEARCH_FONTS', $adminLangId); ?>" value="<?php echo $googleFontFamily; ?>">
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label class="label">
                                                    <?php echo Labels::getLabel('LBL_SELECT_FONT_WEIGHT', $adminLangId); ?>*
                                                </label>
                                                <input name='CONF_THEME_FONT_WEIGHT' class='form-control tagify--outside tagifyWeightJs' placeholder='<?php echo Labels::getLabel('LBL_SELECT_WEIGHT', $adminLangId); ?>' <?php echo $disabled; ?> value="<?php echo htmlentities($fontWeight); ?>">
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label class="label"><?php echo Labels::getLabel('LBL_THEME_COLOR', $adminLangId); ?></label>
                                            <div class="color-data colorBlockJs">
                                                <?php 
                                                    $fld = $frm->getField('CONF_THEME_COLOR_RGB');
                                                    $fld->addFieldTagAttribute('class', 'inputRgbJs');
                                                    
                                                    $fld = $frm->getField('CONF_THEME_COLOR_HSL');
                                                    $fld->addFieldTagAttribute('class', 'inputHslJs');

                                                    echo $frm->getFieldHtml('CONF_THEME_COLOR_RGB'); 
                                                    echo $frm->getFieldHtml('CONF_THEME_COLOR_HSL'); 
                                                ?>
                                                <div class="color-swatch" title="Selected color">
                                                    <input type="color" value="<?php echo $themeColor; ?>" class="themeColorJs colorPickerJs" name="CONF_THEME_COLOR">
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_HEX', $adminLangId); ?></h5>
                                                    <span class="hex hexJs"><?php echo $themeColor; ?></span>
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_RGB', $adminLangId); ?></h5>
                                                    <span class="rgb rgbJs"><?php echo $themeColorRgb; ?></span>
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_HSL', $adminLangId); ?></h5>
                                                    <span class="hsl hslJs"><?php echo $themeColorHsl; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="label"><?php echo Labels::getLabel('LBL_THEME_COLOR_INVERSE', $adminLangId); ?></label>
                                            <div class="color-data colorBlockJs">
                                                <?php 
                                                    $fld = $frm->getField('CONF_THEME_COLOR_INVERSE_RGB');
                                                    $fld->addFieldTagAttribute('class', 'inputRgbJs');

                                                    $fld = $frm->getField('CONF_THEME_COLOR_INVERSE_HSL');
                                                    $fld->addFieldTagAttribute('class', 'inputHslJs');

                                                    echo $frm->getFieldHtml('CONF_THEME_COLOR_INVERSE_RGB'); 
                                                    echo $frm->getFieldHtml('CONF_THEME_COLOR_INVERSE_HSL'); 
                                                ?>
                                                <div class="color-swatch" title="Selected color">
                                                    <input type="color" value="<?php echo $themeColorInverse; ?>" class="themeColorInverseJs colorPickerJs" name="CONF_THEME_COLOR_INVERSE">
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_HEX', $adminLangId); ?></h5>
                                                    <span class="hex hexJs"><?php echo $themeColorInverse; ?></span>
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_RGB', $adminLangId); ?></h5>
                                                    <span class="rgb rgbJs"><?php echo $themeColorInverseRgb; ?></span>
                                                </div>
                                                <div class="color-label">
                                                    <h5><?php echo Labels::getLabel('LBL_HSL', $adminLangId); ?></h5>
                                                    <span class="hsl hslJs"><?php echo $themeColorInverseHsl; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-solid-brand " role="alert">
                                            <div class="alert-icon">
                                                <i class="flaticon-warning"></i>
                                            </div>
                                            <div class="alert-text text-xs">
                                                <?php echo Labels::getLabel('LBL_DISCLAIMER:_INVERSE_COLOR_SHOULD_BE_IN_CONTRAST_TO_THE_THEME_COLOR', $adminLangId); ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <?php
                                                $fld = $frm->getField('btn_clear');
                                                $fld->addFieldTagAttribute('class', 'btn btn-outline-brand');
                                                echo $frm->getFieldHtml('btn_clear'); ?>
                                            </div>
                                            <div class="col-auto">
                                                <?php
                                                $fld = $frm->getField('btn_submit');
                                                $fld->addFieldTagAttribute('class', 'btn btn-brand');
                                                echo $frm->getFieldHtml('btn_submit'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <?php echo $frm->getExternalJS(); ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="palette googleFontsJs">
                                            <?php require_once(CONF_THEME_PATH . 'images/retina/theme-settings.svg'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>