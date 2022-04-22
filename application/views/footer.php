<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ('' !=  FatApp::getConfig("CONF_FACEBOOK_PIXEL_ID", FatUtility::VAR_STRING, '')) {  ?>
    <img alt="Facebook Pixel" height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $pixelId; ?>&ev=PageView&noscript=1" />
<?php }
if (CommonHelper::demoUrl()) { ?>
    <div class="feedback-btn">
        <a href="https://www.yo-kart.com/yokart-marketing-website-feedback.html<?php /* echo UrlHelper::generateUrl('Custom','feedback'); */ ?>" class="crcle-btn" data-bs-toggle="tooltip" data-placement="left" title="Give Feedback">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="comments-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M416 224V64c0-35.3-28.7-64-64-64H64C28.7 0 0 28.7 0 64v160c0 35.3 28.7 64 64 64v54.2c0 8 9.1 12.6 15.5 7.8l82.8-62.1H352c35.3.1 64-28.6 64-63.9zm96-64h-64v64c0 52.9-43.1 96-96 96H192v64c0 35.3 28.7 64 64 64h125.7l82.8 62.1c6.4 4.8 15.5.2 15.5-7.8V448h32c35.3 0 64-28.7 64-64V224c0-35.3-28.7-64-64-64z" class=""></path>
            </svg>
        </a>

    </div>
<?php } ?>

<?php if ($controllerName == 'Home' && $action == 'index') {
    $this->includeTemplate('_partial/footerTrustBanners.php');
} ?>


<?php if (FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION', FatUtility::VAR_INT, 0)) { ?>
    <section class="section bg-newsletter" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/bg/bg-newsletter.png) ;">
        <?php $this->includeTemplate('_partial/footerNewsLetterForm.php'); ?>
    </section>
<?php  } ?>

<footer class="footer section no-print" id="footer">
    <section class="footer-top">
        <div class="container">
            <div class="footer-layout">
                <div class="footer-layout-col footer-logo-wrap">
                    <div class="footer-logo">
                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/logos/logo-footer.png" alt="">
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

                    <?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>

                </div>
                <div class="footer-layout-col">
                    <div class="row">
                        <?php $this->includeTemplate('_partial/footerNavigation.php'); ?>
                    </div>
                </div>

                <div class="footer-layout-col">
                    <?php $this->includeTemplate('_partial/footerSocialMedia.php'); ?>
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

    <?php $this->includeTemplate('_partial/footerMetaContent.php'); ?>


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

<?php if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) && !CommonHelper::getUserCookiesEnabled()) { ?>
    <div class="cc-window no-print">
        <?php if (FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, '')) { ?>
            <div class="box-cookies" id="cookieInfoBox">
                <span id="cookieconsent:desc" class="cc-message">
                    <?php echo FatUtility::decodeHtmlEntities(mb_substr(FatApp::getConfig('CONF_COOKIES_TEXT_' . $siteLangId, FatUtility::VAR_STRING, ''), 0, 500)); ?>
                    <a href="<?php echo UrlHelper::generateUrl('cms', 'view', array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT))); ?>"><?php echo Labels::getLabel('LBL_Read_More', $siteLangId); ?></a></span>
                <span class="btn btn-brand btn-sm cc-cookie-accept-js"><?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId); ?></span>
                <span class="btn btn-outline-brand btn-sm cookie-preferences-js"><?php echo Labels::getLabel('LBL_Set_Cookie_Preferences', $siteLangId); ?></span>
            </div>
        <?php }  ?>
    </div><?php } ?>
<?php if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script defer src='https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>&libraries=places'>
    </script>

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
<a class="back-to-top" href="#top">
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