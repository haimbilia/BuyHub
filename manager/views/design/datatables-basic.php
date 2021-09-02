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
							<h3 class="subheader__title">Basic Examples</h3>

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
									Basic Tables </a>
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
							DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.
							<br>For more info see <a class="link font-bold" href="https://datatables.net/" target="_blank">the official home</a> of the plugin.
						</div>
					</div>

					<div class="card card--mobile">
						<div class="card-head card-head--lg">
							<div class="card-head-label">
								<span class="card-head-icon">
									<i class="font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="card-head-title">
									Basic
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
									<div class="col-sm-12">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="table_1" role="grid" aria-describedby="table_1_info" style="width: 1273px;">
											<thead>
												<tr role="row">
													<th class="dt-right sorting_disabled" rowspan="1" colspan="1" style="width: 30.5px;" aria-label="Record ID">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-group-checkable">
															<span></span>
														</label></th>
													<th class="sorting_desc" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 60.25px;" aria-sort="descending" aria-label="Order ID: activate to sort column ascending">Order ID</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 85.25px;" aria-label="Country: activate to sort column ascending">Country</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 103.25px;" aria-label="Ship City: activate to sort column ascending">Ship City</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 127.25px;" aria-label="Ship Address: activate to sort column ascending">Ship Address</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 104.25px;" aria-label="Company Agent: activate to sort column ascending">Company Agent</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 150.25px;" aria-label="Company Name: activate to sort column ascending">Company Name</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 57.25px;" aria-label="Ship Date: activate to sort column ascending">Ship Date</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 46.25px;" aria-label="Status: activate to sort column ascending">Status</th>
													<th class="sorting" tabindex="0" aria-controls="table_1" rowspan="1" colspan="1" style="width: 32.25px;" aria-label="Type: activate to sort column ascending">Type</th>
													<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 69.5px;" aria-label="Actions">Actions</th>
												</tr>
											</thead>

											<tbody>










												<tr role="row" class="odd">
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">75862-001</td>
													<td>Indonesia</td>
													<td>Pineleng</td>
													<td>4 Messerschmidt Point</td>
													<td>Cherish Peplay</td>
													<td>McCullough-Gibson</td>
													<td>11/23/2017</td>
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
												<tr role="row" class="even">
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">68647-122</td>
													<td>Philippines</td>
													<td>Cardona</td>
													<td>4765 Service Hill</td>
													<td>Devi Iglesias</td>
													<td>Ullrich-Dibbert</td>
													<td>7/21/2016</td>
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
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">68428-725</td>
													<td>China</td>
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
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">68084-123</td>
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
												<tr role="row" class="odd">
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">67510-0062</td>
													<td>South Africa</td>
													<td>Pongola</td>
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
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">67457-428</td>
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
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">64980-196</td>
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
												<tr role="row" class="even">
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">64679-154</td>
													<td>Mongolia</td>
													<td>Sharga</td>
													<td>102 Holmberg Park</td>
													<td>Tannie Seakes</td>
													<td>Blanda Group</td>
													<td>7/31/2016</td>
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
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">64117-168</td>
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
												<tr role="row" class="even">
													<td class=" dt-right" tabindex="0">
														<label class="checkbox checkbox--single checkbox--solid">
															<input type="checkbox" value="" class="m-checkable">
															<span></span>
														</label></td>
													<td class="sorting_1">63629-4697</td>
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
											</tbody>

										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-5">
										<div class="dataTables_info" id="table_1_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div>
									</div>
									<div class="col-sm-12 col-md-7 dataTables_pager">
										<div class="dataTables_length" id="table_1_length"><label>Display <select name="table_1_length" aria-controls="table_1" class="custom-select custom-select-sm form-control form-control-sm">
													<option value="5">5</option>
													<option value="10">10</option>
													<option value="25">25</option>
													<option value="50">50</option>
												</select></label></div>
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