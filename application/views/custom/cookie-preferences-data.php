<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Your_Cookie_Preferences', $siteLangId); ?></h5>
</div>
<div class="modal-body cookie-alert">
    <h5 class="h5">
        <strong>
            <?php echo Labels::getLabel('LBL_What_is_a_cookie?', $siteLangId); ?>
        </strong>
    </h5>
    <p class="pb-3">
        <?php echo Labels::getLabel('LBL_What_is_a_cookie_Information', $siteLangId); ?>
    </p>

    <div class="cookies-group">
        <div class="cookies-group-head" data-bs-toggle="collapse" data-bs-target="#Functional_Cookies"
            aria-expanded="false" aria-controls="Functional_Cookies">
            <h6>
                <?php echo Labels::getLabel('LBL_Functional_cookies(non-optional)', $siteLangId); ?>
            </h6>
            <label class="switch switch-sm switch-icon">
                <input type="checkbox" name="functional_cookies" disabled="disabled" checked="true">
            </label>
        </div>
        <div class="cookies-group-body collapse" id="Functional_Cookies">
            <p><?php echo Labels::getLabel('LBL_Functional_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>
    <div class="cookies-group">
        <div class="cookies-group-head" data-bs-toggle="collapse" data-bs-target="#Statistical_analysis"
            aria-expanded="false" aria-controls="Statistical_analysis">
            <h6><?php echo Labels::getLabel('LBL_Statistical_analysis_cookies', $siteLangId); ?></h6>
            <label class="switch switch-sm switch-icon">
                <input type="checkbox" name="statistical_cookies" checked="true">
            </label>
        </div>
        <div class="cookies-group-body collapse" id="Statistical_analysis">
            <p> <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>
    <div class="cookies-group">
        <div class="cookies-group-head" data-bs-toggle="collapse" data-bs-target="#Cookies_to_personalise"
            aria-expanded="false" aria-controls="Cookies_to_personalise">
            <h6>
                <?php echo Labels::getLabel('LBL_Cookies_to_personalise_the_experience', $siteLangId); ?>
            </h6>
            <label class="switch switch-sm switch-icon">
                <input type="checkbox" name="personalise_cookies" checked="true">
            </label>
        </div>
        <div class="cookies-group-body collapse" id="Cookies_to_personalise">
            <p> <?php echo Labels::getLabel('LBL_Personalise_Cookies_Information', $siteLangId); ?></p>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-brand btn-wide" type="button"
        onClick="setUserCookiePreferences()"><?php echo Labels::getLabel('LBL_Save', $siteLangId); ?></button>

</div>