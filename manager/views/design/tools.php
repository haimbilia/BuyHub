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

								card Tools </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									cards </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									card Tools </a>
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
							<div class="card" data-FATbitcard="true" id="card_tools_1">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											card Title
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card" data-FATbitcard="true" id="card_tools_2">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											card Title
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										<div class="separator separator--space separator--dashed"></div>
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card" data-FATbitcard="true" id="card_tools_3">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											card Title
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-outline-success btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-outline-brand btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-outline-danger btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group">
											<label for="exampleInputEmail1">Email address</label>
											<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
											<span class="form-text text-muted">We'll never share your email with anyone else.</span>
										</div>
										<div class="form-group">
											<label for="exampleInputPassword1">Password</label>
											<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
										</div>
									</div>
									<div class="card-foot">
										<div>
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
							<div class="card card--collapsed" data-FATbitcard="true" id="card_tools_4">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Collapsed card
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-brand btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-danger btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-warning btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="card__content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.

										<div class="separator separator--space separator--dashed"></div>

										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.

									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card" data-FATbitcard="true" id="card_tools_5">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											card Title
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-default btn-pill  btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-default btn-pill  btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<div class="card-body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--head-sm" data-FATbitcard="true" id="card_tools_6">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Lazy Initialization
										</h3>
									</div>
									<div class="card-head-toolbar">
										<div class="card-head-group">
											<a href="#" data-FATbitcard-tool="toggle" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-angle-down"></i></a>
											<a href="#" data-FATbitcard-tool="reload" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-refresh"></i></a>
											<a href="#" data-FATbitcard-tool="remove" class="btn btn-sm btn-icon btn-default btn-icon-md"><i class="la la-close"></i></a>
										</div>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group">
											<label for="exampleInputEmail2">Email address</label>
											<input type="email" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="Enter email">
											<span class="form-text text-muted">We'll never share your email with anyone else.</span>
										</div>
										<div class="form-group">
											<label for="exampleInputPassword2">Password</label>
											<input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
										</div>
									</div>
									<div class="card-foot">
										<div class="">
											<button type="reset" class="btn btn-brand">Submit</button>
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