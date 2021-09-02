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
				
				Draggable cards			</h3>

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
	                        Draggable cards	                    </a>
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
		<div class="alert alert-light alert-elevate" role="alert">
	<div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
	<div class="alert-text">
		The draggable cards powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the card positions in your backend.
        <br>For more info please check out <a class="link link--brand font-bold" href="http://jqueryui.com/sortable/#cards" target="_blank">the official documentation.</a>
	</div>
</div>

<div class="row ui-sortable" id="sortable_cards">
   	<div class="col-lg-6">	
   		<!--begin::card-->
   		<div class="card card--mobile card--sortable" style="">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-group">
						<a href="#" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-refresh"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-close"></i></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
   		<div class="card card--mobile card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
					card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-group">
						<a href="#" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-angle-down"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-refresh"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-close"></i></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
   		<div class="card card--mobile card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-group">
						<a href="#" class="btn btn-sm btn-icon btn-brand btn-pill btn-icon-md"><i class="la la-angle-down"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-danger btn-pill btn-icon-md"><i class="la la-refresh"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-success btn-pill btn-icon-md"><i class="la la-close"></i></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="card-head-group">
						<a href="#" class="btn btn-sm btn-icon btn-brand btn-elevate btn-icon-md"><i class="la la-angle-down"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-danger btn-elevate btn-icon-md"><i class="la la-refresh"></i></a>
						<a href="#" class="btn btn-sm btn-icon btn-success btn-elevate btn-icon-md"><i class="la la-close"></i></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!-- begin:Empty card: sortable porlet required for each columns! -->
      	<div class="card card--sortable-empty">
      	</div>
      	<!--end::Empty card-->
	</div>
	<div class="col-lg-6">	
		<!--begin::card-->
    	<div class="card card--tabs card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line  nav-tabs-line-right" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#card_base_demo_1_tab_content" role="tab">
								Logs
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#card_base_demo_2_tab_content" role="tab">
								Messages
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#card_base_demo_3_tab_content" role="tab">
								Settings
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane active" id="card_base_demo_1_tab_content">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
					<div class="tab-pane" id="card_base_demo_2_tab_content">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text.
					</div>
					<div class="tab-pane" id="card_base_demo_3_tab_content">
						Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
				</div>
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--responsive-tablet-and-mobile card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title
					</h3>
				</div>
				<div class="card-head-toolbar">
					<div class="btn-group btn-group btn-group-pill" role="group" aria-label="...">
					 	<button type="button" class="btn btn-brand">Left</button>
					  	<button type="button" class="btn btn-brand">Middle</button>
					  	<button type="button" class="btn btn-brand">Right</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
    	<div class="card card--tabs card--brand card--head-solid-bg card--sortable">
			<div class="card-head ui-sortable-handle">
				<div class="card-head-label">
					<h3 class="card-head-title">
						card Title <small>some description</small>
					</h3>
				</div>
				<div class="card-head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand nav-tabs-line-danger" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#card_base_demo_1_1_tab_content" role="tab">
								<i class="la la-comments-o"></i>
								Logs
							</a>
						</li>
						<li class="nav-item dropdown">
	                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"><i class="la la-map-marker"></i> Settings</a>
	                        <div class="dropdown-menu dropdown-menu-right">
	                            <a class="dropdown-item" data-toggle="tab" href="#card_base_demo_1_1_tab_content">Action</a>
	                            <a class="dropdown-item" data-toggle="tab" href="#card_base_demo_1_3_tab_content">Another action</a>
	                            <a class="dropdown-item" data-toggle="tab" href="#card_base_demo_1_2_tab_content">Something else here</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" data-toggle="tab" href="#card_base_demo_1_3_tab_content">Separated link</a>
	                        </div>
	                    </li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane active" id="card_base_demo_1_1_tab_content">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
					<div class="tab-pane" id="card_base_demo_1_2_tab_content">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text.
					</div>
					<div class="tab-pane" id="card_base_demo_1_3_tab_content">
						Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					</div>
				</div>
			</div>
		</div>	
		<!--end::card-->

		<!--begin::card-->
		<div class="card card--tabs card--sortable">
            <div class="card-head ui-sortable-handle">
                <div class="card-head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#card_base_demo_2_1_tab_content" role="tab">
                                <i class="la la-cog"></i> Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#card_base_demo_2_2_tab_content" role="tab">
                                <i class="la la-briefcase"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#card_base_demo_2_3_tab_content" role="tab">
                                <i class="la la-bell-o"></i>Logs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="card_base_demo_2_1_tab_content" role="tabpanel">
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

		<!-- begin:Empty card: sortable porlet required for each columns! -->
      	<div class="card card--sortable-empty">
      	</div>
      	<!--end::Empty card-->
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