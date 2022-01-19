<div class="onboarding-aside">
    <div class="onboarding-head"></div>
    <div class="onboarding-body">
        <ul class="onboarding-nav">
            <?php $tourSteps = SiteTourHelper::getStepsData($siteLangId);
            foreach ($tourSteps as $keyIndex => $tour) {
            ?>
                <li class="onboarding-nav-item <?php echo (SiteTourHelper::getStepIndex() > $keyIndex) ? 'completed' : ''; ?>">
                    <a href="<?php echo SiteTourHelper::getUrl($keyIndex) ?>" class="onboarding-nav-link ">
                        <span class="onboarding-nav-icn"></span>
                        <span class="onboarding-nav-label"><?php echo $tour['title']; ?></span>
                    </a>

                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="onboarding-foot">
        <div class="rocket">
            <img src="<?php echo CONF_WEBROOT_URL; ?>images/icons/rocket-launch.jpg" width="292" height="217" alt="">
        </div>

    </div>

</div>