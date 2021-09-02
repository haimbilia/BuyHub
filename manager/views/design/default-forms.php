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
							<h3 class="subheader__title">Default Forms</h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Crud </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Forms &amp; Controls </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Form Layouts </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Default Forms </a>
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
										<h3 class="card-head-title">
											Basic Form Layout
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="section section--first">
											<div class="form-group">
												<label>Full Name:</label>
												<input type="email" class="form-control" placeholder="Enter full name">
												<span class="form-text text-muted">Please enter your full name</span>
											</div>
											<div class="form-group">
												<label>Email address:</label>
												<input type="email" class="form-control" placeholder="Enter email">
												<span class="form-text text-muted">We'll never share your email with anyone else</span>
											</div>
											<div class="form-group">
												<label>Subscription</label>
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon2">$</span></div>
													<input type="text" class="form-control" placeholder="99.9">
												</div>
											</div>
											<div class="form-group">
												<label>Communication:</label>
												<div class="checkbox-list">
													<label class="checkbox">
														<input type="checkbox"> Email
														<span></span>
													</label>
													<label class="checkbox">
														<input type="checkbox"> SMS
														<span></span>
													</label>
													<label class="checkbox">
														<input type="checkbox"> Phone
														<span></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<button type="reset" class="btn btn-primary">Submit</button>
											<button type="reset" class="btn btn-secondary">Cancel</button>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Section Separator
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="section section--first">
											<div class="form-group">
												<label>Full Name:</label>
												<input type="email" class="form-control" placeholder="Enter full name">
												<span class="form-text text-muted">Please enter your full name</span>
											</div>
											<div class="separator separator--border-dashed separator--space-lg separator--card-fit"></div>
											<div class="form-group">
												<label>Email address:</label>
												<input type="email" class="form-control" placeholder="Enter email">
												<span class="form-text text-muted">We'll never share your email with anyone else</span>
											</div>
											<div class="separator separator--border-dashed separator--space-lg separator--card-fit"></div>
											<div class="form-group">
												<label>Subscription</label>
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon2">$</span></div>
													<input type="text" class="form-control" placeholder="99.9">
												</div>
											</div>
											<div class="separator separator--border-dashed separator--space-lg separator--card-fit"></div>
											<div class="form-group">
												<label>Communication:</label>
												<div class="checkbox-list">
													<label class="checkbox">
														<input type="checkbox"> Email
														<span></span>
													</label>
													<label class="checkbox">
														<input type="checkbox"> SMS
														<span></span>
													</label>
													<label class="checkbox">
														<input type="checkbox"> Phone
														<span></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<button type="reset" class="btn btn-primary">Submit</button>
											<button type="reset" class="btn btn-secondary">Cancel</button>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::card-->
						</div>
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Horizontal Form Layout
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="section section--first">
											<h3 class="section__title">1. Customer Info:</h3>
											<div class="section__body">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Full Name:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter full name">
														<span class="form-text text-muted">Please enter your full name</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Email address:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter email">
														<span class="form-text text-muted">We'll never share your email with anyone else</span>
													</div>
												</div>
											</div>

											<h3 class="section__title">2. Customer Account:</h3>
											<div class="section__body">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Holder:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter full name">
														<span class="form-text text-muted">Please enter your account holder</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Contact</label>
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-prepend"><span class="input-group-text"><i class="la la-chain"></i></span></div>
															<input type="text" class="form-control" placeholder="Phone number">
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Communication:</label>
													<div class="col-lg-6">
														<div class="checkbox-inline">
															<label class="checkbox">
																<input type="checkbox"> Email
																<span></span>
															</label>
															<label class="checkbox">
																<input type="checkbox"> SMS
																<span></span>
															</label>
															<label class="checkbox">
																<input type="checkbox"> Phone
																<span></span>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6">
													<button type="reset" class="btn btn-success">Submit</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Horizontal Form Layout
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="section section--first">
											<h3 class="section__title">1. Customer Info:</h3>
											<div class="section__body">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Full Name:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter full name">
														<span class="form-text text-muted">Please enter your full name</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Email address:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter email">
														<span class="form-text text-muted">We'll never share your email with anyone else</span>
													</div>
												</div>
											</div>

											<div class="separator separator--border-dashed separator--space-lg"></div>

											<h3 class="section__title">2. Customer Account:</h3>
											<div class="section__body">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Holder:</label>
													<div class="col-lg-6">
														<input type="email" class="form-control" placeholder="Enter full name">
														<span class="form-text text-muted">Please enter your account holder</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Contact</label>
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-prepend"><span class="input-group-text"><i class="la la-chain"></i></span></div>
															<input type="text" class="form-control" placeholder="Phone number">
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Communication:</label>
													<div class="col-lg-6">
														<div class="checkbox-inline">
															<label class="checkbox">
																<input type="checkbox"> Email
																<span></span>
															</label>
															<label class="checkbox">
																<input type="checkbox"> SMS
																<span></span>
															</label>
															<label class="checkbox">
																<input type="checkbox"> Phone
																<span></span>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6">
													<button type="reset" class="btn btn-success">Submit</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<!--end::Form-->
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