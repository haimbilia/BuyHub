<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$this->includeTemplate('restore-system/top-header.php');
$this->includeTemplate('restore-system/page-content.php');
?>

<main class="main">
    <div class="device-preview">
        <div class="device-preview-container <?php echo $deviceClass; ?>">
            <div class="flyer-txt"> It's Mobile Friendly
                <img class="flyer-txt-arrow" src="<?php echo CONF_WEBROOT_URL ?>images/retina/curved-thin-arrow-icon.svg" alt="">
            </div>
            <iframe class="device-preview-iframe" src="<?php echo UrlHelper::generateFullUrl(); ?>" scrolling="yes" frameborder="0" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
            </iframe>
        </div>
        <div class="device-preview-content">
            <div class="device-preview-cms">
                <ul>
                    <li>
                        <h3>Yo!Kart is PWA compliant</h3>
                        <p> Allows business owners to offer a seamless mobile experience to their users.</p>
                    </li>
                    <li>
                        <h3>Yo!Kart Buyer Mobile Apps</h3>
                        <p> Leverage increasing user preference for mobiles with apps tailormade to deliver enriched eCommerce experiences.</p>
                    </li>
                </ul>
            </div>
            <div class="device-preview-cta">
                <ul class="app-actions">
                    <li class="app-actions-item">
                        <img class="app-actions-qr" src="<?php echo CONF_WEBROOT_URL ?>images/qrcode.68050111.png" width="90" height="90" alt="">
                        <a class="app-actions-btn link-add" href="https://play.google.com/store/apps/details?id=com.fatbit.yokartv9.buyer" aria-label="Google play">
                            <img src="<?php echo CONF_WEBROOT_URL ?>images/google-play.png" alt="">
                        </a>
                    </li>
                    <li class="app-actions-item">
                        <img class="app-actions-qr" src="<?php echo CONF_WEBROOT_URL ?>images/qrcode.68050150.png" width="90" height="90" alt="">
                        <a class="app-actions-btn link-add" href="https://apps.apple.com/in/app/yokart/id1619743463" aria-label="App store">
                            <img src="<?php echo CONF_WEBROOT_URL ?>images/app-store.png" alt="">
                        </a>
                    </li>
                </ul>
                <p> Cater To A Wider Audience With Yo!Kart Buyer Mobile Apps For Android & iOS
                </p>
                <a class="btn btn-brand btn-wide get-started" href="https://www.yo-kart.com/contact-us.html?q=mobile_demo">Get Started</a>
            </div>

        </div>
    </div>
</main>