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
	<div class="body " id="body">
										<div class="content " id="content">
						
<!-- begin:: Subheader -->
<div class="subheader   grid__item" id="subheader">
<div class="container ">
	<div class="subheader__main">
		<h3 class="subheader__title">SweetAlert2</h3>

						<div class="subheader__breadcrumbs">
				<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
										<span class="subheader__breadcrumbs-separator"></span>
					<a href="" class="subheader__breadcrumbs-link">
						Components	                    </a>
										<span class="subheader__breadcrumbs-separator"></span>
					<a href="" class="subheader__breadcrumbs-link">
						Extended	                    </a>
										<span class="subheader__breadcrumbs-separator"></span>
					<a href="" class="subheader__breadcrumbs-link">
						SweetAlert2	                    </a>
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
			Flot is a pure JavaScript plotting library for jQuery, with a focus on simple usage, attractive looks and interactive features.
			<br>
			For more info please visit the plugin's <a class="link font-bold" href="https://www.flotcharts.org/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/flot/flot" target="_blank">Github Repo</a>.
		</div>
	</div>
</div>
</div>

<!--begin::card-->
<div class="card">
<div class="card-head">
	<div class="card-head-label">
		<h3 class="card-head-title">
			SweetAlert Examples
		</h3>
	</div>
</div>
<div class="card-body">
	<table class="table table-bordered">
		<tbody><tr>
			<td style="width: 40%; vertical-align: middle;">Basic alert</td>
			<td>
				<button type="button" class="btn btn-info btn-custom" id="sweetalert_demo_1"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">Alert title and text</td>
			<td>
				<button type="button" class="btn btn-success btn-custom" id="sweetalert_demo_2"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">Enable <code>warning</code>, <code>error</code>, <code>success</code>, <code>info</code> and <code>question</code> state icons</td>
			<td>
				<button type="button" class="btn btn-warning btn-custom" id="sweetalert_demo_3_1"> Warning</button>
				<button type="button" class="btn btn-danger btn-custom" id="sweetalert_demo_3_2"> Error</button>
				<button type="button" class="btn btn-success btn-custom" id="sweetalert_demo_3_3"> Success</button>
				<button type="button" class="btn btn-info btn-custom" id="sweetalert_demo_3_4"> Info</button>
				<button type="button" class="btn btn-dark btn-custom" id="sweetalert_demo_3_5"> Question</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">Change confirm button text and class</td>
			<td>
				<button type="button" class="btn btn-success btn-custom" id="sweetalert_demo_4"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">Custom button with icon</td>
			<td>
				<button type="button" class="btn btn-danger btn-custom" id="sweetalert_demo_5"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">A custom positioned dialog with timer to auto close</td>
			<td>
				<button type="button" class="btn btn-success btn-custom" id="sweetalert_demo_6"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">jQuery HTML with custom animate.css animation </td>
			<td>
				<button type="button" class="btn btn-brand btn-custom" id="sweetalert_demo_7"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">A warning message, with a function attached to the confirm button</td>
			<td>
				<button type="button" class="btn btn-info btn-custom" id="sweetalert_demo_8"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">By passing a parameter, you can execute something else for cancel</td>
			<td>
				<button type="button" class="btn btn-danger btn-custom" id="sweetalert_demo_9"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">A message with a custom image and CSS animation disabled</td>
			<td>
				<button type="button" class="btn btn-warning btn-custom" id="sweetalert_demo_10"> Show me</button>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; vertical-align: middle;">A message with auto close timer</td>
			<td>
				<button type="button" class="btn btn-dark btn-custom" id="sweetalert_demo_11"> Show me</button>
			</td>
		</tr>
	</tbody></table>
</div>
</div>
<!--end::card-->
</div>
<!-- end:: Content -->
</div>
</div>

<script>
$("#sweetalert_demo_1").click(function(e) {
Swal.fire("Good job!");
});
</script>


<?php  include 'includes/footer.php';?>


</div>

</body>


</html>