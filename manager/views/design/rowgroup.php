<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
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

                                RowGroup Examples </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Datatables.net </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Extensions </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    RowGroup </a>
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
                            RowGroup adds this ability to DataTables with the ability to customise the start and end grouping rows displayed in the DataTable, letting you integrate the summarised data to fit perfectly in with your site.
                            See official documentation <a class="link font-bold" href="https://datatables.net/extensions/rowgroup/" target="_blank">here</a>.
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    RowGroup DataTable
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
                            <!--begin: Datatable -->
                            <div id="table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="table_1_length"><label>Show <select name="table_1_length" aria-controls="table_1" class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="table_1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="table_1"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable dtr-inline" id="table_1" role="grid" aria-describedby="table_1_info" style="width: 1268px;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 50.25px;" aria-label="Record ID: activate to sort column ascending">Record ID</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 45.25px;" aria-label="Order ID: activate to sort column ascending">Order ID</th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 87.25px;" aria-sort="ascending" aria-label="Country: activate to sort column descending">Country</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 79.25px;" aria-label="Ship City: activate to sort column ascending">Ship City</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 135.25px;" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 90.25px;" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 153.25px;" aria-label="Company Name: activate to sort column ascending">Company Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 51.25px;" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 48.25px;" aria-label="Status: activate to sort column ascending">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 32.25px;" aria-label="Type: activate to sort column ascending">Type</th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 68.5px;" aria-label="Actions">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>










                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">China</td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">33</td>
                                                    <td>68428-725</td>
                                                    <td class="sorting_1">China</td>
                                                    <td>Zhangcun</td>
                                                    <td>3 Goodland Terrace</td>
                                                    <td>Pavel Kringe</td>
                                                    <td>Goldner-Lehner</td>
                                                    <td>4/2/2017</td>
                                                    <td><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
                                                    <td><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td tabindex="0">22</td>
                                                    <td>49348-055</td>
                                                    <td class="sorting_1">China</td>
                                                    <td>Guxi</td>
                                                    <td>45 Butterfield Street</td>
                                                    <td>Yardley Wetherell</td>
                                                    <td>Gerlach-Schultz</td>
                                                    <td>4/3/2017</td>
                                                    <td><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></td>
                                                    <td><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">12</td>
                                                    <td>0185-0130</td>
                                                    <td class="sorting_1">China</td>
                                                    <td>Jiamachi</td>
                                                    <td>23 Walton Pass</td>
                                                    <td>Norri Foldes</td>
                                                    <td>Strosin, Nitzsche and Wisozk</td>
                                                    <td>4/2/2017</td>
                                                    <td><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
                                                    <td><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">Colombia</td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td tabindex="0">9</td>
                                                    <td>0404-0360</td>
                                                    <td class="sorting_1">Colombia</td>
                                                    <td>San Carlos</td>
                                                    <td>38099 Ilene Hill</td>
                                                    <td>Freida Morby</td>
                                                    <td>Haley, Schamberger and Durgan</td>
                                                    <td>3/31/2017</td>
                                                    <td><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></td>
                                                    <td><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">Croatia</td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">8</td>
                                                    <td>64980-196</td>
                                                    <td class="sorting_1">Croatia</td>
                                                    <td>Vinica</td>
                                                    <td>0 Elka Street</td>
                                                    <td>Hazlett Kite</td>
                                                    <td>Streich LLC</td>
                                                    <td>8/5/2016</td>
                                                    <td><span class="badge  badge--danger badge--inline badge--pill">Danger</span></td>
                                                    <td><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">Ethiopia</td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td tabindex="0">29</td>
                                                    <td>58411-198</td>
                                                    <td class="sorting_1">Ethiopia</td>
                                                    <td>Kombolcha</td>
                                                    <td>91066 Amoth Court</td>
                                                    <td>Tuck O'Dowgaine</td>
                                                    <td>Simonis, Rowe and Davis</td>
                                                    <td>5/6/2017</td>
                                                    <td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
                                                    <td><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">Germany</td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">27</td>
                                                    <td>51523-026</td>
                                                    <td class="sorting_1">Germany</td>
                                                    <td>Erfurt</td>
                                                    <td>132 Chive Way</td>
                                                    <td>Lonnie Haycox</td>
                                                    <td>Feest Group</td>
                                                    <td>4/24/2018</td>
                                                    <td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
                                                    <td><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr class="dtrg-group dtrg-start dtrg-level-0">
                                                    <td colspan="11">Indonesia</td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td tabindex="0">2</td>
                                                    <td>63629-4697</td>
                                                    <td class="sorting_1">Indonesia</td>
                                                    <td>Cihaur</td>
                                                    <td>01652 Fulton Trail</td>
                                                    <td>Emelita Giraldez</td>
                                                    <td>Rosenbaum-Reichel</td>
                                                    <td>8/6/2017</td>
                                                    <td><span class="badge  badge--danger badge--inline badge--pill">Danger</span></td>
                                                    <td><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td tabindex="0">20</td>
                                                    <td>42291-712</td>
                                                    <td class="sorting_1">Indonesia</td>
                                                    <td>Kembang</td>
                                                    <td>9029 Blackbird Point</td>
                                                    <td>Leonora Chevin</td>
                                                    <td>Mann LLC</td>
                                                    <td>9/6/2017</td>
                                                    <td><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></td>
                                                    <td><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td tabindex="0">4</td>
                                                    <td>67457-428</td>
                                                    <td class="sorting_1">Indonesia</td>
                                                    <td>Talok</td>
                                                    <td>3050 Buell Terrace</td>
                                                    <td>Evangeline Cure</td>
                                                    <td>Pfannerstill-Treutel</td>
                                                    <td>7/2/2016</td>
                                                    <td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
                                                    <td><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></td>
                                                    <td nowrap="">
                                                        <span class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="la la-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                            </div>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                                            <i class="la la-edit"></i>
                                                        </a></td>
                                                </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">Record ID</th>
                                                    <th rowspan="1" colspan="1">Order ID</th>
                                                    <th rowspan="1" colspan="1">Country</th>
                                                    <th rowspan="1" colspan="1">Ship City</th>
                                                    <th rowspan="1" colspan="1">Ship Address</th>
                                                    <th rowspan="1" colspan="1">Company Agent</th>
                                                    <th rowspan="1" colspan="1">Company Name</th>
                                                    <th rowspan="1" colspan="1">Ship Date</th>
                                                    <th rowspan="1" colspan="1">Status</th>
                                                    <th rowspan="1" colspan="1">Type</th>
                                                    <th rowspan="1" colspan="1">Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="table_1_info" role="status" aria-live="polite">Showing 1 to 10 of 30 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="table_1_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled" id="table_1_previous"><a href="#" aria-controls="table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="la la-angle-left"></i></a></li>
                                                <li class="paginate_button page-item active"><a href="#" aria-controls="table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                                <li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                                <li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                                <li class="paginate_button page-item next" id="table_1_next"><a href="#" aria-controls="table_1" data-dt-idx="4" tabindex="0" class="page-link"><i class="la la-angle-right"></i></a></li>
                                            </ul>
                                        </div>
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