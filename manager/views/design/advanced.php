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

								Advanced cards </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									cards </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Advanced cards </a>
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
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon2-calendar-2"></i>
										</span>
										<h3 class="card-head-title">
											Action Icons
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
												<i class="flaticon2-search-1"></i>
											</a>
											<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
												<i class="flaticon2-gear"></i>
											</a>
											<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
												<i class="flaticon-more-1"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Dropdown Buttons
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<div class="dropdown dropdown-inline">
												<a href="#" class="btn btn-default btn-pill btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon2-add-1"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<ul class="nav">
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-line-chart"></i>
																<span class="nav__link-text">Reports</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-send"></i>
																<span class="nav__link-text">Messages</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-pie-chart-1"></i>
																<span class="nav__link-text">Charts</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-avatar"></i>
																<span class="nav__link-text">Members</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-settings"></i>
																<span class="nav__link-text">Settings</span>
															</a>
														</li>
													</ul>
												</div>
											</div>&nbsp;
											<div class="dropdown dropdown-inline">
												<a href="#" class="btn btn-default btn-pill btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="flaticon2-soft-icons"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<ul class="nav">
														<li class="nav__section nav__section--first">
															<span class="nav__section-text">Finance</span>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-graph-1"></i>
																<span class="nav__link-text">Statistics</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-calendar-4"></i>
																<span class="nav__link-text">Events</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-layers-1"></i>
																<span class="nav__link-text">Reports</span>
															</a>
														</li>
														<li class="nav__section">
															<span class="nav__section-text">Customers</span>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-calendar-4"></i>
																<span class="nav__link-text">Notifications</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-file-1"></i>
																<span class="nav__link-text">Files</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon2-calendar-2"></i>
										</span>
										<h3 class="card-head-title">
											Action Buttons
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<a href="#" class="btn btn-outline-success btn-sm btn-icon btn-icon-md">
												<i class="flaticon2-search-1"></i>
											</a>
											<a href="#" class="btn btn-outline-danger btn-sm btn-icon btn-icon-md">
												<i class="flaticon2-gear"></i>
											</a>
											<a href="#" class="btn btn-outline-brand btn-sm btn-icon btn-icon-md">
												<i class="flaticon2-calendar-5"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon-calendar"></i>
										</span>
										<h3 class="card-head-title font-primary">
											Action Buttons
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<a href="#" class="btn btn-clean btn-sm">
												Import
											</a>
											<a href="#" class="btn btn-outline-brand btn-sm">
												Filter
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
									Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card card--responsive-mobile">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon-technology font-success"></i>
										</span>
										<h3 class="card-head-title font-brand">
											Custom Title &amp; Toolbar
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
											<button type="button" class="btn btn-secondary"><i class="la la-file-text-o"></i></button>
											<button type="button" class="btn btn-secondary"><i class="la la-floppy-o"></i></button>
											<button type="button" class="btn btn-secondary"><i class="la la-header"></i></button>
											<div class="btn-group" role="group">
												<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Dropdown
												</button>
												<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
													<a class="dropdown-item" href="#">Dropdown link</a>
													<a class="dropdown-item" href="#">Dropdown link</a>
													<a class="dropdown-item" href="#">Dropdown link</a>
													<a class="dropdown-item" href="#">Dropdown link</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--responsive-tablet-and-mobile">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Bootstrap Toolbar
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="btn-group btn-group btn-group-pill" role="group" aria-label="...">
											<button type="button" class="btn btn-brand">Left</button>
											<button type="button" class="btn btn-brand">Middle</button>
											<button type="button" class="btn btn-brand">Right</button>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title font-primary">
											Action Buttons <small>button toolbar</small>
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<a href="#" class="btn btn-outline-brand btn-bold btn-sm">
												Tools
											</a>
											<a href="#" class="btn btn-danger btn-sm btn-bold">
												Export
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
									Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon-calendar"></i>
										</span>
										<h3 class="card-head-title font-primary">
											Action Buttons
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-actions">
											<a href="#" class="btn btn-success btn-pill btn-sm">
												Import
											</a>
											<a href="#" class="btn btn-warning btn-pill btn-sm">
												Filter
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
									Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->
						</div>
					</div>

					<div class="row">
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid-half">
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing.
										Lorem Ipsum is simply dummy text of the printing.
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--height-fluid-half">
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing.
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
										when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
					</div>

					<div class="row">
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid-half">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing.
										Lorem Ipsum is simply dummy text of the printing.
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--height-fluid-half">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing.
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">Same Height card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
										when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
					</div>

					<div class="row">
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--solid-brand card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Solid card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
								<div class="card__foot card__foot--sm align-right">
									<a href="#" class="btn btn-font-light btn-outline-hover-light">Dismiss</a>
									<a href="#" class="btn btn-font-light btn-outline-hover-light">View</a>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--solid-warning cardk-card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon"><i class="flaticon-stopwatch"></i></span>
										<h3 class="card-head-title">Solid card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
								<div class="card__foot card__foot--sm align-right">
									<a href="#" class="btn btn-font-light btn-outline-hover-light">Save</a>
									<a href="#" class="btn btn-font-light btn-outline-hover-light">Cancel</a>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-4">
							<!--begin::card-->
							<div class="card card--solid-success card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">Solid card</h3>
									</div>
									<div class="card-head-toolbar">
										Toolbar
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
										when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
								<div class="card__foot card__foot--sm align-right">
									<a href="#" class="btn btn-font-light btn-elevate btn-outline-hover-light">Save</a>
									<a href="#" class="btn btn-font-light btn-elevate btn-outline-hover-light">Cancel</a>
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