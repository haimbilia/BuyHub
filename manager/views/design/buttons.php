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
	
	<link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
	
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
				<div class="subheader grid__item" id="subheader">
					<div class="container">
						<div class="subheader__main">
							<h3 class="subheader__title">Buttons</h3>

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
									Buttons </a>
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
									FB-admin extends <code>Bootstrap Button</code> component with a variety of options to provide uniquely looking Button component that matches the FB-admin's design standards.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/components/buttons/" target="_blank">Documentation</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::Row-->
					<div class="row">
						<div class="col-xl-6">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Basic Buttons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Bootstrap buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary">Primary</button>
											<button type="button" class="btn btn-secondary btn-hover-brand">Secondary</button>
											<button type="button" class="btn btn-success">Success</button>
											<button type="button" class="btn btn-info">Info</button>
											<button type="button" class="btn btn-warning">Warning</button>
											<button type="button" class="btn btn-danger">Danger</button>
											<button type="button" class="btn btn-link">Link</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">The <code>.btn</code> classes are designed to be used with <code>&lt;button&gt;</code>, <code>&lt;a&gt;</code> and <code>&lt;input&gt;</code> elements.</div>
										<div class="section__content section__content--solid">
											<a class="btn btn-primary" href="#" role="button">Link</a>
											<button class="btn btn-success" type="submit">Button</button>
											<input class="btn btn-warning" type="button" value="Input">
											<input class="btn btn-info" type="submit" value="Submit">
											<input class="btn btn-danger" type="reset" value="Reset">
											<a href="#" class="btn btn-dark">Dark</a>
											<button type="button" class="btn btn-brand">Brand</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Button states:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-brand active">Active</button>
											<button type="button" class="btn btn-dark active">Active</button>
											<button type="button" class="btn btn-outline-danger active">Active</button>
											<button type="button" class="btn btn-primary disabled" disabled="">Disabled</button>
											<button type="button" class="btn btn-success disabled" disabled="">Disabled</button>
											<button type="button" class="btn btn-outline-success disabled" disabled="">Disabled</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">FB-admin custom buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-brand">Brand</button>
											<button type="button" class="btn btn-dark">Dark</button>
											<button type="button" class="btn btn-light btn-elevate">Light</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">FB-admin base buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-default btn-bold btn-upper">Button</button>
											<button type="button" class="btn btn-clean btn-bold btn-upper">Button</button>
											<button type="button" class="btn btn-sm btn-default btn-bold btn-upper">Button</button>
											<button type="button" class="btn btn-sm btn-clean btn-bold btn-upper">Button</button>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Button Customization
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Large buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-lg">Primary</button>
											<button type="button" class="btn btn-secondary btn-lg">Secondary</button>
											<button type="button" class="btn btn-success btn-lg">Success</button>
											<br>
											<br>
											<button type="button" class="btn btn-info btn-lg">Info</button>
											<button type="button" class="btn btn-warning btn-lg">Warning</button>
											<button type="button" class="btn btn-danger btn-lg">Danger</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Small buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-sm">Primary</button>
											<button type="button" class="btn btn-secondary btn-sm">Secondary</button>
											<button type="button" class="btn btn-success btn-sm">Success</button>
											<button type="button" class="btn btn-info btn-sm">Info</button>
											<button type="button" class="btn btn-warning btn-sm">Warning</button>
											<button type="button" class="btn btn-danger btn-sm">Danger</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Font settings:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-info btn-font-lg">Large font</button>
											<button type="button" class="btn btn-success btn-font-sm">Small font</button>
											<button type="button" class="btn btn-primary btn-upper">Uppercase</button>
											<button type="button" class="btn btn-secondary btn-upper">Lowercase</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Wide buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-wide">Wide button</button>
											<button type="button" class="btn btn-secondary btn-wide">Wider button</button>
											<button type="button" class="btn btn-success btn-wide">Wides button</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Tall buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-tall">Tall button</button>
											<button type="button" class="btn btn-secondary btn-taller">Taller button</button>
											<button type="button" class="btn btn-success btn-tallest">Tallest button</button>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Outline Buttons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default outline buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-outline-primary">Primary</button>
											<button type="button" class="btn btn-outline-secondary">Secondary</button>
											<button type="button" class="btn btn-outline-success">Success</button>
											<button type="button" class="btn btn-outline-info">Info</button>
											<button type="button" class="btn btn-outline-warning">Warning</button>
											<button type="button" class="btn btn-outline-danger">Danger</button>
											<button type="button" class="btn btn-outline-dark">Dark</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Hover outline buttons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-outline-hover-primary">Primary</button>
											<button type="button" class="btn btn-outline-hover-brand">Brand</button>
											<button type="button" class="btn btn-outline-hover-success">Success</button>
											<button type="button" class="btn btn-outline-hover-info">Info</button>
											<button type="button" class="btn btn-outline-hover-warning">Warning</button>
											<button type="button" class="btn btn-outline-hover-danger">Danger</button>
											<button type="button" class="btn btn-outline-hover-dark">Dark</button>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Elevated Buttons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default effect:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate">Light</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate">Danger</button>&nbsp;
											<button type="button" class="btn btn-dark btn-elevate">Dark</button>&nbsp;

											<div class="separator separator--space-sm  separator--border-dashed"></div>

											<button type="button" class="btn btn-light btn-elevate btn-pill">Light</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-pill">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate btn-pill">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate btn-pill">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-pill">Danger</button>&nbsp;
											<button type="button" class="btn btn-dark btn-elevate btn-pill">Dark</button>&nbsp;

											<div class="separator separator--space-sm  separator--border-dashed"></div>

											<button type="button" class="btn btn-light btn-elevate btn-pill btn-sm">Light</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-pill btn-sm">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate btn-pill btn-sm">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate btn-pill btn-sm">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-pill btn-sm">Danger</button>&nbsp;
											<button type="button" class="btn btn-dark btn-elevate btn-pill btn-sm">Dark</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Hover elevate effect:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-brand btn-elevate btn-elevate-air">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate btn-elevate-air">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate btn-elevate-air">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-elevate-air">Danger</button>&nbsp;
											<button type="button" class="btn btn-warning btn-elevate btn-elevate-air">Warning</button>&nbsp;

											<div class="separator separator--space-sm  separator--border-dashed"></div>

											<button type="button" class="btn btn-brand btn-elevate btn-pill btn-elevate-air">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate btn-pill btn-elevate-air">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate btn-pill btn-elevate-air">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Danger</button>&nbsp;
											<button type="button" class="btn btn-warning btn-elevate btn-pill btn-elevate-air">Warning</button>&nbsp;

											<div class="separator separator--space-sm  separator--border-dashed"></div>

											<button type="button" class="btn btn-brand btn-elevate btn-pill btn-elevate-air btn-sm">Brand</button>&nbsp;
											<button type="button" class="btn btn-success btn-elevate btn-pill btn-elevate-air btn-sm">Success</button>&nbsp;
											<button type="button" class="btn btn-info btn-elevate btn-pill btn-elevate-air btn-sm">Info</button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm">Danger</button>&nbsp;
											<button type="button" class="btn btn-warning btn-elevate btn-pill btn-elevate-air btn-sm">Warning</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>
								</div>
							</div>
							<!--end::card-->


							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Pill Buttons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-pill">Primary</button>&nbsp;
											<button type="button" class="btn btn-brand btn-pill">Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-pill">Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-pill">Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger btn-pill">Hover Outline</button>&nbsp;
											<button type="button" class="btn btn-light btn-hover-brand btn-pill">Hover Solid</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Elevation options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-pill">Hover Flat</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-pill">Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-pill">Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-pill">Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-pill">Hover Outline</button>&nbsp;
											<button type="button" class="btn btn-light btn-elevate btn-pill">Raise Elevation</button>
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
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Square Buttons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-square">Primary</button>&nbsp;
											<button type="button" class="btn btn-brand btn-square">Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-square">Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-square">Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger btn-square">Hover Outline</button>&nbsp;
											<button type="button" class="btn btn-light btn-hover-brand btn-square">Hover Solid</button>
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Elevation options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-square">Hover Flat</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-square">Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-square">Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-square">Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-square">Hover Outline</button>&nbsp;
											<button type="button" class="btn btn-light btn-elevate btn-square">Raise Elevation</button>
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											With Icons
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default options with Fontawesome 5 icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary"><i class="fa fa-dollar-sign"></i> Primary</button>&nbsp;
											<button type="button" class="btn btn-brand"><i class="fa fa-tag"></i> Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary"><i class="fa fa-undo"></i> Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand"><i class="fa fa-code"></i> Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger"><i class="fa fa-search"></i> Hover Outline</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Elevation options with Lineawesome icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-pill"><i class="la la-user"></i> Hover Flat</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-pill"><i class="la la-bank"></i> Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-pill"><i class="la la-bullhorn"></i> Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-pill"><i class="la la-cloud-download"></i> Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-pill"><i class="la la-copy"></i> Hover Outline</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Pill options with Flaticon icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-pill"><i class="flaticon-cogwheel"></i> Hover Flat</button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-pill"><i class="flaticon-business"></i> Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-pill"><i class="flaticon-notes"></i> Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-pill"><i class="flaticon-bell"></i> Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-pill"><i class="flaticon-light"></i> Hover Outline</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Size options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-dollar-sign"></i> Primary</button>&nbsp;
											<button type="button" class="btn btn-brand"><i class="fa fa-tag"></i> Solid</button>&nbsp;
											<button type="button" class="btn btn-secondary  btn-lg"><i class="fa fa-undo"></i> Secondary</button>&nbsp;
											<button type="button" class="btn btn-outline-brand"><i class="fa fa-code"></i> Outline</button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger btn-sm"><i class="fa fa-search"></i> Hover Outline</button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Social network solid buttons:</div>
										<div class="section__content section__content--solid">
											<a href="#" class="btn btn-facebook"><i class="socicon-facebook"></i> Facebook</a>&nbsp;
											<a href="#" class="btn btn-twitter"><i class="socicon-twitter"></i> Twitter</a>&nbsp;
											<a href="#" class="btn btn-google"><i class="socicon-google"></i> Google</a>&nbsp;
											<a href="#" class="btn btn-instagram"><i class="socicon-instagram"></i> Instagram</a>&nbsp;
											<a href="#" class="btn btn-linkedin"><i class="socicon-linkedin"></i> Linkedin</a>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Social network label buttons:</div>
										<div class="section__content section__content--solid">
											<a href="#" class="btn btn-label-facebook"><i class="socicon-facebook"></i> Facebook</a>&nbsp;
											<a href="#" class="btn btn-label-twitter"><i class="socicon-twitter"></i> Twitter</a>&nbsp;
											<a href="#" class="btn btn-label-google"><i class="socicon-google"></i> Google</a>&nbsp;
											<a href="#" class="btn btn-label-instagram"><i class="socicon-instagram"></i> Instagram</a>&nbsp;
											<a href="#" class="btn btn-label-linkedin"><i class="socicon-linkedin"></i> Linkedin</a>&nbsp;
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Icon Only
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">Default options with Fontawesome 5 icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-icon"><i class="fa fa-dollar-sign"></i></button>&nbsp;
											<button type="button" class="btn btn-brand btn-icon"><i class="fa fa-tag"></i></button>&nbsp;
											<button type="button" class="btn btn-secondary btn-icon"><i class="fa fa-undo"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-icon"><i class="fa fa-code"></i></button>&nbsp;
											<button type="button" class="btn btn-dark btn-icon"><i class="fa fa-check"></i></button>&nbsp;
											<button type="button" class="btn btn-danger btn-icon"><i class="fa fa-car"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger btn-icon"><i class="fa fa-search"></i></button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Elevation options with Lineawesome icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-icon"><i class="la la-user"></i></button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-icon"><i class="la la-bank"></i></button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-icon"><i class="la la-bullhorn"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-icon"><i class="la la-cloud-download"></i></button>&nbsp;
											<button type="button" class="btn btn-primary btn-elevate btn-icon"><i class="la la-cogs"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-dark btn-elevate btn-icon"><i class="la la-calendar"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-icon"><i class="la la-copy"></i></button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Circle options with Flaticon icons:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-light btn-elevate-hover btn-circle btn-icon"><i class="flaticon-cogwheel"></i></button>&nbsp;
											<button type="button" class="btn btn-brand btn-elevate btn-circle btn-icon"><i class="flaticon-business"></i></button>&nbsp;
											<button type="button" class="btn btn-secondary btn-elevate btn-circle btn-icon"><i class="flaticon-notes"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button>&nbsp;
											<button type="button" class="btn btn-warning btn-elevate btn-circle btn-icon"><i class="flaticon-technology-2"></i></button>&nbsp;
											<button type="button" class="btn btn-danger btn-elevate btn-circle btn-icon"><i class="flaticon-technology-1"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-info btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-hover-info btn-elevate btn-circle btn-icon"><i class="flaticon-light"></i></button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Size options:</div>
										<div class="section__content section__content--solid">
											<button type="button" class="btn btn-primary btn-sm btn-icon"><i class="fa fa-dollar-sign"></i></button>&nbsp;
											<button type="button" class="btn btn-primary btn-sm btn-icon btn-circle"><i class="fa fa-dollar-sign"></i></button>&nbsp;

											<button type="button" class="btn btn-brand btn-icon"><i class="fa fa-tag"></i></button>&nbsp;
											<button type="button" class="btn btn-info btn-icon btn-circle"><i class="fa fa-tags"></i></button>&nbsp;

											<button type="button" class="btn btn-secondary  btn-lg btn-icon "><i class="fa fa-undo"></i></button>&nbsp;
											<button type="button" class="btn btn-secondary  btn-lg btn-icon btn-circle"><i class="fa fa-check"></i></button>&nbsp;

											<button type="button" class="btn btn-outline-brand btn-icon"><i class="fa fa-code"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-brand btn-icon btn-circle"><i class="fa fa-user"></i></button>&nbsp;

											<button type="button" class="btn btn-outline-hover-danger btn-sm btn-icon"><i class="fa fa-search"></i></button>&nbsp;
											<button type="button" class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle"><i class="fa fa-calendar"></i></button>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Social network icon buttons:</div>
										<div class="section__content section__content--solid">
											<a href="#" class="btn btn-facebook btn-icon"><i class="socicon-facebook"></i></a>&nbsp;
											<a href="#" class="btn btn-twitter  btn-icon"><i class="socicon-twitter"></i></a>&nbsp;
											<a href="#" class="btn btn-google btn-icon"><i class="socicon-google"></i></a>&nbsp;
											<a href="#" class="btn btn-instagram btn-icon"><i class="socicon-instagram"></i></a>&nbsp;
											<a href="#" class="btn btn-linkedin btn-icon"><i class="socicon-linkedin"></i></a>&nbsp;
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hidden">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Label Style
										</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="section">
										<div class="section__info">You can use the buttons styles for labels with <code>span</code> tag:</div>
										<div class="section__content section__content--solid">
											<span class="btn btn-label-primary">Primary</span>&nbsp;
											<span class="btn btn-label-success">Success</span>&nbsp;
											<span class="btn btn-label-info">Info</span>&nbsp;
											<span class="btn btn-label-danger">Danger</span>&nbsp;
											<span class="btn btn-label-warning">Warning</span>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Label pill style:</div>
										<div class="section__content section__content--solid">
											<span class="btn btn-label-primary btn-pill">Primary</span>&nbsp;
											<span class="btn btn-label-success btn-pill">Success</span>&nbsp;
											<span class="btn btn-label-info btn-pill">Info</span>&nbsp;
											<span class="btn btn-label-danger btn-pill">Danger</span>&nbsp;
											<span class="btn btn-label-warning btn-pill">Warning</span>&nbsp;
										</div>
									</div>

									<div class="separator separator--space-sm  separator--border-dashed"></div>

									<div class="section">
										<div class="section__info">Link labels:</div>
										<div class="section__content section__content--solid">
											<a href="#" class="btn btn-label-primary btn-pill">Primary</a>&nbsp;
											<a href="#" class="btn btn-label-success btn-pill">Success</a>&nbsp;
											<a href="#" class="btn btn-label-info btn-pill">Info</a>&nbsp;
											<a href="#" class="btn btn-label-danger btn-pill">Danger</a>&nbsp;
											<a href="#" class="btn btn-label-warning btn-pill">Warning</a>&nbsp;
										</div>
									</div>
								</div>
							</div>
							<!--end::card-->
						</div>
					</div>
					<!--end::Row-->
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