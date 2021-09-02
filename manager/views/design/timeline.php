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
				
				Timeline			</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Components	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Custom	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Timeline	                    </a>
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
		<!--Begin::card-->
<div class="card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                Timeline v1
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-1">
            </div>
            <div class="col-xl-10">
                <div class="timeline-v1">
                    <div class="timeline-v1__items">
                        <div class="timeline-v1__marker"></div>
                        <div class="timeline-v1__item timeline-v1__item--left timeline-v1__item--first">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>

                            <span class="timeline-v1__item-time font-brand">
                                11:35<span>AM</span>
                            </span>

                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Users Joined Today
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="list-pics margin-b-10">
                                        <a href="#"><img src="media/users/100_4.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_13.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_11.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_14.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_7.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_3.jpg" title=""></a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempors labore et dolore. Lorem ipsum dolor sit amit,consectetur eiusmdd
                                    </p>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-label btn-bold btn-sm">Show more ...</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item timeline-v1__item--right">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>
                            <span class="timeline-v1__item-time font-brand">02:50<span>PM</span></span>
                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    New Members Joined!
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="widget4">
                                        <div class="widget4__item">
                                            <div class="widget4__pic">
                                                <img src="media/users/100_4.jpg" alt="">
                                            </div>
                                            <div class="widget4__info">
                                                <a href="#" class="widget4__username">
                                                            Anna Strong
                                                        </a>
                                                <p class="widget4__text">
                                                    Visual Designer, Google Inc
                                                </p>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-label-success btn-bold">Check</a>
                                        </div>
                                        <div class="widget4__item">
                                            <div class="widget4__pic">
                                                <img src="media/users/100_5.jpg" alt="">
                                            </div>
                                            <div class="widget4__info">
                                                <a href="#" class="widget4__username">
                                                            Nick Nelson
                                                        </a>
                                                <p class="widget4__text">
                                                    Project Manage, Apple Inc
                                                </p>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-label-success btn-bold">Check</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-brand">Check all</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item timeline-v1__item--left">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>
                            <span class="timeline-v1__item-time font-brand">02:58<span>PM</span></span>
                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Latest Uploaded Files
                                </div>
                                <div class="timeline-v1__item-body padding-t-10 padding-b-10">
                                    <div class="widget4">
                                        <div class="widget4__item">
                                            <div class="widget4__pic widget4__pic--icon">
                                                <img src="media/files/doc.svg" alt="">
                                            </div>
                                            <a href="#" class="widget4__title">
                                                        Metronic Documentation
                                                    </a>
                                            <div class="widget4__tools">
                                                <a href="#" class="btn btn-clean btn-icon btn-sm">
                                                    <i class="flaticon2-download-symbol-of-down-arrow-in-a-rectangle"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget4__item">
                                            <div class="widget4__pic widget4__pic--icon">
                                                <img src="media/files/jpg.svg" alt="">
                                            </div>
                                            <a href="#" class="widget4__title">
                                                        Project Specifications(product2019_v4.pdf)
                                                    </a>
                                            <div class="widget4__tools">
                                                <a href="#" class="btn btn-clean btn-icon btn-sm">
                                                    <i class="flaticon2-download-symbol-of-down-arrow-in-a-rectangle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-label-danger btn-bold">View more...</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item timeline-v1__item--right">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>
                            <span class="timeline-v1__item-time font-brand">04:10<span>PM</span></span>
                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Recent Notifications
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="notification notification--fit">
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-line-chart font-success"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    New order has been received
                                                </div>
                                                <div class="notification__item-time">
                                                    2 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-box-1 font-brand"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    New customer is registered
                                                </div>
                                                <div class="notification__item-time">
                                                    3 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-chart2 font-danger"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    Application has been approved
                                                </div>
                                                <div class="notification__item-time">
                                                    3 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-label-success btn-bold">Check all...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col align-center">
                        <button type="button" class="btn btn-label-brand btn-bold">Load More...</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-1">
            </div>
        </div>
    </div>
</div>
<!--End::card-->

