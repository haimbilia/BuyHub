<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');

$frm->setFormTagAttribute('onsubmit', 'setCookiesPreferences(this); return(false);');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;

$fld = $frm->getField('ucp_functional');
$fld->setFieldTagAttribute('disabled', "disabled");

$fld = $frm->getField('btn_submit');
$fld->setFieldTagAttribute('class', "btn btn-brand");

$fld = $frm->getField('ucp_functional');
HtmlHelper::configureSwitchForCheckbox($fld);

$fld = $frm->getField('ucp_statistical');
HtmlHelper::configureSwitchForCheckbox($fld);

$fld = $frm->getField('ucp_personalized');
HtmlHelper::configureSwitchForCheckbox($fld);
?>
<div class="content-wrapper content-space">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <?php
            $data = [
                'headingLabel' => Labels::getLabel('LBL_COOKIE_PREFERENCES', $siteLangId),
                'siteLangId' => $siteLangId,
            ];

            $this->includeTemplate('_partial/header/content-header.php', $data); ?>
            <div class="content-body">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <?php echo $frm->getFormTag(); ?>
                                <ul class="cookie-preferences">
                                    <li class="cookie-preferences-item">
                                        <?php echo $frm->getFieldHtml('ucp_functional'); ?>
                                        <div class="data">
                                            <p>
                                                <?php echo Labels::getLabel('LBL_Functional_Cookies_Information', $siteLangId); ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="cookie-preferences-item">
                                        <?php echo $frm->getFieldHtml('ucp_statistical'); ?>
                                        <div class="data">
                                            <p>
                                                <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="cookie-preferences-item">
                                        <?php echo $frm->getFieldHtml('ucp_personalized'); ?>
                                        <div class="data">
                                            <p>
                                                <?php echo Labels::getLabel('LBL_Personalise_Cookies_Information', $siteLangId); ?>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="p-4"> <?php echo $frm->getFieldHtml('btn_submit'); ?></div>
                                <?php echo '</form>'; ?>
                                <?php echo $frm->getExternalJs();  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>