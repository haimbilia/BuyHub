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

                                List Datatable </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Apps </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Users </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    List - Datatable </a>
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
                    <!--begin::card-->
                    <div class="card">
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
                                    <div class="card-head-actions">
                                        <div class="dropdown dropdown-inline">
                                            <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Add Coloumn
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="nav nav--block">

                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                    <li class="dropdown-item nav__item">
                                                        <label class="checkbox"><input type="checkbox" value="1">
                                                            Coloumn Name
                                                            <span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body card__body--fit">
                            <div class="p-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 my-2 my-md-0">
                                            <div class="input-icon input-icon--left">
												<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
												<span class="input-icon__icon input-icon__icon--left">
													<span><i class="la la-search"></i></span>
												</span>
											</div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <select class="form-control"  >
                                                    <option value="">All</option>
                                                    <option value="1">Pending</option>
                                                    <option value="2">Delivered</option>
                                                    <option value="3">Canceled</option>
                                                    <option value="4">Success</option>
                                                    <option value="5">Info</option>
                                                    <option value="6">Danger</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <select class="form-control"  >
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
                                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                        <button type="button" class="btn btn-brand">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="datatable datatable-sticky scroll scroll-y scroll-x">
                                <table class="datatable__table ">
                                    <thead class="datatable__head">
                                        <tr class="datatable__row">
                                            <th data-field="AgentName" class="datatable_cell datatable_cell-sort datatable_cell_top datatable_cell_left"><span>User</span></th>
                                            <th data-field="Country" class="datatable_cell datatable_cell-sort datatable_cell_top"><span>Country</span></th>
                                            <th data-field="Header" class="datatable_cell datatable_cell-sort datatable_cell_top"><span>Header 3 with longer content </span></th>
                                            <th data-field="ShipDate" class="datatable_cell datatable_cell-sort datatable_cell_top"><span>Ship Date</span></th>
                                            <th data-field="ShipName" data-autohide-disabled="false" class="datatable_cell datatable_cell-sort datatable_cell-sorted datatable_cell_top" data-sort="asc"><span>Company<i class="flaticon2-arrow-up"></i></span></th>
                                            <th data-field="Status" class="datatable_cell datatable_cell-sort datatable_cell_top"><span>Status</span></th>
                                            <th data-field="Type" data-autohide-disabled="false" class="datatable_cell datatable_cell-sort datatable_cell_top"><span>Type</span></th>
                                            <th data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right datatable_cell_top"><span>Actions</span></th>

                                        </tr>
                                    </thead>
                                    <tbody class="datatable__body">
                                        <tr data-row="0" class="datatable__row">

                                            <th data-field="AgentName" class="datatable_cell datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic">
                                                            <div class="badge badge--xl badge--info">T</div>
                                                        </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Tuck O'Dowgaine</a> <span class="user-card-v2__desc">Developer</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Ethiopia ET</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>5/6/2017</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo1.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Simonis, Rowe and Davis</a> <span class="user-card-v2__email">Angular, React</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-brand">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="1" class="datatable__row datatable__row--even">

                                            <th data-field="AgentName" class="datatable_cell datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic">
                                                            <div class="badge badge--xl badge--danger">F</div>
                                                        </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Freida Morby</a> <span class="user-card-v2__desc">Manager</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Colombia CO</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>3/31/2017</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo2.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Haley, Schamberger and Durgan</a> <span class="user-card-v2__email">Vue, Kendo</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger">Processing</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell  datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="2" class="datatable__row">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_6.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Jerrome Colvie</a> <span class="user-card-v2__desc">Sales</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Russia RU</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>3/4/2016</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo3.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Kreiger, Glover and Connelly</a> <span class="user-card-v2__email">.NET, Oracle, MySQL</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell  datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="3" class="datatable__row datatable__row--even">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_7.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Bryn Peascod</a> <span class="user-card-v2__desc">Sales</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Portugal PT</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>5/22/2016</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo4.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Larkin and Sons</a> <span class="user-card-v2__email">Node, SASS, Webpack</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger">Done</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell  datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="4" class="datatable__row">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_8.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Freda Arnall</a> <span class="user-card-v2__desc">CEO</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Libya LY</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>7/22/2016</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo5.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Dicki, Morar and Stiedemann</a> <span class="user-card-v2__email">MangoDB, Java</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell  datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="5" class="datatable__row datatable__row--even">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_9.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Chrissie Jeromson</a> <span class="user-card-v2__desc">CEO</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Japan JP</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>11/26/2017</span></td>
                                            <td class="datatable_cell-sorted datatable_cell " data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo3.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Brakus-McCullough</a> <span class="user-card-v2__email">.NET, Oracle, MySQL</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger">Processing</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell  datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="6" class="datatable__row">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_10.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Nixie Sailor</a> <span class="user-card-v2__desc">CEO</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>China CN</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>2/12/2018</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo4.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Gleichner, Ziemann and Gutkowski</a> <span class="user-card-v2__email">Node, SASS, Webpack</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">Success</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="7" class="datatable__row datatable__row--even">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_11.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Yardley Wetherell</a> <span class="user-card-v2__desc">CEO</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>China CN</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>4/3/2017</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo5.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Gerlach-Schultz</a> <span class="user-card-v2__email">MangoDB, Java</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger">Processing</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="8" class="datatable__row">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_12.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Sioux Kneath</a> <span class="user-card-v2__desc">Architect</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Portugal PT</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>10/11/2017</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo3.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Rice, Cole and Spinka</a> <span class="user-card-v2__email">.NET, Oracle, MySQL</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">Delivered</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span></td>
                                        </tr>
                                        <tr data-row="9" class="datatable__row datatable__row--even">

                                            <th data-field="AgentName" class="datatable_cell  datatable_cell_left"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_10.jpg"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Michaelina Plenderleith</a> <span class="user-card-v2__desc">Architect</span> </div>
                                                    </div>
                                                </span></th>
                                            <td data-field="Country" class="datatable_cell"><span>Brazil BR</span></td>
                                            <td data-field="Cell" class="datatable_cell"><span>Cell content longer Cell content longer Cell content longer Cell content longer Cell content longer</span></td>
                                            <td data-field="ShipDate" class="datatable_cell"><span>2/21/2018</span></td>
                                            <td class="datatable_cell-sorted datatable_cell" data-field="ShipName" data-autohide-disabled="false"><span>
                                                    <div class="user-card-v2">
                                                        <div class="user-card-v2__pic"> <img alt="photo" src="media/client-logos/logo4.png"> </div>
                                                        <div class="user-card-v2__details"> <a class="user-card-v2__name" href="#">Legros-Gleichner</a> <span class="user-card-v2__email">Node, SASS, Webpack</span> </div>
                                                    </div>
                                                </span></td>
                                            <td data-field="Status" class="datatable_cell"><span><span class="btn btn-bold btn-sm btn-font-sm  btn-label-brand">Pending</span></span></td>
                                            <td data-field="Type" data-autohide-disabled="false" class="datatable_cell"><span><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable_cell datatable_cell_right"><span>
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="flaticon-more-1"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav">
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-expand"></i> <span class="nav__link-text">View</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-contract"></i> <span class="nav__link-text">Edit</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-trash"></i> <span class="nav__link-text">Delete</span> </a> </li>
                                                                <li class="nav__item"> <a class="nav__link" href="#"> <i class="nav__link-icon flaticon2-mail-1"></i> <span class="nav__link-text">Export</span> </a> </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!--end::card-->


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