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

                                List 4 Columns </h3>

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
                                    List - Columns 2 </a>
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
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    JB
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        John Beans
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--success font-success font-boldest hidden-">
                                                    MP
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Matt Pears
                                                    </a>

                                                    <div class="widget__button">
                                                        <span class="btn btn-label-danger btn-sm">Rejected</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_2.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    JM
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Jessica Miles
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-success btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_1.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    AP
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Antonio Pastore
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-brand btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden-">
                                                    SM
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Sarah May
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_20.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    TW
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Teresa Wild
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-info btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_13.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    LD
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Luca Doncic
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-danger btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--warning font-warning font-boldest hidden-">
                                                    GO
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Giannis Oswald
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_22.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    CR
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Charlie Reid
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--success font-success font-boldest hidden-">
                                                    MH
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Megan Higgins
                                                    </a>

                                                    <div class="widget__button">
                                                        <span class="btn btn-label-danger btn-sm">Rejected</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_4.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    LD
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Luke Davids
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-success btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_5.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    CM
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Cody Morgan
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-brand btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden-">
                                                    AS
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Alivia Sutton
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_7.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    CH
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Chelsea Hughes
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-info btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_6.jpg" alt="image">
                                                <div class="widget__pic widget__pic--danger font-danger font-boldest hidden">
                                                    BP
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Ben Prince
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-danger btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card--height-fluid">
                                <div class="card-head card-head--noborder">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">

                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
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
                                <div class="card-body card__body--fit-y margin-b-40">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">
                                                <div class="widget__pic widget__pic--warning font-warning font-boldest hidden-">
                                                    AP
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Anna Pena
                                                    </a>
                                                    <div class="widget__button">
                                                        <span class="btn btn-label-warning btn-sm">Active</span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-facebook">
                                                            <i class="socicon-facebook"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-twitter">
                                                            <i class="socicon-twitter"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                                                            <i class="socicon-linkedin"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
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