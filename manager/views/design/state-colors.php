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
							<h3 class="subheader__title">State Colors</h3>

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
									State Colors </a>
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
						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											State Colors
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">
											You can apply Bootstrap and FB-admin state color helper classes to the most of the Keen's components:
										</div>
										<div class="section__content">
											<div class="table-responsive">
												<table class="table table-bordered table-head-solid">
													<thead>
														<tr>
															<th style="width: 150px">State</th>
															<th style="width: 200px">Class postfix</th>
															<th>Usage example</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td colspan="4"><span class="font-bold">Bootstrap States</span></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--success">Success</span></td>
															<td><code>*-success</code></td>
															<td><code>btn-success</code> <code>font-success</code></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--warning">Warning</span></td>
															<td><code>*-warning</code></td>
															<td><code>btn-warning</code> <code>font-warning</code></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--danger">Danger</span></td>
															<td><code>*-danger</code></td>
															<td><code>btn-danger</code> <code>font-danger</code></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--info">Info</span></td>
															<td><code>*-info</code></td>
															<td><code>btn-info</code> <code>font-info</code></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--primary">Primary</span></td>
															<td><code>*-primary</code></td>
															<td><code>btn-primary</code> <code>font-primary</code></td>
														</tr>
														<tr>
															<td colspan="4"><span class="font-bold">FB-admin Custom States</span></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--brand">Brand</span></td>
															<td><code>*-brand</code></td>
															<td><code>btn-success</code> <code>font-brand</code></td>
														</tr>
														<tr>
															<td><span class="badge badge--inline badge--dark">Dark</span></td>
															<td><code>*-dark</code></td>
															<td><code>btn-dark</code> <code>font-dark</code></td>
														</tr>
														<tr class="active">
															<td><span class="badge badge--inline badge--light">Light</span></td>
															<td><code>*-light</code></td>
															<td><code>btn-light</code> <code>font-light</code></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Base Colors
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__info">
											You can apply Keen's base color helper classes to the most of the Keen's components:
										</div>
										<div class="section__content ">
											<div class="table-responsive">
												<table class="table table-bordered table-head-solid">
													<thead>
														<tr>
															<th style="width: 150px">Level</th>
															<th width="200">Preview</th>
															<th>Class example</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td colspan="4"><span class="font-bold">Label Classes</span></td>
														</tr>
														<tr>
															<td>Level 1</td>
															<td>
																<span class="label-font-color-1">Font Color</span>
																&nbsp;
																<span class="label-bg-color-1" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>label-font-color-1</code>&nbsp;
																<code>label-bg-color-1</code>
															</td>
														</tr>
														<tr>
															<td>Level 2</td>
															<td>
																<span class="label-font-color-2">Font Color</span>
																&nbsp;
																<span class="label-bg-color-2" style="padding: 5px;  color: #fff;">BG Color</span>
															</td>
															<td>
																<code>label-font-color-2</code>&nbsp;
																<code>label-bg-color-2</code>
															</td>
														</tr>
														<tr>
															<td>Level 3</td>
															<td>
																<span class="label-font-color-3">Font Color</span>
																&nbsp;
																<span class="label-bg-color-3" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>label-font-color-3</code>&nbsp;
																<code>label-bg-color-3</code>
															</td>
														</tr>
														<tr>
															<td>Level 4</td>
															<td>
																<span class="label-font-color-4">Font Color</span>
																&nbsp;
																<span class="label-bg-color-4" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>label-font-color-4</code>&nbsp;
																<code>label-bg-color-4</code>
															</td>
														</tr>
														<tr>
															<td colspan="4"><span class="font-bold">Shape Classes</span></td>
														</tr>
														<tr>
															<td>Level 1</td>
															<td>
																<span class="shape-font-color-1">Font Color</span>
																&nbsp;
																<span class="shape-bg-color-1" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>shape-font-color-1</code>&nbsp;
																<code>shape-bg-color-1</code>
															</td>
														</tr>
														<tr>
															<td>Level 2</td>
															<td>
																<span class="shape-font-color-2">Font Color</span>
																&nbsp;
																<span class="shape-bg-color-2" style="padding: 5px;  color: #fff;">BG Color</span>
															</td>
															<td>
																<code>shape-font-color-2</code>&nbsp;
																<code>shape-bg-color-2</code>
															</td>
														</tr>
														<tr>
															<td>Level 3</td>
															<td>
																<span class="shape-font-color-3">Font Color</span>
																&nbsp;
																<span class="shape-bg-color-3" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>shape-font-color-3</code>&nbsp;
																<code>shape-bg-color-3</code>
															</td>
														</tr>
														<tr>
															<td>Level 4</td>
															<td>
																<span class="shape-font-color-4">Font Color</span>
																&nbsp;
																<span class="shape-bg-color-4" style="padding: 5px; color: #fff;">BG Color</span>
															</td>
															<td>
																<code>shape-font-color-4</code>&nbsp;
																<code>shape-bg-color-4</code>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card card--tab">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Typography Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__desc">
											Apply state color classes to any typography element:
										</div>
										<div class="section__content section__content--solid--">
											<span class="font-success">Success state text</span>&nbsp;
											<span class="font-warning">Warning state text</span>&nbsp;
											<span class="font-info">Info state text</span><br><br>
											<span class="font-danger font-bold">Danger state text</span>&nbsp;
											<span class="font-primary font-bold">Primary state text</span>&nbsp;
											<span class="font-brand font-bold">Focus state text</span>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__desc">
											Apply base color classes to any typography element:
										</div>
										<div class="section__content section__content--solid--">
											<span class="label-font-color-4">Label color level 4</span>&nbsp;&nbsp;
											<span class="label-font-color-3">Label color level 3</span>&nbsp;&nbsp;
											<span class="label-font-color-2">Label color level 2</span>&nbsp;&nbsp;
											<span class="label-font-color-1">Label color level 1</span>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tab">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Button Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__info">
											Apply color classes to any component:
										</div>
										<div class="section__content section__content--solid--">
											<a href="#" class="btn btn-primary">Primary</a>
											<a href="#" class="btn btn-success">Success</a>
											<a href="#" class="btn btn-warning">Warning</a>
											<a href="#" class="btn btn-danger">Danger</a>
											<a href="#" class="btn btn-brand">Brand</a>
											<a href="#" class="btn btn-dark">Dark</a>


											<div class="separator separator--space-lg separator--border-dashed"></div>

											<a href="#" class="btn btn-outline-success">Success</a>
											<a href="#" class="btn btn-outline-warning">Warning</a>
											<a href="#" class="btn btn-outline-danger">Danger</a>
											<a href="#" class="btn btn-outline-dark">Dark</a>
											<a href="#" class="btn btn-outline-brand">Brand</a>
											<a href="#" class="btn btn-outline-primary">Primary</a>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tab">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Alert Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<div class="alert alert-success" role="alert">
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>

											<div class="alert alert-danger" role="alert">
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>

											<div class="alert alert-warning" role="alert">
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>

											<div class="alert alert-outline-brand alert-dismissible fade show" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												</button>
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>

											<div class="alert alert-outline-success" role="alert">
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>

											<div class="alert alert-outline-danger alert-dismissible fade show" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												</button>
												<strong>Well done!</strong> You successfully read this important alert message.
											</div>


											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
											</div>

											<div class="space-10"></div>

											<div class="progress">
												<div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
											</div>

											<div class="space-10"></div>

											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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