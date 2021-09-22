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
                                    JSON Data </a>
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
                            Datatable initialized from remote JSON source with local(frontend) pagination, column order and search support.
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    JSON Datatable
                                    <small>initialized from remote json file</small>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <div class="card-head-wrapper">
                                    <div class="card-head-actions">
                                        <div class="dropdown dropdown-inline">
                                            <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="la la-download"></i> Export
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="nav">
                                                    <li class="nav__section nav__section--first">
                                                        <span class="nav__section-text">Choose an option</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon la la-print"></i>
                                                            <span class="nav__link-text">Print</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon la la-copy"></i>
                                                            <span class="nav__link-text">Copy</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon la la-file-excel-o"></i>
                                                            <span class="nav__link-text">Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon la la-file-text-o"></i>
                                                            <span class="nav__link-text">CSV</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon la la-file-pdf-o"></i>
                                                            <span class="nav__link-text">PDF</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        &nbsp;
                                        <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            New Record
                                        </a>
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
                                                        <label>search:</label>
                                                     </div></div>
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
                            <div class="datatable datatable--default datatable--brand datatable--loaded" id="json_data" style="">
                                <table class="datatable__table" width="100%">
                                    <thead class="datatable__head">
                                        <tr class="datatable__row" style="left: 0px;">
                                            <th data-field="RecordID" class="datatable__cell--center datatable__cell datatable__cell--check"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--all checkbox--solid"><input type="checkbox">&nbsp;<span></span></label></span></th>
                                            <th data-field="OrderID" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Order ID</span></th>
                                            <th data-field="Country" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Country</span></th>
                                            <th data-field="ShipAddress" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Ship Address</span></th>
                                            <th data-field="ShipDate" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Ship Date</span></th>
                                            <th data-field="Status" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Status</span></th>
                                            <th data-field="Type" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Type</span></th>
                                            <th data-field="Actions" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 110px;">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable__body" style="">
                                        <tr data-row="0" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">61715-075</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">746 Pine View Junction</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">2/12/2018</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="1" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="2">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">63629-4697</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Indonesia ID</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">01652 Fulton Trail</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">8/6/2017</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="2" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="3">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">68084-123</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Argentina AR</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">2 Pine View Park</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">5/26/2016</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="3" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="4">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">67457-428</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Indonesia ID</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">3050 Buell Terrace</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">7/2/2016</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="4" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="5">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">31722-529</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Austria AT</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">3038 Trailsway Junction</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">5/20/2017</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="5" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="6">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">64117-168</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">023 South Way</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">11/26/2016</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="6" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="7">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">43857-0331</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">56482 Fairfield Terrace</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">6/28/2016</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="7" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="8">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">64980-196</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Croatia HR</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">0 Elka Street</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">8/5/2016</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="8" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="9">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">0404-0360</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Colombia CO</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">38099 Ilene Hill</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">3/31/2017</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
                                                    </div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr data-row="9" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width: 20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="10">&nbsp;<span></span></label></span></td>
                                            <td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">52125-267</span></td>
                                            <td data-field="Country" class="datatable__cell"><span style="width: 148px;">Thailand TH</span></td>
                                            <td data-field="ShipAddress" class="datatable__cell"><span style="width: 148px;">8696 Barby Pass</span></td>
                                            <td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">1/26/2017</span></td>
                                            <td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
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