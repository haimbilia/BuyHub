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
		<div class="body " id="body">
			<div class="content " id="content">

				<!-- begin:: Subheader -->
				<div class="subheader   grid__item" id="subheader">
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Navs </h3>
							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Custom </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Navigations </a>
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
					<div class="row">
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Default Navigation
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item nav__item--active">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-rocket-2"></i>
														<span class="nav__link-text">Messages</span>
														<span class="nav__link-badge">
															<span class="badge badge--danger badge--inline badge--pill badge--rounded">new</span>
														</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-sm" aria-labelledby="dropdownMenuButton">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item nav__item--active">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-rocket-2"></i>
														<span class="nav__link-text">Messages</span>
														<span class="nav__link-badge">
															<span class="badge badge--danger badge--inline badge--pill badge--rounded">new</span>
														</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Section &amp; Separator
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block">
												<li class="nav__section nav__section--first">
													<span class="nav__section-text">Section 1</span>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-chart"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-user"></i>
														<span class="nav__link-text">Messages</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-box-1"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__section">
													<span class="nav__section-text">Section 2</span>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-pie-chart-1"></i>
														<span class="nav__link-text">Support</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-layers"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-poll-symbol"></i>
														<span class="nav__link-text">Logs</span>
													</a>
												</li>
												<li class="nav__separator nav__separator--fit">
												</li>
												<li class="nav__custom">
													<a href="#" class="btn btn-label-success btn-bold btn-sm">Logout</a>
												</li>
											</ul>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-sm dropdown-menu-fit-bottom">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__section nav__section--first">
													<span class="nav__section-text">Section 1</span>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-chart"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-user"></i>
														<span class="nav__link-text">Messages</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-box-1"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__section">
													<span class="nav__section-text">Section 2</span>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-pie-chart-1"></i>
														<span class="nav__link-text">Support</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-layers"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-poll-symbol"></i>
														<span class="nav__link-text">Logs</span>
													</a>
												</li>
												<li class="nav__separator nav__separator--fit">
												</li>
												<li class="nav__custom">
													<a href="#" class="btn btn-label-success btn-bold btn-sm">Logout</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->

								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Active and disabled links
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block">
												<li class="nav__item nav__item--active">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-layers-1"></i>
														<span class="nav__link-text">Active</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-list-3"></i>
														<span class="nav__link-text">Link</span>
													</a>
												</li>
												<li class="nav__item nav__item--disabled">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-copy"></i>
														<span class="nav__link-text">Disabled</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-contract"></i>
														<span class="nav__link-text">Link</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-sm">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__item nav__item--active">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-layers-1"></i>
														<span class="nav__link-text">Active</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-list-3"></i>
														<span class="nav__link-text">Link</span>
													</a>
												</li>
												<li class="nav__item nav__item--disabled">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-copy"></i>
														<span class="nav__link-text">Disabled</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-contract"></i>
														<span class="nav__link-text">Link</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->

								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Enable spacing &amp; font style options
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__desc">Medium spacing using <code>nav--md-space</code>:</div>
										<div class="section__content section__content--border section__content--fit">
											<!--begin::Nav-->
											<ul class="nav nav--block nav--md-space">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>

												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<div class="section__desc">Large spacing, bold &amp; large font styling using <code>nav--lg-space</code>, <code>nav--bold</code>, <code>nav--lg-font</code>:</div>
										<div class="section__content section__content--border section__content--fit">
											<!--begin::Nav-->
											<ul class="nav nav--bold nav--lg-space nav--lg-font">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
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
										<h3 class="card-head-title">
											Sub navigation using <code>Bootstrap Collapse</code>
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6">
											<div class="section">
												<div class="section__info">
													Static sub navigation:
												</div>
												<div class="section__content section__content--border section__content--fit">
													<ul class="nav nav--block">
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-rocket-1"></i>
																<span class="nav__link-text">Activity</span>
															</a>
														</li>
														<li class="nav__item nav__item--active">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-expand"></i>
																<span class="nav__link-title">
																	<span class="nav__link-text">Messages</span>
																	<span class="nav__link-badge">
																		<span class="badge badge--danger badge--inline badge--pill badge--rounded">new</span>
																	</span>
																</span></a>
															<ul class="nav__sub">
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">New</span>
																	</a>
																</li>
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">Pending</span>
																		<span class="nav__link-badge">
																			<span class="badge badge--warning">3</span>
																		</span>
																	</a>
																</li>
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">Replied</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-chat-1"></i>
																<span class="nav__link-text">FAQ</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-graph-1"></i>
																<span class="nav__link-text">Settings</span>
															</a>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-laptop"></i>
																<span class="nav__link-text">Support</span>
																<span class="nav__link-badge">
																	<span class="badge badge--success badge--inline badge--pill">23</span>
																</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="section">
												<div class="section__info">
													Toggle sub navigation:
												</div>
												<div class="section__content section__content--border section__content--fit">
													<ul class="nav nav--block nav--active-bg" id="nav" role="tablist">
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-help"></i>
																<span class="nav__link-text">Activity</span>
															</a>
														</li>
														<li class="nav__item nav__item--active">
															<a class="nav__link" role="tab" id="nav_link_1" data-toggle="collapse" href="#nav_sub_1" aria-expanded=" false">
																<i class="nav__link-icon flaticon2-graphic"></i>
																<span class="nav__link-text">Messages</span>
																<span class="nav__link-badge">
																	<span class="badge badge--danger badge--inline badge--pill badge--rounded">new</span>
																</span>
																<span class="nav__link-arrow"></span>
															</a>
															<ul class="nav__sub collapse show" id="nav_sub_1" role="tabpanel" aria-labelledby="m_nav_link_1" data-parent="#nav">
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">New</span>
																	</a>
																</li>
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">Replied</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-notepad"></i>
																<span class="nav__link-text">FAQ</span>
															</a>
														</li>
														<li class="nav__item nav__item--active">
															<a class="nav__link  collapsed" role="tab" id="nav_link_2" data-toggle="collapse" href="#nav_sub_2" aria-expanded="  false">
																<i class="nav__link-icon flaticon2-new-email"></i>
																<span class="nav__link-text">Reports</span>
																<span class="nav__link-badge">
																	<span class="badge badge--brand">3</span>
																</span>
																<span class="nav__link-arrow"></span>
															</a>
															<ul class="nav__sub collapse" id="nav_sub_2" role="tabpanel" aria-labelledby="m_nav_link_2" data-parent="#nav">
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">New</span>
																	</a>
																</li>
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">Pending</span>
																		<span class="nav__link-badge">
																			<span class="badge badge--warning">3</span>
																		</span>
																	</a>
																</li>
																<li class="nav__item">
																	<a href="#" class="nav__link">
																		<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
																		<span class="nav__link-text">Replied</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="nav__item">
															<a href="#" class="nav__link">
																<i class="nav__link-icon flaticon2-attention"></i>
																<span class="nav__link-text">Settings</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Navigation Head
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__head">
													Navigation Title
													<i class="flaticon2-warning-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-fit-top dropdown-menu-lg" aria-labelledby="dropdownMenuButton">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__head">
													Navigation Title
													<i class="flaticon2-warning-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Navigation Head &amp; Foot
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__head">
													Navigation Title
													<i class="flaticon2-warning-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__foot">
													<a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
													<a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more...">Learn more</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-fit dropdown-menu-lg " aria-labelledby="dropdownMenuButton">
											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__head">
													Navigation Title
													<i class="flaticon2-warning-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-drop"></i>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-calendar-8"></i>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-link"></i>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<i class="nav__link-icon flaticon2-new-email"></i>
														<span class="nav__link-text">Support</span>
														<span class="nav__link-badge">
															<span class="badge badge--success">5</span>
														</span>
													</a>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__foot">
													<a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
													<a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more...">Learn more</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Navigation Item Bullets
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">Navigation items can have dot and line style bullets:</span>
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
														<span class="nav__link-text">Messages</span>
													</a>
												</li>
												<li class="nav__item ">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--dot"><span></span></span>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--dot"><span></span></span>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-sm">

											<!--begin::Nav-->
											<ul class="nav nav--block">
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
														<span class="nav__link-text">Activity</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--line"><span></span></span>
														<span class="nav__link-text">Messages</span>
													</a>
												</li>
												<li class="nav__item ">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--dot"><span></span></span>
														<span class="nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="nav__item">
													<a href="#" class="nav__link">
														<span class="nav__link-bullet nav__link-bullet--dot"><span></span></span>
														<span class="nav__link-text">Settings</span>
													</a>
												</li>
											</ul>
											<!--end::Nav-->
										</div>
									</div>
									<!--end::Dropdown-->

								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Grid Navigation
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<!--begin: Grid Nav -->
											<div class="grid-nav grid-nav--skin-light">
												<div class="grid-nav__row">
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4.3618034,10.2763932 L4.8618034,9.2763932 C4.94649941,9.10700119 5.11963097,9 5.30901699,9 L15.190983,9 C15.4671254,9 15.690983,9.22385763 15.690983,9.5 C15.690983,9.57762255 15.6729105,9.65417908 15.6381966,9.7236068 L15.1381966,10.7236068 C15.0535006,10.8929988 14.880369,11 14.690983,11 L4.80901699,11 C4.53287462,11 4.30901699,10.7761424 4.30901699,10.5 C4.30901699,10.4223775 4.32708954,10.3458209 4.3618034,10.2763932 Z M14.6381966,13.7236068 L14.1381966,14.7236068 C14.0535006,14.8929988 13.880369,15 13.690983,15 L4.80901699,15 C4.53287462,15 4.30901699,14.7761424 4.30901699,14.5 C4.30901699,14.4223775 4.32708954,14.3458209 4.3618034,14.2763932 L4.8618034,13.2763932 C4.94649941,13.1070012 5.11963097,13 5.30901699,13 L14.190983,13 C14.4671254,13 14.690983,13.2238576 14.690983,13.5 C14.690983,13.5776225 14.6729105,13.6541791 14.6381966,13.7236068 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M17.369,7.618 C16.976998,7.08599734 16.4660031,6.69750122 15.836,6.4525 C15.2059968,6.20749878 14.590003,6.085 13.988,6.085 C13.2179962,6.085 12.5180032,6.2249986 11.888,6.505 C11.2579969,6.7850014 10.7155023,7.16999755 10.2605,7.66 C9.80549773,8.15000245 9.45550123,8.72399671 9.2105,9.382 C8.96549878,10.0400033 8.843,10.7539961 8.843,11.524 C8.843,12.3360041 8.96199881,13.0779966 9.2,13.75 C9.43800119,14.4220034 9.7774978,14.9994976 10.2185,15.4825 C10.6595022,15.9655024 11.1879969,16.3399987 11.804,16.606 C12.4200031,16.8720013 13.1129962,17.005 13.883,17.005 C14.681004,17.005 15.3879969,16.8475016 16.004,16.5325 C16.6200031,16.2174984 17.1169981,15.8010026 17.495,15.283 L19.616,16.774 C18.9579967,17.6000041 18.1530048,18.2404977 17.201,18.6955 C16.2489952,19.1505023 15.1360064,19.378 13.862,19.378 C12.6999942,19.378 11.6325049,19.1855019 10.6595,18.8005 C9.68649514,18.4154981 8.8500035,17.8765035 8.15,17.1835 C7.4499965,16.4904965 6.90400196,15.6645048 6.512,14.7055 C6.11999804,13.7464952 5.924,12.6860058 5.924,11.524 C5.924,10.333994 6.13049794,9.25950479 6.5435,8.3005 C6.95650207,7.34149521 7.5234964,6.52600336 8.2445,5.854 C8.96550361,5.18199664 9.8159951,4.66400182 10.796,4.3 C11.7760049,3.93599818 12.8399943,3.754 13.988,3.754 C14.4640024,3.754 14.9609974,3.79949954 15.479,3.8905 C15.9970026,3.98150045 16.4939976,4.12149906 16.97,4.3105 C17.4460024,4.49950095 17.8939979,4.7339986 18.314,5.014 C18.7340021,5.2940014 19.0909985,5.62999804 19.385,6.022 L17.369,7.618 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Accounting</span>
														<span class="grid-nav__desc">eCommerce</span>
													</a>
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.8571499,13 C14.9499122,12.7223297 15,12.4263059 15,12.1190476 L15,6.88095238 C15,5.28984632 13.6568542,4 12,4 L11.7272727,4 C10.2210416,4 9,5.17258756 9,6.61904762 L10.0909091,6.61904762 C10.0909091,5.75117158 10.823534,5.04761905 11.7272727,5.04761905 L12,5.04761905 C13.0543618,5.04761905 13.9090909,5.86843034 13.9090909,6.88095238 L13.9090909,12.1190476 C13.9090909,12.4383379 13.8240964,12.7385644 13.6746497,13 L10.3253503,13 C10.1759036,12.7385644 10.0909091,12.4383379 10.0909091,12.1190476 L10.0909091,9.5 C10.0909091,9.06606198 10.4572216,8.71428571 10.9090909,8.71428571 C11.3609602,8.71428571 11.7272727,9.06606198 11.7272727,9.5 L11.7272727,11.3333333 L12.8181818,11.3333333 L12.8181818,9.5 C12.8181818,8.48747796 11.9634527,7.66666667 10.9090909,7.66666667 C9.85472911,7.66666667 9,8.48747796 9,9.5 L9,12.1190476 C9,12.4263059 9.0500878,12.7223297 9.14285008,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L14.8571499,13 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M9,10.3333333 L9,12.1190476 C9,13.7101537 10.3431458,15 12,15 C13.6568542,15 15,13.7101537 15,12.1190476 L15,10.3333333 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9,10.3333333 Z M10.0909091,11.1212121 L12,12.5 L13.9090909,11.1212121 L13.9090909,12.1190476 C13.9090909,13.1315697 13.0543618,13.952381 12,13.952381 C10.9456382,13.952381 10.0909091,13.1315697 10.0909091,12.1190476 L10.0909091,11.1212121 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Administration</span>
														<span class="grid-nav__desc">Console</span>
													</a>
												</div>
												<div class="grid-nav__row">
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"></path>
																	<path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Projects</span>
														<span class="grid-nav__desc">Pending Tasks</span>
													</a>
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Customers</span>
														<span class="grid-nav__desc">Latest cases</span>
													</a>
												</div>
											</div>
											<!--end: Grid Nav -->
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-fit dropdown-menu-xl">
											<!--begin: Grid Nav -->
											<div class="grid-nav grid-nav--skin-light">
												<div class="grid-nav__row">
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4.3618034,10.2763932 L4.8618034,9.2763932 C4.94649941,9.10700119 5.11963097,9 5.30901699,9 L15.190983,9 C15.4671254,9 15.690983,9.22385763 15.690983,9.5 C15.690983,9.57762255 15.6729105,9.65417908 15.6381966,9.7236068 L15.1381966,10.7236068 C15.0535006,10.8929988 14.880369,11 14.690983,11 L4.80901699,11 C4.53287462,11 4.30901699,10.7761424 4.30901699,10.5 C4.30901699,10.4223775 4.32708954,10.3458209 4.3618034,10.2763932 Z M14.6381966,13.7236068 L14.1381966,14.7236068 C14.0535006,14.8929988 13.880369,15 13.690983,15 L4.80901699,15 C4.53287462,15 4.30901699,14.7761424 4.30901699,14.5 C4.30901699,14.4223775 4.32708954,14.3458209 4.3618034,14.2763932 L4.8618034,13.2763932 C4.94649941,13.1070012 5.11963097,13 5.30901699,13 L14.190983,13 C14.4671254,13 14.690983,13.2238576 14.690983,13.5 C14.690983,13.5776225 14.6729105,13.6541791 14.6381966,13.7236068 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M17.369,7.618 C16.976998,7.08599734 16.4660031,6.69750122 15.836,6.4525 C15.2059968,6.20749878 14.590003,6.085 13.988,6.085 C13.2179962,6.085 12.5180032,6.2249986 11.888,6.505 C11.2579969,6.7850014 10.7155023,7.16999755 10.2605,7.66 C9.80549773,8.15000245 9.45550123,8.72399671 9.2105,9.382 C8.96549878,10.0400033 8.843,10.7539961 8.843,11.524 C8.843,12.3360041 8.96199881,13.0779966 9.2,13.75 C9.43800119,14.4220034 9.7774978,14.9994976 10.2185,15.4825 C10.6595022,15.9655024 11.1879969,16.3399987 11.804,16.606 C12.4200031,16.8720013 13.1129962,17.005 13.883,17.005 C14.681004,17.005 15.3879969,16.8475016 16.004,16.5325 C16.6200031,16.2174984 17.1169981,15.8010026 17.495,15.283 L19.616,16.774 C18.9579967,17.6000041 18.1530048,18.2404977 17.201,18.6955 C16.2489952,19.1505023 15.1360064,19.378 13.862,19.378 C12.6999942,19.378 11.6325049,19.1855019 10.6595,18.8005 C9.68649514,18.4154981 8.8500035,17.8765035 8.15,17.1835 C7.4499965,16.4904965 6.90400196,15.6645048 6.512,14.7055 C6.11999804,13.7464952 5.924,12.6860058 5.924,11.524 C5.924,10.333994 6.13049794,9.25950479 6.5435,8.3005 C6.95650207,7.34149521 7.5234964,6.52600336 8.2445,5.854 C8.96550361,5.18199664 9.8159951,4.66400182 10.796,4.3 C11.7760049,3.93599818 12.8399943,3.754 13.988,3.754 C14.4640024,3.754 14.9609974,3.79949954 15.479,3.8905 C15.9970026,3.98150045 16.4939976,4.12149906 16.97,4.3105 C17.4460024,4.49950095 17.8939979,4.7339986 18.314,5.014 C18.7340021,5.2940014 19.0909985,5.62999804 19.385,6.022 L17.369,7.618 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Accounting</span>
														<span class="grid-nav__desc">eCommerce</span>
													</a>
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.8571499,13 C14.9499122,12.7223297 15,12.4263059 15,12.1190476 L15,6.88095238 C15,5.28984632 13.6568542,4 12,4 L11.7272727,4 C10.2210416,4 9,5.17258756 9,6.61904762 L10.0909091,6.61904762 C10.0909091,5.75117158 10.823534,5.04761905 11.7272727,5.04761905 L12,5.04761905 C13.0543618,5.04761905 13.9090909,5.86843034 13.9090909,6.88095238 L13.9090909,12.1190476 C13.9090909,12.4383379 13.8240964,12.7385644 13.6746497,13 L10.3253503,13 C10.1759036,12.7385644 10.0909091,12.4383379 10.0909091,12.1190476 L10.0909091,9.5 C10.0909091,9.06606198 10.4572216,8.71428571 10.9090909,8.71428571 C11.3609602,8.71428571 11.7272727,9.06606198 11.7272727,9.5 L11.7272727,11.3333333 L12.8181818,11.3333333 L12.8181818,9.5 C12.8181818,8.48747796 11.9634527,7.66666667 10.9090909,7.66666667 C9.85472911,7.66666667 9,8.48747796 9,9.5 L9,12.1190476 C9,12.4263059 9.0500878,12.7223297 9.14285008,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L14.8571499,13 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M9,10.3333333 L9,12.1190476 C9,13.7101537 10.3431458,15 12,15 C13.6568542,15 15,13.7101537 15,12.1190476 L15,10.3333333 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9,10.3333333 Z M10.0909091,11.1212121 L12,12.5 L13.9090909,11.1212121 L13.9090909,12.1190476 C13.9090909,13.1315697 13.0543618,13.952381 12,13.952381 C10.9456382,13.952381 10.0909091,13.1315697 10.0909091,12.1190476 L10.0909091,11.1212121 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Administration</span>
														<span class="grid-nav__desc">Console</span>
													</a>
												</div>
												<div class="grid-nav__row">
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"></path>
																	<path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Projects</span>
														<span class="grid-nav__desc">Pending Tasks</span>
													</a>
													<a href="#" class="grid-nav__item">
														<span class="grid-nav__icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success svg-icon--lg">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg> </span>
														<span class="grid-nav__title">Customers</span>
														<span class="grid-nav__desc">Latest cases</span>
													</a>
												</div>
											</div>
											<!--end: Grid Nav -->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Modern Navigation Menu
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block nav--bold nav--md-space nav--v3" role="tablist">
												<li class="nav__item active">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Personal Information</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_account_information" role="tab">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M17,2 L19,2 C20.6568542,2 22,3.34314575 22,5 L22,19 C22,20.6568542 20.6568542,22 19,22 L17,22 L17,2 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M4,2 L16,2 C17.6568542,2 19,3.34314575 19,5 L19,19 C19,20.6568542 17.6568542,22 16,22 L4,22 C3.44771525,22 3,21.5522847 3,21 L3,3 C3,2.44771525 3.44771525,2 4,2 Z M11.1176481,13.709585 C10.6725287,14.1547043 9.99251947,14.2650547 9.42948307,13.9835365 C8.86644666,13.7020183 8.18643739,13.8123686 7.74131803,14.2574879 L6.2303083,15.7684977 C6.17542087,15.8233851 6.13406645,15.8902979 6.10952004,15.9639372 C6.02219616,16.2259088 6.16377615,16.5090688 6.42574781,16.5963927 L7.77956724,17.0476658 C9.07965249,17.4810276 10.5130001,17.1426601 11.4820264,16.1736338 L15.4812434,12.1744168 C16.3714821,11.2841781 16.5921828,9.92415954 16.0291464,8.79808673 L15.3965752,7.53294436 C15.3725414,7.48487691 15.3409156,7.44099843 15.302915,7.40299777 C15.1076528,7.20773562 14.7910703,7.20773562 14.5958082,7.40299777 L13.0032662,8.99553978 C12.5581468,9.44065914 12.4477965,10.1206684 12.7293147,10.6837048 C13.0108329,11.2467412 12.9004826,11.9267505 12.4553632,12.3718698 L11.1176481,13.709585 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Acccount Information</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4,16 L5,16 C5.55228475,16 6,16.4477153 6,17 C6,17.5522847 5.55228475,18 5,18 L4,18 C3.44771525,18 3,17.5522847 3,17 C3,16.4477153 3.44771525,16 4,16 Z M1,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L1,13 C0.44771525,13 6.76353751e-17,12.5522847 0,12 C-6.76353751e-17,11.4477153 0.44771525,11 1,11 Z M3,6 L5,6 C5.55228475,6 6,6.44771525 6,7 C6,7.55228475 5.55228475,8 5,8 L3,8 C2.44771525,8 2,7.55228475 2,7 C2,6.44771525 2.44771525,6 3,6 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M10,6 L22,6 C23.1045695,6 24,6.8954305 24,8 L24,16 C24,17.1045695 23.1045695,18 22,18 L10,18 C8.8954305,18 8,17.1045695 8,16 L8,8 C8,6.8954305 8.8954305,6 10,6 Z M21.0849395,8.0718316 L16,10.7185839 L10.9150605,8.0718316 C10.6132433,7.91473331 10.2368262,8.02389331 10.0743092,8.31564728 C9.91179228,8.60740125 10.0247174,8.9712679 10.3265346,9.12836619 L15.705737,11.9282847 C15.8894428,12.0239051 16.1105572,12.0239051 16.294263,11.9282847 L21.6734654,9.12836619 C21.9752826,8.9712679 22.0882077,8.60740125 21.9256908,8.31564728 C21.7631738,8.02389331 21.3867567,7.91473331 21.0849395,8.0718316 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Payments</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<circle fill="#000000" cx="6" cy="18" r="3"></circle>
																	<path d="M16.5,21 L13.5,21 C13.5,15.2010101 8.79898987,10.5 3,10.5 L3,7.5 C10.4558441,7.5 16.5,13.5441559 16.5,21 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M22.5,21 L19.5,21 C19.5,12.163444 11.836556,4.5 3,4.5 L3,1.5 C13.4934102,1.5 22.5,10.5065898 22.5,21 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Social Networks</span>
													</a>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--danger">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M12.7442084,3.27882877 L19.2473374,6.9949025 C19.7146999,7.26196679 20.003129,7.75898194 20.003129,8.29726722 L20.003129,15.7027328 C20.003129,16.2410181 19.7146999,16.7380332 19.2473374,17.0050975 L12.7442084,20.7211712 C12.2830594,20.9846849 11.7169406,20.9846849 11.2557916,20.7211712 L4.75266256,17.0050975 C4.28530007,16.7380332 3.99687097,16.2410181 3.99687097,15.7027328 L3.99687097,8.29726722 C3.99687097,7.75898194 4.28530007,7.26196679 4.75266256,6.9949025 L11.2557916,3.27882877 C11.7169406,3.01531506 12.2830594,3.01531506 12.7442084,3.27882877 Z M12,14.5 C13.3807119,14.5 14.5,13.3807119 14.5,12 C14.5,10.6192881 13.3807119,9.5 12,9.5 C10.6192881,9.5 9.5,10.6192881 9.5,12 C9.5,13.3807119 10.6192881,14.5 12,14.5 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Statements</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Audit Log</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<!--end::Section-->
									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-xl">
											<ul class="nav  nav--block nav--bold nav--md-space nav--v3" role="tablist">
												<li class="nav__item active">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Personal Information</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_account_information" role="tab">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M17,2 L19,2 C20.6568542,2 22,3.34314575 22,5 L22,19 C22,20.6568542 20.6568542,22 19,22 L17,22 L17,2 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M4,2 L16,2 C17.6568542,2 19,3.34314575 19,5 L19,19 C19,20.6568542 17.6568542,22 16,22 L4,22 C3.44771525,22 3,21.5522847 3,21 L3,3 C3,2.44771525 3.44771525,2 4,2 Z M11.1176481,13.709585 C10.6725287,14.1547043 9.99251947,14.2650547 9.42948307,13.9835365 C8.86644666,13.7020183 8.18643739,13.8123686 7.74131803,14.2574879 L6.2303083,15.7684977 C6.17542087,15.8233851 6.13406645,15.8902979 6.10952004,15.9639372 C6.02219616,16.2259088 6.16377615,16.5090688 6.42574781,16.5963927 L7.77956724,17.0476658 C9.07965249,17.4810276 10.5130001,17.1426601 11.4820264,16.1736338 L15.4812434,12.1744168 C16.3714821,11.2841781 16.5921828,9.92415954 16.0291464,8.79808673 L15.3965752,7.53294436 C15.3725414,7.48487691 15.3409156,7.44099843 15.302915,7.40299777 C15.1076528,7.20773562 14.7910703,7.20773562 14.5958082,7.40299777 L13.0032662,8.99553978 C12.5581468,9.44065914 12.4477965,10.1206684 12.7293147,10.6837048 C13.0108329,11.2467412 12.9004826,11.9267505 12.4553632,12.3718698 L11.1176481,13.709585 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Acccount Information</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M4,16 L5,16 C5.55228475,16 6,16.4477153 6,17 C6,17.5522847 5.55228475,18 5,18 L4,18 C3.44771525,18 3,17.5522847 3,17 C3,16.4477153 3.44771525,16 4,16 Z M1,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L1,13 C0.44771525,13 6.76353751e-17,12.5522847 0,12 C-6.76353751e-17,11.4477153 0.44771525,11 1,11 Z M3,6 L5,6 C5.55228475,6 6,6.44771525 6,7 C6,7.55228475 5.55228475,8 5,8 L3,8 C2.44771525,8 2,7.55228475 2,7 C2,6.44771525 2.44771525,6 3,6 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M10,6 L22,6 C23.1045695,6 24,6.8954305 24,8 L24,16 C24,17.1045695 23.1045695,18 22,18 L10,18 C8.8954305,18 8,17.1045695 8,16 L8,8 C8,6.8954305 8.8954305,6 10,6 Z M21.0849395,8.0718316 L16,10.7185839 L10.9150605,8.0718316 C10.6132433,7.91473331 10.2368262,8.02389331 10.0743092,8.31564728 C9.91179228,8.60740125 10.0247174,8.9712679 10.3265346,9.12836619 L15.705737,11.9282847 C15.8894428,12.0239051 16.1105572,12.0239051 16.294263,11.9282847 L21.6734654,9.12836619 C21.9752826,8.9712679 22.0882077,8.60740125 21.9256908,8.31564728 C21.7631738,8.02389331 21.3867567,7.91473331 21.0849395,8.0718316 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Payments</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<circle fill="#000000" cx="6" cy="18" r="3"></circle>
																	<path d="M16.5,21 L13.5,21 C13.5,15.2010101 8.79898987,10.5 3,10.5 L3,7.5 C10.4558441,7.5 16.5,13.5441559 16.5,21 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M22.5,21 L19.5,21 C19.5,12.163444 11.836556,4.5 3,4.5 L3,1.5 C13.4934102,1.5 22.5,10.5065898 22.5,21 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Social Networks</span>
													</a>
												</li>
												<li class="nav__separator"></li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--danger">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M12.7442084,3.27882877 L19.2473374,6.9949025 C19.7146999,7.26196679 20.003129,7.75898194 20.003129,8.29726722 L20.003129,15.7027328 C20.003129,16.2410181 19.7146999,16.7380332 19.2473374,17.0050975 L12.7442084,20.7211712 C12.2830594,20.9846849 11.7169406,20.9846849 11.2557916,20.7211712 L4.75266256,17.0050975 C4.28530007,16.7380332 3.99687097,16.2410181 3.99687097,15.7027328 L3.99687097,8.29726722 C3.99687097,7.75898194 4.28530007,7.26196679 4.75266256,6.9949025 L11.2557916,3.27882877 C11.7169406,3.01531506 12.2830594,3.01531506 12.7442084,3.27882877 Z M12,14.5 C13.3807119,14.5 14.5,13.3807119 14.5,12 C14.5,10.6192881 13.3807119,9.5 12,9.5 C10.6192881,9.5 9.5,10.6192881 9.5,12 C9.5,13.3807119 10.6192881,14.5 12,14.5 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Statements</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" href="#" role="tab" data-toggle="tooltip" title="" data-placement="right" data-original-title="This feature is coming soon!">
														<span class="nav__link-icon">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--success">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"></polygon>
																	<path d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" fill="#000000"></path>
																</g>
															</svg> </span>
														<span class="nav__link-text">Audit Log</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<!--end::Dropdown-->

								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Modern Navigation Menu 2
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content section__content--border section__content--fit">
											<ul class="nav nav--block nav--bold nav--md-space nav--v4" role="tablist">
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Buying</span>
													</a>
												</li>
												<li class="nav__item active">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Product Support</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Account Management</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Product Licenses</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Downloads</span>
													</a>
												</li>

											</ul>
										</div>
									</div>
									<!--end::Section-->
									<!--begin::Dropdown-->
									<div class="dropdown">
										<a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
											Dropdown example
										</a>
										<div class="dropdown-menu dropdown-menu-xl">
											<ul class="nav nav--block nav--bold nav--md-space nav--v4" role="tablist">
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Buying</span>
													</a>
												</li>
												<li class="nav__item active">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Product Support</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Account Management</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Product Licenses</span>
													</a>
												</li>
												<li class="nav__item">
													<a class="nav__link" data-toggle="tab" href="#profile_tab_personal_information" role="tab">
														<span class="nav__link-text">Downloads</span>
													</a>
												</li>

											</ul>
										</div>
									</div>
									<!--end::Dropdown-->
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