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

                                Local Data </h3>

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
                                    Local Data </a>
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
                            The Metronic Datatable component supports local or remote data source. For the local data you can pass javascript array as data source. In this example the grid fetches its
                            data from a javascript array data source. It also defines
                            the schema model of the data source. In addition to the visualization, the Datatable provides built-in support for operations over data such as sorting, filtering and
                            paging performed in user browser(frontend).
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    Local Datasource
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
                                                        <label>Search:</label>
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
                            <div class="datatable datatable--default datatable--brand datatable--loaded" id="local_data" >
                                <table class="datatable__table" width="100%">
                                    <thead class="datatable__head">
                                        <tr class="datatable__row" >
                                            <th data-field="RecordID" class="datatable__cell--center datatable__cell datatable__cell--check"><span><label class="checkbox checkbox--single checkbox--all checkbox--solid"><input type="checkbox">&nbsp;<span></span></label></span></th>
                                            <th data-field="OrderID" class="datatable__cell datatable__cell--sort"><span>Order ID</span></th>
                                            <th data-field="Country" class="datatable__cell datatable__cell--sort"><span>Country</span></th>
                                            <th data-field="ShipDate" class="datatable__cell datatable__cell--sort"><span>Ship Date</span></th>
                                            <th data-field="CompanyName" class="datatable__cell datatable__cell--sort"><span>Company Name</span></th>
                                            <th data-field="Status" class="datatable__cell datatable__cell--sort"><span>Status</span></th>
                                            <th data-field="Type" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span>Type</span></th>
                                            <th data-field="Actions" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable__body" >
                                        <tr data-row="0" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0374-5070</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/27/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kris-Wehner</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="1" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="2">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63868-257</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/3/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Stanton, Friesen and Grant</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="2" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="3">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49288-0815</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Paraguay PY</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/23/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Cartwright, Hilpert and Hartmann</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="3" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="4">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49288-0039</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Azerbaijan AZ</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Bednar-Grant</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="4" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="5">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>59762-0009</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Brazil BR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/28/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Feeney Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="5" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="6">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>43419-020</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Honduras HN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Bechtelar, Wisoky and Homenick</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="6" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="7">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>33261-641</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/15/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Towne, MacGyver and Greenholt</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="7" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="8">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68462-221</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>France FR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/13/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Lubowitz Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="8" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="9">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68084-555</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Mexico MX</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/14/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Larson Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="9" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="10">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>10565-013</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Greece GR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/2/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Hoeger-Waelchi</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="10" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="11">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68026-422</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>United States US</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/11/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Legros, Oberbrunner and Gleason</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="11" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="12">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0264-7780</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/29/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kassulke and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="12" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="13">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>50813-0001</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Tunisia TN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/4/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Cole-Hamill</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="13" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="14">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>21695-353</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Argentina AR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/4/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Frami Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="14" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="15">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63304-791</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Poland PL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/3/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Bauch LLC</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="15" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="16">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>42352-1001</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Azerbaijan AZ</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/13/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Moen, Walsh and Bednar</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="16" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="17">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68275-320</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Estonia EE</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/13/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Connelly Group</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="17" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="18">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>41190-308</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Panama PA</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/1/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Johns-Lueilwitz</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="18" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="19">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>51655-802</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Iran IR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/15/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Mosciski-Williamson</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="19" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="20">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68151-2713</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Costa Rica CR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/22/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Vandervort, Lesch and Bins</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="20" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="21">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68382-161</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Japan JP</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/26/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Maggio-Friesen</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="21" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="22">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>51345-061</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Russia RU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Rath Group</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="22" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="23">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>33342-072</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/14/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Gutkowski-Bartell</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="23" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="24">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0113-0274</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Brown, Glover and Bednar</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="24" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="25">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>60637-013</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Sweden SE</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/28/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Haag Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="25" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="26">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0781-5626</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/27/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Hodkiewicz-Ledner</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="26" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="27">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>10742-8095</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/20/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Emard Group</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="27" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="28">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49288-0426</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Hungary HU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/5/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Morar, Bosco and Rosenbaum</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="28" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="29">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>59091-2001</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Netherlands NL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/8/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Heathcote-Lueilwitz</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="29" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="30">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63629-1299</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Russia RU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/10/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Harber-Hyatt</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="30" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="31">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49527-022</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>French Polynesia PF</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/10/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Hermiston, Stanton and Weissnat</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="31" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="32">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>44523-535</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Argentina AR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>2/16/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Zboncak, Hickle and McLaughlin</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="32" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="33">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63402-306</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Sweden SE</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/29/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Larkin-Armstrong</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="33" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="34">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63629-3798</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>El Salvador SV</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/29/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kohler Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="34" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="35">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49981-010</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/27/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Goodwin and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="35" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="36">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0023-4383</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/29/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Witting, Lindgren and Kessler</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="36" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="37">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>50988-254</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/12/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Yundt-Jacobs</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="37" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="38">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68788-9924</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Norway NO</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/15/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Schulist Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="38" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="39">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>31722-500</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/4/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Koelpin Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="39" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="40">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>50436-7053</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Poland PL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>2/5/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Lockman-Baumbach</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="40" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="41">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63736-027</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/21/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Larson Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="41" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="42">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>54575-228</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/13/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Robel, Hegmann and Grimes</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="42" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="43">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>52125-370</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/25/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Armstrong, Shields and Osinski</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="43" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="44">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>36987-3290</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>South Africa ZA</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/9/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Larson-Kunze</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="44" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="45">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68737-236</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Russia RU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/31/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Cronin-Purdy</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="45" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="46">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>54868-5511</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Portugal PT</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/16/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Skiles-McCullough</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="46" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="47">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>51389-112</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Poland PL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/5/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kub LLC</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="47" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="48">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>53346-1330</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/8/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Mraz-Spinka</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="48" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="49">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>11410-803</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/24/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Cartwright-Cole</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="49" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="50">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>54473-254</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Australia AU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/6/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Ankunding-Hudson</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="50" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="51">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49967-106</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Koch and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="51" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="52">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>65649-501</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/19/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Marvin Group</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="52" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="53">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>11695-1405</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Albania AL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/14/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Sanford, Hoeger and Stanton</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="53" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="54">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68788-6760</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/13/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Blick-Farrell</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="54" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="55">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0268-1441</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/27/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Hegmann-Hettinger</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="55" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="56">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>62032-524</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Israel IL</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kerluke, Witting and Zboncak</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="56" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="57">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>42291-218</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Yemen YE</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/6/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Barton-Mann</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="57" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="58">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0536-3233</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/10/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Feil, Mante and Becker</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="58" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="59">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0143-1265</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/7/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Zboncak-Hettinger</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="59" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="60">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>64980-119</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Macedonia MK</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>2/3/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Moore, Toy and McCullough</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="60" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="61">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0363-0198</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/30/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Simonis and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="61" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="62">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>65862-142</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/4/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Dach-Ernser</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="62" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="63">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>67510-1561</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Peru PE</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/27/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Wisozk-Ratke</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="63" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="64">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>67877-169</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Brazil BR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/21/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Schuster, Flatley and Ledner</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="64" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="65">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>13537-402</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Uganda UG</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/8/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kuphal Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="65" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="66">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>48951-8237</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Portugal PT</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/6/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kautzer Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="66" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="67">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>36987-3279</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Spain ES</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/2/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Jacobson-Brakus</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="67" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="68">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>36987-3092</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Belarus BY</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/12/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Sipes, Schaden and Larkin</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="68" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="69">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>17271-503</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Slovenia SI</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/26/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Reinger Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="69" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="70">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49288-0206</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>France FR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/18/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Dicki and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="70" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="71">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>55312-118</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Belarus BY</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/13/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Jacobs, Blanda and Dickinson</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="71" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="72">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49035-111</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Brazil BR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/18/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Zboncak-Dooley</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="72" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="73">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>33261-888</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/24/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Lemke Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="73" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="74">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>60709-105</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/21/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Schimmel, Mohr and Kutch</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="74" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="75">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>63629-2679</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Finland FI</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/20/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Bergnaum-Kozey</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="75" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="76">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>36800-277</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Serbia RS</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/19/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Schulist-Yost</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="76" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="77">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>52125-910</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Armenia AM</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/24/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Rosenbaum Inc</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="77" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="78">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>24236-120</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>France FR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>2/5/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Witting-Von</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="78" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="79">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>76173-1008</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Pakistan PK</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/29/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kunde-Veum</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="79" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="80">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>41163-146</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/5/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Brown-Hudson</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="80" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="81">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>68084-198</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>10/4/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Adams, Macejkovic and Little</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="81" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="82">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>60512-1043</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Portugal PT</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>8/23/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Osinski LLC</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="82" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="83">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>21695-139</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Slovenia SI</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/27/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Schaefer-Smith</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="83" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="84">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0228-3003</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Dominican Republic DO</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>11/14/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Wiegand and Sons</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="84" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="85">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>36800-124</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Mexico MX</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/13/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Cartwright, Mante and Kris</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="85" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="86">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>59746-175</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Philippines PH</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>5/20/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Nicolas-Bayer</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="86" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="87">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>0268-1481</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Palestinian Territory PS</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>4/2/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Langosh, Kris and Ernser</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="87" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="88">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>58411-157</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/11/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Lueilwitz-Cole</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="88" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="89">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>54569-6438</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Portugal PT</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/17/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Price Group</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="89" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="90">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>64720-141</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/2/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Hackett-Olson</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="90" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="91">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>53145-059</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Brazil BR</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>6/26/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Pfeffer, Harber and Hintz</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="91" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="92">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>57520-0396</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>China CN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/11/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kirlin, Goldner and Upton</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="92" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="93">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>24236-184</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Azerbaijan AZ</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/16/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Herman-Erdman</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="93" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="94">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>11822-9854</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Indonesia ID</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>3/27/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Pacocha-Kling</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="94" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="95">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49643-120</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Russia RU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>9/12/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Smith-Stokes</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="95" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="96">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>56062-393</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Guam GU</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>7/18/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Lynch-Satterfield</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="96" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="97">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>50436-0120</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Dominica DM</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/20/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Denesik-Wyman</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="97" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="98">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>42507-004</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Mexico MX</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/22/2017</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>O'Reilly, Block and Goyette</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="98" class="datatable__row" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="99">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>49230-191</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Japan JP</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>12/12/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Purdy-Carroll</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-cog"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="99" class="datatable__row datatable__row--even" >
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="100">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span>50865-056</span></td>
                                            <td data-field="Country" class="datatable__cell"><span>Honduras HN</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span>1/14/2016</span></td>
                                            <td data-field="CompanyName" class="datatable__cell"><span>Kessler, Greenfelder and Gaylord</span></td>
                                            <td data-field="Status" class="datatable__cell"><span><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
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