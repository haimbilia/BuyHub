<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />

</head>



<body class="">
    <div class="wrapper">
        <?php
  include 'includes/header.php';
?>
        <div class="body " id="body">
            <div class="content " id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">

                                Local Sort </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    YKDatatable </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Base </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Local Sort </a>
                            </div>
                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn subheader__btn-secondary">
                                    Reports
                                </a>

                                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="Quick actions">
                                    <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                        <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                        <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container">
                    <div class="alert alert-light alert-elevate" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                        <div class="alert-text">
                            The Metronic Datatable support local sorting with column's data type and custom sort callback.
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    Sorting
                                    <small>Sorting in local datasource</small>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <div class="card-head-wrapper">
                                    <a href="#" class="btn btn-clean btn-icon-sm">
                                        <i class="la la-long-arrow-left"></i>
                                        Back
                                    </a>
                                    &nbsp;
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon2-plus"></i> Add New
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
                                                <li class="nav__section nav__section--first">
                                                    <span class="nav__section-text">Choose an action:</span>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-open-text-book"></i>
                                                        <span class="nav__link-text">Reservations</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                        <span class="nav__link-text">Appointments</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-bell-alarm-symbol"></i>
                                                        <span class="nav__link-text">Reminders</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-contract"></i>
                                                        <span class="nav__link-text">Announcements</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-shopping-cart-1"></i>
                                                        <span class="nav__link-text">Orders</span>
                                                    </a>
                                                </li>
                                                <li class="nav__separator nav__separator--fit">
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-rocket-1"></i>
                                                        <span class="nav__link-text">Projects</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-chat-1"></i>
                                                        <span class="nav__link-text">User Feedbacks</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!--begin: Search Form -->
                            <div class="form form--label-right margin-t-20 margin-b-10">
                                <div class="row align-items-center">
                                    <div class="col-xl-8 order-2 order-xl-1">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 margin-b-20-tablet-and-mobile">
                                                <div class="form__group form__group--inline">
                                                    <div class="form__label">
                                                        <label>Status:</label>
                                                    </div>
                                                </div>

                                                <div class="input-icon input-icon--left">
                                                    <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                                    <span class="input-icon__icon input-icon__icon--left">
                                                        <span><i class="la la-search"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 margin-b-20-tablet-and-mobile">
                                                <div class="form__group form__group--inline">
                                                    <div class="form__label">
                                                        <label>Status:</label>
                                                    </div>
                                                    <div class="form__control">
                                                        <select class="form-control bootstrap-select" id="form_status" tabindex="-98">
                                                            <option value="">All</option>
                                                            <option value="1">Pending</option>
                                                            <option value="2">Delivered</option>
                                                            <option value="3">Canceled</option>
                                                            <option value="4">Success</option>
                                                            <option value="5">Info</option>
                                                            <option value="6">Danger</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 margin-b-20-tablet-and-mobile">
                                                <div class="form__group form__group--inline">
                                                    <div class="form__label">
                                                        <label>Type:</label>
                                                    </div>
                                                    <div class="form__control">
                                                        <select class="form-control bootstrap-select" id="form_type" tabindex="-98">
                                                            <option value="">All</option>
                                                            <option value="1">Online</option>
                                                            <option value="2">Retail</option>
                                                            <option value="3">Direct</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 order-1 order-xl-2 align-right">
                                        <a href="#" class="btn btn-default hidden">
                                            <i class="la la-cart-plus"></i> New Order
                                        </a>
                                        <div class="separator separator--border-dashed separator--space-lg d-xl-none"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Search Form -->
                        </div>
                        <div class="card-body card__body--fit">
                            <!--begin: Datatable -->
                            <div class="datatable datatable--default datatable--brand datatable--loaded" id="ajax_data" >
                                <table class="datatable__table" width="100%">
                                    <thead class="datatable__head">
                                        <tr class="datatable__row">
                                            <th data-field="RecordID" class="datatable__cell--center datatable__cell datatable__cell--sort datatable__cell--sorted" data-sort="asc"><span>#<i class="flaticon2-arrow-up"></i></span></th>
                                            <th data-field="OrderID" class="datatable__cell datatable__cell--sort"><span>Order ID</span></th>
                                            <th data-field="Country" class="datatable__cell datatable__cell--sort"><span>Country</span></th>
                                            <th data-field="ShipDate" class="datatable__cell datatable__cell--sort"><span>Ship Date</span></th>
                                            <th data-field="TotalPayment" class="datatable__cell datatable__cell--sort"><span>Payment</span></th>
                                            <th data-field="Status" class="datatable__cell datatable__cell--sort"><span>Status</span></th>
                                            <th data-field="Type" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span>Type</span></th>
                                            <th data-field="Actions" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable__body" >
                                        <tr data-row="0" class="datatable__row" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>1</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>61715-075</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>2/12/2018</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$246154.65</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="1" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>2</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63629-4697</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/6/2017</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$795849.41</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="2" class="datatable__row" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>3</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68084-123</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Argentina AR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/26/2016</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$830764.07</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="3" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>4</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>67457-428</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/2/2016</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$777892.92</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="4" class="datatable__row" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>5</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>31722-529</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Austria AT</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/20/2017</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$516467.41</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="5" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>6</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>64117-168</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/26/2016</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$410062.16</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="6" class="datatable__row" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>7</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>43857-0331</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/28/2016</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$210902.65</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="7" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>8</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>64980-196</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Croatia HR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/5/2016</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$1162836.25</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="8" class="datatable__row" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>9</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0404-0360</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Colombia CO</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/31/2017</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$124768.15</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="9" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span>10</span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>52125-267</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Thailand TH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/26/2017</span></td>
                                            <td data-field="TotalPayment" class="datatable__cell"><span>$531999.26</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span >
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="pagination  pagination--brand">
												<ul class="pagination__links">
													<li class="pagination__link--first">
														<a href="#"><i class="fa fa-angle-double-left font-brand"></i></a>
													</li>
													<li class="pagination__link--next">
														<a href="#"><i class="fa fa-angle-left font-brand"></i></a>
													</li>


													<li>
														<a href="#">29</a>
													</li>
													<li>
														<a href="#">30</a>
													</li>

													<li class="pagination__link--active">
														<a href="#">31</a>
													</li>
													<li>
														<a href="#">32</a>
													</li>


													<li class="pagination__link--prev">
														<a href="#"><i class="fa fa-angle-right font-brand"></i></a>
													</li>
													<li class="pagination__link--last">
														<a href="#"><i class="fa fa-angle-double-right font-brand"></i></a>
													</li>
												</ul>
												<div class="pagination__toolbar mt-4 mt-md-0">
													<select class="form-control font-brand" style="width: 60px;">
														<option value="10">10</option>
														<option value="20">20</option>
														<option value="30">30</option>
														<option value="50">50</option>
														<option value="100">100</option>
													</select>
													<span class="pagination__desc">
														Displaying 10 of 230 records
													</span>
												</div>
											</div>
                            </div>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>

        <?php
  include 'includes/footer.php';
?>
    </div>

</body>


</html>