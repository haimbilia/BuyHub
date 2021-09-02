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
		<div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
											<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">
							
<!-- begin:: Subheader -->
<div class="subheader   grid__item" id="subheader">
	<div class="container ">
	    <div class="subheader__main">
		    <h3 class="subheader__title">
				
				Base cards			</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Components	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        cards	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Base cards	                    </a>
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
   	<div class="col-lg-6">	
   		<!--begin::card-->
   		<div class="card card--mobile">
			<div class="card-head">
				<div class="card-head-label">
					<h3 class="card-head-title">
						Basic card <small>card sub title</small>
					</h3>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
   		<div class="card card--bordered">
   			<div class="card-body">
   				<!--begin::card-->
		   		<div class="card card--bordered">
					<div class="card-head">
						<div class="card-head-label">
							<h3 class="card-head-title">
								Bordered Style
							</h3>
						</div>
					</div>
					<div class="card-body">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
				</div>	
				<!--end::card-->

				<!--begin::card-->
		   		<div class="card card--bordered card--head--noborder">
					<div class="card-head">
						<div class="card-head-label">
							<h3 class="card-head-title">
								Semi Bordered Style
							</h3>
						</div>
					</div>
					<div class="card-body">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
				</div>	
				<!--end::card-->
			</div>
		</div>
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--head-lg card--mobile">
			<div class="card-head">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Head Sizing <small>large head</small>
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="dropdown dropdown-inline">
						<button type="button" class="btn btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="flaticon-more-1"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--head-xl card--mobile">
			<div class="card-head">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Head Sizing <small>extra large head</small>
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="dropdown dropdown-inline">
						<a href="#" class="btn btn-default btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="flaticon-more-1"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
				Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
				when an unknown printer took a galley of type and scrambled. Lorem Ipsum is 
				simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
				been the industry's standard dummy text ever since the 1500s, 
				when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->
		
		<!--begin::card-->
		<div class="card">
			<div class="card-head">
				<div class="card-head-label">
					<span class="card-head-icon">
						<i class="flaticon2-graph-1"></i>
					</span>
					<h3 class="card-head-title">
						Icon Title <small>card sub title</small>
					</h3>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
			<div class="card__foot hidden">
				<div class="row">
					<div class="col-lg-6">
						card footer: 
					</div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary">Submit</button>
						<span class="margin-left-10">or <a href="#" class="link font-bold">Cancel</a></span>
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
					<span class="card-head-icon">
						<i class="flaticon2-graph"></i>
					</span>
					<h3 class="card-head-title">
						card Footer
					</h3>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
			<div class="card__foot">
				<div class="row align-items-center">
					<div class="col-lg-6 m--valign-middle">
						card footer: 
					</div>
					<div class="col-lg-6 align-right">
						<button type="submit" class="btn btn-brand">Submit</button>
						<span class="margin-left-10">or <a href="#" class="link font-bold">Cancel</a></span>
					</div>
				</div>
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
   		<div class="card">
			<div class="card-head">
				<div class="card-head-label">
					<span class="card-head-icon">
						<i class="flaticon-multimedia"></i>
					</span>
					<h3 class="card-head-title">
						Scrollable Content
					</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="scroll scroll-y" data-scroll="true" data-height="200" data-scrollbar-shown="true" style="height: 200px;">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
				 </div>
			</div>
			<div class="card__foot">
				<div class="row align-items-center">
					<div class="col-lg-12">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="submit" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card">
			<div class="card-head">
				<div class="card-head-label">
					<span class="card-head-icon">
						<i class="flaticon-statistics"></i>
					</span>
					<h3 class="card-head-title">
						card Action Icons
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-actions">
						<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-add-1"></i>
						</a>
						<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-maps"></i>
						</a>
						<a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-power"></i>
						</a>	
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and  dummy text of the printing  dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--skin-solid bg-danger">
			<div class="card-head card-head--noborder">
				<div class="card-head-label">
					<span class="card-head-icon">
						<i class="flaticon2-graphic"></i>
					</span>
					<h3 class="card-head-title">
						Solid Skin
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-actions">
						<a href="#" class="btn btn-outline-light btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-add-1"></i>
						</a>
						<a href="#" class="btn btn-outline-light btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-maps"></i>
						</a>
						<a href="#" class="btn btn-outline-light btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-power"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting  dummy text of the printing  dummy text of the printing dummy text of the printing industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--skin-solid card-- bg-brand">
			<div class="card-head">
				<div class="card-head-label">
					<span class="card-head-icon">
						<i class="flaticon-notes"></i>
					</span>
					<h3 class="card-head-title">
						Skin Skin
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-actions">
						<a href="#" class="btn btn-outline-light btn-pill btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-lock"></i>
						</a>
						<a href="#" class="btn btn-outline-light btn-pill btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-download-symbol"></i>
						</a>
						<a href="#" class="btn btn-outline-light btn-pill btn-sm btn-icon btn-icon-md">
							<i class="flaticon2-rocket-1"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing  dummy text of the printing  dummy text of the printing  dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->
    </div>
</div>	</div>
<!-- end:: Content -->						</div>
									</div>

		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>