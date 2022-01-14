<div class="onboarding-aside">
    <div class="onboarding-head"></div>
    <div class="onboarding-body">
        <ul class="onboarding-nav">
            <?php $tourSteps = SiteTourHelper::getStepsData($siteLangId);
            foreach ($tourSteps as $keyIndex => $tour) {
            ?>
                <li class="onboarding-nav-item completed">
                    <a href="<?php echo SiteTourHelper::getNextLink($keyIndex)?>" class="onboarding-nav-link" type="button">
                        <img class="onboarding-nav-icn" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/tick-green.svg" width="32" height="32" alt="">
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