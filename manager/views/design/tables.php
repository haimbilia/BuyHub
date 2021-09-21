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
	<style>
		.site-map-nav a {
			padding: 0.5rem 1rem;
			display: flex;
			font-weight: 400;
			align-items: center;
		}
	</style>
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

								Tables </h3>

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
									Tables </a>
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
									FATbit extends <code>Bootstrap Table</code> component with a variety of options to provide uniquely looking Table component that matches the FATbit's design standards.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/content/tables/" target="_blank">Documentation</a>.
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic Tables
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Using the most basic table markup, here’s how tables look in FATbit:
										</span>
										<div class="section__content">
											<table class="table">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											You can also invert the colors—with light text on dark backgrounds—with <code>.table-dark</code>.
										</span>
										<div class="section__content">
											<table class="table table-dark">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Table Head Options
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Similar to default and inverse tables, use one of two modifier classes to make &lt;thead&gt;s appear light or dark gray.
										</span>
										<div class="section__content">
											<table class="table">
												<thead class="thead-light">
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<table class="table">
												<thead class="thead-dark">
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Small Table
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Add <code>.table-sm</code> to make tables more compact by cutting cell padding in half.
										</span>
										<div class="section__content">
											<table class="table table-sm table-head-bg-brand">
												<thead class="thead-inverse">
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Striped Rows
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
							</div>
							<!--end::card-->
						</div>
						<div class="col-xl-6">


							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Bordered Table
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Hoverable Table
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Table Row States
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__content">
											<table class="table">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr class="table-active">
														<th scope="row">1</th>
														<td>Jhon</td>
														<td>Stone</td>
														<td>@jhon</td>
													</tr>
													<tr class="table-primary">
														<th scope="row">2</th>
														<td>Lisa</td>
														<td>Nilson</td>
														<td>@lisa</td>
													</tr>
													<tr class="table-success">
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
													<tr class="table-brand">
														<th scope="row">4</th>
														<td>Nick</td>
														<td>looper</td>
														<td>@king</td>
													</tr>
													<tr class="table-warning">
														<th scope="row">5</th>
														<td>Joan</td>
														<td>thestar</td>
														<td>@joan</td>
													</tr>
													<tr class="table-danger">
														<th scope="row">6</th>
														<td>Sean</td>
														<td>coder</td>
														<td>@coder</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Responsive tables
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__info">
											Create responsive tables by wrapping any table with <code>.table-responsive</code> <code>DIV</code> to make them scroll horizontally on small devices (under 768px)
										</div>
										<div class="section__content">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>#</th>
															<th>Table heading</th>
															<th>Table heading</th>
															<th>Table heading</th>
															<th>Table heading</th>
															<th>Table heading</th>
															<th>Table heading</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">1</th>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
														</tr>
														<tr>
															<th scope="row">2</th>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
														</tr>
														<tr>
															<th scope="row">3</th>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
															<td>Table cell</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!--end::Section-->
								</div>
								<!--end::Form-->
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