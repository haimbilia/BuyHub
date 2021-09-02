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
							<h3 class="subheader__title">List View</h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Calendar </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									List Views </a>
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
						<div class="col-lg-12">
							<!--begin::card-->
							<div class="card" id="card">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon">
											<i class="flaticon-calendar"></i>
										</span>
										<h3 class="card-head-title">
											List View
										</h3>
									</div>
									<div class="card-head-toolbar">
										<a href="#" class="btn btn-brand btn-elevate">
											<i class="la la-plus"></i>
											Add Event
										</a>
									</div>
								</div>
								<div class="card-body">
									<div id="calendar" class="fc fc-ltr fc-unthemed" style="">
										<div class="fc-toolbar fc-header-toolbar">
											<div class="fc-left">
												<div class="fc-button-group"><button type="button" class="fc-prev-button fc-button fc-button-primary" aria-label="prev"><span class="fc-icon fc-icon-chevron-left"></span></button><button type="button" class="fc-next-button fc-button fc-button-primary" aria-label="next"><span class="fc-icon fc-icon-chevron-right"></span></button></div><button type="button" class="fc-today-button fc-button fc-button-primary" disabled="">today</button>
											</div>
											<div class="fc-center">
												<h2>Aug 11 – 17, 2019</h2>
											</div>
											<div class="fc-right">
												<div class="fc-button-group"><button type="button" class="fc-dayGridMonth-button fc-button fc-button-primary">month</button><button type="button" class="fc-timeGridWeek-button fc-button fc-button-primary">week</button><button type="button" class="fc-timeGridDay-button fc-button fc-button-primary">day</button><button type="button" class="fc-listWeek-button fc-button fc-button-primary fc-button-active">list</button></div>
											</div>
										</div>
										<div class="fc-view-container">
											<div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
												<div class="fc-scroller" style="overflow: hidden auto; height: 748px;">
													<table class="fc-list-table ">
														<tbody>
															<tr class="fc-list-heading" data-date="2019-08-11">
																<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main" data-goto="{&quot;date&quot;:&quot;2019-08-11&quot;,&quot;type&quot;:&quot;day&quot;}">Sunday</a><a class="fc-list-heading-alt" data-goto="{&quot;date&quot;:&quot;2019-08-11&quot;,&quot;type&quot;:&quot;day&quot;}">August 11, 2019</a></td>
															</tr>
															<tr class="fc-list-item fc-event-brand">
																<td class="fc-list-item-time fc-widget-content">all-day</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Conference</a>
																	<div class="fc-description">Lorem ipsum dolor eius mod tempor labore</div>
																</td>
															</tr>
															<tr class="fc-list-heading" data-date="2019-08-12">
																<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main" data-goto="{&quot;date&quot;:&quot;2019-08-12&quot;,&quot;type&quot;:&quot;day&quot;}">Monday</a><a class="fc-list-heading-alt" data-goto="{&quot;date&quot;:&quot;2019-08-12&quot;,&quot;type&quot;:&quot;day&quot;}">August 12, 2019</a></td>
															</tr>
															<tr class="fc-list-item fc-event-brand">
																<td class="fc-list-item-time fc-widget-content">all-day</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Conference</a>
																	<div class="fc-description">Lorem ipsum dolor eius mod tempor labore</div>
																</td>
															</tr>
															<tr class="fc-list-item">
																<td class="fc-list-item-time fc-widget-content">all-day</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Dinner</a>
																	<div class="fc-description">Lorem ipsum dolor sit amet, conse ctetur</div>
																</td>
															</tr>
															<tr class="fc-list-item">
																<td class="fc-list-item-time fc-widget-content">10:30am - 12:30pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Meeting</a>
																	<div class="fc-description">Lorem ipsum dolor eiu idunt ut labore</div>
																</td>
															</tr>
															<tr class="fc-list-item fc-event-info">
																<td class="fc-list-item-time fc-widget-content">12:00pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Lunch</a>
																	<div class="fc-description">Lorem ipsum dolor sit amet, ut labore</div>
																</td>
															</tr>
															<tr class="fc-list-item fc-event-warning">
																<td class="fc-list-item-time fc-widget-content">2:30pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Meeting</a>
																	<div class="fc-description">Lorem ipsum conse ctetur adipi scing</div>
																</td>
															</tr>
															<tr class="fc-list-item fc-event-info">
																<td class="fc-list-item-time fc-widget-content">5:30pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Happy Hour</a>
																	<div class="fc-description">Lorem ipsum dolor sit amet, conse ctetur</div>
																</td>
															</tr>
															<tr class="fc-list-heading" data-date="2019-08-13">
																<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main" data-goto="{&quot;date&quot;:&quot;2019-08-13&quot;,&quot;type&quot;:&quot;day&quot;}">Tuesday</a><a class="fc-list-heading-alt" data-goto="{&quot;date&quot;:&quot;2019-08-13&quot;,&quot;type&quot;:&quot;day&quot;}">August 13, 2019</a></td>
															</tr>
															<tr class="fc-list-item fc-event-solid-danger fc-event-light">
																<td class="fc-list-item-time fc-widget-content">5:00am</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Dinner</a>
																	<div class="fc-description">Lorem ipsum dolor sit ctetur adipi scing</div>
																</td>
															</tr>
															<tr class="fc-list-item fc-event-primary">
																<td class="fc-list-item-time fc-widget-content">7:00am</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Birthday Party</a>
																	<div class="fc-description">Lorem ipsum dolor sit amet, scing</div>
																</td>
															</tr>
															<tr class="fc-list-heading" data-date="2019-08-14">
																<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main" data-goto="{&quot;date&quot;:&quot;2019-08-14&quot;,&quot;type&quot;:&quot;day&quot;}">Wednesday</a><a class="fc-list-heading-alt" data-goto="{&quot;date&quot;:&quot;2019-08-14&quot;,&quot;type&quot;:&quot;day&quot;}">August 14, 2019</a></td>
															</tr>
															<tr class="fc-list-item fc-event-success">
																<td class="fc-list-item-time fc-widget-content">1:30pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Reporting</a>
																	<div class="fc-description">Lorem ipsum dolor incid idunt ut labore</div>
																</td>
															</tr>
															<tr class="fc-list-heading" data-date="2019-08-16">
																<td class="fc-widget-header" colspan="3"><a class="fc-list-heading-main" data-goto="{&quot;date&quot;:&quot;2019-08-16&quot;,&quot;type&quot;:&quot;day&quot;}">Friday</a><a class="fc-list-heading-alt" data-goto="{&quot;date&quot;:&quot;2019-08-16&quot;,&quot;type&quot;:&quot;day&quot;}">August 16, 2019</a></td>
															</tr>
															<tr class="fc-list-item">
																<td class="fc-list-item-time fc-widget-content">4:00pm</td>
																<td class="fc-list-item-marker fc-widget-content"><span class="fc-event-dot"></span></td>
																<td class="fc-list-item-title fc-widget-content"><a>Repeating Event</a>
																	<div class="fc-description">Lorem ipsum dolor sit amet, labore</div>
																</td>
															</tr>
														</tbody>
													</table>
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