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
							<h3 class="subheader__title">Bootstrap Datepicker</h3>

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
									Datepicker </a>
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
									A datepicker for twitter bootstrap (@twbs).
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://uxsolutions.github.io/bootstrap-datepicker/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/uxsolutions/bootstrap-datepicker" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Bootstrap Date Picker Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right">
							<div class="card-body">
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<input type="text" class="form-control" id="datepicker_1" readonly="" placeholder="Select date">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Input Group Setup</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="input-group date">
											<input type="text" class="form-control" readonly="" placeholder="Select date" id="datepicker_2">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-calendar-check-o"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Enable Helper Buttons</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="input-group date">
											<input type="text" class="form-control" readonly="" value="05/20/2017" id="datepicker_3">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-calendar"></i>
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
											<input type="text" class="form-control" placeholder="Top left" id="datepicker_4_1">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-bullhorn"></i>
												</span>
											</div>
										</div>
										<div class="space-10"></div>
										<div class="input-group date">
											<input type="text" class="form-control" placeholder="Top right" id="datepicker_4_2">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-clock-o"></i>
												</span>
											</div>
										</div>
										<div class="space-10"></div>
										<div class="input-group date">
											<input type="text" class="form-control" placeholder="Bottom left" id="datepicker_4_3">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-check"></i>
												</span>
											</div>
										</div>
										<div class="space-10"></div>
										<div class="input-group date">
											<input type="text" class="form-control" placeholder="Bottom right" id="datepicker_4_4">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-check-circle-o"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Range Picker</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="input-daterange input-group" id="datepicker_5">
											<input type="text" class="form-control" name="start">
											<div class="input-group-append">
												<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
											</div>
											<input type="text" class="form-control" name="end">
										</div>
										<span class="form-text text-muted">Linked pickers for date range selection</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Inline Mode</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="" id="datepicker_6">
											<div class="datepicker datepicker-inline">
												<div class="datepicker-days" style="">
													<table class="table-condensed">
														<thead>
															<tr>
																<th colspan="7" class="datepicker-title" style="display: none;"></th>
															</tr>
															<tr>
																<th class="prev"><i class="la la-angle-left"></i></th>
																<th colspan="5" class="datepicker-switch">September 2019</th>
																<th class="next"><i class="la la-angle-right"></i></th>
															</tr>
															<tr>
																<th class="dow">Su</th>
																<th class="dow">Mo</th>
																<th class="dow">Tu</th>
																<th class="dow">We</th>
																<th class="dow">Th</th>
																<th class="dow">Fr</th>
																<th class="dow">Sa</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="old day" data-date="1566691200000">25</td>
																<td class="old day" data-date="1566777600000">26</td>
																<td class="old day" data-date="1566864000000">27</td>
																<td class="old day" data-date="1566950400000">28</td>
																<td class="old day" data-date="1567036800000">29</td>
																<td class="old day" data-date="1567123200000">30</td>
																<td class="old day" data-date="1567209600000">31</td>
															</tr>
															<tr>
																<td class="day" data-date="1567296000000">1</td>
																<td class="day" data-date="1567382400000">2</td>
																<td class="day" data-date="1567468800000">3</td>
																<td class="active day" data-date="1567555200000">4</td>
																<td class="day" data-date="1567641600000">5</td>
																<td class="day" data-date="1567728000000">6</td>
																<td class="day" data-date="1567814400000">7</td>
															</tr>
															<tr>
																<td class="day" data-date="1567900800000">8</td>
																<td class="day" data-date="1567987200000">9</td>
																<td class="day" data-date="1568073600000">10</td>
																<td class="day" data-date="1568160000000">11</td>
																<td class="day" data-date="1568246400000">12</td>
																<td class="day" data-date="1568332800000">13</td>
																<td class="day" data-date="1568419200000">14</td>
															</tr>
															<tr>
																<td class="day" data-date="1568505600000">15</td>
																<td class="day" data-date="1568592000000">16</td>
																<td class="day" data-date="1568678400000">17</td>
																<td class="day" data-date="1568764800000">18</td>
																<td class="day" data-date="1568851200000">19</td>
																<td class="day" data-date="1568937600000">20</td>
																<td class="day" data-date="1569024000000">21</td>
															</tr>
															<tr>
																<td class="day" data-date="1569110400000">22</td>
																<td class="day" data-date="1569196800000">23</td>
																<td class="day" data-date="1569283200000">24</td>
																<td class="day" data-date="1569369600000">25</td>
																<td class="day" data-date="1569456000000">26</td>
																<td class="day" data-date="1569542400000">27</td>
																<td class="day" data-date="1569628800000">28</td>
															</tr>
															<tr>
																<td class="day" data-date="1569715200000">29</td>
																<td class="day" data-date="1569801600000">30</td>
																<td class="new day" data-date="1569888000000">1</td>
																<td class="new day" data-date="1569974400000">2</td>
																<td class="new day" data-date="1570060800000">3</td>
																<td class="new day" data-date="1570147200000">4</td>
																<td class="new day" data-date="1570233600000">5</td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="7" class="today" style="display: none;">Today</th>
															</tr>
															<tr>
																<th colspan="7" class="clear" style="display: none;">Clear</th>
															</tr>
														</tfoot>
													</table>
												</div>
												<div class="datepicker-months" style="display: none;">
													<table class="table-condensed">
														<thead>
															<tr>
																<th colspan="7" class="datepicker-title" style="display: none;"></th>
															</tr>
															<tr>
																<th class="prev"><i class="la la-angle-left"></i></th>
																<th colspan="5" class="datepicker-switch">2019</th>
																<th class="next"><i class="la la-angle-right"></i></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month focused active">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="7" class="today" style="display: none;">Today</th>
															</tr>
															<tr>
																<th colspan="7" class="clear" style="display: none;">Clear</th>
															</tr>
														</tfoot>
													</table>
												</div>
												<div class="datepicker-years" style="display: none;">
													<table class="table-condensed">
														<thead>
															<tr>
																<th colspan="7" class="datepicker-title" style="display: none;"></th>
															</tr>
															<tr>
																<th class="prev"><i class="la la-angle-left"></i></th>
																<th colspan="5" class="datepicker-switch">2010-2019</th>
																<th class="next"><i class="la la-angle-right"></i></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan="7"><span class="year old">2009</span><span class="year">2010</span><span class="year">2011</span><span class="year">2012</span><span class="year">2013</span><span class="year">2014</span><span class="year">2015</span><span class="year">2016</span><span class="year">2017</span><span class="year">2018</span><span class="year active focused">2019</span><span class="year new">2020</span></td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="7" class="today" style="display: none;">Today</th>
															</tr>
															<tr>
																<th colspan="7" class="clear" style="display: none;">Clear</th>
															</tr>
														</tfoot>
													</table>
												</div>
												<div class="datepicker-decades" style="display: none;">
													<table class="table-condensed">
														<thead>
															<tr>
																<th colspan="7" class="datepicker-title" style="display: none;"></th>
															</tr>
															<tr>
																<th class="prev"><i class="la la-angle-left"></i></th>
																<th colspan="5" class="datepicker-switch">2000-2090</th>
																<th class="next"><i class="la la-angle-right"></i></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade active focused">2010</span><span class="decade">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="7" class="today" style="display: none;">Today</th>
															</tr>
															<tr>
																<th colspan="7" class="clear" style="display: none;">Clear</th>
															</tr>
														</tfoot>
													</table>
												</div>
												<div class="datepicker-centuries" style="display: none;">
													<table class="table-condensed">
														<thead>
															<tr>
																<th colspan="7" class="datepicker-title" style="display: none;"></th>
															</tr>
															<tr>
																<th class="prev"><i class="la la-angle-left"></i></th>
																<th colspan="5" class="datepicker-switch">2000-2900</th>
																<th class="next"><i class="la la-angle-right"></i></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan="7"><span class="century old">1900</span><span class="century active focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="7" class="today" style="display: none;">Today</th>
															</tr>
															<tr>
																<th colspan="7" class="clear" style="display: none;">Clear</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<a href="#" class="btn btn-label-brand" data-toggle="modal" data-target="#datepicker_modal">Launch modal datepickers</a>
									</div>
								</div>
							</div>
							<div class="card-foot">
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
					<div class="modal fade" id="datepicker_modal" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
											<label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<input type="text" class="form-control" id="datepicker_1_modal" readonly="" placeholder="Select date">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-sm-12">Input Group Setup</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="input-group date">
													<input type="text" class="form-control" readonly="" placeholder="Select date" id="datepicker_2_modal">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar-check-o"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row margin-b-20">
											<label class="col-form-label col-lg-3 col-sm-12">Enable Helper Buttons</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="input-group date">
													<input type="text" class="form-control" value="05/20/2017" id="datepicker_3_modal">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
												<span class="form-text text-muted">Enable clear and today helper buttons</span>
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
											<input type="text" class="form-control is-valid" readonly="" placeholder="Select date" id="datepicker_1_validate">
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
											<input type="text" class="form-control is-invalid" readonly="" placeholder="Select date" id="datepicker_2_validate">
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