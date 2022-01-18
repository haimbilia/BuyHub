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
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="wrap">
            <?php
            include 'includes/new-header.php';
            ?>

            <button class="help-btn btn btn-light" data-bs-toggle="modal" data-bs-target="#help">
                <span class="help_label">Help</span>
            </button>

            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
                <div class="modal-dialog modal-dialog-vertical" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="help-window">
                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">

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
                                        <h3 class="card-head-title">Collections Managements</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <ul class="actions">
                                            <li> <a href="#" class="btn btn-icon btn-light btn-add">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                        </use>
                                                    </svg>
                                                    <span>New</span>
                                                </a></li>
                                            <li>
                                                <a class="" href="#" title="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#active">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="" href="#" title="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#in-active">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- <div class="table-processing">
                                                <div class="spinner spinner--sm spinner--brand"></div>
                                            </div> -->
                                        <table width="100%" class="table">
                                            <thead>
                                                <tr>
                                                    <th class="">
                                                    </th>
                                                    <th class="">
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </th>

                                                    <th class="sorting"> <span> Collection Name
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-down">
                                                                    </use>
                                                                </svg>
                                                            </i></span>

                                                    </th>
                                                    <th class="sorting" width="30%"> <span> Type
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-down">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="sorting"> <span>Layout type <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i> </span></th>




                                                    <th class="sorting"> <span>Status <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>

                                                    <th class="align-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Categories
                                                    </td>
                                                    <td>
                                                        Product Categories
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            CL2

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td> Featured Products</td>
                                                    <td>
                                                        Product
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL2
                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="dragHandle">

                                                        <i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#drag">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                    </td>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>Top Products</td>
                                                    <td>
                                                        Products
                                                    </td>
                                                    <td>
                                                        <div class="icn-lt">
                                                            PL1

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <span class="switch switch-sm switch-icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
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
                                <div class="card-foot">
                                    <div class="row justify-content-between">
                                        <div class="col">
                                            <div class="data-length">
                                                <select name="" class="form-select data-length-select">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <div class="data-length-info"></div> Showing 1 to 10 of 29 records
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <ul class="pagination">
                                                <li class="prev">
                                                    <a href="javascript:void(0);"> </a>
                                                </li>
                                                <li><a href="javascript:void(0);">1</a></li>
                                                <li class="selected"><a href="javascript:void(0);">2</a></li>
                                                <li><a href="javascript:void(0);">...</a></li>
                                                <li class="next"><a href="javascript:void(0);"> </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-vertical" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                                        </button>
                                    </div>
                                    <form class="modal-body form form-edit">

                                        <div class="form-edit-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required">Layout </label>
                                                        <div>
                                                            <select class="selectpicker">
                                                                <option>
                                                                    PL 1</option>
                                                                <option>CL2</option>
                                                                <option>PL2</option>
                                                            </select>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">
                                                            <span class="required">Shop Name</span>
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-original-title="Specify a target priorty" aria-label="Specify a target priorty" aria-describedby="tooltip849482"></i>
                                                        </label>
                                                        <input data-field-caption="Shop Name" type="text" name="shop_name" value="Jason's Store">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Shop City</label>

                                                        <input data-field-caption="Shop City" type="text" name="shop_city" value="phoenix">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Contact Person</label>
                                                        <input data-field-caption="Contact Person" type="text" name="shop_contact_person" value="Jason">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Description</label>

                                                        <textarea data-field-caption="Description" name="shop_description">Best range of products in the United States</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-edit-foot">
                                            <div class="row">
                                                <div class="col">
                                                    <button type="reset" class="btn btn-outline-brand">Cancel</button>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-brand  ">Update</button>
                                                </div>
                                            </div>
                                        </div>


                                    </form>


                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            </main>

            <?php
            include 'includes/footer.php';
            ?>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js">
            </script>
            <script>
                $(document).ready(function() {
                    $('.selectpicker').selectpicker();
                });
            </script>


        </div>

    </div>

</body>

</html>