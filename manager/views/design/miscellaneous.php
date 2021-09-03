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

								Miscellaneous </h3>

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
									Miscellaneous </a>
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
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Basic User Pics
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<!--begin::Section-->
										<div class="section__info">Default user pics:</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_19.jpg" alt="image">
											</span>
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_13.jpg" alt="image">
											</span>
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
											</span>
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_6.jpg" alt="image">
											</span>
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg" alt="image">
											</span>
											<span class="media margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
											</span>
											<span class="media margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
											</span>
										</div>
										<!--end::Section-->

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<!--begin::Section-->
										<div class="section__info">Alternative user pics:</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<span class="media media--danger margin-r-5 margin-t-5">
												<span>JD</span>
											</span>
											<span class="media media--info margin-r-5 margin-t-5">
												<span>SA</span>
											</span>
											<span class="media media--success margin-r-5 margin-t-5">
												<span>ER</span>
											</span>
											<span class="media media--warning margin-r-5 margin-t-5">
												<span>BD</span>
											</span>
											<span class="media media--danger margin-r-5 margin-t-5">
												<span>CD</span>
											</span>
											<span class="media media--brand margin-r-5 margin-t-5">
												<span>NG</span>
											</span>
											<span class="media media--success margin-r-5 margin-t-5">
												<span>MR</span>
											</span>
										</div>
										<!--end::Section-->

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<!--begin::Section-->
										<div class="section__info">Circle user pics:</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<span class="media media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_12.jpg" alt="image">
											</span>
											<span class="media media--circle media--danger margin-r-5 margin-t-5">
												<span>TR</span>
											</span>
											<span class="media media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_8.jpg" alt="image">
											</span>
											<span class="media media--circle media--warning margin-r-5 margin-t-5">
												<span>LP</span>
											</span>
											<span class="media media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
											</span>
											<span class="media media--circle media--success margin-r-5 margin-t-5">
												<span>BY</span>
											</span>
											<span class="media media--circle margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_13.jpg" alt="image">
											</span>
										</div>
										<!--end::Section-->

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">linkable user pics:</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<a href="#" class="media margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
											</a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg" alt="image">
											</a>
											<a href="#" class="media margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
											</a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_8.jpg" alt="image">
											</a>
											<a href="#" class="media margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg" alt="image">
											</a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_24.jpg" alt="image">
											</a>
											<a href="#" class="media margin-t-5" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click here for more info">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_20.jpg" alt="image">
											</a>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<!--begin::Section-->
										<div class="section__info">Background user pics:</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<a href="#" class="media margin-r-5 margin-t-5" style="min-height: 50px;width: 50px;  background-image: url(./assets/media/blog/blog5.jpg)"></a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" style="min-height: 50px;width: 50px;  background-image: url(./assets/media/blog/blog4.jpg)"></a>
											<a href="#" class="media margin-r-5 margin-t-5" style="min-height: 50px;width: 50px; background-image: url(./assets/media//products/product4.jpg)"></a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" style="min-height: 50px;width: 50px; background-image: url(./assets/media/blog/blog3.jpg)"></a>
											<a href="#" class="media margin-r-5 margin-t-5" style="min-height: 50px;width: 50px; background-image: url(./assets/media/blog/blog2.jpg)"> </a>
											<a href="#" class="media media--circle margin-r-5 margin-t-5" style="min-height: 50px;width: 50px;  background-image: url(./assets/media//products/product6.jpg)"></a>
											<a href="#" class="media margin-t-5" style="min-height: 50px;width: 50px; background-image: url(./assets/media/blog/blog1.jpg)"></a>
										</div>
										<!--end::Section-->

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<!--begin::Section-->
										<div class="section__info">Sizing options(sm, lg, xl):</div>
										<div class="section__content d-flex flex-wrap section__content--solid--">
											<span class="media media--sm margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_16.jpg" alt="image">
											</span>
											<span class="media media--sm media--success media--circle margin-r-5 margin-t-5">
												<span>MS</span>
											</span>
											<span class="media media--sm margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_9.jpg" alt="image">
											</span>
											<span class="media media--sm media--circle media--danger margin-r-5 margin-t-5">
												<span>AC</span>
											</span>
											<span class="media media--sm margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_17.jpg" alt="image">
											</span>
											<span class="media media--sm media--circle media--warning margin-r-5 margin-t-5">
												<span>KL</span>
											</span>
											<span class="media media--sm margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg" alt="image">
											</span>
											<span class="media media--sm media--circle media--brand margin-r-5 margin-t-5">
												<span>FR</span>
											</span>
											<span class="media media--sm  margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_19.jpg" alt="image">
											</span>
										</div>
										<!--end::Section-->

										<!--begin::Section-->
										<div class="section__content d-flex flex-wrap margin-t-30 section__content--solid--">
											<span class="media media--lg media--brand margin-r-5 margin-t-5">
												<span>BT</span>
											</span>
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_12.jpg" alt="image">
											</span>
											<span class="media media--lg  media--danger margin-r-5 margin-t-5">
												<span>PY</span>
											</span>
											<span class="media media--lg media--circle  margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_8.jpg" alt="image">
											</span>
											<span class="media media--lg media--warning margin-r-5 margin-t-5">
												<span>JU</span>
											</span>
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
											</span>
											<span class="media media--lg  media--success margin-r-5 margin-t-5">
												<span>GF</span>
											</span>
											<span class="media media--lg media--circle margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_13.jpg" alt="image">
											</span>
										</div>
										<!--end::Section-->

										<!--begin::Section-->
										<div class="section__content d-flex flex-wrap margin-t-30 section__content--solid--">
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/1.png" alt="image">
											</span>
											<span class="media media--lg margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/2.png" alt="image">
											</span>
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/3.png" alt="image">
											</span>
											<span class="media media--lg margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/4.png" alt="image">
											</span>
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/5.png" alt="image">
											</span>
											<span class="media media--lg margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/6.png" alt="image">
											</span>
											<span class="media media--lg media--circle margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/project-logos/7.png" alt="image">
											</span>
										</div>
										<!--end::Section-->

										<!--begin::Section-->
										<div class="section__content d-flex flex-wrap margin-t-30 section__content--solid--">
											<span class="media media--xl media--circle media--danger margin-r-5 margin-t-5">
												<span>BT</span>
											</span>
											<span class="media media--xl  margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_19.jpg" alt="image">
											</span>
											<span class="media media--xl media--circle media--warning margin-r-5 margin-t-5">
												<span>PY</span>
											</span>
											<span class="media media--xl margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_9.jpg" alt="image">
											</span>
											<span class="media media--xl media--circle media--brand margin-r-5 margin-t-5">
												<span>JU</span>
											</span>
											<span class="media media--xl margin-r-5 margin-t-5">
												<img src="<?php echo CONF_WEBROOT_URL;?>images/users/300_10.jpg" alt="image">
											</span>
											<span class="media media--xl media--circle media--success margin-r-5 margin-t-5">
												<span>GF</span>
											</span>
										</div>
										<!--end::Section-->
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
											Basic searchbar
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default searchbars:</div>
										<div class="section__content section__content--solid--">
											<div class="searchbar">
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg></span></div>
													<input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon1">
												</div>
											</div>
										</div>

										<div class="section__content margin-t-30 section__content--solid--">
											<div class="searchbar">
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="flaticon-search"></i></span></div>
													<input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon1">
												</div>
											</div>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Searchbar right icon:</div>
										<div class="searchbar">
											<div class="input-icon input-icon--right">
												<input type="text" class="form-control" placeholder="Search" id="generalSearch">
												<span class="input-icon__icon input-icon__icon--right">
													<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"></rect>
																<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
														</svg></span>
												</span>
											</div>
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">Sizing options(sm, lg):</div>
										<div class="section__content section__content--solid--">
											<div class="searchbar">
												<div class="input-group input-group-sm">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg></span></div>
													<input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon1">
												</div>
											</div>
										</div>

										<div class="section__content margin-t-30  section__content--solid--">
											<div class="searchbar">
												<div class="input-group input-group-lg">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg></span></div>
													<input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon1">
												</div>
											</div>
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