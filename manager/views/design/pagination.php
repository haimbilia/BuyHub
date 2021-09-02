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

								Pagination </h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Custom </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Pagination </a>
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
					<!--begin: Pagination -->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Pagination Examples
								</h3>
							</div>
						</div>
						<div class="card-body">
							<div class="tab-content">

								<!--begin: Section-->
								<div class="section">
									<p class="section__desc">Basic pagination example:</p>
									<p class="section__content">
										<!--begin: Pagination-->
									</p>
									<div class="pagination  pagination--brand">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-brand"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-brand"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li>
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">32</a>
											</li>
											<li>
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-brand"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-brand"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-brand" style="width: 60px;">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->
									<p></p>
								</div>
								<!--end: Section-->

								<div class="separator separator--space-lg separator--border-dashed"></div>

								<!--begin: Section-->
								<div class="section">
									<p class="section__desc">Pagination sizing options:</p>
									<p class="section__content">
										<!--begin: Pagination(sm)-->
									</p>
									<div class="pagination pagination--sm pagination--danger">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-danger"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-danger"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li>
												<a href="#">32</a>
											</li>
											<li>
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-danger"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-danger"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-danger" style="width: 60px;">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->

									<div class="separator separator--space-md separator--border-dashed"></div>

									<!--begin: Pagination(lg)-->
									<div class="pagination pagination--lg pagination--success">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-success"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-success"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li>
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li>
												<a href="#">32</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-success"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-success"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-success" style="width: 60px;">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->
									<p></p>
								</div>
								<!--end: Section-->

								<div class="separator separator--space-lg separator--border-dashed"></div>

								<!--begin: Section-->
								<div class="section">
									<p class="section__desc">Circle link style pagination example:</p>
									<p class="section__content">
										<!--begin: Pagination-->
									</p>
									<div class="pagination pagination--brand pagination--circle">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-brand"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-brand"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li>
												<a href="#">30</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">31</a>
											</li>
											<li>
												<a href="#">32</a>
											</li>
											<li>
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-brand"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-brand"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-brand" style="width: 60px">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->
									<p></p>
								</div>
								<!--end: Section-->

								<div class="separator  separator--border-dashed"></div>

								<!--begin: Section-->
								<div class="section">
									<p class="section__desc">Pagination state colors:</p>
									<p class="section__content">
										<!--begin: Pagination-->
									</p>
									<div class="pagination  pagination--danger">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-danger"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-danger"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li>
												<a href="#">32</a>
											</li>
											<li>
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-danger"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-danger"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-danger" style="width: 60px">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->

									<div class="separator  separator--border-dashed"></div>

									<!--begin: Pagination-->
									<div class="pagination  pagination--warning pagination--circle">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-warning"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-warning"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li>
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li>
												<a href="#">32</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-warning"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-warning"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-warning" style="width: 60px">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->

									<div class="separator separator--space-md separator--border-dashed"></div>

									<!--begin: Pagination-->
									<div class="pagination  pagination--info">
										<ul class="pagination__links">
											<li class="pagination__link--first">
												<a href="#"><i class="fa fa-angle-double-left font-info"></i></a>
											</li>
											<li class="pagination__link--next">
												<a href="#"><i class="fa fa-angle-left font-info"></i></a>
											</li>

											<li>
												<a href="#">...</a>
											</li>
											<li>
												<a href="#">29</a>
											</li>
											<li>
												<a href="#">30</a>
											</li>
											<li>
												<a href="#">31</a>
											</li>
											<li class="pagination__link--active">
												<a href="#">32</a>
											</li>
											<li>
												<a href="#">33</a>
											</li>
											<li>
												<a href="#">34</a>
											</li>
											<li>
												<a href="#">...</a>
											</li>

											<li class="pagination__link--prev">
												<a href="#"><i class="fa fa-angle-right font-info"></i></a>
											</li>
											<li class="pagination__link--last">
												<a href="#"><i class="fa fa-angle-double-right font-info"></i></a>
											</li>
										</ul>

										<div class="pagination__toolbar">
											<select class="form-control font-info" style="width: 60px">
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<span class="pagination__desc">
												Displaying 10 of 230 records
											</span>
										</div>
									</div>
									<!--end: Pagination-->
									<p></p>
								</div>
								<!--end: Section-->
							</div>
						</div>
					</div>
					<!--end: Pagination -->
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