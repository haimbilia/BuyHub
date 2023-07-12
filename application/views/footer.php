<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$pixelId = FatApp::getConfig("CONF_FACEBOOK_PIXEL_ID", FatUtility::VAR_STRING, '');
if ('' !=  $pixelId) {  ?>
    <img alt="Facebook Pixel" height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $pixelId; ?>&ev=PageView&noscript=1" />
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
                        $dialCode =  FatApp::getConfig('CONF_SITE_PHONE_DCODE', FatUtility::VAR_STRING, '');
                        $site_conatct =  FatApp::getConfig('CONF_SITE_PHONE', FatUtility::VAR_INT, '');
                        if ($site_conatct) { ?>
                            <li class="contact-info-item">
                                <?php echo (CommonHelper::demoUrl() == true) ? '+1 469 844 3346' : ValidateElement::formatDialCode($dialCode) . $site_conatct; ?>
                            </li>
                        <?php } ?>
                        <?php $email_id = (CommonHelper::demoUrl() == true) ? 'sales@fatbit.com' : FatApp::getConfig('CONF_CONTACT_EMAIL', FatUtility::VAR_STRING, '');
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
                    if (CommonHelper::demoUrl() || true == WHITE_LABELED) {
                        $replacements = array(
                            '{YEAR}' => '&copy; ' . date("Y"),
                            '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com">Yo!Kart</a>',
                            '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>',
                        );
                        echo $str = CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $siteLangId), $replacements);
                    } else {
                        echo $str = 'Copyright &copy; ' . date('Y') . ' ' . FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId, FatUtility::VAR_STRING, '') . '. Powered by <a target="_blank" href="https://yo-kart.com">Yo!Kart</a> and Developed by <a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>';
                    }
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
    $this->includeTemplate('_partial/footerMetaContent.php');
    if (CommonHelper::demoUrl()) { ?>
        <section class="footer-cta">
            <div class="container">
                <div class="footer-cta-inner">
                    <h4 class="footer-cta-title">Yo!Kart Comes With All Essential eCommerce Features To Start An Online Marketplace</h4>
                    <a class="footer-cta-link btn btn-brand" href="https://www.yo-kart.com/contact-us.html?q=demo-footer">Get Started</a>

                </div>
            </div>
        </section>
    <?php }
    if ('cart' != strtolower($controllerName)) { ?>
        <!-- Mobile menu -->
        <div class="mobile-actions">
            <div class="mobile-actions-item">
                <a class="mobile-actions-link" href="<?php echo UrlHelper::generateUrl(); ?>">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-home">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel("NAV_HOME", $siteLangId); ?></span>
                </a>
            </div>
            <div class="mobile-actions-item">
                <button type="button" class="mobile-actions-link btn-open first">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-category">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel("NAV_MENU", $siteLangId); ?></span>
                </button>
            </div>
            <div class="mobile-actions-item">
                <button class="mobile-actions-link wishListJs">
                    <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-wishlist">
                        </use>
                    </svg>
                    <span class="txt"><?php echo Labels::getLabel('NAV_WISHLIST', $siteLangId); ?></span>
                </button>
            </div>
            <div class="mobile-actions-item">
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
            </div>

            <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                <div class="mobile-actions-item">
                    <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-gps-location">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-location">
                            </use>
                        </svg>
                        <span class="txt"><?php echo Labels::getLabel("NAV_LOCATION", $siteLangId); ?></span>
                    </button>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</footer>
<?php if (
    FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) &&
    !CommonHelper::getUserCookiesEnabled() &&
    FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, '')
) { ?>
    <div class="cookies-notice no-print" id="cookieInfoBox" style="display:none;">
        <div class="cookies-notice-content">
            <span class="cookies-notice-message">
                <?php echo FatUtility::decodeHtmlEntities(mb_substr(FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, ''), 0, 600)); ?>
                <a class="" href="<?php echo UrlHelper::generateUrl('cms', 'view', array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT))); ?>">
                    <?php echo Labels::getLabel('LBL_Cookies_Policy', $siteLangId); ?></a>
            </span>
            <div class="cookies-notice-buttons">
                <button class="btn btn-decline cookie-preferences-js">
                    <?php echo Labels::getLabel('LBL_Set_Cookie_Preferences', $siteLangId); ?>
                </button>
                <button class="btn btn-accept cc-cookie-accept-js">
                    <?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId); ?>
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('#cookieInfoBox').show();
            }, 3000);
        });
    </script>
<?php }
if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script src="https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>&libraries=places&callback=initMap"></script>
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
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/5fe08aa9df060f156a8ef9fd/1eq2hracf';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
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
    <svg class="svg" width="16" height="16">
        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow"></use>
    </svg>
    <span>
        <?php echo Labels::getLabel('LBL_TOP', $siteLangId); ?></span>
</a>

<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>
</body>

</html>