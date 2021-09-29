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

                <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-label">
                                                <span class="card-head-title">Catagories</span>
                                                <span class="text-muted">Lorem ipsum dolor sit amet consectetur
                                                </span>
                                            </h3>

                                        </div>
                                        <div class="card-toolbar">

                                            <ul class="actions">
                                                <li> <a href="#" class="btn btn-icon btn-light btn-add">
                                                        <i class="icn">
                                                            <svg class="svg">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#add">
                                                                </use>
                                                            </svg></i>
                                                        <span>New</span>
                                                    </a></li>
                                                <li>
                                                    <a class="" href="#" title="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#active">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="#" title="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#in-active">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="categories-accordion" id="categories-accordion">
                                            <div class="categories-accordion-items">
                                                <div class="categories-accordion-items-level">

                                                    <div class="categories-accordion-label">
                                                        <i class="icn icn-drag">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <span class="categories-accordion-title" data-toggle="collapse"
                                                            data-target="#level1" aria-expanded="true"
                                                            aria-controls="level1">
                                                            <i class="categories-accordion">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                    </use>
                                                                </svg>
                                                            </i> Category 1 <span
                                                                class="count badge badge-success">8</span></span>

                                                    </div>

                                                    <div class="categories-accordion-action">

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>


                                                        <button type="button" class="btn btn-clean btn-sm btn-icon">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#link">
                                                                </use>
                                                            </svg>

                                                        </button>
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#view">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                                                                </use>
                                                            </svg>
                                                        </button>

                                                    </div>
                                                </div>

                                                <div id="level1" class="collapse" aria-labelledby="level1"
                                                    data-parent="#categories-accordion">

                                                    <div class="categories-accordion-items">
                                                        <div class="categories-accordion-items-level">
                                                            <div class="categories-accordion-label">
                                                                <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#drag">
                                                                        </use>
                                                                    </svg>
                                                                </i>

                                                                <span class="categories-accordion-title"
                                                                    data-toggle="collapse" data-target="#level1-1"
                                                                    aria-expanded="true" aria-controls="level1-1">
                                                                    <i class="categories-accordion">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                            </use>
                                                                        </svg>
                                                                    </i> Category 1.1 <span
                                                                        class="count badge badge-success">25</span>
                                                                </span>

                                                            </div>

                                                            <div class="categories-accordion-action">

                                                                <label class="switch switch-sm switch-icon">
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>


                                                                <button type="button"
                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#link">
                                                                        </use>
                                                                    </svg>

                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#view">
                                                                        </use>
                                                                    </svg>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </button>

                                                            </div>
                                                        </div>

                                                        <div id="level1-1" class="collapse" aria-labelledby="level1-1"
                                                            data-parent="#categories-accordion">

                                                            <div class="categories-accordion-items">
                                                                <div class="categories-accordion-items-level">
                                                                    <div class="categories-accordion-label">
                                                                        <i class="icn">
                                                                            <svg class="svg" width="18" height="18">
                                                                                <use
                                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#drag">
                                                                                </use>
                                                                            </svg>
                                                                        </i>

                                                                        <span class="categories-accordion-title"
                                                                            data-toggle="collapse"
                                                                            data-target="#level1-1-1"
                                                                            aria-expanded="true"
                                                                            aria-controls="level1-1-1">
                                                                            <i class="categories-accordion">
                                                                                <svg class="svg" width="18" height="18">
                                                                                    <use
                                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                                    </use>
                                                                                </svg>
                                                                            </i> Category 1.1.1 <span
                                                                                class="count badge badge-success">25</span>
                                                                        </span>

                                                                    </div>

                                                                    <div class="categories-accordion-action">

                                                                        <label class="switch switch-sm switch-icon">
                                                                            <input type="checkbox" checked="checked"
                                                                                name="">
                                                                            <span></span>
                                                                        </label>


                                                                        <button type="button"
                                                                            class="btn btn-clean btn-sm btn-icon">
                                                                            <svg class="svg" width="18" height="18">
                                                                                <use
                                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#link">
                                                                                </use>
                                                                            </svg>

                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-clean btn-sm btn-icon">
                                                                            <svg class="svg" width="18" height="18">
                                                                                <use
                                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#view">
                                                                                </use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-clean btn-sm btn-icon">
                                                                            <svg class="svg" width="18" height="18">
                                                                                <use
                                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
                                                                                </use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-clean btn-sm btn-icon">
                                                                            <svg class="svg" width="18" height="18">
                                                                                <use
                                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                                                                                </use>
                                                                            </svg>
                                                                        </button>

                                                                    </div>
                                                                </div>

                                                                <div id="level1-1" class="collapse"
                                                                    aria-labelledby="level1-1"
                                                                    data-parent="#categories-accordion">

                                                                    <div class="categories-accordion-items">
                                                                        <div class="categories-accordion-items-level">
                                                                            <div class="categories-accordion-label">
                                                                                <i class="icn">
                                                                                    <svg class="svg" width="18"
                                                                                        height="18">
                                                                                        <use
                                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#drag">
                                                                                        </use>
                                                                                    </svg>
                                                                                </i>

                                                                                <span class="categories-accordion-title"
                                                                                    data-toggle="collapse"
                                                                                    data-target="#level1-1-1"
                                                                                    aria-expanded="true"
                                                                                    aria-controls="level1-1-1">
                                                                                    <i class="categories-accordion">
                                                                                        <svg class="svg" width="18"
                                                                                            height="18">
                                                                                            <use
                                                                                                xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                                            </use>
                                                                                        </svg>
                                                                                    </i> Category 1.1.1 <span
                                                                                        class="count badge badge-success">25</span>
                                                                                </span>

                                                                            </div>

                                                                            <div class="categories-accordion-action">

                                                                                <label
                                                                                    class="switch switch-sm switch-icon">
                                                                                    <input type="checkbox"
                                                                                        checked="checked" name="">
                                                                                    <span></span>
                                                                                </label>


                                                                                <button type="button"
                                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                                    <svg class="svg" width="18"
                                                                                        height="18">
                                                                                        <use
                                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#link">
                                                                                        </use>
                                                                                    </svg>

                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                                    <svg class="svg" width="18"
                                                                                        height="18">
                                                                                        <use
                                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#view">
                                                                                        </use>
                                                                                    </svg>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                                    <svg class="svg" width="18"
                                                                                        height="18">
                                                                                        <use
                                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
                                                                                        </use>
                                                                                    </svg>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-clean btn-sm btn-icon">
                                                                                    <svg class="svg" width="18"
                                                                                        height="18">
                                                                                        <use
                                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                                                                                        </use>
                                                                                    </svg>
                                                                                </button>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
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