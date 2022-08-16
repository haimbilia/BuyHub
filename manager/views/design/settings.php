<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body class="fb-body">
    <div class="app">
        <?php include 'includes/sidebar.php';  ?>
        <div class="wrap">
            <?php include 'includes/new-header.php';  ?>
            <main class="main">
                <div class="container">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">Settings </h3>
                            </div>
                            <div class="card-toolbar">
                                <div class="maintenance-mode">
                                    <label class="switch switch-sm">
                                        <input type="checkbox">
                                        <span class="input-helper"></span> Maintenance Mode
                                    </label>

                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="setting-search">
                                <form class="form">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <input type="search" class="form-control omni-search" name="search" value="addons" placeholder="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="settings">
                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>configurations">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#general-settings">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>General Settings</h6>
                                        <span>Display, Sound, notifications, power</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>plugins">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#plugins">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Plugins</h6>
                                        <span><mark>Addons</mark>, Third party services</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>labels">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#labels">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Labels</h6>
                                        <span>Manage application labels</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>theme-color">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#theme">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Theme</h6>
                                        <span>Fonts, color, styling</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>currency-management">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#currencies">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Currencies</h6>
                                        <span>Currency, Symbol, conversions</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>commission">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#site-commission">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Site Commission</h6>
                                        <span>Category, Seller, product, commision fees</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>affiliate-commission">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#affiliate-commision">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Affiliate Commission</h6>
                                        <span>Category, Users, Commision fees</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>seller-packages">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#subscriptions-packages">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Seller Packages</h6>
                                        <span>Subscription, Packages for seller</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>zones">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#zones">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Zones</h6>
                                        <span>Manage country zones</span>
                                    </div>
                                </a>
                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>countries">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#countries">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Countries</h6>
                                        <span>Addresses, Shipping Rates configuration and Tax rates</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>states">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#states">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>States</h6>
                                        <span>Addresses, Shipping Rates configuration and Tax rates</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>abusive-words">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#abusive-keywords">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Abusive Keywords</h6>
                                        <span>Configure Abusive keywords</span>
                                    </div>
                                </a>

                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>empty-cart-items">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#empty-cart">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Empty Cart</h6>
                                        <span>Items for empty cart page</span>
                                    </div>
                                </a>
                                <a class="setting" href="<?php echo CONF_WEBROOT_URL; ?>shop-report-reasons">
                                    <div class="setting__icon">
                                        <span class="icon">
                                            <svg class="icon" width="40" height="40">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#shop-reports">
                                                </use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="setting__detail">
                                        <h6>Shop Report Reasons Management</h6>
                                        <span>Shop report reasons</span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include 'includes/footer.php';  ?>
        </div>
    </div>



</body>

</html>