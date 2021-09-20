<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">


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



<body class="subheader--transparent page--loading">
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
							<h3 class="subheader__title">Options</h3>

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
									Form Controls </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Mega Options </a>
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
						<div class="col-lg-12 col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Default Example
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="form-group form-group-marginless">
											<label>Choose Delivery Type:</label>
											<div class="row">
												<div class="col-lg-6">
													<label class="option">
														<span class="option__control">
															<span class="radio radio--check-bold">
																<input type="radio" name="m_option_1" value="1" checked="">
																<span></span>
															</span>
														</span>
														<span class="option__label">
															<span class="option__head">
																<span class="option__title">
																	Standart Delevery
																</span>
																<span class="option__focus">
																	Free
																</span>
															</span>
															<span class="option__body">
																Estimated 14-20 Day Shipping
																(&nbsp;Duties end taxes may be due
																upon delivery&nbsp;)
															</span>
														</span>
													</label>
												</div>
												<div class="col-lg-6">
													<label class="option">
														<span class="option__control">
															<span class="radio radio--check-bold">
																<input type="radio" name="m_option_1" value="1">
																<span></span>
															</span>
														</span>
														<span class="option__label">
															<span class="option__head">
																<span class="option__title">
																	Fast Delevery
																</span>
																<span class="option__focus">
																	$&nbsp;8.00
																</span>
															</span>
															<span class="option__body">
																Estimated 2-5 Day Shipping
																(&nbsp;Duties end taxes may be due
																upon delivery&nbsp;)
															</span>
														</span>
													</label>
												</div>
											</div>
										</div>

										<div class="separator separator--border-dashed separator--space-lg"></div>

										<div class="form-group">
											<label>Membership:</label>
											<div class="row">
												<div class="col-lg-6">
													<label class="option option option--plain">
														<span class="option__control">
															<span class="radio radio--check-bold">
																<input type="radio" name="m_option_1" value="1" checked="">
																<span></span>
															</span>
														</span>
														<span class="option__label">
															<span class="option__head">
																<span class="option__title">
																	Premium Partner
																</span>
															</span>
															<span class="option__body">
																30 days free trial and lifetime free updates
															</span>
														</span>
													</label>
												</div>
												<div class="col-lg-6">
													<label class="option option option--plain">
														<span class="option__control">
															<span class="radio radio--check-bold">
																<input type="radio" name="m_option_1" value="1" checked="">
																<span></span>
															</span>
														</span>
														<span class="option__label">
															<span class="option__head">
																<span class="option__title">
																	Free Membership
																</span>
															</span>
															<span class="option__body">
																24/7 support and Lifetime access
															</span>
														</span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="card-foot">
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
						<div class="col-lg-12 col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Horizontal Form Example
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="form-group row form-group-marginless">
											<label class="col-lg-2 col-form-label">Delivery:</label>
											<div class="col-lg-10">
												<div class="row">
													<div class="col-lg-6">
														<label class="option">
															<span class="option__control">
																<span class="radio radio--bold radio--brand radio--check-bold" checked="">
																	<input type="radio" name="m_option_1" value="1">
																	<span></span>
																</span>
															</span>
															<span class="option__label">
																<span class="option__head">
																	<span class="option__title">
																		Standart Delevery
																	</span>
																	<span class="option__focus">
																		Free
																	</span>
																</span>
																<span class="option__body">
																	Estimated 14-20 Day Shipping
																	(Duties end taxes may be due)
																</span>
															</span>
														</label>
													</div>
													<div class="col-lg-6">
														<label class="option">
															<span class="option__control">
																<span class="radio radio--bold radio--brand">
																	<input type="radio" name="m_option_1" value="1">
																	<span></span>
																</span>
															</span>
															<span class="option__label">
																<span class="option__head">
																	<span class="option__title">
																		Fast Delevery
																	</span>
																	<span class="option__focus">
																		$&nbsp;8.00
																	</span>
																</span>
																<span class="option__body">
																	Estimated 2-5 Day Shipping
																	(Duties end taxes may be due)
																</span>
															</span>
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="separator separator--border-dashed separator--space-lg"></div>

										<div class="form-group row form-group-marginless">
											<label class="col-lg-2 col-form-label">Full Name:</label>
											<div class="col-lg-10">
												<div class="row">
													<div class="col-lg-6">
														<label class="option option--plain">
															<span class="option__control">
																<span class="radio radio--brand">
																	<input type="radio" name="m_option_1" value="1">
																	<span></span>
																</span>
															</span>
															<span class="option__label">
																<span class="option__head">
																	<span class="option__title">
																		Premium Partner
																	</span>
																</span>
																<span class="option__body">
																	30 days free trial and lifetime free updates
																</span>
															</span>
														</label>
													</div>
													<div class="col-lg-6">
														<label class="option option--plain">
															<span class="option__control">
																<span class="radio radio--brand">
																	<input type="radio" name="m_option_1" value="1" checked="">
																	<span></span>
																</span>
															</span>
															<span class="option__label">
																<span class="option__head">
																	<span class="option__title">
																		Free Membership
																	</span>
																</span>
																<span class="option__body">
																	24/7 support and Lifetime access
																</span>
															</span>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-foot">
										<div class="form__actions">
											<button type="reset" class="btn btn-success">Submit</button>
											<button type="reset" class="btn btn-secondary">Cancel</button>
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