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

								Dual Listbox Dashboard </h3>

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
									Dual Listbox </a>
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
									Dual Listbox is a pure JavaScript plugin that converts the normal select box into a searchable dual list box where the users are able to move options between two selection panels.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://www.cssscript.com/demo/pure-js-dual-list-box-component/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/maykinmedia/dual-listbox" target="_blank">GitHub</a>.
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Default Dual Listbox
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="dual-listbox dual-listbox-1"><input class="dual-listbox__search" placeholder="Search">
										<div class="dual-listbox__container">
											<div>
												<div class="dual-listbox__title">Available options</div>
												<ul class="dual-listbox__available">
													<li class="dual-listbox__item" data-id="1">One</li>
													<li class="dual-listbox__item" data-id="2">Two</li>
													<li class="dual-listbox__item" data-id="3">Three</li>
													<li class="dual-listbox__item" data-id="4">Four</li>
													<li class="dual-listbox__item" data-id="5">Five</li>
													<li class="dual-listbox__item" data-id="6">Six</li>
													<li class="dual-listbox__item" data-id="7">Seven</li>
													<li class="dual-listbox__item" data-id="8">Eight</li>
													<li class="dual-listbox__item" data-id="9">Nine</li>
													<li class="dual-listbox__item" data-id="10">Ten</li>
												</ul>
											</div>
											<div class="dual-listbox__buttons"><button class="dual-listbox__button">Add All</button><button class="dual-listbox__button">Add</button><button class="dual-listbox__button">Remove</button><button class="dual-listbox__button">Remove All</button></div>
											<div>
												<div class="dual-listbox__title">Selected options</div>
												<ul class="dual-listbox__selected"></ul>
											</div>
										</div>
									</div><select id="dual-listbox-1" class="dual-listbox" multiple="" style="display: none;"></select>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Dual Listbox with Custom Labels
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="dual-listbox dual-listbox-2"><input class="dual-listbox__search" placeholder="Search">
										<div class="dual-listbox__container">
											<div>
												<div class="dual-listbox__title">Source Options</div>
												<ul class="dual-listbox__available">
													<li class="dual-listbox__item" data-id="1">One</li>
													<li class="dual-listbox__item" data-id="2">Two</li>
													<li class="dual-listbox__item" data-id="3">Three</li>
													<li class="dual-listbox__item" data-id="4">Four</li>
													<li class="dual-listbox__item" data-id="5">Five</li>
													<li class="dual-listbox__item" data-id="6">Six</li>
													<li class="dual-listbox__item" data-id="7">Seven</li>
													<li class="dual-listbox__item" data-id="8">Eight</li>
													<li class="dual-listbox__item" data-id="9">Nine</li>
													<li class="dual-listbox__item" data-id="10">Ten</li>
												</ul>
											</div>
											<div class="dual-listbox__buttons"><button class="dual-listbox__button"><i class="flaticon2-fast-next"></i></button><button class="dual-listbox__button"><i class="flaticon2-next"></i></button><button class="dual-listbox__button"><i class="flaticon2-back"></i></button><button class="dual-listbox__button"><i class="flaticon2-fast-back"></i></button></div>
											<div>
												<div class="dual-listbox__title">Destination Options</div>
												<ul class="dual-listbox__selected"></ul>
											</div>
										</div>
									</div><select id="dual-listbox-2" class="dual-listbox" multiple="" data-available-title="Source Options" data-selected-title="Destination Options" data-add="<i class='flaticon2-next'></i>" data-remove="<i class='flaticon2-back'></i>" data-add-all="<i class='flaticon2-fast-next'></i>" data-remove-all="<i class='flaticon2-fast-back'></i>" style="display: none;"></select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Dual Listbox with Pre-Selection
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="dual-listbox dual-listbox-3"><input class="dual-listbox__search" placeholder="Search">
										<div class="dual-listbox__container">
											<div>
												<div class="dual-listbox__title">Available options</div>
												<ul class="dual-listbox__available">
													<li class="dual-listbox__item" data-id="1">One</li>
													<li class="dual-listbox__item" data-id="3">Three</li>
													<li class="dual-listbox__item" data-id="4">Four</li>
													<li class="dual-listbox__item" data-id="5">Five</li>
													<li class="dual-listbox__item" data-id="7">Seven</li>
													<li class="dual-listbox__item" data-id="8">Eight</li>
													<li class="dual-listbox__item" data-id="9">Nine</li>
													<li class="dual-listbox__item" data-id="10">Ten</li>
												</ul>
											</div>
											<div class="dual-listbox__buttons"><button class="dual-listbox__button">Add All</button><button class="dual-listbox__button">Add</button><button class="dual-listbox__button">Remove</button><button class="dual-listbox__button">Remove All</button></div>
											<div>
												<div class="dual-listbox__title">Selected options</div>
												<ul class="dual-listbox__selected">
													<li class="dual-listbox__item" data-id="2">Two</li>
													<li class="dual-listbox__item" data-id="6">Six</li>
												</ul>
											</div>
										</div>
									</div><select id="dual-listbox-3" class="dual-listbox" multiple="" style="display: none;"></select>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card card--height-fluid">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Dual Listbox without Search
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="dual-listbox dual-listbox-4"><input class="dual-listbox__search dual-listbox__search--hidden" placeholder="Search">
										<div class="dual-listbox__container">
											<div>
												<div class="dual-listbox__title">Available options</div>
												<ul class="dual-listbox__available">
													<li class="dual-listbox__item" data-id="1">One</li>
													<li class="dual-listbox__item" data-id="2">Two</li>
													<li class="dual-listbox__item" data-id="3">Three</li>
													<li class="dual-listbox__item" data-id="4">Four</li>
													<li class="dual-listbox__item" data-id="5">Five</li>
													<li class="dual-listbox__item" data-id="6">Six</li>
													<li class="dual-listbox__item" data-id="7">Seven</li>
													<li class="dual-listbox__item" data-id="8">Eight</li>
													<li class="dual-listbox__item" data-id="9">Nine</li>
													<li class="dual-listbox__item" data-id="10">Ten</li>
												</ul>
											</div>
											<div class="dual-listbox__buttons"><button class="dual-listbox__button">Add All</button><button class="dual-listbox__button">Add</button><button class="dual-listbox__button">Remove</button><button class="dual-listbox__button">Remove All</button></div>
											<div>
												<div class="dual-listbox__title">Selected options</div>
												<ul class="dual-listbox__selected"></ul>
											</div>
										</div>
									</div><select id="dual-listbox-4" class="dual-listbox" data-search="false" multiple="" style="display: none;"></select>
								</div>
							</div>
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