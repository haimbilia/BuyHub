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
                                <div class="card card-tabs">
                                    <div class="card-head">
                                        <nav class="nav nav-tabs">
                                            <a class="nav-link active" href="#">All</a>
                                            <a class="nav-link" href="#">Ship</a>
                                            <a class="nav-link" href="#">Pickup</a>
                                            <a class="nav-link" href="#">Unpaid</a>
                                            <a class="nav-link" href="#">Return</a>
                                            <a class="nav-link" href="#">Cancellation</a>
                                            <a class="nav-link" href="#">Completed</a>
                                        </nav>

                                    </div>
                                    <div class="card-body">
                                        <form class="form my-4" action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="input-group-append"> <input type="search"
                                                            placeholder="Search orders, tags, customers, products">

                                                        <button type="button" data-toggle="dropdown"
                                                            class="btn btn-brand dropdown-toggle"
                                                            aria-expanded="false">Filters</button>
                                                        <div class="dropdown-menu">

                                                            <ul class="">
                                                                <li class="dropdown-item nav__item">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" value="1">
                                                                        Pending
                                                                        <span></span></label>
                                                                </li>
                                                                <li class="dropdown-item nav__item"><label
                                                                        class="checkbox"><input type="checkbox"
                                                                            value="2">
                                                                        Paid
                                                                        <span></span></label></li>
                                                                <li class="dropdown-item nav__item"><label
                                                                        class="checkbox"><input type="checkbox"
                                                                            value="cod">
                                                                        Cash
                                                                        <span></span></label></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-orders">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Sr no.
                                                        </th>
                                                        <th class="sorting"> <span>Order ID. <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i></span></th>
                                                        <th class="sorting">
                                                            <span>Customer <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i></span>
                                                        </th>
                                                        <th class="sorting">
                                                            <span>Purchased <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i></span>
                                                        </th>
                                                        <th class="sorting"> <span>Order date & time <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i> </span></th>
                                                        <th class="sorting"> <span>Amount <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i></span></th>



                                                        <th class="sorting"> <span>Payment Status <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i></span></th>

                                                        <th class="align-right">Action</th>
                                                    </tr>

                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>01</td>
                                                        <td><a href="">00055886982</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Michael
                                                                        Williams </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased"> Cadbury fruit and nut <span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>02</td>
                                                        <td><a href="">000558854982</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Jason Smith</span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Rainbow Flatware </span></td>
                                                        <td> <span class="date"> 23/10/2022 <time>11:45</time></span>
                                                        </td>
                                                        <td>$70.00</td>
                                                        <td> <span class="badge badge-danger">Pending</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>58</td>
                                                        <td><a href="">00055699982</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Sachin Tendulkar </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Smart Personal Air Cooler<span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 01/05/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>25</td>
                                                        <td><a href="">000525686982</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Robinson </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Reusable Straws </span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$2140.00</td>
                                                        <td> <span class="badge badge-danger">Pending</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>01</td>
                                                        <td><a href="">003546486982</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Jackie </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Wooden Alarm Clock <span
                                                                    class="text-muted fw-bold">+ 8
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/02/2018 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>56</td>
                                                        <td><a href="">00055886987</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_6.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Sourabh Rana </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased"> Cadbury fruit and nut <span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$8690.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>01</td>
                                                        <td><a href="">00055886258</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Michael
                                                                        Williams </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased"> Cadbury fruit and nut <span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>02</td>
                                                        <td><a href="">000558854369</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Jason Smith</span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Rainbow Flatware </span></td>
                                                        <td> <span class="date"> 23/10/2022 <time>11:45</time></span>
                                                        </td>
                                                        <td>$70.00</td>
                                                        <td> <span class="badge badge-danger">Pending</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>58</td>
                                                        <td><a href="">00055699147</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Sachin Tendulkar </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Smart Personal Air Cooler<span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 01/05/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>25</td>
                                                        <td><a href="">000525686369</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Robinson </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Reusable Straws </span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$2140.00</td>
                                                        <td> <span class="badge badge-danger">Pending</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>01</td>
                                                        <td><a href="">003546486954</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Jackie </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased">Wooden Alarm Clock <span
                                                                    class="text-muted fw-bold">+ 8
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/02/2018 <time>15:45</time></span>
                                                        </td>
                                                        <td>$90.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>56</td>
                                                        <td><a href="">00055886935</a> </td>
                                                        <td>
                                                            <a href="" class="user-profile user-profile-sm">
                                                                <figure class="user-profile_photo">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_6.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <span class="text-muted fw-bold">
                                                                        Sourabh Rana </span>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td> <span class="purchased"> Cadbury fruit and nut <span
                                                                    class="text-muted fw-bold">+ 2
                                                                    more</span></span></td>
                                                        <td> <span class="date"> 13/10/2021 <time>15:45</time></span>
                                                        </td>
                                                        <td>$8690.00</td>
                                                        <td> <span class="badge badge-success">Paid</span> </td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
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

                            <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog"
                                aria-labelledby="edit" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-vertical" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Card title goes here</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="modal-body form form-edit">
                                            <div class="form-edit-head">
                                                <nav class="nav nav-tabs">
                                                    <a class="nav-link active" href="#">Active</a>
                                                    <a class="nav-link" href="#">Longer nav link</a>
                                                    <a class="nav-link" href="#">Link</a>
                                                    <a class="nav-link disabled" href="#">Disabled</a>
                                                </nav>

                                            </div>
                                            <div class="form-edit-body">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label required">Language </label>
                                                            <select onchange="addShopLangForm(5, this.value);"
                                                                data-field-caption="Language"
                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                name="lang_id">
                                                                <option value="1" selected="selected">English
                                                                </option>
                                                                <option value="2">Arabic</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">
                                                                <span class="required">Shop Name</span>
                                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-toggle="tooltip" title=""
                                                                    data-original-title="Specify a target priorty"
                                                                    aria-label="Specify a target priorty"
                                                                    aria-describedby="tooltip849482"></i>
                                                            </label>
                                                            <input data-field-caption="Shop Name"
                                                                data-fatreq="{&quot;required&quot;:true}" type="text"
                                                                name="shop_name" value="Jason's Store">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Shop City</label>

                                                            <input data-field-caption="Shop City"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_city" value="phoenix">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Contact Person</label>
                                                            <input data-field-caption="Contact Person"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_contact_person" value="Jason">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Description</label>

                                                            <textarea data-field-caption="Description"
                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                name="shop_description">Best range of products in the United States</textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-edit-foot">
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="reset"
                                                            class="btn btn-outline-brand">Cancel</button>
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


            </div>

        </div>

    </body>

</html>