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

								Input Groups </h3>

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
									Input Groups </a>
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
											Basic Example
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Use any icon in input group from <a class="link" href="flaticon.html">Flaticon</a>, <a class="link" href="fontawesome5.html">Fontawesome 5</a>, <a class="link" href="lineawesome.html">Lineawesome</a> or <a class="link" href="socicons.html">Socicons</a> icons.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Addon</label>
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text">@</span></div>
												<input type="text" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group form-group-marginless">
											<label>Right Addon</label>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon2">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon2">@example.com</span></div>
											</div>
										</div>
										<div class="separator separator--border-dashed separator--space-lg"></div>
										<div class="form-group ">
											<label>Joint Addons</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">$</span>
													<span class="input-group-text">0.00</span>
												</div>
												<input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
											</div>
										</div>
										<div class="form-group ">
											<label>Left &amp; Right Addons</label>
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">#</span></div>
												<input type="text" class="form-control" placeholder="Units" aria-describedby="basic-addon1">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon1">px</span></div>
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

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											With Icons
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Easily extend form controls by adding text, buttons, icons, or button groups on either side of textual.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Addon</label>
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="la la-exclamation-triangle font-brand"></i></span></div>
												<input type="text" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group form-group-marginless">
											<label>Right Addon</label>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="la la-group"></i></span></div>
											</div>
										</div>

										<div class="separator separator--border-dashed separator--space-lg"></div>

										<div class="form-group ">
											<label>Joint Addons</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">$</span>
												</div>
												<input type="text" class="form-control" placeholder="0.00" aria-label="Amount (to the nearest dollar)">
												<div class="input-group-append">
													<span class="input-group-text"><i class="la la-registered"></i></span>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Both Addons</label>
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text" id="basic-addon2"><i class="flaticon-refresh"></i></span></div>
												<input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="flaticon-user"></i></span></div>
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

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Sizing
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Add the relative form sizing classes to the <code>.input-group</code> itself and contents within
													will automatically resize.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Large Input Group</label>
											<div class="input-group input-group-lg">
												<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="la la-exclamation-triangle font-brand"></i></span></div>
												<input type="text" class="form-control" placeholder="Large size" aria-describedby="basic-addon1">
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Large Input Group</label>
											<div class="input-group input-group-lg">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="flaticon-refresh"></i></span>
													<span class="input-group-text">0.00</span>
												</div>
												<input type="text" class="form-control" aria-label="Large size">
											</div>
										</div>
										<div class="form-group ">
											<label>Small Input Group</label>
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" placeholder="Small size" aria-describedby="basic-addon2">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="la la-group"></i></span></div>
											</div>
										</div>
										<div class="form-group  input-group-sm">
											<label>Small Input Group</label>
											<div class="input-group input-group-sm">
												<div class="input-group-prepend"><span class="input-group-text" id="basic-addon2"><i class="fa fa-paper-plane" aria-hidden="true"></i></span></div>
												<input type="text" class="form-control" placeholder="Small size" aria-describedby="basic-addon2">
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

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Input Icons
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Use custom icon input component to place icon inside input control.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Icon Input</label>
											<div class="input-icon input-icon--left">
												<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
												<span class="input-icon__icon input-icon__icon--left">
													<span><i class="la la-search"></i></span>
												</span>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Right Icon Input</label>
											<div class="input-icon input-icon--right">
												<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
												<span class="input-icon__icon input-icon__icon--right">
													<span><i class="la la-search"></i></span>
												</span>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Large Size</label>
											<div class="input-icon input-icon--left">
												<input type="text" class="form-control form-control-lg" placeholder="Search..." id="generalSearch">
												<span class="input-icon__icon input-icon__icon--left">
													<span><i class="la la-download"></i></span>
												</span>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Small Size</label>
											<div class="input-icon input-icon--left">
												<input type="text" class="form-control form-control-sm" placeholder="Search..." id="generalSearch">
												<span class="input-icon__icon input-icon__icon--left">
													<span><i class="la la-binoculars"></i></span>
												</span>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
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
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Checkboxes and Radio addons
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Place any checkbox or radio option within an input group’s addon instead of text.
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Left Checkbox Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<label class="checkbox checkbox--single checkbox--success">
															<input type="checkbox" checked="">
															<span></span>
														</label>
													</span>
													<span class="input-group-text">$</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with checkbox">
											</div>
										</div>
										<div class="form-group ">
											<label>Right Checkbox Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">$</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with checkbox">
												<div class="input-group-append">
													<span class="input-group-text">
														<label class="checkbox checkbox--single checkbox--primary">
															<input type="checkbox" checked="">
															<span></span>
														</label>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Right &amp; Left Checkbox Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<label class="checkbox checkbox--single">
															<input type="checkbox" checked="">
															<span></span>
														</label>
													</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with checkbox">
												<div class="input-group-append">
													<span class="input-group-text">
														<label class="checkbox checkbox--single">
															<input type="checkbox">
															<span></span>
														</label>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Radio Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<label class="radio radio--single radio--success">
															<input type="radio" checked="">
															<span></span>
														</label>
													</span>
													<span class="input-group-text">$</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with radio">
											</div>
										</div>
										<div class="form-group ">
											<label>Right Radio Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">$</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with radio">
												<div class="input-group-append">
													<span class="input-group-text">
														<label class="radio radio--single radio--primary">
															<input type="radio" checked="">
															<span></span>
														</label>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Right &amp; Left Radio Addon</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<label class="radio radio--single">
															<input type="radio">
															<span></span>
														</label>
													</span>
												</div>
												<input type="text" class="form-control" aria-label="Text input with radio">
												<div class="input-group-append">
													<span class="input-group-text">
														<label class="radio radio--single">
															<input type="radio">
															<span></span>
														</label>
													</span>
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

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Button Addons
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													Buttons in input groups must wrapped in a <code>.input-group-prepend</code> or <code>.input-group-append</code> for proper alignment and sizing.
													This is required due to default browser styles that cannot be overridden.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Addon Button</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button class="btn btn-secondary" type="button">Go!</button>
												</div>
												<input type="text" class="form-control" placeholder="Search for...">
											</div>
										</div>
										<div class="form-group ">
											<label>Right Addon Button</label>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search for...">
												<div class="input-group-append">
													<button class="btn btn-secondary" type="button">Go!</button>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left &amp; Right Addon Button</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button class="btn btn-secondary" type="button">Go!</button>
												</div>
												<input type="text" class="form-control" placeholder="Search for...">
												<div class="input-group-append">
													<button class="btn btn-secondary" type="button">Go!</button>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Addon Button</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button class="btn btn-brand" type="button">Go!</button>
												</div>
												<input type="text" class="form-control" placeholder="Search for...">
											</div>
										</div>
										<div class="form-group ">
											<label>Right Addon Button</label>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search for...">
												<div class="input-group-append">
													<button class="btn btn-primary" type="button">Go!</button>
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left &amp; Right Addon Button</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button class="btn btn-success" type="button">Go!</button>
												</div>
												<input type="text" class="form-control" placeholder="Search for...">
												<div class="input-group-append">
													<button class="btn btn-warning" type="button">Go!</button>
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

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Buttons With Dropdowns
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last">
											<div class="alert alert-secondary" role="alert">
												<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
												<div class="alert-text">
													The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
												</div>
											</div>
										</div>
										<div class="form-group ">
											<label>Left Button Dropdown</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#">Action</a>
														<a class="dropdown-item" href="#">Another action</a>
														<a class="dropdown-item" href="#">Something else here</a>
														<div role="separator" class="dropdown-divider"></div>
														<a class="dropdown-item" href="#">Separated link</a>
													</div>
												</div>
												<input type="text" class="form-control" aria-label="Text input with dropdown button">
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Right Button Dropdown</label>
											<div class="input-group">
												<input type="text" class="form-control" aria-label="Text input with dropdown button">
												<div class="input-group-append">
													<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#">Action</a>
														<a class="dropdown-item" href="#">Another action</a>
														<a class="dropdown-item" href="#">Something else here</a>
														<div role="separator" class="dropdown-divider"></div>
														<a class="dropdown-item" href="#">Separated link</a>
													</div>
												</div>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
										</div>
										<div class="form-group ">
											<label>Left &amp; Right Button Dropdown</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#">Action</a>
														<a class="dropdown-item" href="#">Another action</a>
														<a class="dropdown-item" href="#">Something else here</a>
														<div role="separator" class="dropdown-divider"></div>
														<a class="dropdown-item" href="#">Separated link</a>
													</div>
												</div>
												<input type="text" class="form-control" aria-label="Text input with dropdown button">
												<div class="input-group-append">
													<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#">Action</a>
														<a class="dropdown-item" href="#">Another action</a>
														<a class="dropdown-item" href="#">Something else here</a>
														<div role="separator" class="dropdown-divider"></div>
														<a class="dropdown-item" href="#">Separated link</a>
													</div>
												</div>
											</div>
											<span class="form-text text-muted">Some help content goes here</span>
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