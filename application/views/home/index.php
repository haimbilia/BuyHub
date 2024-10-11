<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<script>
    ykevents.viewContent();
</script>

<main id="main" class="main">
    <section class="section">
        <div class="container">
            <div class="hero-banners">
                <div class="banners">
                    <a href="">
                        <img src="/images/banners/hero-banner.png" alt="">
                    </a>
                </div>
                <div class="banners">
                    <a href="">
                        <img src="/images/banners/hero-banner-1.png" alt="">
                    </a>
                </div>
                <div class="banners">
                    <a href="">
                        <img src="/images/banners/hero-banner-2.png" alt="">
                    </a>
                </div>

            </div>
        </div>
    </section>
    <?php foreach ($collectionTemplates as $collection) {
        echo FatUtility::decodeHtmlEntities($collection['html']);
    }
    $this->includeTemplate('_partial/footerTrustBanners.php');
    ?>
</main>