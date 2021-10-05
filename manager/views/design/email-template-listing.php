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
            <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                <span class="help_label">Help</span>
            </button>

            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
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
                            <form class="form" action="#">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="search" class="form-control" name="search" value="" placeholder="Search">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-brand btn-block">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <div class="card-head">
                                    <h3 class="card-head-label">
                                        <span class="card-head-title">Email Templates </span>
                                    </h3>
                                    <div class="card-toolbar">

                                        <ul class="actions">
                                            <li> <a href="#" class="btn btn-icon btn-light btn-add">
                                                    <i class="icn">
                                                        <svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                            </use>
                                                        </svg></i>
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
                                        <table width="100%" class="table table-dashed">
                                            <thead>
                                                <tr>
                                                    <th class="">
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </th>
                                                    <th class="sorting">#</th>

                                                    <th class="sorting"> <span> Name <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-down">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="sorting"> <span> Status <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="align-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>1</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>2</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>3</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>4</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>5</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>6</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>7</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>8</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>9</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>
                                                    </td>
                                                    <td>10</td>
                                                    <td>
                                                        Abandoned Cart Deleted Discount Notification
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
                                                                <a href="#" data-toggle="modal" data-target="#edit" title="Edit">

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
                                        <h5 class="modal-title" id="">Abandoned Cart Deleted Discount Notification </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="modal-body form form-edit">
                                        <div class="form-edit-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required">Template Name </label>
                                                        <input data-field-caption="template Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="template_name" value="Abandoned Cart Deleted Discount Notification">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">
                                                            <span class="required">Email Subject</span>
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-toggle="tooltip" title="" data-original-title="Specify a target priorty" aria-label="Specify a target priorty" aria-describedby="tooltip849482"></i>
                                                        </label>
                                                        <input data-field-caption="email subject " data-fatreq="{&quot;required&quot;:true}" type="text" name="subject_name" value="Verification link for changing your email on {websiteName}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Email body</label>
                                                        <div class="iframe-container">
                                                            <iframe border="0" height="100%" width="100%" src="quill-chat.php"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Replacement Variables</label>
                                                        <ul class="click-to-copy">
                                                            <li title="Click to copy" data-val="{name}">
                                                                <div class="text">Admin Name</div>
                                                            </li>
                                                            <li title="Click to copy" data-val="{email}">
                                                                <div class="text">New Email</div>
                                                            </li>
                                                            <li title="Click to copy" data-val="{resetlink}">
                                                                <div class="text">Verification Link</div>
                                                            </li>
                                                            <li title="Click to copy" data-val="{websiteName}">
                                                                <div class="text">Website Name</div>
                                                            </li>
                                                            <li title="Click to copy" data-val="{contactUsEmail}">
                                                                <div class="text">Contactus Email</div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-edit-foot">
                                            <div class="row">
                                                <div class="col"><button type="reset" class="btn btn-outline-brand">Cancel</button>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
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
        </div>
    </div>
</body>
</html>