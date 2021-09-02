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
							<h3 class="subheader__title">Bootstrap Multiple Select Splitter</h3>

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
									Multiple Select Splitter </a>
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
									Transforms a &lt;select&gt; containing one or more &lt;optgroup&gt; into two chained &lt;select&gt;.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://github.com/poolerMF/bootstrap-multiselectsplitter" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Bootstrap Multiple Select Splitter Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right">
							<div class="card-body">
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Standard Group Select</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<select class="form-control">
											<optgroup label="Category 1">
												<option value="1">Choice 1</option>
												<option value="2">Choice 2</option>
												<option value="3">Choice 3</option>
												<option value="4">Choice 4</option>
											</optgroup>
											<optgroup label="Category 2">
												<option value="5">Choice 5</option>
												<option value="6">Choice 6</option>
												<option value="7">Choice 7</option>
												<option value="8">Choice 8</option>
											</optgroup>
											<optgroup label="Category 3">
												<option value="5">Choice 9</option>
												<option value="6">Choice 10</option>
												<option value="7">Choice 11</option>
												<option value="8">Choice 12</option>
											</optgroup>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Select Splitter 1</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<select class="form-control" id="multipleselectsplitter_1" style="display: none;">
											<optgroup label="Category 1">
												<option value="1">Choice 1</option>
												<option value="2">Choice 2</option>
												<option value="3">Choice 3</option>
												<option value="4">Choice 4</option>
											</optgroup>
											<optgroup label="Category 2">
												<option value="5">Choice 5</option>
												<option value="6" selected="">Choice 6</option>
												<option value="7">Choice 7</option>
												<option value="8">Choice 8</option>
											</optgroup>
											<optgroup label="Category 3">
												<option value="5">Choice 9</option>
												<option value="6">Choice 10</option>
												<option value="7">Choice 11</option>
												<option value="8">Choice 12</option>
											</optgroup>
										</select>
										<div class="row" data-multiselectsplitter-wrapper-selector="">
											<div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-firstselect-selector="" size="4">
													<option value="Category 1" data-current-label="Category 1">Category 1</option>
													<option value="Category 2" data-current-label="Category 2">Category 2</option>
													<option value="Category 3" data-current-label="Category 3">Category 3</option>
												</select></div> <!-- Add the extra clearfix for only the required viewport -->
											<div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-secondselect-selector="" size="4">
													<option value="5">Choice 5</option>
													<option value="6">Choice 6</option>
													<option value="7">Choice 7</option>
													<option value="8">Choice 8</option>
												</select></div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Select Splitter 2</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<select class="form-control" id="multipleselectsplitter_2" style="display: none;">
											<optgroup label="Group 1">
												<option value="1" selected="">Option 1</option>
												<option value="2">Option 2</option>
												<option value="3">Option 3</option>
												<option value="4">Option 4</option>
											</optgroup>
											<optgroup label="Group 2">
												<option value="5">Option 5</option>
												<option value="6">Option 6</option>
												<option value="7">Option 7</option>
												<option value="8">Option 8</option>
											</optgroup>
											<optgroup label="Group 3">
												<option value="5">Option 9</option>
												<option value="6">Option 10</option>
												<option value="7">Option 11</option>
												<option value="8">Option 12</option>
											</optgroup>
											<optgroup label="Group 4">
												<option value="5">Option 13</option>
												<option value="6">Option 14</option>
												<option value="7">Option 15</option>
												<option value="8">Option 16</option>
											</optgroup>
											<optgroup label="Group 5">
												<option value="5">Option 17</option>
												<option value="6">Option 18</option>
												<option value="7">Option 19</option>
												<option value="8">Option 20</option>
											</optgroup>
										</select>
										<div class="row" data-multiselectsplitter-wrapper-selector="">
											<div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-firstselect-selector="" size="5">
													<option value="Group 1" data-current-label="Group 1">Group 1</option>
													<option value="Group 2" data-current-label="Group 2">Group 2</option>
													<option value="Group 3" data-current-label="Group 3">Group 3</option>
													<option value="Group 4" data-current-label="Group 4">Group 4</option>
													<option value="Group 5" data-current-label="Group 5">Group 5</option>
												</select></div> <!-- Add the extra clearfix for only the required viewport -->
											<div class="col-xs-6 col-sm-6"><select class="form-control" data-multiselectsplitter-secondselect-selector="" size="5">
													<option value="1">Option 1</option>
													<option value="2">Option 2</option>
													<option value="3">Option 3</option>
													<option value="4">Option 4</option>
												</select></div>
										</div>
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