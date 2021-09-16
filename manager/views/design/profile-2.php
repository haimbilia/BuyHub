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
                                <button class="subheader__mobile-toggle subheader__mobile-toggle--left" id="subheader_mobile_toggle"><span></span></button>

                                Profile 2 </h3>

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
                                    Profile 2 </a>
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
                    <!--Begin::App-->
                    <div class="grid grid--desktop grid--ver grid--ver-desktop app">
                        <!--Begin:: App Aside Mobile Toggle-->
                        <button class="app__aside-close" id="user_profile_aside_close">
                            <i class="la la-close"></i>
                        </button>
                        <!--End:: App Aside Mobile Toggle-->

                        <!--Begin:: App Aside-->
                        <div class="grid__item app__toggle app__aside" id="user_profile_aside" style="opacity: 1;">
                            <!--begin:: Widgets/Applications/User/Profile4-->
                            <div class="card card--height-fluid-">
                                <div class="card-body">
                                    <!--begin::Widget -->
                                    <div class="widget widget--user-profile-4">
                                        <div class="widget__head">
                                            <div class="widget__media">
                                                <img class="widget__img hidden-" src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg" alt="image">

                                                <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                                    JD
                                                </div>
                                            </div>
                                            <div class="widget__content">
                                                <div class="widget__section">
                                                    <a href="#" class="widget__username">
                                                        Luca Doncic
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
                                                        <a href="#" class="btn btn-icon btn-circle btn-label-google">
                                                            <i class="socicon-google"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget__body">
                                            <a href="#" class="widget__item widget__item--active">
                                                Profile Overview
                                            </a>
                                            <a href="#" class="widget__item">
                                                Personal info
                                            </a>
                                            <a href="#" class="widget__item">
                                                Account info
                                            </a>
                                            <a href="#" class="widget__item">
                                                Change Passwort
                                            </a>
                                            <a href="#" class="widget__item">
                                                Email settings
                                            </a>
                                            <a href="#" class="widget__item">
                                                Saved Credit Cards
                                            </a>
                                            <a href="#" class="widget__item">
                                                Tax information
                                            </a>
                                        </div>
                                    </div>
                                    <!--end::Widget -->
                                </div>
                            </div>
                            <!--end:: Widgets/Applications/User/Profile4-->
                            <!--Begin:: card-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="widget1 widget1--fit">
                                        <div class="widget1__item">
                                            <div class="widget1__info">
                                                <h3 class="widget1__title">Member Profit</h3>
                                                <span class="widget1__desc">Awerage Weekly Profit</span>
                                            </div>
                                            <span class="widget1__number font-brand">+$17,800</span>
                                        </div>
                                        <div class="widget1__item">
                                            <div class="widget1__info">
                                                <h3 class="widget1__title">Orders</h3>
                                                <span class="widget1__desc">Weekly Customer Orders</span>
                                            </div>
                                            <span class="widget1__number font-danger">+1,800</span>
                                        </div>
                                        <div class="widget1__item">
                                            <div class="widget1__info">
                                                <h3 class="widget1__title">Issue Reports</h3>
                                                <span class="widget1__desc">System bugs and issues</span>
                                            </div>
                                            <span class="widget1__number font-success">-27,49%</span>
                                        </div>
                                        <div class="widget1__item">
                                            <div class="widget1__info">
                                                <h3 class="widget1__title">Customer Support</h3>
                                                <span class="widget1__desc">Closed &amp; pending issues</span>
                                            </div>
                                            <span class="widget1__number font-warning">40%</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end:: card-->
                        </div>
                        <!--End:: App Aside-->

                        <!--Begin:: App Content-->
                        <div class="grid__item grid__item--fluid app__content">
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin:: Widgets/Trends-->
                                    <div class="card card--head--noborder card--height-fluid">
                                        <div class="card-head card-head--noborder">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">
                                                    Trends
                                                </h3>
                                            </div>
                                            <div class="card-head-toolbar">
                                                <div class="dropdown dropdown-inline">
                                                    <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body card__body--fluid card__body--fit">
                                            <div class="widget4 widget4--sticky">
                                                <div class="widget4__chart">
                                                    <div class="chartjs-size-monitor">
                                                        <div class="chartjs-size-monitor-expand">
                                                            <div class=""></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink">
                                                            <div class=""></div>
                                                        </div>
                                                    </div>
                                                    <canvas id="chart_trends_stats" style="height: 240px; display: block; width: 465px;" width="465" height="240" class="chartjs-render-monitor"></canvas>
                                                </div>
                                                <div class="widget4__items widget4__items--bottom card__space-x margin-b-20">
                                                    <div class="widget4__item">
                                                        <div class="widget4__img widget4__img--logo">
                                                            <img src="/metronic/themes/metronic/theme/default/demo4/dist/media/client-logos/logo3.png" alt="">
                                                        </div>
                                                        <div class="widget4__info">
                                                            <a href="#" class="widget4__title">
                                                                Phyton
                                                            </a>
                                                            <span class="widget4__sub">
                                                                A Programming Language
                                                            </span>
                                                        </div>
                                                        <span class="widget4__ext">
                                                            <span class="widget4__number font-danger">+$17</span>
                                                        </span>
                                                    </div>
                                                    <div class="widget4__item">
                                                        <div class="widget4__img widget4__img--logo">
                                                            <img src="/metronic/themes/metronic/theme/default/demo4/dist/media/client-logos/" alt="">
                                                        </div>
                                                        <div class="widget4__info">
                                                            <a href="#" class="widget4__title">
                                                                FlyThemes
                                                            </a>
                                                            <span class="widget4__sub">
                                                                A Let's Fly Fast Again Language
                                                            </span>
                                                        </div>
                                                        <span class="widget4__ext">
                                                            <span class="widget4__number font-danger">+$300</span>
                                                        </span>
                                                    </div>
                                                    <div class="widget4__item">
                                                        <div class="widget4__img widget4__img--logo">
                                                            <img src="/metronic/themes/metronic/theme/default/demo4/dist/media/client-logos/logo2.png" alt="">
                                                        </div>
                                                        <div class="widget4__info">
                                                            <a href="#" class="widget4__title">
                                                                AirApp
                                                            </a>
                                                            <span class="widget4__sub">
                                                                Awesome App For Project Management
                                                            </span>
                                                        </div>
                                                        <span class="widget4__ext">
                                                            <span class="widget4__number font-danger">+$6700</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Trends-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin:: Widgets/Last Updates-->
                                    <div class="card card--height-fluid">
                                        <div class="card-head">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">
                                                    Latest Updates
                                                </h3>
                                            </div>
                                            <div class="card-head-toolbar">
                                                <a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    Today
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
                                                    <!--begin::Nav-->
                                                    <ul class="nav">
                                                        <li class="nav__head">
                                                            Export Options
                                                            <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more...">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon svg-icon--brand svg-icon--md1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                                        <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect>
                                                                        <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect>
                                                                    </g>
                                                                </svg> </span>
                                                        </li>
                                                        <li class="nav__separator"></li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-drop"></i>
                                                                <span class="nav__link-text">Activity</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-calendar-8"></i>
                                                                <span class="nav__link-text">FAQ</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-telegram-logo"></i>
                                                                <span class="nav__link-text">Settings</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-new-email"></i>
                                                                <span class="nav__link-text">Support</span>
                                                                <span class="nav__link-badge">
                                                                    <span class="badge badge--success badge--rounded">5</span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__separator"></li>
                                                        <li class="nav__foot">
                                                            <a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
                                                            <a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more...">Learn more</a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Nav-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!--begin::widget 12-->
                                            <div class="widget4">
                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon-pie-chart-1 font-info"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Metronic v6 has been arrived!
                                                    </a>
                                                    <span class="widget4__number font-info">+500</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon-safe-shield-protection  font-success"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Metronic community meet-up 2019 in Rome.
                                                    </a>
                                                    <span class="widget4__number font-success">+1260</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon2-line-chart font-danger"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Metronic Angular 8 version will be landing soon...
                                                    </a>
                                                    <span class="widget4__number font-danger">+1080</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon2-pie-chart-1 font-primary"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        ale! Purchase Metronic at 70% off for limited time
                                                    </a>
                                                    <span class="widget4__number font-primary">70% Off!</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon2-rocket font-brand"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Metronic VueJS version is in progress. Stay tuned!
                                                    </a>
                                                    <span class="widget4__number font-brand">+134</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon2-notification font-warning"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Black Friday! Purchase Metronic at ever lowest 90% off for limited time
                                                    </a>
                                                    <span class="widget4__number font-warning">70% Off!</span>
                                                </div>

                                                <div class="widget4__item">
                                                    <span class="widget4__icon">
                                                        <i class="flaticon2-file font-success"></i>
                                                    </span>
                                                    <a href="#" class="widget4__title widget4__title--light">
                                                        Metronic React version is in progress.
                                                    </a>
                                                    <span class="widget4__number font-success">+13%</span>
                                                </div>
                                            </div>
                                            <!--end::Widget 12-->
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Last Updates-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <!--begin:: Widgets/Best Sellers-->
                                    <div class="card card--height-fluid">
                                        <div class="card-head">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">
                                                    Best Sellers
                                                </h3>
                                            </div>
                                            <div class="card-head-toolbar">
                                                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#widget5_tab1_content" role="tab">
                                                            Latest
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#widget5_tab2_content" role="tab">
                                                            Month
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#widget5_tab3_content" role="tab">
                                                            All time
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="widget5_tab1_content" aria-expanded="true">
                                                    <div class="widget5">
                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product27.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Great Logo Designn
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Yokart</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">19,200</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1046</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product22.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Branding Mockup
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic bootstrap themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">24,583</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">3809</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product15.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Awesome Mobile App
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.Lorem Ipsum Amet
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">210,054</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1103</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="widget5_tab2_content">
                                                    <div class="widget5">
                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product10.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Branding Mockup
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic bootstrap themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">24,583</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">3809</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product11.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Awesome Mobile App
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.Lorem Ipsum Amet
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">210,054</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1103</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product6.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Great Logo Designn
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Yokart</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">19,200</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1046</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="widget5_tab3_content">
                                                    <div class="widget5">
                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product11.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Awesome Mobile App
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.Lorem Ipsum Amet
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">210,054</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1103</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product6.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Great Logo Designn
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic admin themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Yokart</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">19,200</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">1046</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="widget5__item">
                                                            <div class="widget5__content">
                                                                <div class="widget5__pic">
                                                                    <img class="widget7__img" src="/metronic/themes/metronic/theme/default/demo4/dist/assets/media/products/product10.jpg" alt="">
                                                                </div>
                                                                <div class="widget5__section">
                                                                    <a href="#" class="widget5__title">
                                                                        Branding Mockup
                                                                    </a>
                                                                    <p class="widget5__desc">
                                                                        Metronic bootstrap themes.
                                                                    </p>
                                                                    <div class="widget5__info">
                                                                        <span>Author:</span>
                                                                        <span class="font-info">Fly themes</span>
                                                                        <span>Released:</span>
                                                                        <span class="font-info">23.08.17</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="widget5__content">
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">24,583</span>
                                                                    <span class="widget5__sales">sales</span>
                                                                </div>
                                                                <div class="widget5__stats">
                                                                    <span class="widget5__number">3809</span>
                                                                    <span class="widget5__votes">votes</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Best Sellers-->


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <!--begin:: Widgets/User Progress -->
                                    <div class="card card--height-fluid">
                                        <div class="card-head">
                                            <div class="card-head-label">
                                                <h3 class="card-head-title">
                                                    User Progress
                                                </h3>
                                            </div>
                                            <div class="card-head-toolbar">
                                                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#widget31_tab1_content" role="tab">
                                                            Today
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#widget31_tab2_content" role="tab">
                                                            Week
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="widget31_tab1_content">
                                                    <div class="widget31">
                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Anna Strong
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Visual Designer,Google Inc
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>63%</span>
                                                                        <span>London</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-brand" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_14.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Milano Esco
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Product Designer, Apple Inc
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>33%</span>
                                                                        <span>Paris</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic widget4__pic--pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Nick Bold
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Web Developer, Facebook Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>13%</span>
                                                                        <span>London</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic widget4__pic--pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Wiltor Delton
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Project Manager, Amazon Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <div class="widget31__stats">
                                                                        <span>93%</span>
                                                                        <span>New York</span>
                                                                    </div>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_6.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Sam Stone
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Project Manager, Kilpo Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <div class="widget31__stats">
                                                                        <span>50%</span>
                                                                        <span>New York</span>
                                                                    </div>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="widget31_tab2_content">
                                                    <div class="widget31">
                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic widget4__pic--pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Nick Bold
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Web Developer, Facebook Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>13%</span>
                                                                        <span>London</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic widget4__pic--pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Wiltor Delton
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Project Manager, Amazon Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <div class="widget31__stats">
                                                                        <span>93%</span>
                                                                        <span>New York</span>
                                                                    </div>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_14.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Milano Esco
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Product Designer, Apple Inc
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>33%</span>
                                                                        <span>Paris</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_6.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Sam Stone
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Project Manager, Kilpo Inc
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <div class="widget31__stats">
                                                                        <span>50%</span>
                                                                        <span>New York</span>
                                                                    </div>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>

                                                        <div class="widget31__item">
                                                            <div class="widget31__content">
                                                                <div class="widget31__pic">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg" alt="">
                                                                </div>
                                                                <div class="widget31__info">
                                                                    <a href="#" class="widget31__username">
                                                                        Anna Strong
                                                                    </a>
                                                                    <p class="widget31__text">
                                                                        Visual Designer,Google Inc
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="widget31__content">
                                                                <div class="widget31__progress">
                                                                    <a href="#" class="widget31__stats">
                                                                        <span>63%</span>
                                                                        <span>London</span>
                                                                    </a>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-brand" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <a href="#" class="btn-label-brand btn btn-sm btn-bold">Follow</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/User Progress -->
                                </div>
                            </div>
                        </div>
                        <!--End:: App Content-->
                    </div>
                    <!--End::App-->
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