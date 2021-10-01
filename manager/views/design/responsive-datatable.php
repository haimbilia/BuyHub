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



<body class="">
    <div class="wrapper">
        <?php include 'includes/header.php'; ?>


        <div class="body " id="body">
            <div class="content " id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Responsive Data Table </h3>
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

                        <div class="card-body card__body--fit">
                            <!--begin: Datatable -->
                            <div class="dataTables_wrapper dt-bootstrap4" id="local_data">
                                <table class="table table-striped- table-bordered table-hover table-checkable responsive dataTable dtr-inline collapsed" id="m_table_1" role="grid" aria-describedby="m_table_1_info" >
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 50.25px;" aria-sort="ascending" aria-label="OrderID: activate to sort column descending">OrderID</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 81.25px;" aria-label="ShipCountry: activate to sort column ascending">ShipCountry</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 54.25px;" aria-label="ShipCity: activate to sort column ascending">ShipCity</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 68.25px;" aria-label="ShipName: activate to sort column ascending">ShipName</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="ShipAddress: activate to sort column ascending">ShipAddress</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 211.25px;" aria-label="CompanyEmail: activate to sort column ascending">CompanyEmail</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 104.25px;" aria-label="CompanyAgent: activate to sort column ascending">CompanyAgent</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 105.25px;" aria-label="CompanyName: activate to sort column ascending">CompanyName</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 61.25px;" aria-label="Currency: activate to sort column ascending">Currency</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 80.25px;" aria-label="Department: activate to sort column ascending">Department</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Latitude: activate to sort column ascending">Latitude</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Longitude: activate to sort column ascending">Longitude</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="ShipDate: activate to sort column ascending">ShipDate</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="PaymentDate: activate to sort column ascending">PaymentDate</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="TimeZone: activate to sort column ascending">TimeZone</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="TotalPayment: activate to sort column ascending">TotalPayment</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Status: activate to sort column ascending">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Type: activate to sort column ascending">Type</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label="Actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr role="row" class="odd">
                                            <td class="sorting_1" tabindex="0">0007-3230</td>
                                            <td>RU</td>
                                            <td>Bilyarsk</td>
                                            <td>Kuhlman-Bosco</td>
                                            <td>5899 Basil Place</td>
                                            <td>ablick18@pinterest.com</td>
                                            <td>Ashley Blick</td>
                                            <td>Cummings-Goodwin</td>
                                            <td>RUB</td>
                                            <td>Electronics</td>
                                            <td style="">54.9794837</td>
                                            <td style="">50.3850925</td>
                                            <td style="display: none;">10/1/2016</td>
                                            <td style="display: none;">2016-01-07 03:02:49</td>
                                            <td style="display: none;">Europe/Moscow</td>
                                            <td style="display: none;">$902481.80</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--success m-badge--wide">Success</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-primary">Retail</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1" tabindex="0">0093-1016</td>
                                            <td>ID</td>
                                            <td>Merdeka</td>
                                            <td>Pfannerstill-Jenkins</td>
                                            <td>3150 Cherokee Center</td>
                                            <td>gclampo@vistaprint.com</td>
                                            <td>Gusti Clamp</td>
                                            <td>Stokes Group</td>
                                            <td>IDR</td>
                                            <td>Grocery</td>
                                            <td style="">-6.9136675</td>
                                            <td style="">107.6200524</td>
                                            <td style="display: none;">4/12/2018</td>
                                            <td style="display: none;">2017-10-06 00:23:49</td>
                                            <td style="display: none;">Asia/Makassar</td>
                                            <td style="display: none;">$158287.28</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--danger m-badge--wide">Danger</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-primary">Retail</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd">
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
                                            <td style="">23.2905</td>
                                            <td style="">113.234549</td>
                                            <td style="display: none;">3/6/2018</td>
                                            <td style="display: none;">2016-01-01 18:08:34</td>
                                            <td style="display: none;">Asia/Chongqing</td>
                                            <td style="display: none;">$429312.02</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--success m-badge--wide">Success</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-primary">Retail</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="even">
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
                                            <td style="">29.503085</td>
                                            <td style="">108.984759</td>
                                            <td style="display: none;">4/2/2017</td>
                                            <td style="display: none;">2016-08-05 06:19:54</td>
                                            <td style="display: none;">Asia/Chongqing</td>
                                            <td style="display: none;">$1143125.96</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--primary m-badge--wide">Canceled</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" tabindex="0">0187-2201</td>
                                            <td>BR</td>
                                            <td>Rio das Ostras</td>
                                            <td>Leffler LLC</td>
                                            <td>5722 Buhler Place</td>
                                            <td>spuvia14@alexa.com</td>
                                            <td>Shaw Puvia</td>
                                            <td>Veum LLC</td>
                                            <td>BRL</td>
                                            <td>Electronics</td>
                                            <td style="">-22.4206096</td>
                                            <td style="">-41.8625084</td>
                                            <td style="display: none;">6/10/2017</td>
                                            <td style="display: none;">2016-04-21 02:47:05</td>
                                            <td style="display: none;">America/Sao_Paulo</td>
                                            <td style="display: none;">$340528.17</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--primary m-badge--wide">Canceled</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-primary">Retail</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
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
                                            <td style="">33.9278354</td>
                                            <td style="">-6.9051819</td>
                                            <td style="display: none;">6/4/2016</td>
                                            <td style="display: none;">2016-06-13 16:43:18</td>
                                            <td style="display: none;">Africa/Casablanca</td>
                                            <td style="display: none;">$285288.32</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--info m-badge--wide">Info</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--accent m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-accent">Direct</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
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
                                            <td style="">8.797145</td>
                                            <td style="">-75.698571</td>
                                            <td style="display: none;">3/31/2017</td>
                                            <td style="display: none;">2018-02-23 01:18:36</td>
                                            <td style="display: none;">America/Bogota</td>
                                            <td style="display: none;">$124768.15</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--metal m-badge--wide">Delivered</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1" tabindex="0">10819-6003</td>
                                            <td>FR</td>
                                            <td>Rivesaltes</td>
                                            <td>Stiedemann-Weissnat</td>
                                            <td>4981 Springs Center</td>
                                            <td>mlaurencot1a@google.com</td>
                                            <td>Mellisa Laurencot</td>
                                            <td>Jacobs Group</td>
                                            <td>EUR</td>
                                            <td>Movies</td>
                                            <td style="">42.8271637</td>
                                            <td style="">2.9134412</td>
                                            <td style="display: none;">10/30/2017</td>
                                            <td style="display: none;">2017-09-21 03:09:00</td>
                                            <td style="display: none;">Europe/Paris</td>
                                            <td style="display: none;">$955141.22</td>
                                            <td style="display: none;"><span class="m-badge m-badge--brand m-badge--wide">Pending</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd">
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
                                            <td style="">-19.9241693</td>
                                            <td style="">-48.3811173</td>
                                            <td style="display: none;">2/21/2018</td>
                                            <td style="display: none;">2016-08-06 05:33:25</td>
                                            <td style="display: none;">America/Sao_Paulo</td>
                                            <td style="display: none;">$1096683.96</td>
                                            <td style="display: none;"><span class="m-badge m-badge--brand m-badge--wide">Pending</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--primary m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-primary">Retail</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="even">
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
                                            <td style="">-10.3931514</td>
                                            <td style="">39.1361568</td>
                                            <td style="display: none;">2/18/2018</td>
                                            <td style="display: none;">2016-08-06 20:08:36</td>
                                            <td style="display: none;">Africa/Dar_es_Salaam</td>
                                            <td style="display: none;">$290437.32</td>
                                            <td style="display: none;"><span class="m-badge  m-badge--primary m-badge--wide">Canceled</span></td>
                                            <td style="display: none;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></td>
                                            <td nowrap="" style="display: none;">
                                                <span class="dropdown">
                                                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                                        <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                                    </div>
                                                </span>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">OrderID</th>
                                            <th rowspan="1" colspan="1">ShipCountry</th>
                                            <th rowspan="1" colspan="1">ShipCity</th>
                                            <th rowspan="1" colspan="1">ShipName</th>
                                            <th rowspan="1" colspan="1">ShipAddress</th>
                                            <th rowspan="1" colspan="1">CompanyEmail</th>
                                            <th rowspan="1" colspan="1">CompanyAgent</th>
                                            <th rowspan="1" colspan="1">CompanyName</th>
                                            <th rowspan="1" colspan="1">Currency</th>
                                            <th rowspan="1" colspan="1">Department</th>
                                            <th rowspan="1" colspan="1" style="">Latitude</th>
                                            <th rowspan="1" colspan="1" style="">Longitude</th>
                                            <th rowspan="1" colspan="1" style="display: none;">ShipDate</th>
                                            <th rowspan="1" colspan="1" style="display: none;">PaymentDate</th>
                                            <th rowspan="1" colspan="1" style="display: none;">TimeZone</th>
                                            <th rowspan="1" colspan="1" style="display: none;">TotalPayment</th>
                                            <th rowspan="1" colspan="1" style="display: none;">Status</th>
                                            <th rowspan="1" colspan="1" style="display: none;">Type</th>
                                            <th rowspan="1" colspan="1" style="display: none;">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row justify-content-between ">
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

    <script src="<?php echo JS_PATH; ?>vendors/datatables.js"></script>
    <script src="<?php echo JS_PATH; ?>responsive.js"></script>

    <script>
        $(document).ready(function() {
    $('#m_table_1').DataTable({
        responsive: true
    });
} );
    </script>
</body>


</html>