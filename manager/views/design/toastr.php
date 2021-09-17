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
							<h3 class="subheader__title">Toastr </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Extended </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Toastr </a>
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
						<div class="col">
							<div class="alert alert-light alert-elevate fade show" role="alert">
								<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
								<div class="alert-text">
									toastr is a Javascript library for Gnome / Growl type non-blocking notifications. jQuery is required. The goal is to create a simple core library that can be customized and extended.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://codeseven.github.io/toastr/demo.html" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/CodeSeven/toastr" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Toastr Notifications Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="title">Title</label>
											<input id="title" type="text" class="form-control" placeholder="Enter a title ...">
										</div>
										<div class="form-group">
											<label for="message">Message</label>
											<textarea class="form-control" id="message" rows="3" placeholder="Enter a message ..."></textarea>
										</div>
										<div class="form-group">
											<div class="checkbox-list">
												<label class="checkbox">
													<input id="closeButton" type="checkbox" value="checked">Close Button
													<span></span>
												</label>
												<label class="checkbox">
													<input id="addBehaviorOnToastClick" type="checkbox" value="checked">Add behavior on toast click
													<span></span>
												</label>
												<label class="checkbox">
													<input id="debugInfo" type="checkbox" value="checked">Debug
													<span></span>
												</label>
												<label class="checkbox">
													<input id="progressBar" type="checkbox" value="checked">Progress Bar
													<span></span>
												</label>
												<label class="checkbox">
													<input id="preventDuplicates" type="checkbox" value="checked">Prevent Duplicates
													<span></span>
												</label>
												<label class="checkbox">
													<input id="addClear" type="checkbox" value="checked">Add button to force clearing a toast, ignoring focus
													<span></span>
												</label>
												<label class="checkbox">
													<input id="newestOnTop" type="checkbox" value="checked">Newest on top
													<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Toast Type</label>
											<div class="radio-list d-block" id="toastTypeGroup">
												<label class="radio">
													<input type="radio" name="toasts" checked="" value="success">Success
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="toasts" value="info">Info
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="toasts" value="warning">Warning
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="toasts" value="error">Error
													<span></span>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label>Position</label>
											<div class="radio-list d-block" id="positionGroup">
												<label class="radio">
													<input type="radio" name="positions" value="toast-top-right" checked="">Top Right
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-bottom-right">Bottom Right
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-bottom-left">Bottom Left
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-top-left">Top Left
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-top-full-width">Top Full Width
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-bottom-full-width">Bottom Full Width
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-top-center">Top Center
													<span></span>
												</label>
												<label class="radio">
													<input type="radio" name="positions" value="toast-bottom-center">Bottom Center
													<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label for="showEasing">Show Easing</label>
											<input id="showEasing" type="text" class="form-control" placeholder="swing, linear" value="swing">
										</div>
										<div class="form-group">
											<label for="hideEasing">Hide Easing</label>
											<input id="hideEasing" type="text" class="form-control" placeholder="swing, linear" value="linear">
										</div>
										<div class="form-group">
											<label for="showMethod">Show Method</label>
											<input id="showMethod" type="text" class="form-control" placeholder="show, fadeIn, slideDown" value="fadeIn">
										</div>
										<div class="form-group">
											<label for="hideMethod">Hide Method</label>
											<input id="hideMethod" type="text" class="form-control" placeholder="hide, fadeOut, slideUp" value="fadeOut">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group form__grou">
											<label for="showDuration">Show Duration</label>
											<input id="showDuration" type="text" class="form-control" placeholder="ms" value="300">
										</div>
										<div class="form-group form__grou">

											<label for="hideDuration">Hide Duration</label>
											<input id="hideDuration" type="text" class="form-control" placeholder="ms" value="1000">
										</div>
										<div class="form-group form__grou">

											<label for="timeOut">Time out</label>
											<input id="timeOut" type="text" class="form-control" placeholder="ms" value="5000">
										</div>
										<div class="form-group form__grou">
											<label for="extendedTimeOut">Extended time out</label>
											<input id="extendedTimeOut" class="form-control" type="text" placeholder="ms" value="1000">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<pre id="toastrOptions" style="border:4px solid #efefef;padding:15px; margin:20px 0;">Output:</pre>
										</div>
									</div>
								</div>
							</div>
							<div class="card-foot">
								<div class=" ">
									<div class="row">
										<div class="col-lg-8 offset-lg-4">
											<a href="javascript:;" class="btn btn-primary" id="showtoast">Show Toast</a>
											<a href="javascript:;" class="btn btn-danger" id="cleartoasts">Clear Toasts</a>
											<a href="javascript:;" class="btn btn-danger" id="clearlasttoast">Clear Last Toast</a>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::card-->
				</div>
				<!-- end:: Content -->
			</div>
		</div>

<?php  include 'includes/footer.php';?>
</div>

</body>


</html>