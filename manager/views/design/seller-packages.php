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
                                <div class="xxx">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Subscription Packages</h3><span
                                                class="text-muted">Over 500 new products</span>
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

                                            </ul>

                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-packages">
                                            <thead>
                                                <tr>
                                                    <th><label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label></th>

                                                    <th width="60%">Package Name</th>
                                                    <th>Status</th>
                                                    <th class="align-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="packages-data">
                                                            <div class="h6">Silver Plan
                                                                <i class="" type="button" data-toggle="collapse"
                                                                    data-target="#plan1" aria-expanded="false"
                                                                    aria-controls="plan1">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                        </use>
                                                                    </svg>

                                                                </i>






                                                            </div>
                                                            <ul class="list-bullet collapse" class="" id="plan1">
                                                                <li>$110.00 / Per 60 Days</li>
                                                                <li> $140.00 / Per 90 Days</li>
                                                                <li> $990.00 / Unlimited</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label></td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#edit"
                                                                    title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
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
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="packages-data">
                                                            <div class="h6">Silver Plan
                                                                <i class="" type="button" data-toggle="collapse"
                                                                    data-target="#plan2" aria-expanded="false"
                                                                    aria-controls="plan2">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                        </use>
                                                                    </svg>

                                                                </i>






                                                            </div>
                                                            <ul class="list-bullet collapse" class="" id="plan2">
                                                                <li>$110.00 / Per 60 Days</li>
                                                                <li> $140.00 / Per 90 Days</li>
                                                                <li> $990.00 / Unlimited</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label></td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#edit"
                                                                    title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
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
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="packages-data">
                                                            <div class="h6">Silver Plan
                                                                <i class="" type="button" data-toggle="collapse"
                                                                    data-target="#plan3" aria-expanded="false"
                                                                    aria-controls="plan3">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                        </use>
                                                                    </svg>

                                                                </i>






                                                            </div>
                                                            <ul class="list-bullet collapse" class="" id="plan3">
                                                                <li>$110.00 / Per 60 Days</li>
                                                                <li> $140.00 / Per 90 Days</li>
                                                                <li> $990.00 / Unlimited</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label></td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#edit"
                                                                    title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
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
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="packages-data">
                                                            <div class="h6">Silver Plan
                                                                <i class="" type="button" data-toggle="collapse"
                                                                    data-target="#plan4" aria-expanded="false"
                                                                    aria-controls="plan4">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                        </use>
                                                                    </svg>

                                                                </i>






                                                            </div>
                                                            <ul class="list-bullet collapse" class="" id="plan4">
                                                                <li>$110.00 / Per 60 Days</li>
                                                                <li> $140.00 / Per 90 Days</li>
                                                                <li> $990.00 / Unlimited</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label></td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#edit"
                                                                    title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
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
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="packages-data">
                                                            <div class="h6">Silver Plan
                                                                <i class="" type="button" data-toggle="collapse"
                                                                    data-target="#plan5" aria-expanded="false"
                                                                    aria-controls="plan5">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#expand">
                                                                        </use>
                                                                    </svg>

                                                                </i>






                                                            </div>
                                                            <ul class="list-bullet collapse" class="" id="plan5">
                                                                <li>$110.00 / Per 60 Days</li>
                                                                <li> $140.00 / Per 90 Days</li>
                                                                <li> $990.00 / Unlimited</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label></td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#edit"
                                                                    title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
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
                                                    </td>

                                                </tr>
                                            </tbody>

                                        </table>






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