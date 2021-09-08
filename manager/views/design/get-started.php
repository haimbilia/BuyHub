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
        ?>

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
                                                        <div class="list-started_icon">
                                                            <a href="#/localization/bussiness-management" class="links"
                                                                target="_blank">
                                                                <svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-logo-address">
                                                                    </use>
                                                                </svg></a>
                                                        </div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/localization/bussiness-management"
                                                                    class="links" target="_blank">Add localization
                                                                    Settings</a></h5>
                                                            <p>Fill in your store's business information, units,
                                                                currencies &amp; languages to get started.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/system-settings/logo"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-logo-address">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/system-settings/logo" class="links"
                                                                    target="_blank">Configure General Settings</a></h5>
                                                            <p>Let's configure the system's workflows.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a target="_blank"
                                                                href="https://demo.tribe.yo-kart.com/admin/pages/1/edit"
                                                                class="links"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-homepage">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a target="_blank"
                                                                    href="https://demo.tribe.yo-kart.com/admin/pages/1/edit"
                                                                    class="links">Configure Homepage</a></h5>
                                                            <p>Customize your homepage with an easy to use editor</p>
                                                        </div>
                                                        <div class="list-started_action">
                                                            <img src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/payment-methods"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-payment-gateway">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/payment-methods" class="links"
                                                                    target="_blank">Setup Payment Gateway</a></h5>
                                                            <p>Help the money roll in by setting up payment gateways to
                                                                collect payments online.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/shipping/create"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-shipping-charges">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/shipping/create" class="links"
                                                                    target="_blank">Setup Shipping Charges</a></h5>
                                                            <p>Configure your rates and pick up times according to your
                                                                location and shipping carriers.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/tax/create"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-tax-rates">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/tax/create" class="links"
                                                                    target="_blank">Setup Tax Rates</a></h5>
                                                            <p>Configure store-wide taxes and invoice settings.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/brands" class="links"
                                                                target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-brand">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/brands" class="links" target="_blank">Add
                                                                    Brands</a></h5>
                                                            <p>Adding brands takes you one step closer to getting you
                                                                products online</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/product/categories"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-categoriess">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/product/categories" class="links"
                                                                    target="_blank">Add Categoriese</a></h5>
                                                            <p>Add categories to showcase your product range</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="list-started_icon"><a href="#/product/create"
                                                                class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-products">
                                                                    </use>
                                                                </svg></a></div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/product/create" class="links"
                                                                    target="_blank">Add Products</a></h5>
                                                            <p>Let's roll your products out! Showcase your products with
                                                                images, options &amp; detailed descriptions.</p>
                                                        </div>
                                                        <div class="list-started_action"><img
                                                                src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-green.svg"
                                                                alt="">

                                                        </div>
                                                    </li>
                                                    <li class="">
                                                        <div class="list-started_icon">
                                                            <a href="#/pages" class="links" target="_blank"><svg>
                                                                    <use
                                                                        xlink:href="https://demo.tribe.yo-kart.com/admin/images/retina/sprite.svg#setup-content-pages">
                                                                    </use>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <div class="list-started_data">
                                                            <h5><a href="#/pages" class="links"
                                                                    target="_blank">Configure Content Pages</a></h5>
                                                            <p>Setup your content pages. How about a brand story?</p>
                                                        </div>
                                                        <div class="list-started_action">
                                                            <img src="https://demo.tribe.yo-kart.com/admin/images/retina/tick-unfill.svg"
                                                                alt="">
                                                        </div>
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