<!--Begin::card-->
<div class="card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                Timeline v2
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6">
                <div class="timeline-v1 timeline-v1--justified">
                    <div class="timeline-v1__items">
                        <div class="timeline-v1__marker"></div>

                        <div class="timeline-v1__item timeline-v1__item--first">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>

                            <span class="timeline-v1__item-time font-brand">
                                11:35<span>AM</span>
                            </span>

                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Users Joined Today
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="list-pics margin-b-10">
                                        <a href="#"><img src="media/users/100_4.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_13.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_11.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_14.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_7.jpg" title=""></a>
                                        <a href="#"><img src="media/users/100_3.jpg" title=""></a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempors labore et dolore. Lorem ipsum dolor sit amit,consectetur eiusmdd
                                    </p>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-label-brand btn-bold">Show more ...</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>

                            <span class="timeline-v1__item-time font-brand">02:50<span>PM</span></span>

                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    New Members Joined!
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="widget4">
                                        <div class="widget4__item">
                                            <div class="widget4__pic">
                                                <img src="media/users/100_4.jpg" alt="">
                                            </div>
                                            <div class="widget4__info">
                                                <a href="#" class="widget4__username">
                                                            Anna Strong
                                                        </a>
                                                <p class="widget4__text">
                                                    Visual Designer, Google Inc
                                                </p>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-label-success btn-bold">Check</a>
                                        </div>
                                        <div class="widget4__item">
                                            <div class="widget4__pic">
                                                <img src="media/users/100_5.jpg" alt="">
                                            </div>
                                            <div class="widget4__info">
                                                <a href="#" class="widget4__username">
                                                            Nick Nelson
                                                </a>
                                                <p class="widget4__text">
                                                    Project Manage, Apple Inc
                                                </p>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-label-success btn-bold">Check</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-brand">Check all</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>
                            <span class="timeline-v1__item-time font-brand">02:58<span>PM</span></span>
                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Latest Uploaded Files
                                </div>
                                <div class="timeline-v1__item-body padding-t-10 padding-b-10">
                                    <div class="widget4">
                                        <div class="widget4__item">
                                            <div class="widget4__pic widget4__pic--icon">
                                                <img src="media/files/doc.svg" alt="">
                                            </div>
                                            <a href="#" class="widget4__title">
                                                        Metronic Documentation
                                                    </a>
                                            <div class="widget4__tools">
                                                <a href="#" class="btn btn-clean btn-icon btn-sm">
                                                    <i class="flaticon2-download-symbol-of-down-arrow-in-a-rectangle"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget4__item">
                                            <div class="widget4__pic widget4__pic--icon">
                                                <img src="media/files/jpg.svg" alt="">
                                            </div>
                                            <a href="#" class="widget4__title">
                                                        Project Specifications(product2019_v4.pdf)
                                                    </a>
                                            <div class="widget4__tools">
                                                <a href="#" class="btn btn-clean btn-icon btn-sm">
                                                    <i class="flaticon2-download-symbol-of-down-arrow-in-a-rectangle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-label-danger">View more...</a>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-v1__item">
                            <div class="timeline-v1__item-circle">
                                <div class="bg-danger"></div>
                            </div>
                            <span class="timeline-v1__item-time font-brand">04:10<span>PM</span></span>
                            <div class="timeline-v1__item-content">
                                <div class="timeline-v1__item-title">
                                    Recent Notifications
                                </div>
                                <div class="timeline-v1__item-body">
                                    <div class="notification notification--fit">
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-line-chart font-success"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    New order has been received
                                                </div>
                                                <div class="notification__item-time">
                                                    2 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-box-1 font-brand"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    New customer is registered
                                                </div>
                                                <div class="notification__item-time">
                                                    3 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="notification__item">
                                            <div class="notification__item-icon">
                                                <i class="flaticon2-chart2 font-danger"></i>
                                            </div>
                                            <div class="notification__item-details">
                                                <div class="notification__item-title">
                                                    Application has been approved
                                                </div>
                                                <div class="notification__item-time">
                                                    3 hrs ago
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="timeline-v1__item-actions">
                                    <a href="#" class="btn btn-sm btn-label-success">Check all...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col align-center">
                        <button type="button" class="btn btn-label-brand">Load More...</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
</div>
<!--End::card-->

<div class="row">
    <div class="col-xl-6">
        <!--Begin::card-->
        <div class="card card--height-fluid">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                       Timeline v3
                    </h3>
                </div>
                <div class="card-head-toolbar">
                    <div class="dropdown dropdown-inline">
                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
