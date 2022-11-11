<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Your_Cookie_Preferences', $siteLangId); ?></h5>
</div>
<div class="modal-body cookie-alert cms">
    <h5>
        <strong>
            <?php echo Labels::getLabel('LBL_What_is_a_cookie?', $siteLangId); ?>
        </strong>
    </h5>
    <p><?php echo Labels::getLabel('LBL_What_is_a_cookie_Information', $siteLangId); ?></p>
    <div class="my-5">
        <label class="checkbox">
            <input type="checkbox" name="functional_cookies" disabled="disabled" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Functional_cookies(non-optional)', $siteLangId); ?></strong>
        </label>
        <p><?php echo Labels::getLabel('LBL_Functional_Cookies_Information', $siteLangId); ?></p>
    </div>
    <div class="my-5">
        <label class="checkbox">
            <input type="checkbox" name="statistical_cookies" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Statistical_analysis_cookies', $siteLangId); ?></strong>
        </label>
        <p> <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?></p>
    </div>
    <div class="my-5">
        <label class="checkbox">
            <input type="checkbox" name="personalise_cookies" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Cookies_to_personalise_the_experience', $siteLangId); ?></strong>
        </label>
        <p> <?php echo Labels::getLabel('LBL_Personalise_Cookies_Information', $siteLangId); ?></p>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-brand btn-wide" type="button" onClick="setUserCookiePreferences()"><?php echo Labels::getLabel('LBL_Save', $siteLangId); ?></button>
</div>