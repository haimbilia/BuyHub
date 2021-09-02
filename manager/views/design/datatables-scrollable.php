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

		<div class="body" id="body">
			<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

				<!-- begin:: Subheader -->
				<div id="subheader" class="subheader" >
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Scrollable Examples</h3>

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
									Basic </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Scrollable Tables </a>
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
							This example shows a vertically scrolling DataTable that makes use of the CSS3 vh unit in order to dynamically resize the viewport based on the browser window height.
						</div>
					</div>

					<div class="card card--mobile">
						<div class="card-head card-head--lg">
							<div class="card-head-label">
								<span class="card-head-icon">
									<i class="font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="card-head-title">
									Scrollable Table
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
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px none; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 1253px; padding-right: 17px;">
													<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer" role="grid" style="margin-left: 0px; width: 1253px;">
														<thead>
															<tr role="row">
																<th class="sorting_asc" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 54.9833px;" aria-sort="ascending" aria-label="Record ID: activate to sort column descending">Record ID</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 60.2333px;" aria-label="Order ID: activate to sort column ascending">Order ID</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 77.4833px;" aria-label="Country: activate to sort column ascending">Country</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 90.8333px;" aria-label="Ship City: activate to sort column ascending">Ship City</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 109.533px;" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 95.3333px;" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 130.317px;" aria-label="Company Name: activate to sort column ascending">Company Name</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 54.9833px;" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 48.5833px;" aria-label="Status: activate to sort column ascending">Status</th>
																<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 32.2333px;" aria-label="Type: activate to sort column ascending">Type</th>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 69.4833px;" aria-label="Actions">Actions</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%; max-height: 50vh;">
												<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer" id="table_1" role="grid" aria-describedby="table_1_info" style="width: 1256px;">
													<thead>
														<tr role="row" style="height: 0px;">
															<th class="sorting_asc" aria-controls="table_1" rowspan="1" colspan="1" style="width: 54.9833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-sort="ascending" aria-label="Record ID: activate to sort column descending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Record ID</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 60.2333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Order ID: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Order ID</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 77.4833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Country: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Country</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 90.8333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship City: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship City</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 109.533px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Address: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Address</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 95.3333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Company Agent: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Company Agent</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 130.317px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Company Name: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Company Name</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 54.9833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Date: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Date</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 48.5833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Status: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Status</div>
															</th>
															<th class="sorting" aria-controls="table_1" rowspan="1" colspan="1" style="width: 32.2333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Type: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Type</div>
															</th>
															<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 69.4833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Actions">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Actions</div>
															</th>
														</tr>
													</thead>


													<tbody>










														<tr role="row" class="odd">
															<td class="sorting_1">1</td>
															<td>61715-075</td>
															<td>China</td>
															<td>Tieba</td>
															<td>746 Pine View Junction</td>
															<td>Nixie Sailor</td>
															<td>Gleichner, Ziemann and Gutkowski</td>
															<td>2/12/2018</td>
															<td><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
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
															<td class="sorting_1">2</td>
															<td>63629-4697</td>
															<td>Indonesia</td>
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
															<td class="sorting_1">3</td>
															<td>68084-123</td>
															<td>Argentina</td>
															<td>Puerto Iguazú</td>
															<td>2 Pine View Park</td>
															<td>Ula Luckin</td>
															<td>Kulas, Cassin and Batz</td>
															<td>5/26/2016</td>
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
															<td class="sorting_1">4</td>
															<td>67457-428</td>
															<td>Indonesia</td>
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
														<tr role="row" class="odd">
															<td class="sorting_1">5</td>
															<td>31722-529</td>
															<td>Austria</td>
															<td>Sankt Andrä-Höch</td>
															<td>3038 Trailsway Junction</td>
															<td>Tierney St. Louis</td>
															<td>Dicki-Kling</td>
															<td>5/20/2017</td>
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
															<td class="sorting_1">6</td>
															<td>64117-168</td>
															<td>China</td>
															<td>Rongkou</td>
															<td>023 South Way</td>
															<td>Gerhard Reinhard</td>
															<td>Gleason, Kub and Marquardt</td>
															<td>11/26/2016</td>
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
														<tr role="row" class="odd">
															<td class="sorting_1">7</td>
															<td>43857-0331</td>
															<td>China</td>
															<td>Baiguo</td>
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
															<td class="sorting_1">8</td>
															<td>64980-196</td>
															<td>Croatia</td>
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
														<tr role="row" class="odd">
															<td class="sorting_1">9</td>
															<td>0404-0360</td>
															<td>Colombia</td>
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
														<tr role="row" class="even">
															<td class="sorting_1">10</td>
															<td>52125-267</td>
															<td>Thailand</td>
															<td>Maha Sarakham</td>
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
													</tbody>

												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-5">
										<div class="dataTables_info" id="table_1_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div>
									</div>
									<div class="col-sm-12 col-md-7">
										<div class="dataTables_paginate paging_simple_numbers" id="table_1_paginate">
											<ul class="pagination">
												<li class="paginate_button page-item previous disabled" id="table_1_previous"><a href="#" aria-controls="table_1" data-dt-idx="0" tabindex="0" class="page-link"><i class="la la-angle-left"></i></a></li>
												<li class="paginate_button page-item active"><a href="#" aria-controls="table_1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_1" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
												<li class="paginate_button page-item next" id="table_1_next"><a href="#" aria-controls="table_1" data-dt-idx="6" tabindex="0" class="page-link"><i class="la la-angle-right"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<!--end: Datatable -->
						</div>
					</div>

					<div class="card card--mobile">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Scrollable Horizontal &amp; Vertical DataTable
								</h3>
							</div>
						</div>

						<div class="card-body">
							<!--begin: Datatable -->
							<div id="table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
								<div class="row">
									<div class="col-sm-12 col-md-6">
										<div class="dataTables_length" id="table_2_length"><label>Show <select name="table_2_length" aria-controls="table_2" class="custom-select custom-select-sm form-control form-control-sm">
													<option value="10">10</option>
													<option value="25">25</option>
													<option value="50">50</option>
													<option value="100">100</option>
												</select> entries</label></div>
									</div>
									<div class="col-sm-12 col-md-6">
										<div id="table_2_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="table_2"></label></div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px none; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 2221.4px; padding-right: 17px;">
													<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer" role="grid" style="margin-left: 0px; width: 2221.4px;">
														<thead>
															<tr role="row">
																<th class="sorting_asc" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 46.15px;" aria-sort="ascending" aria-label="Record ID: activate to sort column descending">Record ID</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 59.6333px;" aria-label="Order ID: activate to sort column ascending">Order ID</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 52.6167px;" aria-label="Ship Country: activate to sort column ascending">Ship Country</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 44.6833px;" aria-label="Ship City: activate to sort column ascending">Ship City</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 54.9167px;" aria-label="Ship Name: activate to sort column ascending">Ship Name</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 53.6167px;" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 171.067px;" aria-label="Company Email: activate to sort column ascending">Company Email</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 65.4833px;" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 66.6167px;" aria-label="Company Name: activate to sort column ascending">Company Name</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 60.3px;" aria-label="Currency: activate to sort column ascending">Currency</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 79.4833px;" aria-label="Department: activate to sort column ascending">Department</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 96.5833px;" aria-label="Website: activate to sort column ascending">Website</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 53.0333px;" aria-label="Latitude: activate to sort column ascending">Latitude</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 64.85px;" aria-label="Longitude: activate to sort column ascending">Longitude</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 46.5px;" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 58.9px;" aria-label="Payment Date: activate to sort column ascending">Payment Date</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 102.35px;" aria-label="Time Zone: activate to sort column ascending">Time Zone</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 58.9px;" aria-label="Total Payment: activate to sort column ascending">Total Payment</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 48.5833px;" aria-label="Status: activate to sort column ascending">Status</th>
																<th class="sorting" tabindex="0" aria-controls="table_2" rowspan="1" colspan="1" style="width: 31.7333px;" aria-label="Type: activate to sort column ascending">Type</th>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 68.9px;" aria-label="Actions">Actions</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%; max-height: 50vh;">
												<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer" id="table_2" role="grid" aria-describedby="table_2_info" style="width: 2292px;">
													<thead>
														<tr role="row" style="height: 0px;">
															<th class="sorting_asc" aria-controls="table_2" rowspan="1" colspan="1" style="width: 46.15px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-sort="ascending" aria-label="Record ID: activate to sort column descending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Record ID</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 59.6333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Order ID: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Order ID</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 52.6167px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Country: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Country</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 44.6833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship City: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship City</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 54.9167px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Name: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Name</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 53.6167px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Address: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Address</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 171.067px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Company Email: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Company Email</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 65.4833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Company Agent: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Company Agent</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 66.6167px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Company Name: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Company Name</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 60.3px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Currency: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Currency</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 79.4833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Department: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Department</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 96.5833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Website: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Website</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 53.0333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Latitude: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Latitude</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 64.85px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Longitude: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Longitude</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 46.5px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Ship Date: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Ship Date</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 58.9px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Payment Date: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Payment Date</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 102.35px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Time Zone: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Time Zone</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 58.9px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Total Payment: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Total Payment</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 48.5833px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Status: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Status</div>
															</th>
															<th class="sorting" aria-controls="table_2" rowspan="1" colspan="1" style="width: 31.7333px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Type: activate to sort column ascending">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Type</div>
															</th>
															<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 68.9px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Actions">
																<div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Actions</div>
															</th>
														</tr>
													</thead>


													<tbody>










														<tr role="row" class="odd">
															<td class="sorting_1">1</td>
															<td>61715-075</td>
															<td>CN</td>
															<td>Tieba</td>
															<td>Collins, Dibbert and Hoeger</td>
															<td>746 Pine View Junction</td>
															<td>nsailor0@livejournal.com</td>
															<td>Nixie Sailor</td>
															<td>Gleichner, Ziemann and Gutkowski</td>
															<td>CNY</td>
															<td>Outdoors</td>
															<td>irs.gov</td>
															<td>35.0032213</td>
															<td>102.913526</td>
															<td>2/12/2018</td>
															<td>2016-04-27 23:53:15</td>
															<td>Asia/Chongqing</td>
															<td>$246154.65</td>
															<td><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></td>
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
															<td class="sorting_1">2</td>
															<td>63629-4697</td>
															<td>ID</td>
															<td>Cihaur</td>
															<td>Prosacco-Breitenberg</td>
															<td>01652 Fulton Trail</td>
															<td>egiraldez1@seattletimes.com</td>
															<td>Emelita Giraldez</td>
															<td>Rosenbaum-Reichel</td>
															<td>IDR</td>
															<td>Toys</td>
															<td>ameblo.jp</td>
															<td>-7.1221059</td>
															<td>106.5701927</td>
															<td>8/6/2017</td>
															<td>2017-11-13 14:37:22</td>
															<td>Asia/Jakarta</td>
															<td>$795849.41</td>
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
															<td class="sorting_1">3</td>
															<td>68084-123</td>
															<td>AR</td>
															<td>Puerto Iguazú</td>
															<td>Lebsack-Emard</td>
															<td>2 Pine View Park</td>
															<td>uluckin2@state.gov</td>
															<td>Ula Luckin</td>
															<td>Kulas, Cassin and Batz</td>
															<td>ARS</td>
															<td>Electronics</td>
															<td>pbs.org</td>
															<td>-25.6112339</td>
															<td>-54.5515662</td>
															<td>5/26/2016</td>
															<td>2018-01-22 12:01:51</td>
															<td>America/Argentina/Cordoba</td>
															<td>$830764.07</td>
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
															<td class="sorting_1">4</td>
															<td>67457-428</td>
															<td>ID</td>
															<td>Talok</td>
															<td>O'Conner, Lebsack and Romaguera</td>
															<td>3050 Buell Terrace</td>
															<td>ecure3@trellian.com</td>
															<td>Evangeline Cure</td>
															<td>Pfannerstill-Treutel</td>
															<td>IDR</td>
															<td>Automotive</td>
															<td>fastcompany.com</td>
															<td>1.05</td>
															<td>118.8</td>
															<td>7/2/2016</td>
															<td>2017-05-26 08:31:15</td>
															<td>Asia/Jakarta</td>
															<td>$777892.92</td>
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
															<td class="sorting_1">5</td>
															<td>31722-529</td>
															<td>AT</td>
															<td>Sankt Andrä-Höch</td>
															<td>Stehr-Kunde</td>
															<td>3038 Trailsway Junction</td>
															<td>tst4@msn.com</td>
															<td>Tierney St. Louis</td>
															<td>Dicki-Kling</td>
															<td>EUR</td>
															<td>Health</td>
															<td>jimdo.com</td>
															<td>46.791555</td>
															<td>15.379192</td>
															<td>5/20/2017</td>
															<td>2016-02-17 10:53:48</td>
															<td>Europe/Vienna</td>
															<td>$516467.41</td>
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
															<td class="sorting_1">6</td>
															<td>64117-168</td>
															<td>CN</td>
															<td>Rongkou</td>
															<td>O'Hara LLC</td>
															<td>023 South Way</td>
															<td>greinhard5@instagram.com</td>
															<td>Gerhard Reinhard</td>
															<td>Gleason, Kub and Marquardt</td>
															<td>CNY</td>
															<td>Electronics</td>
															<td>cocolog-nifty.com</td>
															<td>37.646108</td>
															<td>120.477813</td>
															<td>11/26/2016</td>
															<td>2018-02-08 07:09:18</td>
															<td>Asia/Shanghai</td>
															<td>$410062.16</td>
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
														<tr role="row" class="odd">
															<td class="sorting_1">7</td>
															<td>43857-0331</td>
															<td>CN</td>
															<td>Baiguo</td>
															<td>Lebsack Group</td>
															<td>56482 Fairfield Terrace</td>
															<td>eshelley6@pcworld.com</td>
															<td>Englebert Shelley</td>
															<td>Jenkins Inc</td>
															<td>CNY</td>
															<td>Garden</td>
															<td>cdc.gov</td>
															<td>26.006775</td>
															<td>104.512603</td>
															<td>6/28/2016</td>
															<td>2017-10-01 05:29:08</td>
															<td>Asia/Chongqing</td>
															<td>$210902.65</td>
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
															<td class="sorting_1">8</td>
															<td>64980-196</td>
															<td>HR</td>
															<td>Vinica</td>
															<td>Gutkowski LLC</td>
															<td>0 Elka Street</td>
															<td>hkite7@epa.gov</td>
															<td>Hazlett Kite</td>
															<td>Streich LLC</td>
															<td>HRK</td>
															<td>Automotive</td>
															<td>accuweather.com</td>
															<td>46.3395131</td>
															<td>16.1537893</td>
															<td>8/5/2016</td>
															<td>2017-04-29 22:07:06</td>
															<td>Europe/Zagreb</td>
															<td>$1162836.25</td>
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
														<tr role="row" class="odd">
															<td class="sorting_1">9</td>
															<td>0404-0360</td>
															<td>CO</td>
															<td>San Carlos</td>
															<td>Bartoletti, Howell and Jacobson</td>
															<td>38099 Ilene Hill</td>
															<td>fmorby8@surveymonkey.com</td>
															<td>Freida Morby</td>
															<td>Haley, Schamberger and Durgan</td>
															<td>COP</td>
															<td>Garden</td>
															<td>trellian.com</td>
															<td>8.797145</td>
															<td>-75.698571</td>
															<td>3/31/2017</td>
															<td>2018-02-23 01:18:36</td>
															<td>America/Bogota</td>
															<td>$124768.15</td>
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
														<tr role="row" class="even">
															<td class="sorting_1">10</td>
															<td>52125-267</td>
															<td>TH</td>
															<td>Maha Sarakham</td>
															<td>Schroeder-Champlin</td>
															<td>8696 Barby Pass</td>
															<td>ohelian9@usatoday.com</td>
															<td>Obed Helian</td>
															<td>Labadie, Predovic and Hammes</td>
															<td>THB</td>
															<td>Kids</td>
															<td>gizmodo.com</td>
															<td>16.1991156</td>
															<td>103.2839975</td>
															<td>1/26/2017</td>
															<td>2016-01-17 18:58:57</td>
															<td>Asia/Bangkok</td>
															<td>$531999.26</td>
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
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-5">
										<div class="dataTables_info" id="table_2_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div>
									</div>
									<div class="col-sm-12 col-md-7">
										<div class="dataTables_paginate paging_simple_numbers" id="table_2_paginate">
											<ul class="pagination">
												<li class="paginate_button page-item previous disabled" id="table_2_previous"><a href="#" aria-controls="table_2" data-dt-idx="0" tabindex="0" class="page-link"><i class="la la-angle-left"></i></a></li>
												<li class="paginate_button page-item active"><a href="#" aria-controls="table_2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
												<li class="paginate_button page-item "><a href="#" aria-controls="table_2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
												<li class="paginate_button page-item next" id="table_2_next"><a href="#" aria-controls="table_2" data-dt-idx="6" tabindex="0" class="page-link"><i class="la la-angle-right"></i></a></li>
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