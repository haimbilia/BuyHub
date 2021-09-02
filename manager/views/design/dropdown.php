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
	
	<link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
	
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
							<h3 class="subheader__title">Dropdown</h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Base </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Dropdown </a>
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
					<div class="row">
						<div class="col">
							<div class="alert alert-light alert-elevate fade show" role="alert">
								<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
								<div class="alert-text">
									FB-admin extends <code>Bootstrap Dropdown</code> component with a variety of options to provide uniquely looking Dropdown component that matches the FB-admin's design standards.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/components/dropdowns/" target="_blank">Documentation</a>.
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Basic Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Single button dropdowns:</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="#" data-toggle="tooltip" title="" data-placement="right" data-skin="dark" data-container="body" data-original-title="Tooltip title">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#" data-toggle="tooltip" title="" data-placement="left" data-original-title="Tooltip title">Something else here</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Dropdown menu with icons:</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Lineawesome
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="#"><i class="la la-bell"></i> Action</a>
															<a class="dropdown-item" href="#"><i class="la la-cloud-upload"></i> Another action</a>
															<a class="dropdown-item" href="#"><i class="la la-cog"></i> Something else</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Fontawesome
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="#"><i class="fa fa-bell"></i> Action</a>
															<a class="dropdown-item" href="#"><i class="fa fa-cloud-upload"></i> Another action</a>
															<a class="dropdown-item" href="#"><i class="fa fa-cog"></i> Something else</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															FB-admin Icons
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="#"><i class="flaticon-share"></i> Action</a>
															<a class="dropdown-item" href="#"><i class="flaticon-settings"></i> Another action</a>
															<a class="dropdown-item" href="#"><i class="flaticon-graphic-2"></i> Something else</a>
														</div>
													</div>
												</div>

											</div>
										</div>

									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">

										<span class="section__info">Button state dropdowns:</span>

										<div class="section__content">
											<div class="btn-group">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Primary</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Secondary</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Success</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-brand dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Info</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danger</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->

										</div>

									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">

										<span class="section__info">Single button dropdowns:</span>
										<div class="section__content">
											<div class="btn-group">
												<button type="button" class="btn btn-primary">Primary</button>
												<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-brand">Secondary</button>
												<button type="button" class="btn btn-brand dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-success">Success</button>
												<button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->
											<div class="btn-group">
												<button type="button" class="btn btn-warning">Warning</button>
												<button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<!-- /btn-group -->

										</div>

									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">

										<span class="section__info">Single icon button dropdowns:</span>
										<div class="section__content">
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more-1"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

											&nbsp;&nbsp;&nbsp;
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-hover-danger btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more-1"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

											&nbsp;&nbsp;&nbsp;
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

											&nbsp;&nbsp;&nbsp;
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-default btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

											&nbsp;&nbsp;&nbsp;
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-clean btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

											&nbsp;&nbsp;&nbsp;
											<div class="dropdown dropdown-inline">
												<button type="button" class="btn btn-brand btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon-more-1"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
													<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
													<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
												</div>
											</div>

										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Sizing
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Button dropdowns work with buttons of all sizes, including default and split dropdown buttons.</span>
										<div class="section__content">
											<div class="btn-group">
												<button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Large button
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>

											<div class="btn-group">
												<button type="button" class="btn btn-lg btn-secondary">Large split button</button>
												<button type="button" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>

											<div class="separator separator--space-lg separator--border-dashed"></div>

											<div class="btn-group">
												<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Small button
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-brand">Small split button</button>
												<button type="button" class="btn btn-sm btn-brand dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>

										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->
						</div>

						<div class="col-md-6">

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Dropup variation
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Trigger dropdown menus above elements by adding <code>.dropup</code> to the parent element.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="btn-group dropup">
														<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropup button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group dropleft">
														<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown left
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group dropright">
														<button type="button" class="btn btn-outline-success">
															Dropdown right
														</button>
														<button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="sr-only">Toggle Dropdown</span>
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Dropdown Menu
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">You can optionally use <code>button</code> elements for your dropdowns items.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown menu
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown menu
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="dropdown">
														<button class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown menu
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Add <code>.dropdown-menu-right</code> to a <code>.dropdown-menu</code> to right align the dropdown menu.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-brand dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Right Aligned
														</button>
														<div class="dropdown-menu dropdown-menu-right">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Left Aligned
														</button>
														<div class="dropdown-menu dropdown-menu-left">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-outline-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Right Aligned
														</button>
														<div class="dropdown-menu dropdown-menu-right">
															<button class="dropdown-item" type="button">Action</button>
															<button class="dropdown-item" type="button">Another action</button>
															<button class="dropdown-item" type="button">Something else here</button>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Add a header to label sections of actions in any dropdown menu.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropup button
														</button>
														<div class="dropdown-menu">
															<h6 class="dropdown-header">Dropdown header</h6>
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-outline-brand dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropup button
														</button>
														<div class="dropdown-menu">
															<h6 class="dropdown-header">Dropdown header</h6>
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-outline-success">
															Split dropup button
														</button>
														<button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="sr-only">Toggle Dropdown</span>
														</button>
														<div class="dropdown-menu">
															<h6 class="dropdown-header">Dropdown header</h6>
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Separate groups of related menu items with a divider.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-brand dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Action</a>
															<a class="dropdown-item" href="#">Another action</a>
															<a class="dropdown-item" href="#">Something else here</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Separated link</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--space-lg separator--border-dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Add <code>.disabled</code> to items in the dropdown to style them as disabled.</span>
										<div class="section__content">
											<div class="row">
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item active" href="#">Active link</a>
															<a class="dropdown-item disabled" href="#">Disabled link</a>
															<a class="dropdown-item" href="#">Another link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-brand dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item active" href="#">Active link</a>
															<a class="dropdown-item disabled" href="#">Disabled link</a>
															<a class="dropdown-item" href="#">Another link</a>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="btn-group">
														<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Dropdown button
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Regular link</a>
															<a class="dropdown-item disabled" href="#">Disabled link</a>
															<a class="dropdown-item active" href="#">Active link</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->
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