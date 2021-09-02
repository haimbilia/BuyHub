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
		<div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
			<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

				<!-- begin:: Subheader -->
				<div class="subheader   grid__item" id="subheader">
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">

								Spinners </h3>

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
									Spinners </a>
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
										<h3 class="card-head-title">
											Basic Spinners
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Color and size options:</div>
										<div class="section__content section__content--solid--">
											<div class="row">
												<div class="col-sm">
													<div class="spinner spinner--sm spinner--brand"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--sm spinner--success"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--md spinner--info"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--md spinner--danger"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--lg spinner--dark"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--lg spinner--warning"></div>
												</div>
											</div>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Using with buttons:</div>
										<div class="section__content section__content--solid--">
											<button class="btn btn-outline-success spinner spinner--sm spinner--danger">Button</button>&nbsp;
											<button class="btn btn-brand spinner spinner--right spinner--sm spinner--light">Button</button>&nbsp;

											<button class="btn btn-outline-brand spinner spinner--md spinner--danger">Button</button>&nbsp;

											<div class="space-20"></div>

											<button class="btn btn-primary spinner spinner--right spinner--md spinner--light">Button</button>&nbsp;

											<button class="btn btn-outline-dark spinner spinner--lg spinner--danger">Button</button>&nbsp;
											<button class="btn btn-danger spinner spinner--right spinner--lg spinner--light">Button</button>&nbsp;

											<div class="space-20"></div>

											<button class="btn btn-outline-success btn-icon"><i class="la la-user"></i></button>&nbsp;
											<button class="btn btn-brand btn-icon spinner spinner--center spinner--sm spinner--light"></button>&nbsp;
											<button class="btn btn-success btn-icon btn-circle spinner spinner--center spinner--sm spinner--light"></button>&nbsp;
											<button class="btn btn-outline-dark btn-icon spinner spinner--center spinner--sm spinner--danger"></button>&nbsp;
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Using with form controls:</div>
										<div class="section__content section__content--solid--">
											<div class="spinner spinner--sm spinner--success spinner--right spinner--input">
												<input type="text" class="form-control">
											</div>

											<div class="space-10"></div>

											<div class="spinner spinner--sm spinner--danger spinner--left spinner--input">
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>

						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Style Options
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Color and size options:</div>
										<div class="section__content section__content--solid--">
											<div class="row">
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--sm spinner--brand"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--sm spinner--success"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--md spinner--info"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--md spinner--danger"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--lg spinner--dark"></div>
												</div>
												<div class="col-sm">
													<div class="spinner spinner--v2 spinner--lg spinner--warning"></div>
												</div>
											</div>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Using with buttons:</div>
										<div class="section__content section__content--solid--">
											<button class="btn btn-outline-success spinner spinner--v2 spinner--sm spinner--danger">Button</button>&nbsp;
											<button class="btn btn-brand spinner spinner--v2 spinner--right spinner--sm spinner--dark">Button</button>&nbsp;

											<button class="btn btn-outline-success spinner spinner--v2 spinner--md spinner--danger">Button</button>&nbsp;
											<div class="space-20"></div>
											<button class="btn btn-primary spinner spinner--v2 spinner--right spinner--md spinner--warning">Button</button>&nbsp;

											<button class="btn btn-outline-dark spinner spinner--v2 spinner--lg spinner--danger">Button</button>&nbsp;
											<button class="btn btn-danger spinner spinner--v2 spinner--right spinner--lg spinner--success">Button</button>&nbsp;

											<div class="space-20"></div>

											<button class="btn btn-outline-success btn-icon"><i class="la la-user"></i></button>&nbsp;
											<button class="btn btn-brand btn-icon spinner spinner--v2 spinner--center spinner--sm spinner--primary"></button>&nbsp;
											<button class="btn btn-success btn-icon btn-circle spinner spinner--v2 spinner--center spinner--sm spinner--danger"></button>&nbsp;
											<button class="btn btn-outline-dark btn-icon spinner spinner--v2 spinner--center spinner--sm spinner--danger"></button>&nbsp;
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Using with form controls:</div>
										<div class="section__content section__content--solid--">
											<div class="spinner spinner--v2 spinner--sm spinner--success spinner--right spinner--input">
												<input type="text" class="form-control">
											</div>

											<div class="space-10"></div>

											<div class="spinner spinner--v2 spinner--sm spinner--danger spinner--left spinner--input">
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
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