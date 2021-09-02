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

                                List 3 Columns </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Apps </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Users </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    List - Columns 1 </a>
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
                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--success font-success font-boldest hidden">
                                                    ChS
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Luca Doncic
                                                </a>

                                                <span class="widget__desc">
                                                    Head of Development
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-54pq</a> objectsves First
                                                esetablished and nice coocked rice
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">luca@festudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">44(76)34254578</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Barcelona</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-warning btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_19.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest  hidden">
                                                    MP
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Charlie Stone
                                                </a>

                                                <span class="widget__desc">
                                                    PR Manager
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Lorem ipsum dolor sit amet <a href="#" class="font-brand link font-transform-u font-bold"> #xrs-23pq</a>, sed
                                                <b>USD342/Annual</b> doloremagna
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">charlie@studiovoila.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">22(43)64534621</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Italy</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-danger btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                <div class="widget__pic widget__pic--info font-info font-boldest  hidden-">
                                                    A K
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Anna Krox
                                                </a>

                                                <span class="widget__desc">
                                                    Python Developer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                esetablished and nice coocked
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">giannis@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">52(43)56254826</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Moscow</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-brand btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                <div class="widget__pic widget__pic--brand font-brand font-boldest hidden">
                                                    JM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Jason Muller
                                                </a>

                                                <span class="widget__desc">
                                                    Atr Direcrtor
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Contrary to popular belief, Lorem Ipsum is not simply random text <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>.
                                            </div>
                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">32(76)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Melbourne</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-success btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg" alt="image">
                                                <div class="widget__pic widget__pic--warning font-warning font-boldest hidden">
                                                    TF
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Teresa Fox
                                                </a>

                                                <span class="widget__desc">
                                                    Project Manager
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Lorem Ipsum is simply <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a> dummy text of the printing and
                                                typesetting industry.
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">75(58)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">France</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-success btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                <div class="widget__pic widget__pic--info font-info font-boldest  hidden-">
                                                    GN
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Giannis Nelson
                                                </a>

                                                <span class="widget__desc">
                                                    Python Developer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                merely firsr <b>USD421/Annual</b>
                                                esetablished and nice coocked
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">giannis@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">52(43)56254826</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Moscow</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-brand btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    LM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Lisa Moss
                                                </a>

                                                <span class="widget__desc">
                                                    Grahpic Designer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                merely firsr <b>USD421/Annual</b> your
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">lisa@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">43(16)98462644</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">London</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-warning btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg" alt="image">
                                                <div class="widget__pic widget__pic--brand font-brand font-boldest hidden">
                                                    JM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Nick Mana
                                                </a>

                                                <span class="widget__desc">
                                                    Atr Direcrtor
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Contrary to popular belief, Lorem Ipsum is not simply random text <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>.
                                            </div>
                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">32(76)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Melbourne</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-danger btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--success font-success font-boldest hidden">
                                                    ChS
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Luca Doncic
                                                </a>

                                                <span class="widget__desc">
                                                    Head of Development
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-54pq</a> objectsves First
                                                esetablished and nice coocked rice
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">luca@festudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">44(76)34254578</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Barcelona</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-warning btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_19.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest  hidden">
                                                    MP
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Charlie Stone
                                                </a>

                                                <span class="widget__desc">
                                                    PR Manager
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Lorem ipsum dolor sit amet <a href="#" class="font-brand link font-transform-u font-bold"> #xrs-23pq</a>, sed
                                                <b>USD342/Annual</b> doloremagna
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">charlie@studiovoila.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">22(43)64534621</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Italy</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-danger btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                <div class="widget__pic widget__pic--info font-info font-boldest  hidden-">
                                                    A K
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Anna Krox
                                                </a>

                                                <span class="widget__desc">
                                                    Python Developer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                esetablished and nice coocked
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">giannis@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">52(43)56254826</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Moscow</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-brand btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                <div class="widget__pic widget__pic--brand font-brand font-boldest hidden">
                                                    JM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Jason Muller
                                                </a>

                                                <span class="widget__desc">
                                                    Atr Direcrtor
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Contrary to popular belief, Lorem Ipsum is not simply random text <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>.
                                            </div>
                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">32(76)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Melbourne</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-success btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg" alt="image">
                                                <div class="widget__pic widget__pic--warning font-warning font-boldest hidden">
                                                    TF
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Teresa Fox
                                                </a>

                                                <span class="widget__desc">
                                                    Project Manager
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Lorem Ipsum is simply <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a> dummy text of the printing and
                                                typesetting industry.
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">75(58)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">France</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-success btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                <div class="widget__pic widget__pic--info font-info font-boldest  hidden-">
                                                    GN
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Giannis Nelson
                                                </a>

                                                <span class="widget__desc">
                                                    Python Developer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                merely firsr <b>USD421/Annual</b>
                                                esetablished and nice coocked
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">giannis@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">52(43)56254826</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Moscow</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-brand btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    LM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Lisa Moss
                                                </a>

                                                <span class="widget__desc">
                                                    Grahpic Designer
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                I distinguish three <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>objectsves First
                                                merely firsr <b>USD421/Annual</b> your
                                            </div>

                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">lisa@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">43(16)98462644</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">London</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-warning btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>

                        <div class="col-xl-3">
                            <!--Begin::card-->
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav--block">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-2">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg" alt="image">
                                                <div class="widget__pic widget__pic--brand font-brand font-boldest hidden">
                                                    JM
                                                </div>
                                            </div>

                                            <div class="widget__info">
                                                <a href="#" class="widget__username">
                                                    Nick Mana
                                                </a>

                                                <span class="widget__desc">
                                                    Atr Direcrtor
                                                </span>
                                            </div>
                                        </div>

                                        <div class="widget__body">
                                            <div class="widget__section">
                                                Contrary to popular belief, Lorem Ipsum is not simply random text <a href="#" class="font-brand link font-transform-u font-bold">#xrs-65pq </a>.
                                            </div>
                                            <div class="widget__item">
                                                <div class="widget__contact">
                                                    <span class="widget__label">Email:</span>
                                                    <a href="#" class="widget__data">jason@fifestudios.com</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Phone:</span>
                                                    <a href="#" class="widget__data">32(76)87545243</a>
                                                </div>
                                                <div class="widget__contact">
                                                    <span class="widget__label">Location:</span>
                                                    <span class="widget__data">Melbourne</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget__footer">
                                            <button type="button" class="btn btn-label-danger btn-lg btn-upper">write message</button>
                                        </div>
                                    </div>

                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--End::card-->
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Pagination-->
                    <div class="row">
                        <div class="col-xl-12">
                            <!--begin:: Components/Pagination/Default-->
                            <div class="card">
                                <div class="card-body">
                                    <!--begin: Pagination-->
                                    <div class="pagination pagination--brand">
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
                                </div>
                            </div>
                            <!--end:: Components/Pagination/Default-->
                        </div>
                    </div>
                    <!--End::Pagination-->
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