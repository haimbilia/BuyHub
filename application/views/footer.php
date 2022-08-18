<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ('' !=  FatApp::getConfig("CONF_FACEBOOK_PIXEL_ID", FatUtility::VAR_STRING, '')) {  ?>
    <img alt="Facebook Pixel" height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $pixelId; ?>&ev=PageView&noscript=1" />
<?php }
if (FatApp::getConfig("CONF_ENABLE_ENGAGESPOT_PUSH_NOTIFICATION", FatUtility::VAR_STRING, '') && UserAuthentication::getLoggedUserId(true) > 0) {
?>

    <div class="engagespot-btn" id="engagespotUI">
    </div>
<?php } ?>


<?php if (FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION', FatUtility::VAR_INT, 0)) { ?>
    <section class="section bg-newsletter no-print" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/bg/bg-newsletter.jpg) ;">
        <?php
        $this->includeTemplate('_partial/footerNewsLetterForm.php'); ?>
    </section>
<?php  } ?>

<footer class="footer section no-print" id="footer">
    <section class="footer-top">
        <div class="container">
            <div class="footer-layout">
                <div class="footer-layout-col footer-logo-wrap">
                    <div class="footer-logo">
                        <?php
                        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                        $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        ?>
                        <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
                    </div>

                    <ul class="contact-info">
                        <?php
                        $dialCode = FatApp::getConfig('CONF_SITE_PHONE_DCODE', FatUtility::VAR_STRING, '');
                        $site_conatct = FatApp::getConfig('CONF_SITE_PHONE', FatUtility::VAR_INT, '');
                        if ($site_conatct) { ?>
                            <li class="contact-info-item">
                                <?php echo ValidateElement::formatDialCode($dialCode) . $site_conatct; ?>
                            </li>
                        <?php } ?>
                        <?php $email_id = FatApp::getConfig('CONF_CONTACT_EMAIL', FatUtility::VAR_STRING, '');
                        if ($email_id) { ?>
                            <li class="contact-info-item">
                                <a class="contact-info-link" href="mailto:<?php echo $email_id; ?>"><?php echo $email_id; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <?php
                    $this->includeTemplate('_partial/headerLanguageArea.php'); ?>

                </div>
                <div class="footer-layout-col">
                    <div class="row">
                        <?php
                        $this->includeTemplate('_partial/footerNavigation.php'); ?>
                    </div>
                </div>

                <div class="footer-layout-col">
                    <?php
                    $this->includeTemplate('_partial/footerSocialMedia.php'); ?>
                </div>
            </div>



        </div>
    </section>
    <section class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="copyright">
                    <?php
                    $replacements = array(
                        '{YEAR}' => '&copy; ' . date("Y"),
                        '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com" rel="noopener">Yo!Kart</a>',
                        '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com" rel="noopener">FATbit Technologies</a>',
                    );
                    echo CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $siteLangId), $replacements);
                    ?>
                </div>
                <div class="payment">
                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/payment-method/payment-1.svg" width="36" height="23" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>">

                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/payment-method/payment-2.svg" width="36" height="23" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>">
                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/payment-method/payment-3.svg" width="36" height="23" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>">
                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/payment-method/payment-4.svg" width="36" height="23" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>">
                </div>
            </div>


        </div>
    </section>

    <?php
    $this->includeTemplate('_partial/footerMetaContent.php'); ?>

    <?php if ('cart' != strtolower($controllerName)) { ?>
        <!-- Mobile menu -->
        <ul class="mobile-actions">
            <li class="mobile-actions-item" role="none">
                <a class="mobile-actions-link" href="<?php echo UrlHelper::generateUrl(); ?>">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-home">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel("NAV_HOME", $siteLangId); ?></span>
                </a>
            </li>
            <li class="mobile-actions-item" role="none">
                <button type="button" class="mobile-actions-link btn-open first">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-category">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel("NAV_MENU", $siteLangId); ?></span>
                </button>
            </li>
            <li class="mobile-actions-item" role="none">
                <button class="mobile-actions-link wishListJs">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-wishlist">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel('NAV_WISHLIST', $siteLangId); ?></span>
                </button>
            </li>
            <li class="mobile-actions-item" role="none">
                <?php if ((!UserAuthentication::isUserLogged() && UserAuthentication::isGuestUserLogged()) ||  UserAuthentication::isUserLogged()) {        ?>
                    <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-account">
                    <?php } else { ?>
                        <button class="mobile-actions-link sign-in-popup-js" type="button">
                        <?php  } ?>
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-account">
                            </use>
                        </svg>
                        <span class="txt"><?php echo Labels::getLabel("LBL_Account", $siteLangId); ?></span>
                        </button>
            </li>

            <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                <li class="mobile-actions-item" role="none">
                    <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-gps-location">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-location">
                            </use>
                        </svg>
                        <span class="txt"><?php echo Labels::getLabel("NAV_LOCATION", $siteLangId); ?></span>
                    </button>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <div class="outdated">
        <div class="outdated-inner">
            <div class="outdated-messages">
                <div class="heading">The browser you are using is not supported. Some critical security features are not
                    available for your
                    browser version.</div>
                <div class="para">We want you to have the best possible experience with
                    <?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, ''); ?>.
                    For this you'll need to use a supported browser and upgrade to the latest version. </div>
                <ul class="list-browser">
                    <li><a href="https://www.google.com/chrome" target="_blank" rel="noopener noreferrer"><i class="icn chrome"></i>
                            <p><strong>Chrome</strong><br>
                                <span>Get the latest version</span>
                            </p>
                        </a></li>
                    <li><a href="https://getfirefox.com" target="_blank" rel="noopener noreferrer"><i class="icn firefox"></i>
                            <p><strong>Firefox</strong><br>
                                <span>Get the latest version</span>
                            </p>
                        </a></li>
                    <li><a href="http://support.apple.com/downloads/#safari" target="_blank" rel="noopener noreferrer"><i class="icn safari"></i>
                            <p><strong>Safari</strong><br>
                                <span>Get the latest version</span>
                            </p>
                        </a></li>
                    <li>
                        <a href="http://getie.com" target="_blank" rel="noopener noreferrer"><i class="icn internetexplorer"></i>
                            <p><strong>Internet Explorer</strong><br>
                                <span>Get the latest version</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?php if (
    FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) &&
    !CommonHelper::getUserCookiesEnabled() &&
    FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, '')
) { ?>
    <div class="cc-window no-print" id="cookieInfoBox">
        <div class="box-cookies">
            <p id="cookieconsent:desc" class="cc-message">
                <?php echo FatUtility::decodeHtmlEntities(mb_substr(FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, ''), 0, 600)); ?>
                <a href="<?php echo UrlHelper::generateUrl('cms', 'view', array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT))); ?>">
                    <?php echo Labels::getLabel('LBL_Read_More', $siteLangId); ?></a>
            </p>
            <div class="cookies-actions">
                <button class="btn btn-outline-gray cookie-preferences-js">
                    <?php echo Labels::getLabel('LBL_Set_Cookie_Preferences', $siteLangId); ?>
                </button>
                <button class="btn btn-brand cc-cookie-accept-js">
                    <?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId); ?>
                </button>
            </div>
        </div>
    </div>
