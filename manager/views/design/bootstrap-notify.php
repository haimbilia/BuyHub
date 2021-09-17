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

								Bootstrap Notify </h3>

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
									Bootstrap Notify </a>
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
									This plugin helps to turn standard bootstrap alerts into "growl" like notifications.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="http://bootstrap-notify.remabledesigns.com/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/mouse0270/bootstrap-notify/" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Bootstrap Notify Demo
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right">
							<div class="card-body">
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Placement</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="row">
											<div class="col">
												<select class="form-control" id="notify_placement_from">
													<option value="top">Top</option>
													<option value="bottom">Bottom</option>
												</select>
											</div>
											<div class="col">
												<select class="form-control" id="notify_placement_align">
													<option value="left">Left</option>
													<option value="right" selected="">Right</option>
													<option value="center">Center</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Animation</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="row">
											<div class="col">
												<select class="form-control" id="notify_animate_enter">
													<optgroup label="Attention Seekers">
														<option value="bounce">bounce</option>
														<option value="flash">flash</option>
														<option value="pulse">pulse</option>
														<option value="rubberBand">rubberBand</option>
														<option value="shake">shake</option>
														<option value="swing">swing</option>
														<option value="tada">tada</option>
														<option value="wobble">wobble</option>
														<option value="jello">jello</option>
													</optgroup>

													<optgroup label="Bouncing Entrances">
														<option value="bounceIn">bounceIn</option>
														<option value="bounceInDown">bounceInDown</option>
														<option value="bounceInLeft">bounceInLeft</option>
														<option value="bounceInRight">bounceInRight</option>
														<option value="bounceInUp">bounceInUp</option>
													</optgroup>

													<optgroup label="Bouncing Exits">
														<option value="bounceOut">bounceOut</option>
														<option value="bounceOutDown">bounceOutDown</option>
														<option value="bounceOutLeft">bounceOutLeft</option>
														<option value="bounceOutRight">bounceOutRight</option>
														<option value="bounceOutUp">bounceOutUp</option>
													</optgroup>

													<optgroup label="Fading Entrances">
														<option value="fadeIn">fadeIn</option>
														<option value="fadeInDown">fadeInDown</option>
														<option value="fadeInDownBig">fadeInDownBig</option>
														<option value="fadeInLeft">fadeInLeft</option>
														<option value="fadeInLeftBig">fadeInLeftBig</option>
														<option value="fadeInRight">fadeInRight</option>
														<option value="fadeInRightBig">fadeInRightBig</option>
														<option value="fadeInUp">fadeInUp</option>
														<option value="fadeInUpBig">fadeInUpBig</option>
													</optgroup>

													<optgroup label="Fading Exits">
														<option value="fadeOut">fadeOut</option>
														<option value="fadeOutDown">fadeOutDown</option>
														<option value="fadeOutDownBig">fadeOutDownBig</option>
														<option value="fadeOutLeft">fadeOutLeft</option>
														<option value="fadeOutLeftBig">fadeOutLeftBig</option>
														<option value="fadeOutRight">fadeOutRight</option>
														<option value="fadeOutRightBig">fadeOutRightBig</option>
														<option value="fadeOutUp">fadeOutUp</option>
														<option value="fadeOutUpBig">fadeOutUpBig</option>
													</optgroup>

													<optgroup label="Flippers">
														<option value="flip">flip</option>
														<option value="flipInX">flipInX</option>
														<option value="flipInY">flipInY</option>
														<option value="flipOutX">flipOutX</option>
														<option value="flipOutY">flipOutY</option>
													</optgroup>

													<optgroup label="Lightspeed">
														<option value="lightSpeedIn">lightSpeedIn</option>
														<option value="lightSpeedOut">lightSpeedOut</option>
													</optgroup>

													<optgroup label="Rotating Entrances">
														<option value="rotateIn">rotateIn</option>
														<option value="rotateInDownLeft">rotateInDownLeft</option>
														<option value="rotateInDownRight">rotateInDownRight</option>
														<option value="rotateInUpLeft">rotateInUpLeft</option>
														<option value="rotateInUpRight">rotateInUpRight</option>
													</optgroup>

													<optgroup label="Rotating Exits">
														<option value="rotateOut">rotateOut</option>
														<option value="rotateOutDownLeft">rotateOutDownLeft</option>
														<option value="rotateOutDownRight">rotateOutDownRight</option>
														<option value="rotateOutUpLeft">rotateOutUpLeft</option>
														<option value="rotateOutUpRight">rotateOutUpRight</option>
													</optgroup>

													<optgroup label="Sliding Entrances">
														<option value="slideInUp">slideInUp</option>
														<option value="slideInDown">slideInDown</option>
														<option value="slideInLeft">slideInLeft</option>
														<option value="slideInRight">slideInRight</option>

													</optgroup>
													<optgroup label="Sliding Exits">
														<option value="slideOutUp">slideOutUp</option>
														<option value="slideOutDown">slideOutDown</option>
														<option value="slideOutLeft">slideOutLeft</option>
														<option value="slideOutRight">slideOutRight</option>

													</optgroup>

													<optgroup label="Zoom Entrances">
														<option value="zoomIn">zoomIn</option>
														<option value="zoomInDown">zoomInDown</option>
														<option value="zoomInLeft">zoomInLeft</option>
														<option value="zoomInRight">zoomInRight</option>
														<option value="zoomInUp">zoomInUp</option>
													</optgroup>

													<optgroup label="Zoom Exits">
														<option value="zoomOut">zoomOut</option>
														<option value="zoomOutDown">zoomOutDown</option>
														<option value="zoomOutLeft">zoomOutLeft</option>
														<option value="zoomOutRight">zoomOutRight</option>
														<option value="zoomOutUp">zoomOutUp</option>
													</optgroup>

													<optgroup label="Specials">
														<option value="hinge">hinge</option>
														<option value="rollIn">rollIn</option>
														<option value="rollOut">rollOut</option>
													</optgroup>
												</select>
											</div>
											<div class="col">
												<select class="form-control" id="notify_animate_exit">
													<optgroup label="Attention Seekers">
														<option value="bounce">bounce</option>
														<option value="flash">flash</option>
														<option value="pulse">pulse</option>
														<option value="rubberBand">rubberBand</option>
														<option value="shake">shake</option>
														<option value="swing">swing</option>
														<option value="tada">tada</option>
														<option value="wobble">wobble</option>
														<option value="jello">jello</option>
													</optgroup>

													<optgroup label="Bouncing Entrances">
														<option value="bounceIn">bounceIn</option>
														<option value="bounceInDown">bounceInDown</option>
														<option value="bounceInLeft">bounceInLeft</option>
														<option value="bounceInRight">bounceInRight</option>
														<option value="bounceInUp">bounceInUp</option>
													</optgroup>

													<optgroup label="Bouncing Exits">
														<option value="bounceOut">bounceOut</option>
														<option value="bounceOutDown">bounceOutDown</option>
														<option value="bounceOutLeft">bounceOutLeft</option>
														<option value="bounceOutRight">bounceOutRight</option>
														<option value="bounceOutUp">bounceOutUp</option>
													</optgroup>

													<optgroup label="Fading Entrances">
														<option value="fadeIn">fadeIn</option>
														<option value="fadeInDown">fadeInDown</option>
														<option value="fadeInDownBig">fadeInDownBig</option>
														<option value="fadeInLeft">fadeInLeft</option>
														<option value="fadeInLeftBig">fadeInLeftBig</option>
														<option value="fadeInRight">fadeInRight</option>
														<option value="fadeInRightBig">fadeInRightBig</option>
														<option value="fadeInUp">fadeInUp</option>
														<option value="fadeInUpBig">fadeInUpBig</option>
													</optgroup>

													<optgroup label="Fading Exits">
														<option value="fadeOut">fadeOut</option>
														<option value="fadeOutDown">fadeOutDown</option>
														<option value="fadeOutDownBig">fadeOutDownBig</option>
														<option value="fadeOutLeft">fadeOutLeft</option>
														<option value="fadeOutLeftBig">fadeOutLeftBig</option>
														<option value="fadeOutRight">fadeOutRight</option>
														<option value="fadeOutRightBig">fadeOutRightBig</option>
														<option value="fadeOutUp">fadeOutUp</option>
														<option value="fadeOutUpBig">fadeOutUpBig</option>
													</optgroup>

													<optgroup label="Flippers">
														<option value="flip">flip</option>
														<option value="flipInX">flipInX</option>
														<option value="flipInY">flipInY</option>
														<option value="flipOutX">flipOutX</option>
														<option value="flipOutY">flipOutY</option>
													</optgroup>

													<optgroup label="Lightspeed">
														<option value="lightSpeedIn">lightSpeedIn</option>
														<option value="lightSpeedOut">lightSpeedOut</option>
													</optgroup>

													<optgroup label="Rotating Entrances">
														<option value="rotateIn">rotateIn</option>
														<option value="rotateInDownLeft">rotateInDownLeft</option>
														<option value="rotateInDownRight">rotateInDownRight</option>
														<option value="rotateInUpLeft">rotateInUpLeft</option>
														<option value="rotateInUpRight">rotateInUpRight</option>
													</optgroup>

													<optgroup label="Rotating Exits">
														<option value="rotateOut">rotateOut</option>
														<option value="rotateOutDownLeft">rotateOutDownLeft</option>
														<option value="rotateOutDownRight">rotateOutDownRight</option>
														<option value="rotateOutUpLeft">rotateOutUpLeft</option>
														<option value="rotateOutUpRight">rotateOutUpRight</option>
													</optgroup>

													<optgroup label="Sliding Entrances">
														<option value="slideInUp">slideInUp</option>
														<option value="slideInDown">slideInDown</option>
														<option value="slideInLeft">slideInLeft</option>
														<option value="slideInRight">slideInRight</option>

													</optgroup>
													<optgroup label="Sliding Exits">
														<option value="slideOutUp">slideOutUp</option>
														<option value="slideOutDown">slideOutDown</option>
														<option value="slideOutLeft">slideOutLeft</option>
														<option value="slideOutRight">slideOutRight</option>

													</optgroup>

													<optgroup label="Zoom Entrances">
														<option value="zoomIn">zoomIn</option>
														<option value="zoomInDown">zoomInDown</option>
														<option value="zoomInLeft">zoomInLeft</option>
														<option value="zoomInRight">zoomInRight</option>
														<option value="zoomInUp">zoomInUp</option>
													</optgroup>

													<optgroup label="Zoom Exits">
														<option value="zoomOut">zoomOut</option>
														<option value="zoomOutDown">zoomOutDown</option>
														<option value="zoomOutLeft">zoomOutLeft</option>
														<option value="zoomOutRight">zoomOutRight</option>
														<option value="zoomOutUp">zoomOutUp</option>
													</optgroup>

													<optgroup label="Specials">
														<option value="hinge">hinge</option>
														<option value="rollIn">rollIn</option>
														<option value="rollOut">rollOut</option>
													</optgroup>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Icon</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<select class="form-control" id="notify_icon">
											<option value="">None</option>
											<option value="la la-cloud-download">la la-cloud-download</option>
											<option value="la la-warning">la la-warning</option>
											<option value="fa fa-warning">fa fa-warning</option>
											<option value="fa fa-cloud-download">fa fa-cloud-download</option>
											<option value="flaticon-exclamation-2">flaticon-exclamation-2</option>
											<option value="flaticon-signs">flaticon-signs</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">URL Clickable </label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" data-on-color="brand" id="notify_url"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Allow dismiss</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-off bootstrap-switch-on" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" checked="" data-on-color="brand" id="notify_dismiss"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Pause on hover</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" data-on-color="brand" id="notify_pause"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Newest on top</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" data-on-color="brand" id="notify_top"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Show Title</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" data-on-color="brand" id="notify_title"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Show Progress</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 106px;">
											<div class="bootstrap-switch-container" style="width: 156px; margin-left: -52px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 52px;">ON</span><span class="bootstrap-switch-label" style="width: 52px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 52px;">OFF</span><input data-switch="true" type="checkbox" data-on-color="brand" id="notify_progress"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Spacing</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="10" id="notify_spacing">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Offset X</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="30" id="notify_offset_x">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Offset Y</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="30" id="notify_offset_y">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Delay</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="1000" id="notify_delay">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Timer</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="2000" id="notify_timer">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Z-Index</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="number" class="form-control" value="10000" id="notify_zindex">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">State</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<select class="form-control" id="notify_state">
											<option value="success">Success</option>
											<option value="danger">Danger</option>
											<option value="warning">Warning</option>
											<option value="info">Info</option>
											<option value="primary">Primary</option>
											<option value="brand">Brand</option>
										</select>
									</div>
								</div>
							</div>
							<div class="card-foot">
								<div class="">
									<div class="row">
										<div class="col-lg-9 ml-lg-auto">
											<a href="javascript:;" id="notify_btn" class="btn btn-success">Display</a>
											<button type="reset" class="btn btn-secondary">Reset</button>
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

		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>