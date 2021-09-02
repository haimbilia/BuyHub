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

								Tabbed cards </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									cards </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Tabbed cards </a>
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
						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic Tabs
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line   nav-tabs-line-right nav-tabs-line-brand" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_tab_1_1" role="tab">
													Logs
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_tab_1_2" role="tab">
													Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_tab_1_3" role="tab">
													Settings
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_tab_1_1">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="card_tab_1_2">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text.
										</div>
										<div class="tab-pane" id="card_tab_1_3">
											Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
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
											Tabs <small>with lineawesome icons</small>
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_tab_2_1" role="tab">
													<i class="la la-comments-o"></i>
													Logs
												</a>
											</li>
											<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"><i class="la la-map-marker"></i> Settings</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_2_2">Action</a>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_2_3">Another action</a>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_2_1">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_2_3">Separated link</a>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_tab_2_1">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="card_tab_2_2">
											Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="card_tab_2_3">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
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
											Tabs <small>bootstrap dropdown</small>
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand  nav-tabs-line-right nav-tabs-line-danger" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_tab_3_1" role="tab">
													<i class="la la-comment"></i>
													Messages
												</a>
											</li>
											<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
													<i class="la la-cog"></i>
													Settings
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_3_2">Action</a>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_3_3">Another action</a>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_3_2">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" data-toggle="tab" href="#card_tab_3_3">Separated link</a>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_tab_3_1">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="card_tab_3_2">
											Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="card_tab_3_3">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">Bold Tabs</h3>
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-2x nav-tabs-line-success" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_4_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_3">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_4_1">Something else here</a>
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
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuriesm.
										</div>
										<div class="tab-pane" id="tabs_4_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_4_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
									</div>

									<div class="separator separator--space-md separator--border-dashed"></div>

									<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_5_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_1">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_5_3">Something else here</a>
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
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
										</div>
										<div class="tab-pane" id="tabs_5_2" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="tabs_5_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
										</div>
									</div>

									<div class="separator separator--space-md separator--border-dashed"></div>

									<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-danger" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tabs_6_1" role="tab">Messages</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_3">Another action</a>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_2">Something else here</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" data-toggle="tab" href="#tabs_6_1">Separated link</a>
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

						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Pill Tabs <small>small size</small>
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-pills nav-pills-sm" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#tabs_7_1" role="tab">
													Logs
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#tabs_7_2" role="tab">
													Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#tabs_7_3" role="tab">
													Settings
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_7_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_7_2" role="tabpanel">
											Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="tabs_7_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry.When an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
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
											Pill Tabs <small>default size</small>
										</h3>
									</div>
									<div class="card-head-toolbar">
										<ul class="nav nav-pills nav-pills" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#tabs_8_1" role="tab">
													Logs
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#tabs_8_2" role="tab">
													Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#tabs_8_3" role="tab">
													Settings
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="tabs_8_1" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane" id="tabs_8_2" role="tabpanel">
											Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
										<div class="tab-pane " id="tabs_8_3" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry.When an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">
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
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_base_demo_2_3_tab_content" role="tab">
													<i class="fa fa-dolly" aria-hidden="true"></i>Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_2_tab_content" role="tab">
													<i class="fab fa-dribbble" aria-hidden="true"></i>Settings
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_3_tab_content" role="tab">
													<i class="fab fa-gitter" aria-hidden="true"></i>Logs
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

							<!--begin::card-->
							<div class="card card--tabs">
								<div class="card-head">
									<div class="card-head-toolbar">
										<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#card_base_demo_3_3_tab_content" role="tab">
													<i class="flaticon2-heart-rate-monitor" aria-hidden="true"></i>Messages
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_3_2_tab_content" role="tab">
													<i class="flaticon2-pie-chart-2" aria-hidden="true"></i>Settings
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#card_base_demo_3_3_tab_content" role="tab">
													<i class="flaticon2-chronometer" aria-hidden="true"></i>Logs
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane active" id="card_base_demo_3_3_tab_content" role="tabpanel">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_3_2_tab_content" role="tabpanel">
											It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
										</div>
										<div class="tab-pane" id="card_base_demo_3_3_tab_content" role="tabpanel">
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