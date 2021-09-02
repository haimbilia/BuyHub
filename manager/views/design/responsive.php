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

                                Responsive Examples </h3>

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
                                    Responsive </a>
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
                            Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                            See official documentation <a class="link font-bold" href="https://datatables.net/extensions/responsive/" target="_blank">here</a>.
                        </div>
                    </div>

                    <div class="card card--mobile">
                        <div class="card-head card-head--lg">
                            <div class="card-head-label">
                                <span class="card-head-icon">
                                    <i class="font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="card-head-title">
                                    Responsive DataTable
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
                                        <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap dataTable dtr-inline collapsed" id="table_1" role="grid" aria-describedby="table_1_info" style="width: 1268px;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 38.25px;" aria-sort="ascending" aria-label="Order ID: activate to sort column descending">Order ID</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 53.25px;" aria-label="Ship Country: activate to sort column ascending">Ship Country</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 54.25px;" aria-label="Ship City: activate to sort column ascending">Ship City</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 69.25px;" aria-label="Ship Name: activate to sort column ascending">Ship Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 61.25px;" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 213.25px;" aria-label="Company Email: activate to sort column ascending">Company Email</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 66.25px;" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 69.25px;" aria-label="Company Name: activate to sort column ascending">Company Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 61.25px;" aria-label="Currency: activate to sort column ascending">Currency</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 80.25px;" aria-label="Department: activate to sort column ascending">Department</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 53.25px;" aria-label="Latitude: activate to sort column ascending">Latitude</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Longitude: activate to sort column ascending">Longitude</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Payment Date: activate to sort column ascending">Payment Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Time Zone: activate to sort column ascending">Time Zone</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Total Payment: activate to sort column ascending">Total Payment</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Status: activate to sort column ascending">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Type: activate to sort column ascending">Type</th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Actions">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>










                                                <tr role="row" class="odd">
                                                    <td class="sorting_1" tabindex="0" style="">0093-1016</td>
                                                    <td>ID</td>
                                                    <td>Merdeka</td>
                                                    <td>Pfannerstill-Jenkins</td>
                                                    <td>3150 Cherokee Center</td>
                                                    <td>gclampo@vistaprint.com</td>
                                                    <td>Gusti Clamp</td>
                                                    <td>Stokes Group</td>
                                                    <td>IDR</td>
                                                    <td>Grocery</td>
                                                    <td>-6.9136675</td>
                                                    <td style="display: none;">107.6200524</td>
                                                    <td style="display: none;">4/12/2018</td>
                                                    <td style="display: none;">2017-10-06 00:23:49</td>
                                                    <td style="display: none;">Asia/Makassar</td>
                                                    <td style="display: none;">$158287.28</td>
                                                    <td style="display: none;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></td>
                                                    <td style="display: none;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">0093-5142</td>
                                                    <td>CN</td>
                                                    <td>Jianggao</td>
                                                    <td>Romaguera-Greenholt</td>
                                                    <td>289 Badeau Alley</td>
                                                    <td>ojobbinsp@w3.org</td>
                                                    <td>Otis Jobbins</td>
                                                    <td>Ruecker, Leffler and Abshire</td>
                                                    <td>CNY</td>
                                                    <td>Kids</td>
                                                    <td>23.2905</td>
                                                    <td style="display: none;">113.234549</td>
                                                    <td style="display: none;">3/6/2018</td>
                                                    <td style="display: none;">2016-01-01 18:08:34</td>
                                                    <td style="display: none;">Asia/Chongqing</td>
                                                    <td style="display: none;">$429312.02</td>
                                                    <td style="display: none;"><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
                                                    <td style="display: none;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">0185-0130</td>
                                                    <td>CN</td>
                                                    <td>Jiamachi</td>
                                                    <td>Langosh Inc</td>
                                                    <td>23 Walton Pass</td>
                                                    <td>nfoldesb@lycos.com</td>
                                                    <td>Norri Foldes</td>
                                                    <td>Strosin, Nitzsche and Wisozk</td>
                                                    <td>CNY</td>
                                                    <td>Jewelery</td>
                                                    <td>29.503085</td>
                                                    <td style="display: none;">108.984759</td>
                                                    <td style="display: none;">4/2/2017</td>
                                                    <td style="display: none;">2016-08-05 06:19:54</td>
                                                    <td style="display: none;">Asia/Chongqing</td>
                                                    <td style="display: none;">$1143125.96</td>
                                                    <td style="display: none;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
                                                    <td style="display: none;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">0363-0724</td>
                                                    <td>MA</td>
                                                    <td>Temara</td>
                                                    <td>Hegmann, Gleason and Stehr</td>
                                                    <td>9550 Weeping Birch Crossing</td>
                                                    <td>fnazaretx@si.edu</td>
                                                    <td>Felix Nazaret</td>
                                                    <td>Waters, Quigley and Keeling</td>
                                                    <td>MAD</td>
                                                    <td>Home</td>
                                                    <td>33.9278354</td>
                                                    <td style="display: none;">-6.9051819</td>
                                                    <td style="display: none;">6/4/2016</td>
                                                    <td style="display: none;">2016-06-13 16:43:18</td>
                                                    <td style="display: none;">Africa/Casablanca</td>
                                                    <td style="display: none;">$285288.32</td>
                                                    <td style="display: none;"><span class="badge  badge--info badge--inline badge--pill">Info</span></td>
                                                    <td style="display: none;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td tabindex="0" class="sorting_1">0404-0360</td>
                                                    <td>CO</td>
                                                    <td>San Carlos</td>
                                                    <td>Bartoletti, Howell and Jacobson</td>
                                                    <td>38099 Ilene Hill</td>
                                                    <td>fmorby8@surveymonkey.com</td>
                                                    <td>Freida Morby</td>
                                                    <td>Haley, Schamberger and Durgan</td>
                                                    <td>COP</td>
                                                    <td>Garden</td>
                                                    <td>8.797145</td>
                                                    <td style="display: none;">-75.698571</td>
                                                    <td style="display: none;">3/31/2017</td>
                                                    <td style="display: none;">2018-02-23 01:18:36</td>
                                                    <td style="display: none;">America/Bogota</td>
                                                    <td style="display: none;">$124768.15</td>
                                                    <td style="display: none;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></td>
                                                    <td style="display: none;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">11673-479</td>
                                                    <td>BR</td>
                                                    <td>Conceição das Alagoas</td>
                                                    <td>Gleason Inc</td>
                                                    <td>191 Stone Corner Road</td>
                                                    <td>mplenderleithh@globo.com</td>
                                                    <td>Michaelina Plenderleith</td>
                                                    <td>Legros-Gleichner</td>
                                                    <td>BRL</td>
                                                    <td>Grocery</td>
                                                    <td>-19.9241693</td>
                                                    <td style="display: none;">-48.3811173</td>
                                                    <td style="display: none;">2/21/2018</td>
                                                    <td style="display: none;">2016-08-06 05:33:25</td>
                                                    <td style="display: none;">America/Sao_Paulo</td>
                                                    <td style="display: none;">$1096683.96</td>
                                                    <td style="display: none;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
                                                    <td style="display: none;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">15127-874</td>
                                                    <td>TZ</td>
                                                    <td>Nanganga</td>
                                                    <td>Kozey-Okuneva</td>
                                                    <td>33 Anniversary Parkway</td>
                                                    <td>mrotlauf10@naver.com</td>
                                                    <td>Magdaia Rotlauf</td>
                                                    <td>Hettinger, Medhurst and Heaney</td>
                                                    <td>TZS</td>
                                                    <td>Beauty</td>
                                                    <td>-10.3931514</td>
                                                    <td style="display: none;">39.1361568</td>
                                                    <td style="display: none;">2/18/2018</td>
                                                    <td style="display: none;">2016-08-06 20:08:36</td>
                                                    <td style="display: none;">Africa/Dar_es_Salaam</td>
                                                    <td style="display: none;">$290437.32</td>
                                                    <td style="display: none;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
                                                    <td style="display: none;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">17089-415</td>
                                                    <td>PS</td>
                                                    <td>Za‘tarah</td>
                                                    <td>Ratke, Schoen and Mitchell</td>
                                                    <td>42806 Ridgeview Terrace</td>
                                                    <td>kchettoe12@zdnet.com</td>
                                                    <td>Kessiah Chettoe</td>
                                                    <td>Mraz LLC</td>
                                                    <td>ILS</td>
                                                    <td>Automotive</td>
                                                    <td>31.67361</td>
                                                    <td style="display: none;">35.25662</td>
                                                    <td style="display: none;">3/4/2017</td>
                                                    <td style="display: none;">2016-06-10 04:20:27</td>
                                                    <td style="display: none;">Asia/Hebron</td>
                                                    <td style="display: none;">$503984.70</td>
                                                    <td style="display: none;"><span class="badge  badge--info badge--inline badge--pill">Info</span></td>
                                                    <td style="display: none;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">21130-678</td>
                                                    <td>CN</td>
                                                    <td>Qiaole</td>
                                                    <td>Jenkins-Haag</td>
                                                    <td>328 Glendale Hill</td>
                                                    <td>morhtmannc@weibo.com</td>
                                                    <td>Myrna Orhtmann</td>
                                                    <td>Miller-Schiller</td>
                                                    <td>CNY</td>
                                                    <td>Books</td>
                                                    <td>28.643587</td>
                                                    <td style="display: none;">115.568583</td>
                                                    <td style="display: none;">6/7/2016</td>
                                                    <td style="display: none;">2017-02-02 05:24:00</td>
                                                    <td style="display: none;">Asia/Shanghai</td>
                                                    <td style="display: none;">$159355.37</td>
                                                    <td style="display: none;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
                                                    <td style="display: none;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <td class="sorting_1" tabindex="0">27495-006</td>
                                                    <td>PT</td>
                                                    <td>Arrifes</td>
                                                    <td>Von LLC</td>
                                                    <td>3 Fairfield Junction</td>
                                                    <td>vcoshamt@simplemachines.org</td>
                                                    <td>Vernon Cosham</td>
                                                    <td>Kreiger-Nicolas</td>
                                                    <td>EUR</td>
                                                    <td>Movies</td>
                                                    <td>37.760365</td>
                                                    <td style="display: none;">-25.7013016</td>
                                                    <td style="display: none;">2/8/2017</td>
                                                    <td style="display: none;">2017-07-22 18:32:31</td>
                                                    <td style="display: none;">Africa/Accra</td>
                                                    <td style="display: none;">$179291.15</td>
                                                    <td style="display: none;"><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
                                                    <td style="display: none;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
                                                    <td nowrap="" style="display: none;">
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
                                                    <th rowspan="1" colspan="1">Order ID</th>
                                                    <th rowspan="1" colspan="1">Ship Country</th>
                                                    <th rowspan="1" colspan="1">Ship City</th>
                                                    <th rowspan="1" colspan="1">Ship Name</th>
                                                    <th rowspan="1" colspan="1">Ship Address</th>
                                                    <th rowspan="1" colspan="1">Company Email</th>
                                                    <th rowspan="1" colspan="1">Company Agent</th>
                                                    <th rowspan="1" colspan="1">Company Name</th>
                                                    <th rowspan="1" colspan="1">Currency</th>
                                                    <th rowspan="1" colspan="1">Department</th>
                                                    <th rowspan="1" colspan="1">Latitude</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Longitude</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Ship Date</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Payment Date</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Time Zone</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Total Payment</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Status</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Type</th>
                                                    <th rowspan="1" colspan="1" style="display: none;">Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="table_1_info" role="status" aria-live="polite">Showing 1 to 10 of 40 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="table_1_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled" id="table_1_previous"><a href="#" aria-controls="table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="la la-angle-left"></i></a></li>
                                                <li class="paginate_button page-item active"><a href="#" aria-controls="table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                                <li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                                <li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                                <li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                                                <li class="paginate_button page-item next" id="table_1_next"><a href="#" aria-controls="table_1" data-dt-idx="5" tabindex="0" class="page-link"><i class="la la-angle-right"></i></a></li>
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