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
							<h3 class="subheader__title">noUiSlider</h3>

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
									noUiSlider </a>
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
									noUiSlider is a lightweight JavaScript range slider library with full multi-touch support. It fits wonderfully in responsive designs and has no dependencies.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://refreshless.com/nouislider/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/leongersen/noUiSlider" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Bootstrap noUiSlider Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--fit form--label-right">
							<div class="card-body">
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Basic Setup</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row align-items-center">
											<div class="col-4">
												<input type="text" class="form-control" id="nouislider_1_input" placeholder="Quantity">
											</div>
											<div class="col-8">
												<div id="nouislider_1" class="nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal">
													<div class="noUi-base">
														<div class="noUi-connects"></div>
														<div class="noUi-origin" style="transform: translate(-80%); z-index: 4;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="10.0" aria-valuenow="2.0" aria-valuetext="2">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted">Input control is attached to slider</span>
									</div>
								</div>
								<div class="separator separator--border-dashed separator--space-lg"></div>

								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Currency Formatting</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row align-items-center">
											<div class="col-4">
												<input type="text" class="form-control" id="nouislider_2_input" placeholder="Currency">
											</div>
											<div class="col-8">
												<div id="nouislider_2" class="nouislider nouislider--handle-danger noUi-target noUi-ltr noUi-horizontal">
													<div class="noUi-base">
														<div class="noUi-connects">
															<div class="noUi-connect" style="transform: translate(0%) scale(0.433333, 1);"></div>
														</div>
														<div class="noUi-origin" style="transform: translate(-56.6667%); z-index: 4;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="20000.0" aria-valuemax="80000.0" aria-valuenow="46000.0" aria-valuetext="46.000 (US $)">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted">To format the slider output, noUiSlider offers a format option.</span>
									</div>
								</div>

								<div class="separator separator--border-dashed separator--space-lg"></div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Slider With Tooltip</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row align-items-center">
											<div class="col-2">
												<input type="text" class="form-control" id="nouislider_3_input" placeholder="Quantity">
											</div>
											<div class="col-2">
												<input type="text" class="form-control" id="nouislider_3.1_input" placeholder="Quantity">
											</div>
											<div class="col-8">
												<div id="nouislider_3" class="nouislider noUi-target noUi-rtl noUi-horizontal">
													<div class="noUi-base">
														<div class="noUi-connects">
															<div class="noUi-connect" style="transform: translate(28.5714%) scale(0.5, 1);"></div>
														</div>
														<div class="noUi-origin" style="transform: translate(-21.4286%); z-index: 5;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="130.0" aria-valuenow="30.0" aria-valuetext="30.00">
																<div class="noUi-touch-area"></div>
																<div class="noUi-tooltip">30.00</div>
															</div>
														</div>
														<div class="noUi-origin" style="transform: translate(-71.4286%); z-index: 4;">
															<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="30.0" aria-valuemax="200.0" aria-valuenow="130.0" aria-valuetext="130.00">
																<div class="noUi-touch-area"></div>
																<div class="noUi-tooltip">130.0</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted">Slider with tooltips to show slider values.</span>
									</div>
								</div>

								<div class="separator separator--border-dashed separator--space-lg"></div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Slider State Colors</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row align-items-center">
											<div class="col-2">
												<select class="form-control" id="nouislider_input_select">
													<option value="-20">-20</option>
													<option value="-19">-19</option>
													<option value="-18">-18</option>
													<option value="-17">-17</option>
													<option value="-16">-16</option>
													<option value="-15">-15</option>
													<option value="-14">-14</option>
													<option value="-13">-13</option>
													<option value="-12">-12</option>
													<option value="-11">-11</option>
													<option value="-10">-10</option>
													<option value="-9">-9</option>
													<option value="-8">-8</option>
													<option value="-7">-7</option>
													<option value="-6">-6</option>
													<option value="-5">-5</option>
													<option value="-4">-4</option>
													<option value="-3">-3</option>
													<option value="-2">-2</option>
													<option value="-1">-1</option>
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
													<option value="31">31</option>
													<option value="32">32</option>
													<option value="33">33</option>
													<option value="34">34</option>
													<option value="35">35</option>
													<option value="36">36</option>
													<option value="37">37</option>
													<option value="38">38</option>
													<option value="39">39</option>
													<option value="40">40</option>
												</select>
											</div>
											<div class="col-2">
												<input type="number" class="form-control" id="nouislider_input_number" placeholder="Quantity">
											</div>
											<div class="col-8">
												<div id="nouislider_4" class="nouislider nouislider--handle-primary nouislider--connect-warning noUi-target noUi-ltr noUi-horizontal">
													<div class="noUi-base">
														<div class="noUi-connects">
															<div class="noUi-connect" style="transform: translate(50%) scale(0.333333, 1);"></div>
														</div>
														<div class="noUi-origin" style="transform: translate(-50%); z-index: 5;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="-20.0" aria-valuemax="30.0" aria-valuenow="10.0" aria-valuetext="10.00">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
														<div class="noUi-origin" style="transform: translate(-16.6667%); z-index: 4;">
															<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="10.0" aria-valuemax="40.0" aria-valuenow="30.0" aria-valuetext="30.00">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted">Use state classes to change the slider's connect path and handle colors.</span>
									</div>
								</div>

								<div class="separator separator--border-dashed separator--space-lg"></div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Soft Limits</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row align-items-center">
											<div class="col-4">
												<input type="text" class="form-control" id="nouislider_5_input" placeholder="Quantity">
											</div>
											<div class="col-8">
												<div id="nouislider_5" class="noUi-target noUi-ltr noUi-horizontal">
													<div class="noUi-base">
														<div class="noUi-connects"></div>
														<div class="noUi-origin" style="transform: translate(-80%); z-index: 4;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="100.0" aria-valuenow="20.0" aria-valuetext="20.00">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
													</div>
													<div class="noUi-pips noUi-pips-horizontal">
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 0%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 4%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 8%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 12%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 16%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 20%;"></div>
														<div class="noUi-value noUi-value-horizontal noUi-value-large" data-value="20" style="left: 20%;">20</div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 24%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 28%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 32%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 36%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 40%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 44%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 48%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 52%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 56%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 60%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 64%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 68%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 72%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 76%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 80%;"></div>
														<div class="noUi-value noUi-value-horizontal noUi-value-large" data-value="80" style="left: 80%;">80</div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 84%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 88%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 92%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 96%;"></div>
														<div class="noUi-marker noUi-marker-horizontal noUi-marker-normal" style="left: 100%;"></div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted margin-t-20">Disables the edges of slider where handler bounces back when released</span>
									</div>
								</div>

								<div class="separator separator--border-dashed separator--space-lg"></div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Vertical Slider</label>
									<div class="col-lg-6 col-md-12 col-sm-12">
										<div class="row">
											<div class="col-4">
												<input type="text" class="form-control" id="nouislider_6_input" placeholder="Quantity">
											</div>
											<div class="col-8">
												<div id="nouislider_6" class="noUi-target noUi-ltr noUi-vertical">
													<div class="noUi-base">
														<div class="noUi-connects"></div>
														<div class="noUi-origin" style="transform: translate(0px, 81.2162%); z-index: 4;">
															<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="vertical" aria-valuemin="0.0" aria-valuemax="100.0" aria-valuenow="81.2" aria-valuetext="81.22">
																<div class="noUi-touch-area"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<span class="form-text text-muted">Vertical orientation slider example</span>
									</div>
								</div>

								<div class="separator separator--border-dashed separator--space-lg"></div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<a href="" class="btn btn-success btn-pill" data-toggle="modal" data-target="#nouislider_modal">Launch modal examples</a>
									</div>
								</div>
							</div>
							<div class="card-foot card-foot-fit-x">
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

					<!--begin::Modal-->
					<div class="modal fade" id="nouislider_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Bootstrap Date Picker Examples</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" class="la la-remove"></span>
									</button>
								</div>
								<form class="form form--fit form--label-right">
									<div class="modal-body">
										<div class="form-group row margin-t-20">
											<label class="col-form-label col-lg-3 col-sm-12">Basic Setup</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="row align-items-center">
													<div class="col-6">
														<input type="text" class="form-control" id="nouislider_modal1_input" placeholder="Quantity">
													</div>
													<div class="col-6">
														<div id="nouislider_modal1" class="nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal">
															<div class="noUi-base">
																<div class="noUi-connects"></div>
																<div class="noUi-origin" style="transform: translate(-100%); z-index: 4;">
																	<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="10.0" aria-valuenow="0.0" aria-valuetext="0">
																		<div class="noUi-touch-area"></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group row margin-t-20">
											<label class="col-form-label col-lg-3 col-sm-12">Currency Formatting</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="row align-items-center">
													<div class="col-6">
														<input type="text" class="form-control" id="nouislider_modal2_input" placeholder="Quantity">
													</div>
													<div class="col-6">
														<div id="nouislider_modal2" class="nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal">
															<div class="noUi-base">
																<div class="noUi-connects">
																	<div class="noUi-connect" style="transform: translate(0%) scale(0, 1);"></div>
																</div>
																<div class="noUi-origin" style="transform: translate(-100%); z-index: 4;">
																	<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="20000.0" aria-valuemax="80000.0" aria-valuenow="20000.0" aria-valuetext="20.000 (US $)">
																		<div class="noUi-touch-area"></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group row margin-t-20">
											<label class="col-form-label col-lg-3 col-sm-12">Slider With Tooltip</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="row align-items-center">
													<div class="col-3">
														<input type="text" class="form-control" id="nouislider_modal1.1_input" placeholder="Quantity">
													</div>
													<div class="col-3">
														<input type="text" class="form-control" id="nouislider_modal1.2_input" placeholder="Quantity">
													</div>
													<div class="col-6">
														<div id="nouislider_modal3" class="nouislider noUi-target noUi-rtl noUi-horizontal">
															<div class="noUi-base">
																<div class="noUi-connects">
																	<div class="noUi-connect" style="transform: translate(28.5714%) scale(0.557143, 1);"></div>
																</div>
																<div class="noUi-origin" style="transform: translate(-15.7143%); z-index: 5;">
																	<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="130.0" aria-valuenow="20.0" aria-valuetext="20.00">
																		<div class="noUi-touch-area"></div>
																		<div class="noUi-tooltip">20.00</div>
																	</div>
																</div>
																<div class="noUi-origin" style="transform: translate(-71.4286%); z-index: 4;">
																	<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="20.0" aria-valuemax="200.0" aria-valuenow="130.0" aria-valuetext="130.00">
																		<div class="noUi-touch-area"></div>
																		<div class="noUi-tooltip">130.0</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
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