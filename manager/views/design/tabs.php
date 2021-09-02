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
							<h3 class="subheader__title">Line Tabs</h3>

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
									Tabs </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Line Tabs </a>
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
									FB-admin extends <code>Bootstrap Tab</code> component with a variety of options to provide uniquely looking Tab component that matches the FB-admin's design standards.
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
											Default Line Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs  nav-tabs-line" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_1_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_1_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_1_3" role="tab">Logs</a>
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
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Line Tabs States
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_2_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_2_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_2_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_2_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_2_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_2_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_2_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_2_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
										</div>
										<div class="tab-pane" id="tabs_2_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scramble.
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-primary" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_3_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_3_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_3_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_3_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_3_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
										</div>
										<div class="tab-pane" id="tabs_3_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scramble.
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-danger" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_46_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_4_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_4_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_4_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
										</div>
										<div class="tab-pane" id="tabs_4_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scramble.
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-warning" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_5_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_5_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_5_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_5_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
										</div>
										<div class="tab-pane" id="tabs_5_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scramble.
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
											Bold Line Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-success" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_6_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_6_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_6_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_6_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_6_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_6_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_6_3" role="tab">Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_6_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
										</div>
										<div class="tab-pane" id="tabs_6_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_6_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
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
											Icon Tabs
										</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_7_1" role="tab"><i class="la la-cloud-upload"></i> Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="la la-cog"></i> Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_7_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_7_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_7_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_7_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_7_3" role="tab"><i class="la la-puzzle-piece"></i> Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_7_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to.
										</div>
										<div class="tab-pane" id="tabs_7_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently.
										</div>
										<div class="tab-pane" id="tabs_7_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-primary" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_8_1" role="tab"><i class="fa fa-cloud-upload"></i> Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_8_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_8_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_8_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_8_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_8_3" role="tab"><i class="fa fa-puzzle-piece"></i> Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_8_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to.
										</div>
										<div class="tab-pane" id="tabs_8_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently.
										</div>
										<div class="tab-pane" id="tabs_8_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
										</div>
									</div>

									<div class="separator separator--dashed"></div>

									<ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-brand" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_9_1" role="tab"><i class="flaticon-time-2"></i> Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="flaticon-placeholder-2"></i> Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_9_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_9_2">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_9_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_9_2">Separated link</a>
											</div>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tabs_9_3" role="tab"><i class="flaticon-multimedia"></i> Logs</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_9_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to.
										</div>
										<div class="tab-pane" id="tabs_9_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently.
										</div>
										<div class="tab-pane" id="tabs_9_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											card Tabs
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-right" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_base_demo_1_tab_content" role="tab">
													<i class="flaticon-multimedia"></i> Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_tab_content" role="tab">
													<i class="flaticon-cogwheel-2"></i> Settings
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_3_tab_content" role="tab">
													<i class="flaticon-lifebuoy"></i> Logs
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_base_demo_1_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_2_tab_content" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_3_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success nav-tabs-line-2x" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_base_demo_1_1_tab_content" role="tab">
													<i class="la la-cog"></i> Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_1_2_tab_content" role="tab">
													<i class="la la-briefcase"></i> Settings
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_1_3_tab_content" role="tab">
													<i class="la la-bell-o"></i>Logs
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_base_demo_1_1_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_1_2_tab_content" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_1_3_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_base_demo_2_3_tab_content" role="tab">
													<i class="fa fa-calendar-check-o" aria-hidden="true"></i>Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_2_tab_content" role="tab">
													<i class="fa fa-bar-chart" aria-hidden="true"></i>Settings
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_3_tab_content" role="tab">
													<i class="fa fa-tags" aria-hidden="true"></i>Logs
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_base_demo_2_3_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_2_2_tab_content" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_2_3_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
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