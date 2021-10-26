<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.css" rel="stylesheet" type="text/css" />
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
                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg"
                                                alt="">
                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...
                                                </h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.
                                                    </li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.
                                                    </li>
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
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                <a class="back" href="">
                                                    <svg class="svg" width="24" height="24">
                                                        <use
                                                            xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#back">
                                                        </use>
                                                    </svg>
                                                </a>
                                                Plugins
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="settings-inner">
                                            <ul>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Currency Converter</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Social Login</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Push Notification</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item is-active">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Payout</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title"> Advertisement Feed</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Sms Notification</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Sales Tax Services</h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title"> Split Payment Methods
                                                            </h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title">Regular Payment Methods
                                                            </h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title"> Markeplace Channels
                                                            </h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title"> Shipping Services
                                                            </h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                                consectetur adipisicing
                                                                elit. Suscipit est quos </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item">
                                                    <a class="settings-inner-link" href="">
                                                        <i class="settings-inner-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="settings-inner-title"> Shipment Tracking
                                                            </h6>
                                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
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
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <form class="form form-section" action="">
                                                    <h3 class="form-section-head">COD Payments </h3>
                                                    <div class="form-section-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="label">
                                                                        <span class="required"> COD Order Total
                                                                        </span>
                                                                        <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                            data-toggle="tooltip" title=""
                                                                            data-original-title="This Is The
                                                                         Cash On Delivery Order
                                                                        Total, Eligible For COD Payments." aria-label="This Is The
                                                                         Cash On Delivery Order
                                                                        Total, Eligible For COD Payments.">
                                                                        </i>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                class="input-group-text">$</span></div>
                                                                        <input type="text" class="form-control">
                                                                    </div>



                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="label"> Maximum COD Order Total
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                class="input-group-text">$</span></div>
                                                                        <input type="text" class="form-control">
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="label required">Wallet
                                                                        Balance

                                                                    </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                class="input-group-text">$</span></div>
                                                                        <input type="text" class="form-control">
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>

                                                    <h3 class="form-section-head">Pickup</h3>
                                                    <div class="form-section-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="label">Display Time Slots After
                                                                    Order </label>
                                                                <div class="">
                                                                    <input type="text" value="2">
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <h3 class="form-section-head">Checkout Process</h3>
                                                    <div class="form-section-body">
                                                        <div class="row form-group">
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Activate
                                                                            Live
                                                                            Payment
                                                                            Transaction
                                                                            Mode</span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Use Manual Shipping Rates. Instead
                                                                            Of Third Party.</span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>
                                                            </div>


                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Shipped By Admin Only
                                                                        </span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Tax After Discounts </span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>
                                                            </div>


                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Tax Collected By Seller</span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <label class="setting-widget">
                                                                    <div class="setting-widget-data">
                                                                        <span class="setting-widget-tittle">
                                                                            Return Shipping Charges To
                                                                            Customer</span>
                                                                        <span class="form-text text-muted">
                                                                            Lorem ipsum,
                                                                            dolor sit amet consectetur adipisicing
                                                                            elit.
                                                                        </span>
                                                                    </div>
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <input type="checkbox" name="" checked>
                                                                        <span></span>
                                                                    </span>
                                                                </label>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h3 class="form-section-head">Section heading goes here</h3>
                                                    <div class="form-section-body">
                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <label class="label"> Default Child Order Status</label>
                                                                <div class="">
                                                                    <select
                                                                        data-field-caption="Default Child Order Status"
                                                                        data-fatreq="{&quot;required&quot;:false}"
                                                                        name="CONF_DEFAULT_ORDER_STATUS">
                                                                        <option value="1" selected="selected">Payment
                                                                            Pending</option>
                                                                        <option value="16">cash on delivery</option>
                                                                        <option value="17">Pay At Store</option>
                                                                        <option value="2">Payment Confirmed</option>
                                                                        <option value="15">Approved</option>
                                                                        <option value="3">In Process</option>
                                                                        <option value="4">Shipped</option>
                                                                        <option value="18">Ready For Pickup</option>
                                                                        <option value="5">Delivered</option>
                                                                        <option value="6">Return Requested</option>
                                                                        <option value="7">Completed</option>
                                                                        <option value="8">Cancelled</option>
                                                                        <option value="9">Refunded/Completed</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="label">Default Paid Order Status</label>
                                                                <div>

                                                                    <select
                                                                        data-field-caption="Default Paid Order Status"
                                                                        data-fatreq="{&quot;required&quot;:false}"
                                                                        name="CONF_DEFAULT_PAID_ORDER_STATUS">
                                                                        <option value="1">Payment Pending
                                                                        </option>
                                                                        <option value="16">cash on delivery
                                                                        </option>
                                                                        <option value="17">Pay At Store</option>
                                                                        <option value="2" selected="selected">
                                                                            Payment Confirmed</option>
                                                                        <option value="15">Approved</option>
                                                                        <option value="3">In Process</option>
                                                                        <option value="4">Shipped</option>
                                                                        <option value="18">Ready For Pickup
                                                                        </option>
                                                                        <option value="5">Delivered</option>
                                                                        <option value="6">Return Requested
                                                                        </option>
                                                                        <option value="7">Completed</option>
                                                                        <option value="8">Cancelled</option>
                                                                        <option value="9">Refunded/Completed
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <label class="label">Default Approved
                                                                    Order
                                                                    Status</label>
                                                                <div>
                                                                    <select
                                                                        data-field-caption="Default Approved Order Status"
                                                                        data-fatreq="{&quot;required&quot;:false}"
                                                                        name="CONF_DEFAULT_APPROVED_ORDER_STATUS">
                                                                        <option value="1">Payment Pending
                                                                        </option>
                                                                        <option value="16">cash on delivery
                                                                        </option>
                                                                        <option value="17">Pay At Store</option>
                                                                        <option value="2">Payment Confirmed
                                                                        </option>
                                                                        <option value="15" selected="selected">
                                                                            Approved</option>
                                                                        <option value="3">In Process</option>
                                                                        <option value="4">Shipped</option>
                                                                        <option value="18">Ready For Pickup
                                                                        </option>
                                                                        <option value="5">Delivered</option>
                                                                        <option value="6">Return Requested
                                                                        </option>
                                                                        <option value="7">Completed</option>
                                                                        <option value="8">Cancelled</option>
                                                                        <option value="9">Refunded/Completed
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="label">Status Used By
                                                                    System To Mark Order As
                                                                    Completed</label>
                                                                <div>
                                                                    <select
                                                                        data-field-caption="Status Used By System To Mark Order As Completed"
                                                                        data-fatreq="{&quot;required&quot;:false}"
                                                                        name="CONF_DEFAULT_COMPLETED_ORDER_STATUS">
                                                                        <option value="1" selected="selected">Payment
                                                                            Pending</option>
                                                                        <option value="16">cash on delivery
                                                                        </option>
                                                                        <option value="17">Pay At Store
                                                                        </option>
                                                                        <option value="2">Payment Confirmed
                                                                        </option>
                                                                        <option value="15">Approved</option>
                                                                        <option value="3">In Process
                                                                        </option>
                                                                        <option value="4">Shipped</option>
                                                                        <option value="18">Ready For Pickup
                                                                        </option>
                                                                        <option value="5">Delivered</option>
                                                                        <option value="6">Return Requested
                                                                        </option>
                                                                        <option value="7">Completed</option>
                                                                        <option value="8">Cancelled</option>
                                                                        <option value="9">Refunded/Completed
                                                                        </option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Default Delivered Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Default Delivered Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_DEFAULT_DEIVERED_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5" selected="selected">
                                                                                    Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Default Cancelled Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Default Cancelled Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_DEFAULT_CANCEL_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8" selected="selected">
                                                                                    Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Return Requested Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Return Requested Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_RETURN_REQUEST_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6" selected="selected">
                                                                                    Return Requested</option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Return Request Withdrawn
                                                                            Order Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Return Request Withdrawn Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_RETURN_REQUEST_WITHDRAWN_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7" selected="selected">
                                                                                    Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Return Request Approved
                                                                            Order Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Return Request Approved Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9" selected="selected">
                                                                                    Refunded/Completed</option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label class="label">Pay
                                                                            At Store Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Pay At Store Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_PAY_AT_STORE_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17" selected="selected">
                                                                                    Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Cash On Delivery Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Cash On Delivery Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_COD_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16" selected="selected">
                                                                                    cash on delivery</option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select><small>Set The Cash On Delivery
                                                                                Order Status.</small></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Ready For Pickup Order
                                                                            Status</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Ready For Pickup Order Status"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_PICKUP_READY_ORDER_STATUS">
                                                                                <option value="1">Payment Pending
                                                                                </option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18" selected="selected">
                                                                                    Ready For Pickup</option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select><small>Set The Ready For Pickup
                                                                                Order Status.</small></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Status Used By System To
                                                                            Mark Order As Completed</label></div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><select
                                                                                data-field-caption="Status Used By System To Mark Order As Completed"
                                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                                name="CONF_DEFAULT_COMPLETED_ORDER_STATUS">
                                                                                <option value="1" selected="selected">
                                                                                    Payment Pending</option>
                                                                                <option value="16">cash on delivery
                                                                                </option>
                                                                                <option value="17">Pay At Store</option>
                                                                                <option value="2">Payment Confirmed
                                                                                </option>
                                                                                <option value="15">Approved</option>
                                                                                <option value="3">In Process</option>
                                                                                <option value="4">Shipped</option>
                                                                                <option value="18">Ready For Pickup
                                                                                </option>
                                                                                <option value="5">Delivered</option>
                                                                                <option value="6">Return Requested
                                                                                </option>
                                                                                <option value="7">Completed</option>
                                                                                <option value="8">Cancelled</option>
                                                                                <option value="9">Refunded/Completed
                                                                                </option>
                                                                            </select><small>Set The Default Child Order
                                                                                Status When An Order Is Marked
                                                                                Completed.</small></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="field-set">
                                                                    <div class="caption-wraper"><label
                                                                            class="label">Default Return Age
                                                                            [days]<span
                                                                                class="spn_must_field">*</span></label>
                                                                    </div>
                                                                    <div class="field-wraper">
                                                                        <div class="field_cover"><input
                                                                                data-field-caption="Default Return Age [days]"
                                                                                data-fatreq="{&quot;required&quot;:true,&quot;integer&quot;:true}"
                                                                                type="text"
                                                                                name="CONF_DEFAULT_RETURN_AGE"
                                                                                value="7"><small>It Will Considered If
                                                                                No Return Age Is Defined In Shop Or
                                                                                Seller Product.</small></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
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
                <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
                <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>
                <script>
                var input = document.querySelector('input[name=tags-outside]')
                // init Tagify script on the above inputs
                var tagify = new Tagify(input, {
                    whitelist: ["Thin 100", "Thin 100 italic", "Light 300", "Light 300 italic", "Regular 400",
                        "Regular 400 italic",
                        "Medium 500", "Medium 500 italic", "Bold 700", "Bold 700 italic",
                        "Black 900"
                    ],
                    dropdown: {
                        position: "input",
                        enabled: 0 // always opens dropdown when input gets focus
                    }
                })
                </script>
            </div>
        </div>
    </body>

</html>