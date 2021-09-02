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
        <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">
                                HTML Table </h3>

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
                                    HTML Table </a>
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
                <div class="container  grid__item grid__item--fluid">
                    <div class="alert alert-light alert-elevate" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                        <div class="alert-text">
                            The Metronic Datatable component supports initialization from HTML table. It also defines the schema model of the data source. In addition to the visualization, the Datatable
                            provides built-in support for operations over data such
                            as sorting, filtering and paging performed in user browser(frontend).
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    HTML Table
                                    <small>Datatable initialized from HTML table</small>
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
                            <div class="datatable datatable--default datatable--brand datatable--loaded">
                                <table class="datatable__table" id="html_table" width="100%">
                                    <thead class="datatable__head">

                                        <tr class="datatable__row" style="left: 0px;">
                                            <th class="datatable__cell datatable__toggle-detail"><span></span></th>
                                            <th data-field="Order ID" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Order ID</span></th>
                                            <th data-field="Car Make" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Car Make</span></th>
                                            <th data-field="Car Model" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Car Model</span></th>
                                            <th data-field="Color" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Color</span></th>
                                            <th data-field="Deposit Paid" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Deposit Paid</span></th>
                                            <th data-field="Order Date" class="datatable__cell datatable__cell--sort" style="display: none;"><span style="width: 148px;">Order Date</span></th>
                                            <th data-field="Status" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Status</span></th>
                                            <th data-field="Type" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Type</span></th>
                                        </tr>
                                    </thead>
                                    <tbody style="" class="datatable__body">
                                        <tr data-row="0" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">0006-3629</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Land Rover</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Range Rover</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Orange</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$22672.60</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-11-28</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                        </tr>
                                        <tr data-row="1" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">66403-315</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">GMC</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Jimmy</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Goldenrod</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$55141.29</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2017-04-29</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                        </tr>
                                        <tr data-row="2" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">54868-5055</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Ford</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Club Wagon</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Goldenrod</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$70991.52</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2017-03-16</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                        </tr>
                                        <tr data-row="3" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">44924-112</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">GMC</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Envoy</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Indigo</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$42615.31</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-09-04</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                        </tr>
                                        <tr data-row="4" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">0378-0357</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Saab</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">9-5</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Teal</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$74919.63</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2017-09-21</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                        </tr>
                                        <tr data-row="5" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">0363-0590</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Suzuki</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Grand Vitara</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Crimson</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$72908.80</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2017-04-03</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                        </tr>
                                        <tr data-row="6" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">35356-778</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Dodge</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Ram 2500</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Goldenrod</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$13569.00</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-03-22</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                        </tr>
                                        <tr data-row="7" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">48951-3040</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Mitsubishi</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">Eclipse</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Aquamarine</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$22471.73</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-04-17</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                        </tr>
                                        <tr data-row="8" class="datatable__row" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">0487-9801</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Pontiac</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">GTO</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Green</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$43149.39</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-05-27</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--success badge--inline badge--pill">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                        </tr>
                                        <tr data-row="9" class="datatable__row datatable__row--even" style="left: 0px;">
                                            <td class="datatable__cell datatable__toggle-detail"><a class="datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
                                            <td data-field="Order ID" class="datatable__cell"><span style="width: 148px;">54753-003</span></td>
                                            <td data-field="Car Make" class="datatable__cell"><span style="width: 148px;">Audi</span></td>
                                            <td data-field="Car Model" class="datatable__cell"><span style="width: 148px;">S4</span></td>
                                            <td data-field="Color" class="datatable__cell"><span style="width: 148px;">Turquoise</span></td>
                                            <td data-field="Deposit Paid" class="datatable__cell"><span style="width: 148px;">$39286.74</span></td>
                                            <td data-field="Order Date" class="datatable__cell" style="display: none;"><span style="width: 148px;">2016-07-23</span></td>
                                            <td data-field="Status" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
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