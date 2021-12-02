<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $recordLang_id != $siteDefaultLangId) { ?>
    <div class="row justify-content-end">
        <div class="col-auto mb-4">
            <input class="btn btn-brand" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteDefaultLangId); ?>" onClick="langForm(<?php echo $record_id; ?>, <?php echo $recordLang_id; ?>, 1)">
        </div>
    </div>
<?php } ?>