</ul>                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="scroll scroll-y" data-scroll="true" data-height="380" data-mobile-height="300" style="height: 380px;">
                    <!--Begin::Timeline 3 -->
                    <div class="timeline-v2">
                        <div class="timeline-v2__items  padding-top-25 padding-bottom-30">
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">10:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-danger"></i>
                                </div>
                                <div class="timeline-v2__item-text  padding-top-5">
                                    Lorem ipsum dolor sit amit,consectetur eiusmdd tempor<br>
                                    incididunt ut labore et dolore magna                                           	                                	               
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">12:45</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-success"></i>
                                </div>
                                <div class="timeline-v2__item-text timeline-v2__item-text--bold">
                                    AEOL Meeting With 
                                </div>
                                <div class="list-pics list-pics--sm padding-l-20">
                                    <a href="#"><img src="media/users/100_4.jpg" title=""></a>
                                    <a href="#"><img src="media/users/100_13.jpg" title=""></a>
                                    <a href="#"><img src="media/users/100_11.jpg" title=""></a>
                                    <a href="#"><img src="media/users/100_14.jpg" title=""></a>
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">14:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-brand"></i>
                                </div>
                                <div class="timeline-v2__item-text padding-top-5">
                                    Make Deposit <a href="#" class="link link--brand font-bolder">USD 700</a> To ESL.
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">16:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-warning"></i>
                                </div>
                                <div class="timeline-v2__item-text padding-top-5">
                                    Lorem ipsum dolor sit amit,consectetur eiusmdd tempor<br>
                                    incididunt ut labore et dolore magna elit enim at minim<br>
                                    veniam quis nostrud                                                            	                                
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">17:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-info"></i>
                                </div>
                                <div class="timeline-v2__item-text padding-top-5">
                                    Placed a new order in <a href="#" class="link link--brand font-bolder">SIGNATURE MOBILE</a> marketplace.
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">16:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-brand"></i>
                                </div>
                                <div class="timeline-v2__item-text padding-top-5">
                                    Lorem ipsum dolor sit amit,consectetur eiusmdd tempor<br>
                                    incididunt ut labore et dolore magna elit enim at minim<br>
                                    veniam quis nostrud                                                            	                                
                                </div>
                            </div>
                            <div class="timeline-v2__item">
                                <span class="timeline-v2__item-time">17:00</span>
                                <div class="timeline-v2__item-cricle">
                                    <i class="fa fa-genderless font-danger"></i>
                                </div>
                                <div class="timeline-v2__item-text padding-top-5">
                                    Received a new feedback on <a href="#" class="link link--brand font-bolder">FinancePro App</a> product.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Timeline 3 -->
              </div>
            </div>
        </div>
        <!--End::card-->
    </div>
    <div class="col-xl-6">
        <!--Begin::card-->	    
        <div class="card card--height-fluid">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Timeline v4
                    </h3>
                </div>
                <div class="card-head-toolbar">
                    <ul class="nav nav-pills nav-pills--brand nav-pills-btn-pill nav-pills-btn-sm" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#widget2_tab1_content" role="tab">
                            Today
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#widget2_tab2_content" role="tab">
                            Month
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="widget2_tab1_content">
                        <!--Begin::Timeline 4 -->
                        <div class="timeline-v3">
                            <div class="timeline-v3__items">
                                <div class="timeline-v3__item timeline-v3__item--info">
                                    <span class="timeline-v3__item-time">09:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempor 
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Bob
                                        </a>
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--warning">
                                    <span class="timeline-v3__item-time">10:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit amit
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Sean
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--brand">
                                    <span class="timeline-v3__item-time">11:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit amit eiusmdd tempor
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By James
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--success">
                                    <span class="timeline-v3__item-time">12:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor 
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By James
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--danger">
                                    <span class="timeline-v3__item-time">14:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit amit,consectetur eiusmdd
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Derrick
                                        </a>										 
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--info">
                                    <span class="timeline-v3__item-time">15:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit amit,consectetur
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Iman
                                        </a>
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--brand">
                                    <span class="timeline-v3__item-time">17:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem ipsum dolor sit consectetur eiusmdd tempor
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Aziko
                                        </a>	
                                        </span>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End::Timeline 3 -->
                    </div>
                    <div class="tab-pane" id="widget2_tab2_content">
                        <!--Begin::Timeline 3 -->
                        <div class="timeline-v3">
                            <div class="timeline-v3__items">
                                <div class="timeline-v3__item timeline-v3__item--info">
                                    <span class="timeline-v3__item-time font-info">09:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                            Contrary to popular belief, Lorem Ipsum is not simply random text.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Bob
                                        </a>
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--warning">
                                    <span class="timeline-v3__item-time font-warning">10:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        There are many variations of passages of Lorem Ipsum available.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Sean
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--brand">
                                    <span class="timeline-v3__item-time font-primary">11:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Contrary to popular belief, Lorem Ipsum is not simply random text.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By James
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--success">
                                    <span class="timeline-v3__item-time font-success">12:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By James
                                        </a>	
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--danger">
                                    <span class="timeline-v3__item-time font-warning">14:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Latin words, combined with a handful of model sentence structures.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Derrick
                                        </a>										 
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--info">
                                    <span class="timeline-v3__item-time font-info">15:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Contrary to popular belief, Lorem Ipsum is not simply random text.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Iman
                                        </a>
                                        </span>		 
                                    </div>
                                </div>
                                <div class="timeline-v3__item timeline-v3__item--brand">
                                    <span class="timeline-v3__item-time font-danger">17:00</span>
                                    <div class="timeline-v3__item-desc">
                                        <span class="timeline-v3__item-text">
                                        Lorem Ipsum is therefore always free from repetition, injected humour.
                                        </span><br>
                                        <span class="timeline-v3__item-user-name">
                                        <a href="#" class="link link--dark timeline-v3__item-link">
                                        By Aziko
                                        </a>	
                                        </span>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End::Timeline 3 -->
                    </div>
                </div>
            </div>
        </div>
        <!--End::card-->
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