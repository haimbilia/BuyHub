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
							<h3 class="subheader__title">Bootstrap Switch</h3>

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
									Form Widgets </a>
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
						<div class="col">
							<div class="alert alert-light alert-elevate fade show" role="alert">
								<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
								<div class="alert-text">
									Turn checkboxes and radio buttons into toggle switches.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://bttstrp.github.io/bootstrap-switch/examples.html" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/Bttstrp/bootstrap-switch" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Bootstrap Switch Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right">
							<div class="card-body">
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Basic Example</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" id="switch_1"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off bootstrap-switch-on" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" id="switch_1"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">State Colors</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off bootstrap-switch-on" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-warning" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="success" data-off-color="warning"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off bootstrap-switch-on" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="brand"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off bootstrap-switch-on" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-danger" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="danger"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="info"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Custom Label</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 154px;">
											<div class="bootstrap-switch-container" style="width: 228px; margin-left: -76px;"><span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 76px;">True</span><span class="bootstrap-switch-label" style="width: 76px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 76px;">False</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="True" data-handle-width="50" data-off-text="False" data-on-color="success"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 114px;">
											<div class="bootstrap-switch-container" style="width: 168px; margin-left: -56px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 56px;">1</span><span class="bootstrap-switch-label" style="width: 56px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 56px;">0</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="1" data-handle-width="30" data-off-text="0" data-on-color="info"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 194px;">
											<div class="bootstrap-switch-container" style="width: 288px; margin-left: -96px;"><span class="bootstrap-switch-handle-on bootstrap-switch-brand" style="width: 96px;">Enabled</span><span class="bootstrap-switch-label" style="width: 96px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 96px;">Disabled</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="Enabled" data-handle-width="70" data-off-text="Disabled" data-on-color="brand"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Disabled State</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked" disabled=""></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" disabled=""></div>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Sizing</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<div class="bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" data-size="small" type="checkbox" checked="checked"></div>
										</div>
										<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" type="checkbox" checked="checked"></div>
										</div>
										<div class="bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 104px;">
											<div class="bootstrap-switch-container" style="width: 153px; margin-left: -51px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 51px;">ON</span><span class="bootstrap-switch-label" style="width: 51px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 51px;">OFF</span><input data-switch="true" data-size="large" type="checkbox" checked="checked"></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
									<div class="col-lg-9 col-md-9 col-sm-12">
										<a href="" class="btn btn-outline-danger success btn-pill" data-toggle="modal" data-target="#switch_modal">Launch switches on modal</a>
									</div>
								</div>
							</div>
							<div class="card__foot">
								<div class="form__actions">
									<div class="row">
										<div class="col-lg-9 ml-lg-auto">
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

					<!--begin::Modal-->
					<div class="modal fade" id="switch_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="">Bootstrap Switch Examples</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" class="la la-remove"></span>
									</button>
								</div>
								<form class="form form--fit form--label-right">
									<div class="modal-body">
										<div class="form-group row margin-t-20">
											<label class="col-form-label col-lg-3 col-sm-12">Basic Example</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-primary">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" checked="checked" id="switch_1"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-primary">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" id="switch_1"></div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-sm-12">State Colors</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-success">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-warning">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="success" data-off-color="warning"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-brand">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="brand"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-danger">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="danger"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-info">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" checked="checked" data-on-color="info"></div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-sm-12">Custom Label</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-success">True</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">False</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="True" data-off-text="False" data-on-color="success"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-info">1</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">0</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="1" data-off-text="0" data-on-color="info"></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-brand">Enabled</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">Disabled</span><input data-switch="true" type="checkbox" checked="checked" data-on-text="Enabled" data-off-text="Disabled" data-on-color="brand"></div>
												</div>
											</div>
										</div>
										<div class="form-group row margin-b-20">
											<label class="col-form-label col-lg-3 col-sm-12">Disabled State</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-primary">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" checked="checked" disabled=""></div>
												</div>
												<div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper">
													<div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-primary">ON</span><span class="bootstrap-switch-label">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default">OFF</span><input data-switch="true" type="checkbox" disabled=""></div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-secondary">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!--end::Modal-->
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