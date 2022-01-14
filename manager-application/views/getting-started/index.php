<main class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="get-started">
                    <div class="get-started-head">
                        <h2> Getting Started</h2>
                        <p> Wel Come! We’re here to help you get things rolling.</p>
                    </div>
                    <div class="get-started-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-started">
                                    <?php foreach ($tourSteps as $tourId => $tour) { ?>
                                        <li class="completed">
                                            <a class="target" href="<?php echo SiteTourHelper::getUrl($tourId); ?>">
                                                <div class="list-started_icon">
                                                    <svg class="svg">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-getting-started.svg#setup-logo-address">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="list-started_data">
                                                    <h5><?php echo $tour['title']; ?> </h5>
                                                    <p><?php echo $tour['msg']; ?></p>
                                                </div>
                                                <div class="list-started_action"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/tick-green.svg" alt="">

                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="get-started-foot">
                        <a href="<?php echo UrlHelper::generateUrl('Home'); ?>">Skip and continue to your Dashboard</a>
                        <p>Tip: You return here any time from the Setting Menu</p>
                    </div>
                </div>


            </div>
        </div>



    </div>
</main>