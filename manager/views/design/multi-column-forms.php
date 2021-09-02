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
	        <h3 class="subheader__title">Multi Column Forms</h3>

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
	                        Form Layouts	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Multi Column Forms	                    </a>
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
	<div class="col-lg-12">
		<!--begin::card-->
		<div class="card">
			<div class="card-head">
				<div class="card-head-label">
					<h3 class="card-head-title">
						2 Columns Form Layout
					</h3>
				</div>
			</div>
			<!--begin::Form-->
			<form class="form form--label-right">
				<div class="card-body">
					<div class="form-group row">
						<div class="col-lg-6">
							<label>Full Name:</label>
							<input type="email" class="form-control" placeholder="Enter full name">
							<span class="form-text text-muted">Please enter your full name</span>
						</div>
						<div class="col-lg-6">
							<label class="">Contact Number:</label>
							<input type="email" class="form-control" placeholder="Enter contact number">
							<span class="form-text text-muted">Please enter your contact number</span>
						</div>
					</div>	 
					<div class="form-group row">
						<div class="col-lg-6">
							<label>Address:</label>
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your address">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your address</span>
						</div>
						<div class="col-lg-6">
							<label class="">Postcode:</label>
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your postcode">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-bookmark-o"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your postcode</span>
						</div>
					</div>	 
					<div class="form-group row">
						<div class="col-lg-6">
							<label>User Group:</label>
							<div class="radio-inline">
								<label class="radio radio--solid">
	                                <input type="radio" name="example_2" checked="" value="2"> Sales Person
	                                <span></span>
	                            </label>
	                            <label class="radio radio--solid">
	                                <input type="radio" name="example_2" value="2"> Customer
	                                <span></span>
	                            </label>
	                        </div>
							<span class="form-text text-muted">Please select user group</span>
						</div>
					</div>	                
	            </div>
	            <div class="card__foot">
					<div class="form__actions">
						<div class="row">
							<div class="col-lg-6">
								<button type="reset" class="btn btn-primary">Save</button>
								<button type="reset" class="btn btn-secondary">Cancel</button>
							</div>
							<div class="col-lg-6 align-right">
								<button type="reset" class="btn btn-danger">Delete</button>
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
						2 Columns Horizontal Form Layout
					</h3>
				</div>
			</div>
			<!--begin::Form-->
			<form class="form form--fit form--label-right">
				<div class="card-body">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">Full Name:</label>
						<div class="col-lg-3">
							<input type="email" class="form-control" placeholder="Enter full name">
							<span class="form-text text-muted">Please enter your full name</span>
						</div>
						<label class="col-lg-2 col-form-label">Contact Number:</label>
						<div class="col-lg-3">
							<input type="email" class="form-control" placeholder="Enter contact number">
							<span class="form-text text-muted">Please enter your contact number</span>
						</div>
					</div>	     
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">Address:</label>
						<div class="col-lg-3">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your address">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your address</span>
						</div>
						<label class="col-lg-2 col-form-label">Postcode:</label>
						<div class="col-lg-3">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your postcode">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-bookmark-o"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your postcode</span>
						</div>
					</div>	     
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">Group:</label>
						<div class="col-lg-3">
							<div class="radio-inline">
								<label class="radio radio--solid">
	                                <input type="radio" name="example_2" checked="" value="2"> Sales Person
	                                <span></span>
	                            </label>
	                            <label class="radio radio--solid">
	                                <input type="radio" name="example_2" value="2"> Customer
	                                <span></span>
	                            </label>
	                        </div>
							<span class="form-text text-muted">Please select user group</span>
						</div>
					</div>	            
	            </div>
	            <div class="card__foot card__foot--fit-x">
					<div class="form__actions">
						<div class="row">
							<div class="col-lg-2"></div>
							<div class="col-lg-10">
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
						3 Columns Form Layout
					</h3>
				</div>
			</div>
			<!--begin::Form-->
			<form class="form form--label-right">
				<div class="card-body">
					<div class="form-group row">
						<div class="col-lg-4">
							<label>Full Name:</label>
							<input type="email" class="form-control" placeholder="Enter full name">
							<span class="form-text text-muted">Please enter your full name</span>
						</div>
						<div class="col-lg-4">
							<label class="">Email:</label>
							<input type="email" class="form-control" placeholder="Enter email">
							<span class="form-text text-muted">Please enter your email</span>
						</div>
						<div class="col-lg-4">
							<label>Username:</label>
							<div class="input-group">
							  	<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
								<input type="text" class="form-control" placeholder="">
							</div>
							<span class="form-text text-muted">Please enter your username</span>
						</div>
					</div>	  
					<div class="form-group row">
						<div class="col-lg-4">
							<label class="">Contact:</label>
							<input type="email" class="form-control" placeholder="Enter contact number">
							<span class="form-text text-muted">Please enter your contact</span>
						</div>
						<div class="col-lg-4">
							<label class="">Fax:</label>
							<div class="input-icon input-icon--right">
								<input type="text" class="form-control" placeholder="Fax number">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-info-circle"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter fax</span>
						</div>
						<div class="col-lg-4">
							<label>Address:</label>
							<div class="input-icon input-icon--right">
								<input type="text" class="form-control" placeholder="Enter your address">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your address</span>
						</div>
					</div>	  
					<div class="form-group row">
						<div class="col-lg-4">
							<label class="">Postcode:</label>
							<div class="input-icon input-icon--right">
								<input type="text" class="form-control" placeholder="Enter your postcode">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-bookmark-o"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your postcode</span>
						</div>
						<div class="col-lg-4">
							<label class="">User Group:</label>
							<div class="radio-inline">
								<label class="radio radio--solid">
	                                <input type="radio" name="example_2" checked="" value="2"> Sales Person
	                                <span></span>
	                            </label>
	                            <label class="radio radio--solid">
	                                <input type="radio" name="example_2" value="2"> Customer
	                                <span></span>
	                            </label>
	                        </div>
							<span class="form-text text-muted">Please select user group</span>
						</div>
					</div>	                
	            </div>
	            <div class="card__foot">
					<div class="form__actions">
						<div class="row">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								<button type="reset" class="btn btn-primary">Submit</button>
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
						3 Columns Horizontal Form Layout
					</h3>
				</div>
			</div>
			<!--begin::Form-->
			<form class="form form--label-right">
				<div class="card-body">
					<div class="form-group row form-group-marginless margin-t-20">
						<label class="col-lg-1 col-form-label">Full Name:</label>
						<div class="col-lg-3">
							<input type="email" class="form-control" placeholder="Full name">
							<span class="form-text text-muted">Please enter your full name</span>
						</div>
						<label class="col-lg-1 col-form-label">Email:</label>
						<div class="col-lg-3">
							<input type="email" class="form-control" placeholder="Email">
							<span class="form-text text-muted">Please enter your email</span>
						</div>
						<label class="col-lg-1 col-form-label">Username:</label>
						<div class="col-lg-3">
							<div class="input-group">
							  	<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
								<input type="text" class="form-control" placeholder="">
							</div>
							<span class="form-text text-muted">Please enter your username</span>
						</div>
					</div>	  

					<div class="separator separator--border-dashed separator--space-lg separator--card-fit"></div>

					<div class="form-group row form-group-marginless">
						<label class="col-lg-1 col-form-label">Contact:</label>
						<div class="col-lg-3">
							<input type="email" class="form-control" placeholder="Enter contact number">
							<span class="form-text text-muted">Please enter your contact</span>
						</div>
						<label class="col-lg-1 col-form-label">Fax:</label>
						<div class="col-lg-3">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Fax number">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-info-circle"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter fax</span>
						</div>
						<label class="col-lg-1 col-form-label">Address:</label>
						<div class="col-lg-3">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your address">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your address</span>
						</div>
					</div>	  

					<div class="separator separator--border-dashed separator--space-lg separator--card-fit"></div>

					<div class="form-group row">
						<label class="col-lg-1 col-form-label">Postcode:</label>
						<div class="col-lg-3">
							<div class="input-icon">
								<input type="text" class="form-control" placeholder="Enter your postcode">
								<span class="input-icon__icon input-icon__icon--right"><span><i class="la la-bookmark-o"></i></span></span>
							</div>
							<span class="form-text text-muted">Please enter your postcode</span>
						</div>
						<label class="col-lg-1 col-form-label">User Group:</label>
						<div class="col-lg-3">
							<div class="radio-inline">
								<label class="radio radio--solid">
	                                <input type="radio" name="example_2" checked="" value="2"> Sales Person
	                                <span></span>
	                            </label>
	                            <label class="radio radio--solid">
	                                <input type="radio" name="example_2" value="2"> Customer
	                                <span></span>
	                            </label>
	                        </div>
							<span class="form-text text-muted">Please select user group</span>
						</div>
					</div>	               
	            </div>
	            <div class="card__foot">
					<div class="form__actions">
						<div class="row">
							<div class="col-lg-5"></div>
							<div class="col-lg-7">
								<button type="reset" class="btn btn-brand">Submit</button>
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
</div>	</div>
<!-- end:: Content -->						</div>
									</div>


		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>