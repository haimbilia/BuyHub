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
		<!-- end:: Header -->

		<div class="body" id="body">
			<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

				<!-- begin:: Subheader -->
				<div id="subheader" class="subheader" >
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Base Controls</h3>
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
									Base Inputs </a>
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
											Base Controls
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
													The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Email address</label>
											<input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
											<span class="form-text text-muted">We'll never share your email with anyone else.</span>
										</div>
										<div class="form-group">
											<label for="exampleInputPassword1">Password</label>
											<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
										</div>
										<div class="form-group">
											<label>Static:</label>
											<p class="form-control-static">email@example.com</p>
										</div>
										<div class="form-group">
											<label for="exampleSelect1">Example select</label>
											<select class="form-control" id="exampleSelect1">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleSelect2">Example multiple select</label>
											<select multiple="" class="form-control" id="exampleSelect2">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
										<div class="form-group form-group-last">
											<label for="exampleTextarea">Example textarea</label>
											<textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
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
											Textual HTML5 Inputs
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
													Here are examples of <code>.form-control</code> applied to each textual HTML5 input type:
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="example-text-input" class="col-2 col-form-label">Text</label>
											<div class="col-10">
												<input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-search-input" class="col-2 col-form-label">Search</label>
											<div class="col-10">
												<input class="form-control" type="search" value="How do I shoot web" id="example-search-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-email-input" class="col-2 col-form-label">Email</label>
											<div class="col-10">
												<input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-url-input" class="col-2 col-form-label">URL</label>
											<div class="col-10">
												<input class="form-control" type="url" value="https://getbootstrap.com" id="example-url-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-tel-input" class="col-2 col-form-label">Telephone</label>
											<div class="col-10">
												<input class="form-control" type="tel" value="1-(555)-555-5555" id="example-tel-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-password-input" class="col-2 col-form-label">Password</label>
											<div class="col-10">
												<input class="form-control" type="password" value="hunter2" id="example-password-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-number-input" class="col-2 col-form-label">Number</label>
											<div class="col-10">
												<input class="form-control" type="number" value="42" id="example-number-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-datetime-local-input" class="col-2 col-form-label">Date and time</label>
											<div class="col-10">
												<input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-date-input" class="col-2 col-form-label">Date</label>
											<div class="col-10">
												<input class="form-control" type="date" value="2011-08-19" id="example-date-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-month-input" class="col-2 col-form-label">Month</label>
											<div class="col-10">
												<input class="form-control" type="month" value="2011-08" id="example-month-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-week-input" class="col-2 col-form-label">Week</label>
											<div class="col-10">
												<input class="form-control" type="week" value="2011-W33" id="example-week-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-time-input" class="col-2 col-form-label">Time</label>
											<div class="col-10">
												<input class="form-control" type="time" value="13:45:00" id="example-time-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-color-input" class="col-2 col-form-label">Color</label>
											<div class="col-10">
												<input class="form-control" type="color" value="#563d7c" id="example-color-input">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-email-input" class="col-2 col-form-label">Range</label>
											<div class="col-10">
												<input class="form-control" type="range">
											</div>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<div class="row">
												<div class="col-2">
												</div>
												<div class="col-10">
													<button type="reset" class="btn btn-success">Submit</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div>
											</div>
										</div>
									</div>
									
									
									
								</form>
								
								
								

								
							</div>
							<!--end::card-->
						</div>
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Input States
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
													Add the disabled or readonly boolean attribute on an input to prevent user interactions.
													Disabled inputs appear lighter and add a <code>not-allowed</code> cursor.
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Disabled Input</label>
											<input type="email" class="form-control" disabled="disabled" placeholder="Disabled input">
										</div>
										<div class="form-group">
											<label>Disabled select</label>
											<select class="form-control" disabled="disabled">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleTextarea">Disabled textarea</label>
											<textarea class="form-control" disabled="disabled" rows="3"></textarea>
										</div>
										<div class="form-group">
											<label>Readonly Input</label>
											<input type="email" class="form-control" readonly="" placeholder="Readonly input">
										</div>
										<div class="form-group">
											<label for="exampleTextarea">Readonly textarea</label>
											<textarea class="form-control" readonly="" rows="3"></textarea>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<button type="reset" class="btn btn-brand">Submit</button>
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
											Input Sizing
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
													Set heights using classes like <code>.form-control-lg</code>, and set widths using grid column classes like <code>.col-lg-*</code>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Large Input</label>
											<input type="email" class="form-control form-control-lg" aria-describedby="emailHelp" placeholder="Large input">
										</div>
										<div class="form-group">
											<label>Default Input</label>
											<input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Large input">
										</div>
										<div class="form-group">
											<label>Small Input</label>
											<input type="email" class="form-control form-control-sm" aria-describedby="emailHelp" placeholder="Large input">
										</div>
										<div class="form-group">
											<label for="exampleSelectl">Large Select</label>
											<select class="form-control form-control-lg" id="exampleSelectl">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleSelectd">Default Select</label>
											<select class="form-control" id="exampleSelectd">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleSelects">Small Select</label>
											<select class="form-control form-control-sm" id="exampleSelects">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
											</select>
										</div>
									</div>
									<div class="card__foot">
										<div class="form__actions">
											<button type="reset" class="btn btn-success">Submit</button>
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
											Custom Controls
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
													For even more customization and cross browser consistency, use our completely custom form elements to replace the browser defaults. They’re built on top of semantic and accessible markup, so they’re solid replacements for any default form control.
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Custom Range</label>
											<div></div>
											<input type="range" class="custom-range" min="0" max="5" id="customRange2">
										</div>
										<div class="form-group">
											<label>Custom Select</label>
											<div></div>
											<select class="custom-select form-control">
												<option selected="">Open this select menu</option>
												<option value="1">One</option>
												<option value="2">Two</option>
												<option value="3">Three</option>
											</select>
										</div>
										<div class="form-group">
											<label>File Browser</label>
											<div></div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="customFile">
												<label class="custom-file-label" for="customFile">Choose file</label>
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