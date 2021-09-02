<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
	<meta charset="utf-8" />
	<title>FATbit | Dashboard</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<script>
		WebFont.load({
			google: {
				"families": ["Poppins:300,400,500,600,700"]
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
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

								ColReorder Examples </h3>

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
									ColReorder </a>
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
							ColReorder adds the ability for the end user to be able to reorder columns in a DataTable through a click and drag operation.
							See official documentation <a class="link font-bold" href="https://datatables.net/extensions/colreorder/" target="_blank">here</a>.
						</div>
					</div>

					<div class="card card--mobile">
						<div class="card-head card-head--lg">
							<div class="card-head-label">
								<span class="card-head-icon">
									<i class="font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="card-head-title">
									ColReorder DataTable
								</h3>
							</div>
							<div class="card-head-toolbar">
								<div class="card-head-wrapper">
									<div class="card-head-actions">
										<div class="dropdown dropdown-inline">
											<button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="la la-download"></i> Export
											</button>
											<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(115px, 38px, 0px);">
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
							<div id="table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
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
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="table_1" role="grid" aria-describedby="table_1_info" style="width: 1274px;">
											<thead>
												<tr role="row">
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 55.25px;" data-column-index="0" aria-label="Record ID: activate to sort column ascending">Record ID</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 60.25px;" data-column-index="1" aria-label="Order ID: activate to sort column ascending">Order ID</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 80.25px;" data-column-index="2" aria-label="Country: activate to sort column ascending">Country</th>
													<th class="sorting_asc" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 95.25px;" data-column-index="3" aria-label="Ship City: activate to sort column descending" aria-sort="ascending">Ship City</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 116.25px;" data-column-index="4" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 98.25px;" data-column-index="5" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 137.25px;" data-column-index="6" aria-label="Company Name: activate to sort column ascending">Company Name</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 56.25px;" data-column-index="7" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 46.25px;" data-column-index="8" aria-label="Status: activate to sort column ascending">Status</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 32.25px;" data-column-index="9" aria-label="Type: activate to sort column ascending">Type</th>
													<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 69.5px;" data-column-index="10" aria-label="Actions">Actions</th>
												</tr>
											</thead>

											<tbody>










												<tr role="row" class="odd">
													<td class="" tabindex="0">30</td>
													<td class="">27495-006</td>
													<td class="">Portugal</td>
													<td class="sorting_1">Arrifes</td>
													<td>3 Fairfield Junction</td>
													<td>Vernon Cosham</td>
													<td>Kreiger-Nicolas</td>
													<td>2/8/2017</td>
													<td><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
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
												<tr role="row" class="even">
													<td class="" tabindex="0">15</td>
													<td class="">36987-3005</td>
													<td class="">Portugal</td>
													<td class="sorting_1">Bacelo</td>
													<td>548 Morrow Terrace</td>
													<td>Christa Jacmar</td>
													<td>Brakus-Hansen</td>
													<td>8/17/2017</td>
													<td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
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
													<td tabindex="0" class="">7</td>
													<td class="">43857-0331</td>
													<td class="">China</td>
													<td class="sorting_1">Baiguo</td>
													<td>56482 Fairfield Terrace</td>
													<td>Englebert Shelley</td>
													<td>Jenkins Inc</td>
													<td>6/28/2016</td>
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
													<td class="" tabindex="0">14</td>
													<td class="">40076-953</td>
													<td class="">Portugal</td>
													<td class="sorting_1">Burgau</td>
													<td>52550 Crownhardt Court</td>
													<td>Sioux Kneath</td>
													<td>Rice, Cole and Spinka</td>
													<td>10/11/2017</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">11</td>
													<td class="">54092-515</td>
													<td class="">Brazil</td>
													<td class="sorting_1">Canguaretama</td>
													<td>32461 Ridgeway Alley</td>
													<td>Sibyl Amy</td>
													<td>Treutel-Ratke</td>
													<td>3/8/2017</td>
													<td><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
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
												<tr role="row" class="even">
													<td tabindex="0" class="">2</td>
													<td class="">63629-4697</td>
													<td class="">Indonesia</td>
													<td class="sorting_1">Cihaur</td>
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
													<td class="" tabindex="0">18</td>
													<td class="">11673-479</td>
													<td class="">Brazil</td>
													<td class="sorting_1">Conceição das Alagoas</td>
													<td>191 Stone Corner Road</td>
													<td>Michaelina Plenderleith</td>
													<td>Legros-Gleichner</td>
													<td>2/21/2018</td>
													<td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
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
												<tr role="row" class="even">
													<td class="" tabindex="0">36</td>
													<td class="">55289-002</td>
													<td class="">Philippines</td>
													<td class="sorting_1">Dologon</td>
													<td>9 Vidon Terrace</td>
													<td>Hubey Passby</td>
													<td>Lemke-Hermiston</td>
													<td>6/29/2017</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">28</td>
													<td class="">49035-522</td>
													<td class="">Australia</td>
													<td class="sorting_1">Eastern Suburbs Mc</td>
													<td>074 Algoma Drive</td>
													<td>Heddi Castelli</td>
													<td>Kessler and Sons</td>
													<td>1/12/2017</td>
													<td><span class="badge  badge--info badge--inline badge--pill">Info</span></td>
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
													<td class="" tabindex="0">27</td>
													<td class="">51523-026</td>
													<td class="">Germany</td>
													<td class="sorting_1">Erfurt</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">40</td>
													<td class="">51327-510</td>
													<td class="">Philippines</td>
													<td class="sorting_1">Esperanza</td>
													<td>4 Linden Court</td>
													<td>Natka Fairbanks</td>
													<td>Mueller-Greenholt</td>
													<td>6/21/2017</td>
													<td><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
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
													<td class="" tabindex="0">22</td>
													<td class="">49348-055</td>
													<td class="">China</td>
													<td class="sorting_1">Guxi</td>
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
													<td class="" tabindex="0">12</td>
													<td class="">0185-0130</td>
													<td class="">China</td>
													<td class="sorting_1">Jiamachi</td>
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
												<tr role="row" class="even">
													<td class="" tabindex="0">26</td>
													<td class="">0093-5142</td>
													<td class="">China</td>
													<td class="sorting_1">Jianggao</td>
													<td>289 Badeau Alley</td>
													<td>Otis Jobbins</td>
													<td>Ruecker, Leffler and Abshire</td>
													<td>3/6/2018</td>
													<td><span class="badge  badge--success badge--inline badge--pill">Success</span></td>
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
													<td class="" tabindex="0">20</td>
													<td class="">42291-712</td>
													<td class="">Indonesia</td>
													<td class="sorting_1">Kembang</td>
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
													<td class="" tabindex="0">29</td>
													<td class="">58411-198</td>
													<td class="">Ethiopia</td>
													<td class="sorting_1">Kombolcha</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">35</td>
													<td class="">37000-102</td>
													<td class="">Paraguay</td>
													<td class="sorting_1">Los Cedrales</td>
													<td>1 Ridge Oak Way</td>
													<td>Penrod Allanby</td>
													<td>Rodriguez Group</td>
													<td>3/5/2018</td>
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
													<td tabindex="0" class="">10</td>
													<td class="">52125-267</td>
													<td class="">Thailand</td>
													<td class="sorting_1">Maha Sarakham</td>
													<td>8696 Barby Pass</td>
													<td>Obed Helian</td>
													<td>Labadie, Predovic and Hammes</td>
													<td>1/26/2017</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">25</td>
													<td class="">0093-1016</td>
													<td class="">Indonesia</td>
													<td class="sorting_1">Merdeka</td>
													<td>3150 Cherokee Center</td>
													<td>Gusti Clamp</td>
													<td>Stokes Group</td>
													<td>4/12/2018</td>
													<td><span class="badge  badge--danger badge--inline badge--pill">Danger</span></td>
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
												<tr role="row" class="even">
													<td class="" tabindex="0">24</td>
													<td class="">54569-0175</td>
													<td class="">Japan</td>
													<td class="sorting_1">Minato</td>
													<td>077 Hoffman Center</td>
													<td>Chrissie Jeromson</td>
													<td>Brakus-McCullough</td>
													<td>11/26/2017</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">37</td>
													<td class="">15127-874</td>
													<td class="">Tanzania</td>
													<td class="sorting_1">Nanganga</td>
													<td>33 Anniversary Parkway</td>
													<td>Magdaia Rotlauf</td>
													<td>Hettinger, Medhurst and Heaney</td>
													<td>2/18/2018</td>
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
												<tr role="row" class="even">
													<td class="" tabindex="0">17</td>
													<td class="">36987-2542</td>
													<td class="">Russia</td>
													<td class="sorting_1">Novokizhinginsk</td>
													<td>19427 Sloan Road</td>
													<td>Jerrome Colvie</td>
													<td>Kreiger, Glover and Connelly</td>
													<td>3/4/2016</td>
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
												<tr role="row" class="odd">
													<td class="" tabindex="0">16</td>
													<td class="">67510-0062</td>
													<td class="">South Africa</td>
													<td class="sorting_1">Pongola</td>
													<td>02534 Hauk Trail</td>
													<td>Shandee Goracci</td>
													<td>Bergnaum, Thiel and Schuppe</td>
													<td>7/24/2016</td>
													<td><span class="badge  badge--info badge--inline badge--pill">Info</span></td>
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
													<td tabindex="0" class="">3</td>
													<td class="">68084-123</td>
													<td class="">Argentina</td>
													<td class="sorting_1">Puerto Iguazú</td>
													<td>2 Pine View Park</td>
													<td>Ula Luckin</td>
													<td>Kulas, Cassin and Batz</td>
													<td>5/26/2016</td>
													<td><span class="badge badge--brand badge--inline badge--pill">Pending</span></td>
													<td><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></td>
													<td nowrap="">
														<span class="dropdown">
															<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
																<i class="la la-ellipsis-h"></i>
															</a>

															<div class="dropdown-menu dropdown-menu-right" style="display: none; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-32px, -6px, 0px);" x-placement="top-end">
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
													<td class="" tabindex="0">38</td>
													<td class="">49349-123</td>
													<td class="">Indonesia</td>
													<td class="sorting_1">Pule</td>
													<td>77292 Bonner Plaza</td>
													<td>Alfonse Lawrance</td>
													<td>Schuppe-Harber</td>
													<td>4/14/2017</td>
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

										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-5">
										<div class="dataTables_info" id="table_1_info" role="status" aria-live="polite">Showing 1 to 25 of 40 entries</div>
									</div>
									<div class="col-sm-12 col-md-7">
										<div class="dataTables_paginate paging_simple_numbers" id="table_1_paginate">
											<ul class="pagination">
												<li class="paginate_button page-item previous disabled" id="table_1_previous"><a href="#" aria-controls="table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="la la-angle-left"></i></a></li>
												<li class="paginate_button page-item active"><a href="#" aria-controls="table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
												<li class="paginate_button page-item next" id="table_1_next"><a href="#" aria-controls="table_1" data-dt-idx="3" tabindex="0" class="page-link"><i class="la la-angle-right"></i></a></li>
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