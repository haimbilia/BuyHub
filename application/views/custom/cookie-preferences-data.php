<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Your_Cookie_Preferences', $siteLangId); ?></h5>
</div>
<div class="modal-body cookie-alert cms">
    <div>
        <h5> <?php echo Labels::getLabel('LBL_What_is_a_cookie?', $siteLangId); ?> </h5>
    </div>
    
    <div>
        <p> <?php echo Labels::getLabel('LBL_What_is_a_cookie_Information', $siteLangId); ?></p>
    </div>

    <div>
        <label class="checkbox">
            <input type="checkbox" name="functional_cookies" disabled="disabled" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Functional_cookies(non-optional)', $siteLangId); ?></strong>
        </label> <br><br>
        <div>
            <p> <?php echo Labels::getLabel('LBL_Functional_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>

    <div>
        <label class="checkbox">
            <input type="checkbox" name="statistical_cookies" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Statistical_analysis_cookies', $siteLangId); ?></strong>
        </label><br><br>
        <div>
            <p> <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>

    <div>
        <label class="checkbox">
            <input type="checkbox" name="personalise_cookies" checked="true">
            <strong><?php echo Labels::getLabel('LBL_Cookies_to_personalise_the_experience', $siteLangId); ?></strong>
        </label><br><br>
        <div>
            <p> <?php echo Labels::getLabel('LBL_Personalise_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="button" onClick="setUserCookiePreferences()"><?php echo Labels::getLabel('LBL_Save', $siteLangId); ?></button>
</div>