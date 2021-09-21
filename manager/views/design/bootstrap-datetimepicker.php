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
	        <h3 class="subheader__title">Bootstrap Datetimepicker</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Crud	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Forms &amp; Controls	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Form Widgets	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Datetimepicker	                    </a>
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
                Bootstrap form component to handle date and time data.
                <br>
                For more info please visit the plugin's <a class="link font-bold" href="https://www.malot.fr/bootstrap-datetimepicker/demo.php" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/smalot/bootstrap-datetimepicker" target="_blank">Github Repo</a>.
            </div>
        </div>
    </div>
</div>

<!--begin::card-->
<div class="card">
	<div class="card-head">
		<div class="card-head-label">
			<h3 class="card-head-title">
				Bootstrap Date Time Picker Examples
			</h3>
		</div>
	</div>
	<!--begin::Form-->
	<form class="form form--label-right">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<input type="text" class="form-control" id="datetimepicker_1" readonly="" placeholder="Select date &amp; time">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Input Group Setup</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" readonly="" placeholder="Select date &amp; time" id="datetimepicker_2">
						<div class="input-group-append">
							<span class="input-group-text"><i class="la la-calendar-check-o glyphicon-th"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Enable Helper Buttons</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" readonly="" value="1899-11-29 00:30" id="datetimepicker_3">
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-calendar glyphicon-th"></i>
							</span>
						</div>
					</div>
					<span class="form-text text-muted">Enable clear and today helper buttons</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Orientation</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Top left" id="datetimepicker_4_1">
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-check-circle-o glyphicon-th"></i>
							</span>
						</div>
					</div>
					<div class="space-10"></div>
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Top right" id="datetimepicker_4_2">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-clock-o glyphicon-th"></i>
							</span>
						</div>
					</div>
					<div class="space-10"></div>
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Bottom left" id="datetimepicker_4_3">
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-check glyphicon-th"></i>
							</span>
						</div>
					</div>
					<div class="space-10"></div>
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Bottom right" id="datetimepicker_4_4">
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-download glyphicon-th"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Meridian Format</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Select date and time" id="datetimepicker_5">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-calendar glyphicon-th"></i>
							</span>
						</div>
					</div>
					<span class="form-text text-muted">Linked pickers for date range selection</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Date Only</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Select date" id="datetimepicker_6">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-calendar glyphicon-th"></i>
							</span>
						</div>
					</div>
					<span class="form-text text-muted">Only date selection</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Time Only</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control" placeholder="Select time" id="datetimepicker_7">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-calendar glyphicon-th"></i>
							</span>
						</div>
					</div>
					<span class="form-text text-muted">Only time selection</span>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<a href="" class="btn btn-label-brand" data-toggle="modal" data-target="#datetimepicker_modal">Launch Modal Date Time pickers</a>
				</div>
			</div>
		</div>
		<div class="card-foot">
			<div class="form__actions">
				<div class="row">
					<div class="col-lg-9 ml-lg-auto">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="submit" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>
<!--end::card-->

<!--begin::Modal-->
<div class="modal fade" id="datetimepicker_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Bootstrap Date Time Picker Examples</h5>
				<button type="reset" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>
			</div>
			<form class="form form--fit form--label-right">
				<div class="modal-body">
					<div class="form-group row margin-t-20">
						<label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<input type="text" class="form-control" id="datetimepicker_1_modal" readonly="" data-z-index="1100" placeholder="Select date &amp; time">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Input Group Setup</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="input-group date" data-z-index="1100">
								<input type="text" class="form-control" readonly="" placeholder="Select date &amp; time" id="datetimepicker_2_modal">
								<div class="input-group-append">
									<span class="input-group-text"><i class="la la-calendar-check-o glyphicon-th"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row margin-b-20">
						<label class="col-form-label col-lg-3 col-sm-12">Enable Helper Buttons</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="input-group date" data-z-index="1100">
								<input type="text" class="form-control" readonly="" value="1899-11-29 00:30" id="datetimepicker_3_modal">
								<div class="input-group-append">
									<span class="input-group-text">
									<i class="la la-calendar-plus-o glyphicon-th"></i>
									</span>
								</div>
							</div>
							<span class="form-text text-muted">Enable clear and today helper buttons</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-brand" data-dismiss="modal">Close</button>
					<button type="reset" class="btn btn-secondary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end::Modal-->

<!--begin::card-->
<div class="card">
	<div class="card-head">
		<div class="card-head-label">
			<h3 class="card-head-title">
				Validation State Examples
			</h3>
		</div>
	</div>
	<!--begin::Form-->
	<form class="form form--label-right">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Valid State</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control is-valid" readonly="" placeholder="Select date" id="datetimepicker_1_validate">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-calendar-check-o"></i>
							</span>
						</div>
						<div class="valid-feedback">
          					Success! You"ve done it.
        				</div>
					</div>
					<span class="form-text text-muted">Example help text that remains unchanged.</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Invalid State</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="input-group date">
						<input type="text" class="form-control is-invalid" readonly="" placeholder="Select date" id="datetimepicker_2_validate">
						<div class="input-group-append">
							<span class="input-group-text">
							<i class="la la-calendar-check-o"></i>
							</span>
						</div>
						<div class="invalid-feedback">
                            Sorry, the date is taken. Try another date?
        				</div>
					</div>
					<span class="form-text text-muted">Example help text that remains unchanged.</span>
				</div>
			</div>
		</div>
		<div class="card-foot">
			<div class="form__actions">
				<div class="row">
					<div class="col-lg-9 ml-lg-auto">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="submit" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>
<!--end::card-->	</div>
<!-- end:: Content -->						</div>
									</div>


		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>