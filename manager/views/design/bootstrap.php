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
							<h3 class="subheader__title">

								Bootstrap Tabs </h3>

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
									Bootstrap Tabs </a>
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
									Metronic extends <code>Bootstrap Tab</code> component with a variety of options to provide uniquely looking Tab component that matches the Metronic's design standards.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/components/navs/#tabs" target="_blank">Documentation</a>.
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
											Basic Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#" data-target="#tabs_1_1">Active</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_1_4">Disabled</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_1_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_1_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Icon Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_1_1">
												<i class="la la-exclamation-triangle"></i> Active
											</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
												<i class="la la-exclamation-circle font-success"></i> Dropdown
											</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3">
												<i class="la la-cloud-download"></i> Link 1
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3">
												<i class="la la-puzzle-piece font-danger"></i> Link 2
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_1_4">
												<i class="la la-comment"></i> Disabled
											</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_1_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_1_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_1_1">
												<i class="flaticon-interface-5"></i> <span class="-visible-desktop-inline-block">Active1</span>
											</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
												<i class="flaticon-time-2 font-success"></i> <span class="-visible-desktop-inline-block">Dropdown</span>
											</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3">
												<i class="flaticon-placeholder-2"></i> <span class="-visible-desktop-inline-block">Link 1</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3">
												<i class="flaticon-lock font-danger"></i> <span class="-visible-desktop-inline-block">Link 2</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_1_4">
												<i class="flaticon-share"></i> <span class="-visible-desktop-inline-block">Disabled</span>
											</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_1_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_1_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Adjusted Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs nav-fill" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_2_1">Active</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_2_2">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_2_3">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_2_4">Disabled</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_1_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_1_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_1_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
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
											Pills
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_3_1">Active</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_3_3">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_3_4">Disabled</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_3_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_3_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_3_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_3_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Pill Icon Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item ">
											<a class="nav-link active" data-toggle="tab" href="#tabs_3_1"><i class="la la-gear"></i>Active</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
												<i class="la la-gift"></i> Dropdown
											</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_3_3"><i class="la la-map-marker"></i>Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_3_4"><i class="la la-question-circle"></i>Disabled</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_3_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_3_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_3_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_3_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Adjusted Pills
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills nav-fill" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_5_1">Active</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_5_2">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_5_3">Link</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" data-toggle="tab" href="#tabs_5_4">Disabled</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="tabs_5_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_5_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_5_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
										<div class="tab-pane" id="tabs_5_4" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
										</div>
									</div>
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