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
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

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
                        <div class="col-lg-8">
                            <div class="card admin-welcome">
                                <div class="card-body p-0">
                                    <div class="bg-welcome" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>/images/ecommerce-bg.png);background-size:230px; ">
                                        <div class="welcome-text">
                                            <h3 class="text-primary mb-1">Good Afternoon, Michael Williams!</h3>
                                            <span class="text-muted">Here’s what happening with your store today </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <ul class="list-stats list-stats-double">
                                                    <li class="list-stats-item">
                                                        <span class="label">Today's visit</span>
                                                        <span class="value">
                                                            <i class="icn fas fa-arrow-up font-success"></i>
                                                            14,209</span>
                                                    </li>
                                                    <li class="list-stats-item">
                                                        <span class="label">Today’s total sales

                                                        </span>
                                                        <span class="value">
                                                            <i class="icn fas fa-arrow-down font-danger"></i>
                                                            $21,349.29
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <ul class="welcome-list">
                                        <li class="welcome-list-item bg-warning">
                                            <div class="row justify-content-between">
                                                <div class="col">

                                                    <strong>5 products</strong> didn’t publish to your Facebook page

                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <a class="link" href="#!">View products </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="welcome-list-item">
                                            <div class="row justify-content-between">
                                                <div class="col">

                                                    <strong>7 orders</strong> have payments that need to be captured

                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <a class="link" href="#!">View payments</a>
                                                </div>
                                        </li>
                                        <li class="welcome-list-item">
                                            <div class="row justify-content-between">
                                                <div class="col">

                                                    <strong>50+ orders</strong> need to be fulfilled

                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <a class="link" href="#!">View orders</a>
                                                </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card card-tabs">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Statistics</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#statistics-1" role="tab">
                                                    Sales
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#statistics-2" role="tab">
                                                    Sales Earnings
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#statistics-3" role="tab">
                                                    Buyer/seller Signups
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#statistics-4" role="tab">
                                                    Affiliate Signups
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#statistics-5" role="tab">
                                                    Products
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="statistics-1">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-2">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-3">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-4">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-5">
                                            <div class="statistics js-statistics"> </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card card-flush">
                                        <div class="card-head">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">Shopping Cart </h3>
                                            </div>
                                            <div class="card-head--action">
                                                <div class="dropdown dropdown-inline">
                                                    <button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="flaticon-more-1"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-anim ">
                                                        <a class="dropdown-item" href="#"> View</a>
                                                        <a class="dropdown-item" href="#"> Export</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#"> Remove</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body py-0 d-flex h-100">
                                            <div class="flex-fill">
                                                <div class="row g-0 align-iteml-center pb-3">
                                                    <div class="col pe-4">
                                                        <h6 class="fs--2 text-600">Initiated</h6>
                                                        <div class="progress" style="height:5px">
                                                            <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: 50% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right">
                                                        <p class="mb-0 text-900 font-sans-serif"> <span class="mr-1 fas fa-caret-up text-success"></span> 43.6%</p>
                                                        <p class="mb-0 fs--2 text-500 fw-semi-bold"> Session: <span class="text-600">6817</span> </p>
                                                    </div>
                                                </div>
                                                <div class="row g-0 align-iteml-center pb-3 border-top pt-3">
                                                    <div class="col pe-4">
                                                        <h6 class="fs--2 text-600">Abandonment rate</h6>
                                                        <div class="progress" style="height:5px">
                                                            <div class="progress-bar rounded-3 bg-danger" role="progressbar" style="width: 25% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right">
                                                        <p class="mb-0 text-900 font-sans-serif"> <span class="mr-1 fas fa-caret-up text-danger"></span> 13.11%</p>
                                                        <p class="mb-0 fs--2 text-500 fw-semi-bold"><span class="text-600">44</span> of 61</p>
                                                    </div>
                                                </div>
                                                <div class="row g-0 align-iteml-center pb-3 border-top pt-3">
                                                    <div class="col pe-4">
                                                        <h6 class="fs--2 text-600">Bounce rate</h6>
                                                        <div class="progress" style="height:5px">
                                                            <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: 35% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right">
                                                        <p class="mb-0 text-900 font-sans-serif"> <span class="mr-1 fas fa-caret-up text-success"></span> 12.11%</p>
                                                        <p class="mb-0 fs--2 text-500 fw-semi-bold"><span class="text-600">8</span> of 61</p>
                                                    </div>
                                                </div>
                                                <div class="row g-0 align-iteml-center pb-3 border-top pt-3">
                                                    <div class="col pe-4">
                                                        <h6 class="fs--2 text-600">Completion rate</h6>
                                                        <div class="progress" style="height:5px">
                                                            <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: 43% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right">
                                                        <p class="mb-0 text-900 font-sans-serif"> <span class="mr-1 fas fa-caret-down text-danger"></span> 43.6%</p>
                                                        <p class="mb-0 fs--2 text-500 fw-semi-bold"><span class="text-600">18</span> of 179</p>
                                                    </div>
                                                </div>
                                                <div class="row g-0 align-iteml-center pb-3 border-top pt-3">
                                                    <div class="col pe-4">
                                                        <h6 class="fs--2 text-600">Revenue Rate</h6>
                                                        <div class="progress" style="height:5px">
                                                            <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: 60% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right">
                                                        <p class="mb-0 text-900 font-sans-serif"> <span class="mr-1 fas fa-caret-up text-success"></span>60.5%</p>
                                                        <p class="mb-0 fs--2 text-500 fw-semi-bold"> <span class="text-600">18</span> of 179</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-head">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">Conversions Statistics</h3>
                                                <span class="text-muted">Recent conversions statistics</span>
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <ul class="list-stats list-stats-double">

                                                <li class="list-stats-item">
                                                    <span class="label">Added to cart</span>
                                                    <span class="value">
                                                        <i class="icn fas fa-arrow-up font-success"></i>
                                                        100%</span>
                                                </li>
                                                <li class="list-stats-item">
                                                    <span class="label">Reached checkout</span>
                                                    <span class="value">
                                                        <i class="icn fas fa-arrow-down font-danger"></i>
                                                        -66.67% </span>
                                                </li>
                                                <li class="list-stats-item">
                                                    <span class="label">Purchased</span>
                                                    <span class="value">
                                                        <i class="icn fas fa-arrow-up font-success"></i>
                                                        33.33%</span>

                                                </li>
                                                <li class="list-stats-item">
                                                    <span class="label">Cancelled</span>
                                                    <span class="value">
                                                        <i class="icn fas fa-arrow-up font-success"></i>
                                                        12.5%</span>

                                                </li>
                                            </ul>
                                            <div class="widget__chart">
                                                <div class="conversions-statistics js-conversions-statistics">
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Top Orders</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <ul class="actions">
                                            <li>
                                                <a class="btn btn-icon btn-link" href="#">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#export">
                                                        </use>
                                                    </svg>
                                                    <span class="txt">Export</span>
                                                </a>
                                            </li>


                                        </ul>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table width="100%" class="table">
                                            <thead>
                                                <tr>
                                                    <th> Order Id </th>
                                                    <th> Full Name </th>
                                                    <th> Order Date </th>
                                                    <th> Amount </th>
                                                    <th> Status </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                    <td>
                                                        <div class="order-num">
                                                            <a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <figure class="user-profile_photo">
                                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg" alt="image">
                                                            </figure>
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Michael Williams</a>
                                                                <span class="text-muted">login@dummyid.com</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="date"> 17/08/2021
                                                            <time>15:45</time>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="amount">$4,250.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success">Approved</span>
                                                    </td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        <div class="order-num">
                                                            <a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791584</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <figure class="user-profile_photo">
                                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_2.jpg" alt="image">
                                                            </figure>
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Maureen Biologist</a>
                                                                <span class="text-muted">login@dummyid.com</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="date"> 17/08/2021
                                                            <time>15:45</time>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="amount">$250.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success">Approved</span>
                                                    </td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        <div class="order-num">
                                                            <a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <figure class="user-profile_photo">
                                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_3.jpg" alt="image">
                                                            </figure>
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Aida Bugg</a>
                                                                <span class="text-muted">login@dummyid.com</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="date"> 17/08/2021
                                                            <time>15:45</time>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="amount">$25,00.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    </td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        <div class="order-num">
                                                            <a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <figure class="user-profile_photo">
                                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" alt="image">
                                                            </figure>
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Olive Yew
                                                                </a>
                                                                <span class="text-muted">login@dummyid.com</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="date"> 17/08/2021
                                                            <time>15:45</time>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="amount">$589.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-warning">In Progress</span>
                                                    </td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        <div class="order-num">
                                                            <a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <figure class="user-profile_photo">
                                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_5.jpg" alt="image">
                                                            </figure>
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Patty O'Furniture.
                                                                </a>
                                                                <span class="text-muted">login@dummyid.com</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="date"> 17/08/2021
                                                            <time>15:45</time>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="amount">$400.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    </td>


                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Top selling products </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <ul class="actions">
                                            <li>
                                                <a class="btn btn-icon btn-link" href="#">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#export">
                                                        </use>
                                                    </svg>
                                                    <span class="txt">Export</span>
                                                </a>
                                            </li>


                                        </ul>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-scrollable js-scrollable">
                                        <table width="100%" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Images </th>
                                                    <th width="60%">Full Name </th>
                                                    <th>Stock </th>
                                                    <th>User </th>
                                                    <th class="text-right">Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">
                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge badge-info">Rejected</span>
                                                    </td>
                                                </tr>




                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                            </div>

                            <div class=" ">
                                <table class="table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Best Selling Products</th>
                                            <th>Orders(269)</th>
                                            <th>Order(%)</th>
                                            <th>Revenue</th>
                                            <th class="text-right">Revenue (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product1.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>


                                            </td>
                                            <td>26</td>
                                            <td>31%</td>
                                            <td>$1311</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 41%;" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">41%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product2.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>18</td>
                                            <td>29%</td>
                                            <td>$1311</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 41%;" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">41%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product3.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>16</td>
                                            <td>27%</td>
                                            <td>$539</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 27%;" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">27%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product4.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>11</td>
                                            <td>21%</td>
                                            <td>$245</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 17%;" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">17%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product5.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>10</td>
                                            <td>19%</td>
                                            <td>$234</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 7%;" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">7%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product6.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>10</td>
                                            <td>19%</td>
                                            <td>$234</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 7%;" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">7%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-profile product-profile-sm">
                                                    <div class="product-profile__thumbnail" data-ratio="1:1">
                                                        <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>/images/products/product7.jpg">
                                                    </div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Apple iPhone 12</div>
                                                        <div class="categories">Phone</div>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>10</td>
                                            <td>19%</td>
                                            <td>$234</td>
                                            <td class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress mr-3 rounded-3 bg-200" style="height: 5px;width:80px">
                                                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 7%;" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fw-semi-bold ml-2">7%</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="card h-lg-100 overflow-hidden">
                                <div class="card-body">

                                </div>
                                <div class="card-foot">
                                    <div class="row justify-content-between">
                                        <div class="col-auto"><select class="form-select form-select-sm">
                                                <option>Last 7 days</option>
                                                <option>Last Month</option>
                                                <option>Last Year</option>
                                            </select></div>
                                        <div class="col-auto"><a class="btn btn-outline-brand btn-sm" href="#!">View All</a></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-flush commerce-card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h6 class="h6"> Order Sales <i class="far fa-question-circle" data-bs-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="h3">$442.88</h3>
                                            <span class="badge badge-success font-bold">+3.5%</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="commerce-card-graph">
                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/graph-order-sales.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card card-flush commerce-card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h6 class="h6">Sales Earnings </h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="h3">$885.88</h3>
                                            <span class="badge badge-success font-bold">+2.5%</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="commerce-card-graph">
                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/graph-sales-earnings.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card card-flush commerce-card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h6 class="h6">New Users</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="h3">$885.88</h3>
                                            <span class="badge badge-success font-bold">+2.5%</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="commerce-card-graph">
                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/graph-sales-earnings.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card card-flush commerce-card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h6 class="h6">Total Orders</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="h3">$885.88</h3>
                                            <span class="badge badge-success font-bold">+2.5%</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="commerce-card-graph">
                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/graph-sales-earnings.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Total Sales </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <select class="form-select form-select-sm">
                                            <option value="week" selected="selected">Last 7 days</option>
                                            <option value="month">Last month</option>
                                            <option value="year">Last Year</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="card-body">

                                    <div class="js-total-sale"></div>
                                    <ul class="list-stats list-stats-inline">

                                        <li class="list-stats-item">
                                            <span class="label">
                                                <i class="dot" style="background-color:#d70206;"></i>
                                                Direct</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                36%</span>
                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label">
                                                <i class="dot" style="background-color: #f05b4f;"></i>
                                                Affilliate</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-down font-danger"></i>
                                                29%
                                            </span>
                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label"> <i class="dot" style="background-color:#f4c63d;"></i>Sponsored</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                29%</span>

                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label"> <i class="dot" style="background-color:#d17905;"></i>
                                                E-mail</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                14%
                                            </span>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Users By Country </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <select class="form-select form-select-sm">
                                            <option value="week" selected="selected">Last 7 days</option>
                                            <option value="month">Last month</option>
                                            <option value="year">Last Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="vmap" style="height: 224px;"></div>
                                    <ul class="list-stats list-stats-double">

                                        <li class="list-stats-item">
                                            <span class="label">United States</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                100%</span>
                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label">Iran </span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-down font-danger"></i>
                                                -66.67% </span>
                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label">India</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                33.33%</span>

                                        </li>
                                        <li class="list-stats-item">
                                            <span class="label">Malaysia</span>
                                            <span class="value">
                                                <i class="icn fas fa-arrow-up font-success"></i>
                                                12.5%</span>

                                        </li>
                                    </ul>

                                </div>

                            </div>


                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-iteml-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-iteml-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Sales <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div class="sales js-sales">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
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
        <script src="<?php echo JS_PATH; ?>vendors/chartist.min.js"></script>
        <script src="<?php echo JS_PATH; ?>vendors/jquery.vmap.js"></script>
        <script src="<?php echo JS_PATH; ?>vendors/jquery.vmap.world.js"></script>
        <script src="<?php echo JS_PATH; ?>vendors/jquery.vmap.sampledata.js"></script>



        <script>
            jQuery(document).ready(function() {
                jQuery('#vmap').vectorMap({
                    map: 'world_en',
                    backgroundColor: '#fff',
                    color: '#0073CF',
                    hoverOpacity: 0.7,
                    selectedColor: '#0073CF',
                    enableZoom: true,
                    showTooltip: true,
                    values: sample_data,
                    normalizeFunction: 'polynomial'
                });
            });

            //







            //


            new Chartist.Line('.js-statistics', {
                labels: [1, 2, 3, 4, 5, 6, 7, 8],
                series: [
                    [1, 2, 3, 1, -2, 0, 1, 0],
                    [-2, -1, -2, -1, -2.5, -1, -2, -1],
                    [0, 0, 0, 1, 2, 2.5, 2, 1],
                    [2.5, 2, 1, 0.5, 1, 0.5, -1, -2.5]
                ]
            }, {
                high: 3,
                low: -3,
                showArea: true,
                showLine: false,
                showPoint: false,
                fullWidth: true,
                axisX: {
                    showLabel: false,
                    showGrid: false
                }
            });

            new Chartist.Line('.js-sales', {
                labels: [1, 2, 3, 4, 5, 6, 7, 8],
                series: [
                    [5, 9, 7, 8, 5, 3, 5, 4]
                ]
            }, {
                low: 0,
                showArea: true
            });

            //
            var chart = new Chartist.Line('.js-conversions-statistics', {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                series: [
                    [1, 5, 2, 5, 4, 3],
                    [2, 3, 4, 8, 1, 2],
                    [5, 4, 3, 2, 1, 0.5]
                ]
            }, {
                low: 0,
                showArea: true,
                showPoint: false,
                fullWidth: true
            });

            chart.on('draw', function(data) {
                if (data.type === 'line' || data.type === 'area') {
                    data.element.animate({
                        d: {
                            begin: 2000 * data.index,
                            dur: 2000,
                            from: data.path.clone().scale(1, 0).translate(0, data.chartRect
                                    .height())
                                .stringify(),
                            to: data.path.clone().stringify(),
                            easing: Chartist.Svg.Easing.easeOutQuint
                        }
                    });
                }
            });

            var data = {
                series: [5, 3, 4, 2]
            };

            var sum = function(a, b) {
                return a + b
            };

            new Chartist.Pie('.js-total-sale', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                }
            });
        </script>
    </div>


</body>

</html>