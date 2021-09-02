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

								Column Rendering </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Crud </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									FTDatatable </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Advanced </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Column Rendering </a>
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
							The Metronic Datatable allows flexible customization of its rows cells by exposing datatable and column schema object onto a callback function.
							In this example we shown how you can customize specific cell appearance using the datatable cell renderer callback function.
						</div>
					</div>

					<div class="card card--mobile">
						<div class="card-head card-head--lg">
							<div class="card-head-label">
								<span class="card-head-icon">
									<i class="font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="card-head-title">
									Column Rendering
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
														<div class="dropdown bootstrap-select form-control"><select class="form-control bootstrap-select" id="form_status" tabindex="-98">
																<option value="">All</option>
																<option value="1">Pending</option>
																<option value="2">Delivered</option>
																<option value="3">Canceled</option>
																<option value="4">Success</option>
																<option value="5">Info</option>
																<option value="6">Danger</option>
															</select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" data-id="form_status" title="All">
																<div class="filter-option">
																	<div class="filter-option-inner">
																		<div class="filter-option-inner-inner">All</div>
																	</div>
																</div>
															</button>
															<div class="dropdown-menu ">
																<div class="inner show" role="listbox" id="bs-select-1" tabindex="-1">
																	<ul class="dropdown-menu inner show" role="presentation"></ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4 margin-b-20-tablet-and-mobile">
												<div class="form__group form__group--inline">
													<div class="form__label">
														<label>Type:</label>
													</div>
													<div class="form__control">
														<div class="dropdown bootstrap-select form-control"><select class="form-control bootstrap-select" id="form_type" tabindex="-98">
																<option value="">All</option>
																<option value="1">Online</option>
																<option value="2">Retail</option>
																<option value="3">Direct</option>
															</select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" data-id="form_type" title="All">
																<div class="filter-option">
																	<div class="filter-option-inner">
																		<div class="filter-option-inner-inner">All</div>
																	</div>
																</div>
															</button>
															<div class="dropdown-menu ">
																<div class="inner show" role="listbox" id="bs-select-2" tabindex="-1">
																	<ul class="dropdown-menu inner show" role="presentation"></ul>
																</div>
															</div>
														</div>
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
							<div class="datatable datatable--default datatable--brand datatable--loaded" id="column_rendering" style="">
								<table class="datatable__table" style="display: block;">
									<thead class="datatable__head">
										<tr class="datatable__row" style="left: 0px;">
											<th data-field="RecordID" class="datatable__cell--center datatable__cell datatable__cell--sort datatable__cell--sorted" data-sort="asc"><span style="width: 30px;">#<i class="flaticon2-arrow-up"></i></span></th>
											<th data-field="OrderID" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Order ID</span></th>
											<th data-field="Country" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Country</span></th>
											<th data-field="ShipDate" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Ship Date</span></th>
											<th data-field="CompanyName" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Company Name</span></th>
											<th data-field="Status" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Status</span></th>
											<th data-field="Type" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 148px;">Type</span></th>
											<th data-field="Actions" data-autohide-disabled="false" class="datatable__cell datatable__cell--sort"><span style="width: 110px;">Actions</span></th>
										</tr>
									</thead>
									<tbody class="datatable__body" style="">
										<tr data-row="0" class="datatable__row" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">1</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--success">N</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Nixie Sailor</span> <a class="user-card-v2__email link" href="#">nsailor0@livejournal.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">2/12/2018</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Gleichner, Ziemann and Gutkowski</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--primary badge--inline badge--pill">Canceled</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="1" class="datatable__row datatable__row--even" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">2</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--danger">E</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Emelita Giraldez</span> <a class="user-card-v2__email link" href="#">egiraldez1@seattletimes.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Indonesia ID</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">8/6/2017</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Rosenbaum-Reichel</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="2" class="datatable__row" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">3</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--primary">U</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Ula Luckin</span> <a class="user-card-v2__email link" href="#">uluckin2@state.gov</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Argentina AR</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">5/26/2016</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Kulas, Cassin and Batz</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--primary badge--dot"></span>&nbsp;<span class="font-bold font-primary">Retail</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="3" class="datatable__row datatable__row--even" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">4</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--dark">E</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Evangeline Cure</span> <a class="user-card-v2__email link" href="#">ecure3@trellian.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Indonesia ID</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">7/2/2016</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Pfannerstill-Treutel</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--brand badge--inline badge--pill">Pending</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="4" class="datatable__row" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">5</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_11.jpg"> </div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Tierney St. Louis</span> <a class="user-card-v2__email link" href="#">tst4@msn.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Austria AT</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">5/20/2017</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Dicki-Kling</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="5" class="datatable__row datatable__row--even" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">6</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_12.jpg"> </div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Gerhard Reinhard</span> <a class="user-card-v2__email link" href="#">greinhard5@instagram.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">11/26/2016</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Gleason, Kub and Marquardt</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--info badge--inline badge--pill">Info</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="6" class="datatable__row" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">7</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--info">E</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Englebert Shelley</span> <a class="user-card-v2__email link" href="#">eshelley6@pcworld.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">China CN</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">6/28/2016</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Jenkins Inc</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--success badge--dot"></span>&nbsp;<span class="font-bold font-success">Direct</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="7" class="datatable__row datatable__row--even" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">8</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic">
															<div class="badge badge--xl badge--primary">H</div>
														</div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Hazlett Kite</span> <a class="user-card-v2__email link" href="#">hkite7@epa.gov</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Croatia HR</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">8/5/2016</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Streich LLC</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Danger</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="8" class="datatable__row" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">9</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_10.jpg"> </div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Freida Morby</span> <a class="user-card-v2__email link" href="#">fmorby8@surveymonkey.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Colombia CO</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">3/31/2017</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Haley, Schamberger and Durgan</span></td>
											<td data-field="Status" class="datatable__cell"><span style="width: 148px;"><span class="badge  badge--danger badge--inline badge--pill">Delivered</span></span></td>
											<td data-field="Type" data-autohide-disabled="false" class="datatable__cell"><span style="width: 148px;"><span class="badge badge--danger badge--dot"></span>&nbsp;<span class="font-bold font-danger">Online</span></span></td>
											<td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
													<div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-ellipsis-h"></i> </a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="la la-edit"></i> Edit Details</a> <a href="#" class="dropdown-item"><i class="la la-leaf"></i> Update Status</a> <a href="#" class="dropdown-item"><i class="la la-print"></i> Generate Report</a> </div>
													</div> <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a> <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
												</span></td>
										</tr>
										<tr data-row="9" class="datatable__row datatable__row--even" style="left: 0px;">
											<td class="datatable__cell--sorted datatable__cell--center datatable__cell" data-field="RecordID"><span style="width: 30px;">10</span></td>
											<td data-field="OrderID" class="datatable__cell"><span style="width: 148px;">
													<div class="user-card-v2">
														<div class="user-card-v2__pic"> <img alt="photo" src="media/users/100_13.jpg"> </div>
														<div class="user-card-v2__details"> <span class="user-card-v2__name">Obed Helian</span> <a class="user-card-v2__email link" href="#">ohelian9@usatoday.com</a> </div>
													</div>
												</span></td>
											<td data-field="Country" class="datatable__cell"><span style="width: 148px;">Thailand TH</span></td>
											<td data-field="ShipDate" class="datatable__cell"><span style="width: 148px;">1/26/2017</span></td>
											<td data-field="CompanyName" class="datatable__cell"><span style="width: 148px;">Labadie, Predovic and Hammes</span></td>
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
								<div class="datatable__pager datatable--paging-loaded">
									<ul class="datatable__pager-nav">
										<li><a title="First" class="datatable__pager-link datatable__pager-link--first datatable__pager-link--disabled" data-page="1" disabled="disabled"><i class="flaticon2-fast-back"></i></a></li>
										<li><a title="Previous" class="datatable__pager-link datatable__pager-link--prev datatable__pager-link--disabled" data-page="1" disabled="disabled"><i class="flaticon2-back"></i></a></li>
										<li style=""></li>
										<li style="display: none;"><input type="text" class="pager-input form-control" title="Page number"></li>
										<li><a class="datatable__pager-link datatable__pager-link-number datatable__pager-link--active" data-page="1" title="1">1</a></li>
										<li><a class="datatable__pager-link datatable__pager-link-number" data-page="2" title="2">2</a></li>
										<li><a class="datatable__pager-link datatable__pager-link-number" data-page="3" title="3">3</a></li>
										<li><a class="datatable__pager-link datatable__pager-link-number" data-page="4" title="4">4</a></li>
										<li style=""></li>
										<li><a title="Next" class="datatable__pager-link datatable__pager-link--next" data-page="2"><i class="flaticon2-next"></i></a></li>
										<li><a title="Last" class="datatable__pager-link datatable__pager-link--last" data-page="4"><i class="flaticon2-fast-next"></i></a></li>
									</ul>
									<div class="datatable__pager-info">
										<div class="dropdown bootstrap-select datatable__pager-size" style="width: 60px;"><select class="selectpicker datatable__pager-size" title="Select page size" data-width="60px" data-selected="10" tabindex="-98">
												<option class="bs-title-option" value=""></option>
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" title="Select page size">
												<div class="filter-option">
													<div class="filter-option-inner">
														<div class="filter-option-inner-inner">10</div>
													</div>
												</div>
											</button>
											<div class="dropdown-menu ">
												<div class="inner show" role="listbox" id="bs-select-3" tabindex="-1">
													<ul class="dropdown-menu inner show" role="presentation"></ul>
												</div>
											</div>
										</div><span class="datatable__pager-detail">Showing 1 - 10 of 40</span>
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