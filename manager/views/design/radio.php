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
							<h3 class="subheader__title">Radio</h3>

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
									Radio </a>
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
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic Radio
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group">
											<label>Default Radioes</label>
											<div class="radio-list d-block">
												<label class="radio">
													<input type="radio" name="radio1"> Default
													<span></span>
												</label>
												<label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" checked="checked" name="radio1"> Checked
													<span></span>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label>Inline Radioes</label>
											<div class="radio-inline">
												<label class="radio">
													<input type="radio" name="radio2"> Default
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="radio2" checked> Checked
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" disabled="" name="radio2"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>


										<div class="form-group">
											<label>Large Size Radioes</label>
											<div class="radio-inline">
												<label class="radio radio--lg">
													<input type="radio" name="radio2"> Default
													<span></span>
												</label>
												<label class="radio radio--lg">
													<input type="radio" checked="checked" name="radio2"> Checked
													<span></span>
												</label>
												<label class="radio radio--lg">
													<input type="radio" disabled="" name="radio2"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>


										<div class="form-group">
											<label>Square Radioes</label>
											<div class="radio-inline">
												<label class="radio radio--square">
													<input type="radio" name="radio2"> Default
													<span></span>
												</label>
												<label class="radio radio--square">
													<input type="radio" checked="checked" name="radio2"> Checked
													<span></span>
												</label>
												<label class="radio radio--square">
													<input type="radio" disabled="" name="radio2"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>

										<div class="form-group">
											<label>Rounded Radioes</label>
											<div class="radio-inline">
												<label class="radio radio--rd">
													<input type="radio" name="radio2"> Default
													<span></span>
												</label>
												<label class="radio radio--rd">
													<input type="radio" checked="checked" name="radio2"> Checked
													<span></span>
												</label>
												<label class="radio radio--rd">
													<input type="radio" disabled="" name="radio2"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
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
											Horizontal Form
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group row">
											<label class="col-3 col-form-label">Radioes</label>
											<div class="col-9"> 
												<div class="radio-list d-block">
													<label class="radio">
														<input type="radio" name="radio3"> Option 1
														<span></span>
													</label>
													<label class="radio">
														<input type="radio" name="radio3"> Option 2
														<span></span>
													</label>
													<label class="radio">
														<input type="radio" checked="checked" name="radio3"> Checked
														<span></span>
													</label>
													<label class="radio radio--disabled">
														<input type="radio" disabled="" name="radio3"> Disabled
														<span></span>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Inline Radioes</label>
											<div class="col-9">
												<div class="radio-inline">
													<label class="radio">
														<input type="radio" name="radio4"> Option 1
														<span></span>
													</label>
													<label class="radio">
														<input type="radio" checked="checked" name="radio4"> Option 2
														<span></span>
													</label>
													<label class="radio">
														<input type="radio" name="radio4"> Option 3
														<span></span>
													</label>
												</div>
												<span class="form-text text-muted">Some help text goes here</span>
											</div>
										</div>
									</form>
									<!--end::Form-->
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
											Color Options
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group">
											<label>Success State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio5"> Default
													<span></span>
												</label>
												<label class="radio radio--success" name="radio5">
													<input type="radio" checked="checked"> Checked
													<span></span>
												</label><label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Brand State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio6"> Default
													<span></span>
												</label>
												<label class="radio radio--brand">
													<input type="radio" name="radio6" checked="checked">Checked
													<span></span>
												</label><label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Warning State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio7"> Default
													<span></span>
												</label>
												<label class="radio radio--warning">
													<input type="radio" name="radio7" checked="checked">Checked
													<span></span>
												</label><label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Danger State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio8"> Default
													<span></span>
												</label>
												<label class="radio radio--danger">
													<input type="radio" name="radio8" checked="checked">Checked
													<span></span>
												</label><label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Primary State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio9"> Default
													<span></span>
												</label>
												<label class="radio radio--primary">
													<input type="radio" name="radio9" checked="checked">Checked
													<span></span>
												</label><label class="radio radio--disabled">
													<input type="radio" disabled="" name="radio1"> Disabled
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
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
											Outline Options
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Form-->
									<form class="form">
										<div class="form-group">
											<label>Success State</label>
											<div class="radio-list">
												<label class="radio">
													<input type="radio" name="radio5"> Default
													<span></span>
												</label>
												<label class="radio radio--success" name="radio5">
													<input type="radio"> Outline
													<span></span>
												</label>
												<label class="radio radio--bold radio--success">
													<input type="radio" name="radio6"> Outline 2x
													<span></span>
												</label>
												<label class="radio radio--solid radio--success">
													<input type="radio" name="radio7"> Solid State
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Brand State</label>
											<div class="radio-list">
												<label class="radio radio--bold">
													<input type="radio" name="radio6"> Default
													<span></span>
												</label>
												<label class="radio radio--brand" name="radio5">
													<input type="radio"> Outline
													<span></span>
												</label>
												<label class="radio radio--bold radio--brand">
													<input type="radio" name="radio6"> Outline 2x
													<span></span>
												</label>
												<label class="radio radio--solid radio--brand">
													<input type="radio" name="radio7"> Solid state
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Warning State</label>
											<div class="radio-list">
												<label class="radio radio--bold">
													<input type="radio" name="radio6"> Default
													<span></span>
												</label>
												<label class="radio radio--warning" name="radio5">
													<input type="radio"> Outline
													<span></span>
												</label>
												<label class="radio radio--bold radio--warning">
													<input type="radio" name="radio6"> Outline 2x
													<span></span>
												</label>
												<label class="radio radio--solid radio--warning">
													<input type="radio" name="radio7"> Solid state
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Danger State</label>
											<div class="radio-list">
												<label class="radio radio--bold">
													<input type="radio" name="radio6"> Default
													<span></span>
												</label>
												<label class="radio radio--danger" name="radio5">
													<input type="radio"> Outline
													<span></span>
												</label>
												<label class="radio radio--bold radio--danger">
													<input type="radio" name="radio6"> Outline 2x
													<span></span>
												</label>
												<label class="radio radio--solid radio--danger">
													<input type="radio" name="radio7"> Solid state
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
										</div>
										<div class="form-group">
											<label>Primary State</label>
											<div class="radio-list">
												<label class="radio radio--bold">
													<input type="radio" name="radio6"> Default
													<span></span>
												</label>
												<label class="radio radio--primary" name="radio5">
													<input type="radio"> Outline
													<span></span>
												</label>
												<label class="radio radio--bold radio--primary">
													<input type="radio" name="radio6"> Outline 2x
													<span></span>
												</label>
												<label class="radio radio--solid radio--primary">
													<input type="radio" name="radio7"> Solid state
													<span></span>
												</label>
											</div>
											<span class="form-text text-muted">Some help text goes here</span>
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


		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>