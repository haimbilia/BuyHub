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
							<h3 class="subheader__title">Switch</h3>

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
									Switch </a>
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
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group row">
											<label class="col-3 col-form-label">Default Switch</label>
											<div class="col-3">
												<span class="switch">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">With Icon</label>
											<div class="col-3">
												<span class="switch switch--icon">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Unchacked State</label>
											<div class="col-3">
												<span class="switch">
													<label>
														<input type="checkbox" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">With Icon</label>
											<div class="col-3">
												<span class="switch switch--icon">
													<label>
														<input type="checkbox" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Disabled State</label>
											<div class="col-3">
												<span class="switch">
													<label>
														<input type="checkbox" disabled="" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">With Icon</label>
											<div class="col-3">
												<span class="switch switch--icon">
													<label>
														<input type="checkbox" disabled="" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
									</form>
									<!--end::Form-->
								</div>
							</div>
							<!--end::card-->
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Sizing
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section section--last">
										<div class="section__title">Large size:</div>
										<div class="section__content">
											<!--begin::Form-->
											<form class="form">
												<div class="form-group row">
													<label class="col-3 col-form-label">Default Switch</label>
													<div class="col-3">
														<span class="switch switch--lg">
															<label>
																<input type="checkbox" checked="checked" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--lg switch--icon">
															<label>
																<input type="checkbox" checked="checked" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-3 col-form-label">Unchacked State</label>
													<div class="col-3">
														<span class="switch switch--lg">
															<label>
																<input type="checkbox" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--lg switch--icon">
															<label>
																<input type="checkbox" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-3 col-form-label">Disabled State</label>
													<div class="col-3">
														<span class="switch switch--lg">
															<label>
																<input type="checkbox" disabled="" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--lg switch--icon">
															<label>
																<input type="checkbox" disabled="" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
											</form>
											<!--end::Form-->
										</div>

										<div class="section__title">Small size:</div>
										<div class="section__content">
											<!--begin::Form-->
											<form class="form">
												<div class="form-group row">
													<label class="col-3 col-form-label">Default Switch</label>
													<div class="col-3">
														<span class="switch switch--sm">
															<label>
																<input type="checkbox" checked="checked" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--sm switch--icon">
															<label>
																<input type="checkbox" checked="checked" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-3 col-form-label">Unchacked State</label>
													<div class="col-3">
														<span class="switch switch--sm">
															<label>
																<input type="checkbox" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--sm switch--icon">
															<label>
																<input type="checkbox" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-3 col-form-label">Disabled State</label>
													<div class="col-3">
														<span class="switch switch--sm">
															<label>
																<input type="checkbox" disabled="" name="">
																<span></span>
															</label>
														</span>
													</div>
													<label class="col-3 col-form-label">With Icon</label>
													<div class="col-3">
														<span class="switch switch--sm switch--icon">
															<label>
																<input type="checkbox" disabled="" name="">
																<span></span>
															</label>
														</span>
													</div>
												</div>
											</form>
											<!--end::Form-->
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
										<h3 class="card-head-title">
											Solid Style
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group row">
											<label class="col-3 col-form-label">Success</label>
											<div class="col-3">
												<span class="switch switch--success">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Primary</label>
											<div class="col-3">
												<span class="switch switch--primary">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Info</label>
											<div class="col-3">
												<span class="switch switch--info">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Danger</label>
											<div class="col-3">
												<span class="switch switch--danger">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Brand</label>
											<div class="col-3">
												<span class="switch switch--brand">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Dark</label>
											<div class="col-3">
												<span class="switch switch--dark">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
									</form>
									<!--end::Form-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Outline Style
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group row">
											<label class="col-3 col-form-label">Success</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--success">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Warning</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--warning">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Info</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--info">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Danger</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--danger">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Primary</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--primary">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
											<label class="col-3 col-form-label">Brand</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--brand">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Dark</label>
											<div class="col-3">
												<span class="switch switch--outline switch--icon switch--dark">
													<label>
														<input type="checkbox" checked="checked" name="">
														<span></span>
													</label>
												</span>
											</div>
										</div>
									</form>
									<!--end::Form-->
								</div>
							</div>
							<!--end::card-->
						</div>
					</div>
				</div>
				<!-- end:: Content -->
			</div>
		</div>


<?php  include 'includes/footer.php';?>
</div>

</body>


</html>