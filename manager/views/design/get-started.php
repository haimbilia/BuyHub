<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body class="fb-body">
        <div class="app">
            <?php
        include 'includes/sidebar.php';
        ?>

            <div class="wrap">
                <?php
        include 'includes/new-header.php';
        ?> <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                    <span class="help_label">Help</span>
                </button>

                <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help"
                    aria-hidden="true">

                    <div class="modal-dialog modal-dialog-vertical" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="help-window">
                                            <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/no-data-cuate.svg"
                                                alt="">

                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...</h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.</li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.</li>
                                                </ul>

                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>




                </div>

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
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon">

                                                                <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-logo-address">
                                                                    </use>

                                                                </svg>

                                                            </div>
                                                            <div class="list-started_data">
                                                                <h5> Add localization
                                                                    Settings </h5>
                                                                <p>Fill in your store's business information, units,
                                                                    currencies &amp; languages to get started.</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon">

                                                                <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-logo-address">
                                                                    </use>
                                                                </svg>

                                                            </div>
                                                            <div class="list-started_data">
                                                                <h5>
                                                                    Configure General Settings

                                                                </h5>
                                                                <p>Let's configure the system's workflows.</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-homepage">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Configure Homepage </h5>
                                                                <p>Customize your homepage with an easy to use editor
                                                                </p>
                                                            </div>
                                                            <div class="list-started_action">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-payment-gateway">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Setup
                                                                    Payment Gateway </h5>
                                                                <p>Help the money roll in by setting up payment gateways
                                                                    to
                                                                    collect payments online.</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-shipping-charges">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Setup
                                                                    Shipping Charges </h5>
                                                                <p>Configure your rates and pick up times according to
                                                                    your
                                                                    location and shipping carriers.</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-tax-rates">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Setup Tax
                                                                    Rates </h5>
                                                                <p>Configure store-wide taxes and invoice settings.</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"><svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-brand">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Add Brands </h5>
                                                                <p>Adding brands takes you one step closer to getting
                                                                    you
                                                                    products online</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-categoriess">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Add Categoriese </h5>
                                                                <p>Add categories to showcase your product range</p>
                                                            </div>
                                                            <div class="list-started_action"><img
                                                                    src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="completed">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon"> <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-products">
                                                                    </use>
                                                                </svg> </div>
                                                            <div class="list-started_data">
                                                                <h5> Add
                                                                    Products </h5>
                                                                <p>Let's roll your products out! Showcase your products
                                                                    with
                                                                    images, options &amp; detailed descriptions.</p>
                                                            </div>
                                                            <div class="list-started_action">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">

                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a class="target" href="#" target="_blank">
                                                            <div class="list-started_icon">
                                                                <svg class="svg">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-getting-started.svg#setup-content-pages">
                                                                    </use>
                                                                </svg>

                                                            </div>
                                                            <div class="list-started_data">
                                                                <h5> Configure Content
                                                                    Pages </h5>
                                                                <p>Setup your content pages. How about a brand story?
                                                                </p>
                                                            </div>
                                                            <div class="list-started_action">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/tick-green.svg"
                                                                    alt="">
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="get-started-foot">
                                        <a href="">Skip and continue to your Dashboard</a>
                                        <p>Tip: You return here any time from the Setting Menu</p>
                                    </div>
                                </div>


                            </div>
                        </div>



                    </div>
                </main>
                <?php
        include 'includes/footer.php';
        ?>


            </div>

        </div>

    </body>

</html>