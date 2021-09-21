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



<body class="subheader--transparent page--loading">
	<div class="wrapper">

		<?php
  include 'includes/header.php';
?>
		<div class="body" id="body">
			<div class="content " id="content">

				<!-- begin:: Subheader -->
				<div id="subheader" class="subheader" >
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Form Repeater</h3>

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
									Form Widgets 2 </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Form Repeater </a>
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
						<div class="col">
							<div class="alert alert-light alert-elevate fade show" role="alert">
								<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
								<div class="alert-text">
									Create a repeatable group of input elements.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://github.com/DubFriend/jquery.repeater" target="_blank">Github Repo</a>.
								</div>
							</div>
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
									Form Repeater Example
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form">
							<div class="card-body">
								<div class="form__section form__section--first">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Full Name:</label>
										<div class="col-lg-4">
											<input type="email" class="form-control" placeholder="Enter full name">
											<span class="form-text text-muted">Please enter your full name</span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Email address:</label>
										<div class="col-lg-4">
											<input type="email" class="form-control" placeholder="Enter email">
											<span class="form-text text-muted">We'll never share your email with anyone else</span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Contact</label>
										<div class="col-lg-4">
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text"><i class="la la-chain"></i></span></div>
												<input type="text" class="form-control" placeholder="Phone number">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Communication:</label>
										<div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
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

									<div class="separator separator--border-dashed separator--space-lg"></div>

									<div id="repeater_1">
										<div class="form-group form-group-last row" id="repeater_1">
											<label class="col-lg-2 col-form-label">Contacts:</label>
											<div data-repeater-list="" class="col-lg-10">
												<div data-repeater-item="" class="form-group row align-items-center">
													<div class="col-md-3">
														<div class="form__group--inline">
															<div class="form__label">
																<label>Name:</label>
															</div>
															<div class="form__control">
																<input type="email" class="form-control" placeholder="Enter full name">
															</div>
														</div>
														<div class="d-md-none margin-b-10"></div>
													</div>
													<div class="col-md-3">
														<div class="form__group--inline">
															<div class="form__label">
																<label class="label m-label--single">Number:</label>
															</div>
															<div class="form__control">
																<input type="email" class="form-control" placeholder="Enter contact number">
															</div>
														</div>
														<div class="d-md-none margin-b-10"></div>
													</div>
													<div class="col-md-2">
														<div class="radio-inline">
															<label class="checkbox checkbox--state-success">
																<input type="checkbox"> Primary
																<span></span>
															</label>
														</div>
													</div>
													<div class="col-md-4">
														<a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
															<i class="la la-trash-o"></i>
															Delete
														</a>
													</div>
												</div>
												<div data-repeater-item="" class="form-group row align-items-center" style="">
													<div class="col-md-3">
														<div class="form__group--inline">
															<div class="form__label">
																<label>Name:</label>
															</div>
															<div class="form__control">
																<input type="email" class="form-control" placeholder="Enter full name">
															</div>
														</div>
														<div class="d-md-none margin-b-10"></div>
													</div>
													<div class="col-md-3">
														<div class="form__group--inline">
															<div class="form__label">
																<label class="label m-label--single">Number:</label>
															</div>
															<div class="form__control">
																<input type="email" class="form-control" placeholder="Enter contact number">
															</div>
														</div>
														<div class="d-md-none margin-b-10"></div>
													</div>
													<div class="col-md-2">
														<div class="radio-inline">
															<label class="checkbox checkbox--state-success">
																<input type="checkbox"> Primary
																<span></span>
															</label>
														</div>
													</div>
													<div class="col-md-4">
														<a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
															<i class="la la-trash-o"></i>
															Delete
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group form-group-last row">
											<label class="col-lg-2 col-form-label"></label>
											<div class="col-lg-4">
												<a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
													<i class="la la-plus"></i> Add
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-foot">
								<div class="form__actions">
									<div class="row">
										<div class="col-lg-2"></div>
										<div class="col-lg-2">
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
					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Form Repeater Example
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="form__section form__section--first">
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
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Communication:</label>
												<div class="col-lg-12 col-xl-8">
													<div class="checkbox-inline padding-top-3">
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
											<div class="form-group row">
												<label class="col-form-label col-lg-3 col-sm-12">Credit Card</label>
												<div class="col-lg-6 ">
													<div class="input-group">
														<input type="text" class="form-control" name="creditcard" placeholder="Enter card number">
														<div class="input-group-append">
															<span class="input-group-text"><i class="la la-credit-card"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div id="repeater_2">
												<div class="form-group  row">
													<label class="col-lg-3 col-form-label">Contact:</label>
													<div data-repeater-list="" class="col-lg-6">
														<div data-repeater-item="" class="margin-b-10">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-phone"></i>
																	</span>
																</div>
																<input type="text" class="form-control form-control-danger" placeholder="Enter telephone">
																<div class="input-group-append">
																	<a href="javascript:;" class="btn btn-danger btn-icon">
																		<i class="la la-close"></i>
																	</a>
																</div>
															</div>
														</div>
														<div data-repeater-item="" class="margin-b-10" style="">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-phone"></i>
																	</span>
																</div>
																<input type="text" class="form-control form-control-danger" placeholder="Enter telephone">
																<div class="input-group-append">
																	<a href="javascript:;" class="btn btn-danger btn-icon">
																		<i class="la la-close"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-3"></div>
													<div class="col">
														<div data-repeater-create="" class="btn btn btn-warning">
															<span>
																<i class="la la-plus"></i>
																<span>Add</span>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-foot">
										<div class="form__actions">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6">
													<button type="reset" class="btn btn-brand">Submit</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
						</div>

						<div class="col-lg-6">
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Form Repeater Example
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="form__section form__section--first">
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
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Communication:</label>
												<div class="col-lg-12 col-xl-8">
													<div class="checkbox-inline padding-top-3">
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
											<div class="form-group row">
												<label class="col-form-label col-lg-3 col-sm-12">Credit Card</label>
												<div class="col-lg-6 ">
													<div class="input-group">
														<input type="text" class="form-control" name="creditcard" placeholder="Enter card number">
														<div class="input-group-append"><span class="input-group-text"><i class="la la-credit-card"></i></span></div>
													</div>
												</div>
											</div>
											<div id="repeater_3">
												<div class="form-group  row">
													<label class="col-lg-3 col-form-label">Contact:</label>
													<div data-repeater-list="" class="col-lg-9">
														<div data-repeater-item="" class="row margin-b-10">
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-phone"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Phone">
																</div>
															</div>
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-envelope"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Email">
																</div>
															</div>
															<div class="col-lg-2">
																<a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-icon">
																	<i class="la la-remove"></i>
																</a>
															</div>
														</div>
														<div data-repeater-item="" class="row margin-b-10" style="">
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-phone"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Phone">
																</div>
															</div>
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-envelope"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Email">
																</div>
															</div>
															<div class="col-lg-2">
																<a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-icon">
																	<i class="la la-remove"></i>
																</a>
															</div>
														</div>
														<div data-repeater-item="" class="row margin-b-10" style="">
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-phone"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Phone">
																</div>
															</div>
															<div class="col-lg-5">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="la la-envelope"></i>
																		</span>
																	</div>
																	<input type="text" class="form-control form-control-danger" placeholder="Email">
																</div>
															</div>
															<div class="col-lg-2">
																<a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-icon">
																	<i class="la la-remove"></i>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-3"></div>
													<div class="col">
														<div data-repeater-create="" class="btn btn btn-primary">
															<span>
																<i class="la la-plus"></i>
																<span>Add</span>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-foot">
										<div class="form__actions">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6">
													<button type="reset" class="btn btn-brand btn-pill btn-elevate">Submit</button>
													<button type="reset" class="btn btn-secondary btn-pill btn-elevate">Cancel</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
						</div>
					</div>
					<!--end::card-->

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