<?php }
if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script src="https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>&libraries=places"></script>
<?php }
if (FatApp::getConfig('CONF_ENABLE_LIVECHAT', FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig('CONF_LIVE_CHAT_CODE', FatUtility::VAR_STRING, '');
} ?>
<?php if (FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '') && User::checkStatisticalCookiesEnabled() == true) {
    echo FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '');
}

if (FatApp::getConfig("CONF_ENABLE_ENGAGESPOT_PUSH_NOTIFICATION", FatUtility::VAR_STRING, '') && UserAuthentication::getLoggedUserId(true) > 0) { ?>
    <script>
        $.getScript("https://cdn.engagespot.co/engagespot-client.min.js", function(data, textStatus, jqxhr) {
            Engagespot.render('#engagespotUI', {
                apiKey: "<?php echo FatApp::getConfig("CONF_ENGAGESPOT_API_KEY", FatUtility::VAR_STRING, ''); ?>",
                userId: "<?php echo User::getCredentialName(UserAuthentication::getLoggedUserId(true)); ?>",
                userSignature: "<?php echo base64_encode(hash_hmac('sha256', User::getCredentialName(UserAuthentication::getLoggedUserId(true)), FatApp::getConfig("CONF_ENGAGESPOT_SECRET_KEY", FatUtility::VAR_STRING, ''), true)); ?>"
            });
        });
    </script>
<?php } ?>
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
            $(function() {
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', function() {
                        navigator.serviceWorker.register(
                            '<?php echo CONF_WEBROOT_URL; ?>sw.js?t=<?php echo filemtime(CONF_INSTALLATION_PATH . 'public/sw.js'); ?>&f'
                        ).then(function(registration) {});
                    });
                }
            });
        </script>
    <?php } ?>
</div>
</div>
<?php include(CONF_THEME_PATH . '_partial/footer-part/offcanvas-elements.php'); ?>
<a class="back-to-top no-print">
    <svg class="svg">
        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow"></use>
    </svg>
    <span><?php echo Labels::getLabel('LBL_TOP', $siteLangId); ?></span>
</a>
</body>

</html>
<?php
//$content  = ob_get_clean();
//echo CommonHelper::minifyHtml($content);
?>