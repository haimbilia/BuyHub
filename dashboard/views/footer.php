<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ('' !=  FatApp::getConfig("CONF_FACEBOOK_PIXEL_ID", FatUtility::VAR_STRING, '')) {  ?>
    <img alt="Facebook Pixel" height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $pixelId; ?>&ev=PageView&noscript=1" />
<?php }
if (CommonHelper::demoUrl()) { ?>
    <div class="feedback-btn">
        <a href="https://www.yo-kart.com/yokart-marketing-website-feedback.html<?php /* echo UrlHelper::generateUrl('Custom','feedback'); */ ?>" class="crcle-btn" data-toggle="tooltip" data-placement="left" title="Give Feedback">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="comments-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M416 224V64c0-35.3-28.7-64-64-64H64C28.7 0 0 28.7 0 64v160c0 35.3 28.7 64 64 64v54.2c0 8 9.1 12.6 15.5 7.8l82.8-62.1H352c35.3.1 64-28.6 64-63.9zm96-64h-64v64c0 52.9-43.1 96-96 96H192v64c0 35.3 28.7 64 64 64h125.7l82.8 62.1c6.4 4.8 15.5.2 15.5-7.8V448h32c35.3 0 64-28.7 64-64V224c0-35.3-28.7-64-64-64z" class=""></path>
            </svg>
        </a>

    </div>
<?php } ?>
<?php if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) && !CommonHelper::getUserCookiesEnabled()) { ?>
    <div class="cc-window cc-banner cc-type-info cc-theme-block cc-bottom cookie-alert no-print">
        <?php if (FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, '')) { ?>
            <div class="box-cookies">
                <span id="cookieconsent:desc" class="cc-message">
                    <?php echo FatUtility::decodeHtmlEntities(mb_substr(FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, ''), 0, 500)); ?>
                    <a href="<?php echo UrlHelper::generateUrl('cms', 'view', array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT)), CONF_WEBROOT_FRONTEND); ?>"><?php echo Labels::getLabel('LBL_Read_More', $siteLangId); ?></a></span>
                <span class="cc-close cc-cookie-accept-js"><?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId); ?></span>
                <span class="cc-close cookie-preferences-js"><?php echo Labels::getLabel('LBL_Set_Cookie_Preferences', $siteLangId); ?></span>
            </div>
        <?php }  ?>
    </div><?php } ?>
<?php if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script src='https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>&libraries=places'></script>

<?php } ?>
<?php if (FatApp::getConfig('CONF_ENABLE_LIVECHAT', FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig('CONF_LIVE_CHAT_CODE', FatUtility::VAR_STRING, '');
} ?>
<?php if (FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '') && User::checkStatisticalCookiesEnabled() == true) {
    echo FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '');
} ?>

<div class="no-print">
    <?php if (CommonHelper::demoUrl()) { ?>
        <!--Start of Tawk.to Script-->
        <script>
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/5898f87bf1b57c0a05d78696/default';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();

            window.onbeforeprint = function() {
                Tawk_API.hideWidget();
            };
            window.onafterprint = function() {
                Tawk_API.showWidget();
            };
        </script>
        <!--End of Tawk.to Script-->
    <?php
        if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl()) {
            $this->includeTemplate('restore-system/page-content.php');
        }
    } ?>
    <?php if (FatApp::getConfig('CONF_PWA_SERVICE_WORKER', FatUtility::VAR_INT, 1)) { ?>
        <script>
            $(document).ready(function() {
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', function() {
                        navigator.serviceWorker.register('<?php echo CONF_WEBROOT_FRONTEND; ?>sw.js?t=<?php echo filemtime(CONF_INSTALLATION_PATH . 'public/sw.js'); ?>&f').then(function(registration) {});
                    });
                }
            });
        </script>
    <?php } ?>
</div>
</div>
</body>

</html>