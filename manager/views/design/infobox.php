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

								Infobox </h3>

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
									Infobox </a>
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
					<div class="card">
						<div class="card-body">
							<div class="infobox">
								<div class="infobox__header">
									<h2 class="infobox__title">AirPlus SAAS License</h2>
								</div>
								<div class="infobox__body">
									<div class="infobox__section">
										<h3 class="infobox__subtitle">Basic License</h3>
										<div class="infobox__content">
											Windows 10 automatically downloads and installs updates to make sure your device is secure and up to date. This means you receive the latest fixes and security updates, helping your device run efficiently and stay protected. In most cases, restarting your device completes the update. Make sure your device is plugged in when you know updates will be installed. <a href="#" class="link">Read More</a>
										</div>
									</div>
									<div class="infobox__section">
										<h3 class="infobox__subtitle">Extended License</h3>
										<div class="infobox__content">
											Windows 10 automatically downloads and installs updates to make sure your device is secure and up to date. This means you receive the latest fixes and security updates, helping your device run efficiently and stay protected. In most cases, restarting your device completes the update. Make sure your device is plugged in when you know updates will be installed. <a href="#" class="link">Read More</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-body">
									<div class="infobox">
										<div class="infobox__header">
											<h2 class="infobox__title">AirPlus SAAS License</h2>
											<div class="infobox__badge">Blog</div>
										</div>
										<div class="infobox__body">
											<div class="infobox__section">
												<div class="infobox__content">
													Windows 10 automatically downloads and installs updates to make sure your device is secure and up to date. This means you receive the latest fixes and security updates, helping your device run efficiently and stay protected. In most cases, restarting your device completes the update. Make sure your device is plugged in when you know updates will be installed. <br>
													<br>
													<a href="#" class="link">Read More</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card">
								<div class="card-body">
									<div class="infobox infobox--success">
										<div class="infobox__header">
											<h2 class="infobox__title">AirPlus SAAS License</h2>
											<div class="infobox__badge">Blog</div>
										</div>
										<div class="infobox__body">
											<div class="infobox__section">
												<div class="infobox__content">
													Windows 10 automatically downloads and installs updates to make sure your device is secure and up to date. This means you receive the latest fixes and security updates, helping your device run efficiently and stay protected. In most cases, restarting your device completes the update. Make sure your device is plugged in when you know updates will be installed. <br>
													<br>
													<a href="#" class="link">Read More</a>
												</div>
											</div>
										</div>
									</div>
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