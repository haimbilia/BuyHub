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
                        <div class="add-stock">
                            <div class="add-stock-column column-nav">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stock-nav">
                                            <ul>
                                                <li class="stock-nav-item">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                General Information</h6>
                                                            <span class="stock-nav-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="add-stock-column">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Head</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">Body</div>
                                    <div class="card-foot">Foot</div>
                                </div>
                            </div>
                            <div class="add-stock-column">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Head</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">Body</div>
                                    <div class="card-foot">Foot</div>
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