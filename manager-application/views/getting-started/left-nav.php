<div class="onboarding-aside">
    <div class="onboarding-head"></div>
    <div class="onboarding-body">
        <ul class="onboarding-nav">
            <?php $tourSteps = SiteTourHelper::getStepsData($siteLangId);
            $siteTourHelper = new SiteTourHelper();
            foreach ($tourSteps as $keyIndex => $tour) {
                $class = 'pending';
                if ($siteTourHelper->validateSteps($keyIndex) == true) {
                    $class = 'completed';
                }

                if (SiteTourHelper::getStepIndex() == $keyIndex) {
                    $class = 'process';
                }

            ?>
                <li class="onboarding-nav-item <?php echo $class; ?>">
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
            <img src="<?php echo CONF_WEBROOT_URL; ?>images/icons/rocket-launch.svg" width="292" alt="">
        </div>

    </div>

</div>