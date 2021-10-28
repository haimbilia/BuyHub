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
                                    <div class="card-body p-0">
                                        <div class="stock-nav">
                                            <ul>
                                                <li class="stock-nav-item is-active">
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
                                                                Basic details</h6>
                                                            <span class="stock-nav-desc"> Add general details about the
                                                                product
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
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
                                                                Variants and options</h6>
                                                            <span class="stock-nav-desc"> Add options like Color, size
                                                                etc for your product</span>
                                                        </div>
                                                    </a>
                                                </li>
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
                                                                Media</h6>
                                                            <span class="stock-nav-desc"> Attach media files for the
                                                                product </span>
                                                        </div>
                                                    </a>
                                                </li>
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
                                                                Specifications</h6>
                                                            <span class="stock-nav-desc"> Product Specifications are
                                                                added in this section </span>
                                                        </div>
                                                    </a>
                                                </li>
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
                                                                Tax and Shipping</h6>
                                                            <span class="stock-nav-desc"> Add Tax and Shipping details
                                                                from this section </span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="add-stock-column">
                                <div>
                                    <h3> Add Product</h3>
                                    <span class="text-muted"> When adding products here, do not forget to fll the
                                        required felds marked with
                                        asterisk (*).</span>


                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Basic Details </h3>
                                            <span class="text-muted"> Add basic details about your product</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="form" action="">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required"> Product type </label>
                                                        <div class="">
                                                            <ul class="list-radio">
                                                                <li>
                                                                    <label class="radio">
                                                                        <input type="radio" value="0" checked="checked">
                                                                        Physical</label>
                                                                </li>
                                                                <li><label class="radio">
                                                                        <input type="radio" value="0">
                                                                        Digital</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required">
                                                            Product name
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="Lorem ipsum dolor sit amet consectetur adipisicing elit"
                                                                aria-label="Lorem ipsum dolor sit amet consectetur adipisicing elit"></i>
                                                        </label>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required "> Brand </label> <a
                                                                class="link" href="">Add brand</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required ">Category </label> <a
                                                                class="link" href="">Add category</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required "> Brand </label> <a
                                                                class="link" href="">Add brand</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required ">Category </label> <a
                                                                class="link" href="">Add category</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>

                                            </div>



                                        </form>

                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom collapsed" data-toggle="collapse"
                                        data-target="#stock-block1" aria-expanded="false" aria-controls="stock-block1">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Basic Details
                                            </h3>
                                            <span class="text-muted"> Add basic details about your product</span>
                                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body collapse" id="stock-block1">
                                        <form class="form" action="">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">
                                                            <span class="required">Product type
                                                            </span>

                                                        </label>
                                                        <div class="">
                                                            <ul class="list-radio">
                                                                <li>
                                                                    <label class="radio">
                                                                        <input type="radio" value="0" checked="checked">
                                                                        Physical</label>
                                                                </li>
                                                                <li><label class="radio">
                                                                        <input type="radio" value="0">
                                                                        Digital</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">
                                                            <span class="required">Product name</span>
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="Lorem ipsum dolor sit amet consectetur adipisicing elit"
                                                                aria-label="Lorem ipsum dolor sit amet consectetur adipisicing elit"></i>
                                                        </label>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                            </div>


                                        </form>

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