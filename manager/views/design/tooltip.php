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
		<div class="body" id="body">
			<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

				<!-- begin:: Subheader -->
				<div id="subheader" class="subheader" >
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Tooltip</h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Base </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Tooltip </a>
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
									FB-admin extends <code>Bootstrap Tooltip</code> component with a variety of options to provide uniquely looking Tooltip component that matches the FB-admin's design standards.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/components/tooltips/" target="_blank">Documentation</a>.
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											Basic Usage
										</h3>
										<span class="section__info">
											Click below button to toggle tooltip:
										</span>
										<div class="section__content">
											<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Tooltip title">Click me</button>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											Directions
										</h3>
										<span class="section__info">
											Four direction options are available: top, right, bottom, and left aligned:
										</span>
										<div class="section__content">
											<button type="button" class="btn btn-brand" data-container="body" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip title">
												Tooltip on top
											</button>

											<div class="space-10"></div>

											<button type="button" class="btn btn-primary" data-container="body" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tooltip title">
												Tooltip on right
											</button>

											<div class="space-10"></div>

											<button type="button" class="btn btn-warning" data-container="body" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip title">
												Tooltip on bottom
											</button>

											<div class="space-10"></div>

											<button type="button" class="btn btn-success" data-container="body" data-toggle="tooltip" data-placement="left" title="" data-original-title="Tooltip title">
												Tooltip on left
											</button>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											Dismiss on next click
										</h3>
										<span class="section__info">
											Use the focus trigger to dismiss tooltips on the next click that the user makes.
										</span>
										<div class="section__content">
											<a tabindex="0" class="btn btn-success" role="button" data-toggle="tooltip" data-trigger="focus" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="Dismissible tooltip">Dismissible tooltip</a>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->
						</div>
						<div class="col-lg-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Advanced Examples
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											HTML Content
										</h3>
										<span class="section__info">
											Insert HTML into the tooltip:
										</span>
										<div class="section__content">
											<button type="button" class="btn btn-primary" data-toggle="tooltip" title="" data-html="true" data-content="And here's some amazing <b>HTML</b> content. It's very <code>engaging</code>. Right?" data-original-title="Tooltip <b>with</b> <code>HTML</code>">Click me</button>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											Offset
										</h3>
										<span class="section__info">
											Offset of the tooltip relative to its target. For more information refer to <a class="link" href="http://tether.io/#offset" target="_blank">Tether's offset docs.</a>
										</span>
										<div class="section__content">
											<button type="button" class="btn btn-brand" data-offset="20px 20px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip title">
												Example 1
											</button>
											<button type="button" class="btn btn-success" data-offset="-20px -20px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip title">
												Example 2
											</button>
											<button type="button" class="btn btn-danger" data-offset="60px 0px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip title">
												Example 3
											</button>
										</div>
									</div>
									<!--end::Section-->

									<div class="separator separator--dashed"></div>

									<!--begin::Section-->
									<div class="section">
										<h3 class="section__title">
											Skin
										</h3>
										<span class="section__info">
											Use <code>data-skin="light"</code>, <code>data-skin="brand"</code> or <code>data-skin="dark"</code> parameters to set tooltip skin. Default skin is light.
										</span>
										<div class="section__content">
											<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Default light skin">
												Light skin
											</button>
											<button type="button" class="btn btn-brand" data-skin="brand" data-toggle="tooltip" data-placement="top" title="" data-original-title="Brand skin">
												Brand skin
											</button>
											<button type="button" class="btn btn-dark" data-skin="dark" data-toggle="tooltip" data-placement="top" title="" data-original-title="Dark skin">
												Dark skin
											</button>
										</div>
									</div>
									<!--end::Section-->
								</div>
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