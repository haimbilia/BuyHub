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
		<!-- end:: Header -->
		<div class="grid__item grid__item--fluid grid grid--ver grid--stretch">
			<div id="body" class="container body grid grid--ver">
				<div class="grid__item grid__item--fluid grid grid--hor">
					<!-- begin:: Subheader -->
					<div class="subheader grid__item" id="subheader">
						<div class="subheader__main">
							<h3 class="subheader__title">Dashboard</h3>
							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Dashboard </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Default Dashboard </a>
							</div>
						</div>
						<div class="subheader__toolbar">
							<div class="subheader__wrapper">
								<a href="#" class="btn subheader__btn-daterange" id="dashboard_daterangepicker" data-toggle="tooltip" title="" data-placement="left" data-original-title="Select dashboard daterange">
									<span class="subheader__btn-daterange-title" id="dashboard_daterangepicker_title">Today:</span>&nbsp;
									<span class="subheader__btn-daterange-date" id="dashboard_daterangepicker_date">Oct 3</span>
									<i class="flaticon2-calendar-1"></i>
								</a>

								<div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="top">
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
					<!-- end:: Subheader -->
					<!-- begin:: Content -->
					<div class="content grid__item grid__item--fluid">
						<!--Begin::Section-->
						<!--begin:: Widgets/Quick Stats-->
						<div class="row row-full-height">
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$9581</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Total Sales <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"><a class="link" href="#">View Report</a>
															</div>
														</div>
													</div>
													<div class="widget__chart">
														<div id="chart-1" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		63%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$9581</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 96.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Total Orders <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"><a class="link" href="#">View Report</a>
															</div>
														</div>
													</div>
													<div class="widget__chart">
														<div id="chart-2" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		63%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$9581</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-danger"><i class="la la-arrow-down"></i> 2.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Total Online store visitors <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"><a class="link" href="#">View Report</a>
															</div>
														</div>
													</div>
													<div class="widget__chart">
													<div id="chart-3" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		13%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$9581</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 50.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Repeat Customer Rate <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"><a class="link" href="#">View Report</a>
															</div>
														</div>
													</div>
													<div class="widget__chart">
														<div id="chart-4" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		63%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:25%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:65%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 15%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$9581</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Average Order Value <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"></div>
														</div>
													</div>
													<div class="widget__chart">
														<div id="chart-5" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		63%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card--height-fluid-half card--border-bottom-brand">
									<div class="card-body card__body--fluid">
										<div class="row">
											<div class="col-12">
												<div class="widget26">
													<div class="widget26__content">
														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__number">$81</span></div>
															<div class="col-auto">
																<span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 8.6%</span>
															</div>
														</div>

														<div class="row align-items-center justify-content-between">
															<div class="col"><span class="widget26__desc">Total Sales Attributed to marketing campaigns <i class="fa fa-question-circle"></i></span> </div>
															<div class="col-auto"><a class="link" href="#">View Report</a>
															</div>
														</div>
													</div>
													<div class="widget__chart">
														<div id="chart-6" class=""></div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="widget15 mt-4">
													<div class="widget15__items">
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		63%
																	</span>
																	<span class="widget15__text">
																		Online Store
																	</span>
																	<div class="space-10"></div>
																	<div class="progress widget15__chart-progress--sm">
																		<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		54%
																	</span>
																	<span class="widget15__text">
																		Facebook
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
																	</div>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		41%
																	</span>
																	<span class="widget15__text">
																		Profit Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="widget15__item">
																	<span class="widget15__stats">
																		79%
																	</span>
																	<span class="widget15__text">
																		Member Grow
																	</span>
																	<div class="space-10"></div>
																	<div class="progress progress--sm">
																		<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<div class="widget15__desc">
																	* lorem ipsum dolor sit amet consectetuer sediat elit
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Begin::Section-->
						<div class="row">
							<div class="col-xl-5">
								<!--begin:: Widgets/Sale Reports-->
								<div class="card card--tabs card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Online store visits by location</h3>
										</div>
										<div class="card-head-toolbar">
											<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab" href="#widget11_tab1_content" role="tab">
														Last Month
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#widget11_tab2_content" role="tab">
														All Time
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="card-body">
										<!--Begin::Tab Content-->
										<div class="tab-content">
											<!--begin::tab 1 content-->
											<div class="tab-pane active" id="widget11_tab1_content">

												<!--begin::Widget 11-->
												<div class="widget11">
													<div class="table-responsive">
														<table class="table js--table-scrollable">
															<tbody>
																<tr>
																	<td>USA</td>
																	<td>1.458</td>
																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
																</tr>
																<tr>
																	<td>Canada</td>
																	<td>1.458</td>
																	<td class="align-right">
																		<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

																</tr>
																<tr>
																	<td>
																		Germany
																	</td>
																	<td>
																		85.458
																	</td>

																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

																</tr>
																<tr>
																	<td>
																		Maxico
																	</td>
																	<td>
																		12.458
																	</td>

																	<td class="align-right">
																		<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

																</tr>
																<tr>
																	<td>
																		France
																	</td>
																	<td>
																		89.458
																	</td>

																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

																</tr>

															</tbody>
														</table>
													</div>
													<div class="widget11__action align-right">
														<button type="button" class="btn btn-label-brand btn-bold btn-sm">Import Report</button>
													</div>
												</div>
												<!--end::Widget 11-->
											</div>
											<!--end::tab 1 content-->
											<!--begin::tab 2 content-->
											<div class="tab-pane" id="widget11_tab2_content">
												<!--begin::Widget 11-->
												<div class="widget11">
													<div class="table-responsive">
														<table class="table">
															<tbody>

																<tr>
																	<td>Canada</td>
																	<td>1.458</td>
																	<td class="align-right">
																		<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

																</tr>
																<tr>
																	<td>
																		Germany
																	</td>
																	<td>
																		85.458
																	</td>

																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

																</tr>
																<tr>
																	<td>USA</td>
																	<td>1.458</td>
																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
																</tr>
																<tr>
																	<td>
																		Maxico
																	</td>
																	<td>
																		12.458
																	</td>

																	<td class="align-right">
																		<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

																</tr>
																<tr>
																	<td>
																		France
																	</td>
																	<td>
																		89.458
																	</td>

																	<td class="align-right">
																		<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

																</tr>

															</tbody>
														</table>
													</div>
													<div class="widget11__action align-right">
														<button type="button" class="btn btn-label-success btn-bold btn-sm">Generate Report</button>
													</div>
												</div>

												<!--end::Widget 11-->
											</div>
											<!--end::tab 2 content-->

										</div>

										<!--End::Tab Content-->
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
							<div class="col-xl-7">
								<!--begin:: Widgets/Product Sales-->
								<div class="card card--bordered-semi card--space card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">
												Online store conversion rate <i class="fa fa-question-circle"></i>
											</h3>
										</div>
										<div class="card-head-toolbar">
											<button type="button" class="btn btn-label-brand btn-bold btn-sm">View All</button>
										</div>
									</div>
									<div class="card-body">
										<div class="widget25">
											<span class="widget25__stats m-font-brand">37.5% </span>
											<span class="widget25__subtitle"><span class="font-success"><i class="la la-arrow-up"></i> 50.6%</span></span>
											<div class="widget25__items">
												<div class="widget25__item">
													<span class="widget25__number">
														63%
													</span> <span class="widget25__cents"><span class="font-success"><i class="la la-arrow-up"></i> 50.6%</span></span>

													<span class="widget25__desc">
														Added to cart
													</span>
												</div>

												<div class="widget25__item">
													<span class="widget25__number">
														39%
													</span><span class="widget25__cents"><span class="font-danger"><i class="la la-arrow-down"></i> 50.6%</span></span>

													<span class="widget25__desc">
														Reached checkout
													</span>
												</div>

												<div class="widget25__item">
													<span class="widget25__number">
														54%
													</span><span class="widget25__cents"><span class="font-success"><i class="la la-arrow-up"></i> 50.6%</span></span>

													<span class="widget25__desc">
														Purchased
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--end:: Widgets/Product Sales-->
							</div>
						</div>

						<!--End::Section-->

						<!--Begin::Section-->
						<div class="row">
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Top Products by units sold</h3>
										</div>
										<div class="card-head-toolbar">

										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Online store visits by traffic source</h3>
										</div>
										<div class="card-head-toolbar">

										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Sales by traffic source</h3>
										</div>
										<div class="card-head-toolbar">

										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
						</div>


						<div class="row">
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Top landing pages by visits</h3>
										</div>
										<div class="card-head-toolbar">
											<button type="button" class="btn btn-label-brand btn-bold btn-sm">View Report</button>
										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Online store visits by device type</h3>
										</div>
										<div class="card-head-toolbar">
											<button type="button" class="btn btn-label-brand btn-bold btn-sm">View Report</button>
										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
							<div class="col-xl-4">
								<div class="card card--height-fluid">
									<div class="card-head">
										<div class="card-head-label">
											<h3 class="card-head-title">Online store visits from social sources</h3>
										</div>
										<div class="card-head-toolbar">
											<button type="button" class="btn btn-label-brand btn-bold btn-sm">View Report</button>
										</div>
									</div>
									<div class="card-body">
										<div class="widget11">
											<div class="table-responsive">
												<table class="table js--table-scrollable">
													<tbody>
														<tr>
															<td>Woo Shirt heavy</td>
															<td>558</td>
															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span></td>
														</tr>
														<tr>
															<td>Woo long sleeve</td>
															<td>1.458</td>
															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span></td>

														</tr>
														<tr>
															<td>
																Shorts
															</td>
															<td>
																85.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span></td>

														</tr>
														<tr>
															<td>
																Maxico
															</td>
															<td>
																12.458
															</td>

															<td class="align-right">
																<span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span></td>

														</tr>
														<tr>
															<td>
																Socks
															</td>
															<td>
																89.458
															</td>

															<td class="align-right">
																<span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span></td>

														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<!--end:: Widgets/Sale Reports-->
							</div>
						</div>
						<!--End::Section-->
					</div>

					<!-- end:: Content -->
				</div>
			</div>
		</div>

		<?php
  include 'includes/footer.php';
?>
	</div>
	<script src="js/vendors/chartist.js"></script>
	<script src="js/index-charts.js"></script>
</body>


</html>