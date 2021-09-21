<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        

        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="images/favicon.ico" />

    </head>



    <body class="">
        <div class="wrapper">
            <?php
  include 'includes/header.php';
?>
            <div class="body " id="body">
                <div class="content " id="content">

                    <!-- begin:: Subheader -->
                    <div class="subheader   grid__item" id="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title">

                                    General Widgets </h3>

                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Components </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Widgets </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        General </a>
                                </div>
                            </div>
                            <div class="subheader__toolbar">
                                <div class="subheader__wrapper">
                                    <a href="#" class="btn subheader__btn-secondary">
                                        Reports
                                    </a>

                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                        data-placement="top" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Products
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                            <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                            <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New
                                                Download</a>
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
                    <div class="container">
                        <!--begin:: Widgets/Stats-->
                        <div class="card">
                            <div class="card-body  card__body--fit">
                                <div class="row  no-gutters row-col-separator-lg">

                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::Total Profit-->
                                        <div class="widget24">
                                            <div class="widget24__details">
                                                <div class="widget24__info">
                                                    <h4 class="widget24__title">
                                                        Total Profit
                                                    </h4>
                                                    <span class="widget24__desc">
                                                        All Customs Value
                                                    </span>
                                                </div>

                                                <span class="widget24__stats font-brand">
                                                    $18M
                                                </span>
                                            </div>

                                            <div class="progress progress--sm">
                                                <div class="progress-bar bg-brand" role="progressbar"
                                                    style="width: 78%;" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                            <div class="widget24__action">
                                                <span class="widget24__change">
                                                    Change
                                                </span>
                                                <span class="widget24__number">
                                                    78%
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::Total Profit-->
                                    </div>

                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::New Feedbacks-->
                                        <div class="widget24">
                                            <div class="widget24__details">
                                                <div class="widget24__info">
                                                    <h4 class="widget24__title">
                                                        New Feedbacks
                                                    </h4>
                                                    <span class="widget24__desc">
                                                        Customer Review
                                                    </span>
                                                </div>

                                                <span class="widget24__stats font-warning">
                                                    1349
                                                </span>
                                            </div>

                                            <div class="progress progress--sm">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 84%;" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                            <div class="widget24__action">
                                                <span class="widget24__change">
                                                    Change
                                                </span>
                                                <span class="widget24__number">
                                                    84%
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::New Feedbacks-->
                                    </div>

                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::New Orders-->
                                        <div class="widget24">
                                            <div class="widget24__details">
                                                <div class="widget24__info">
                                                    <h4 class="widget24__title">
                                                        New Orders
                                                    </h4>
                                                    <span class="widget24__desc">
                                                        Fresh Order Amount
                                                    </span>
                                                </div>

                                                <span class="widget24__stats font-danger">
                                                    567
                                                </span>
                                            </div>

                                            <div class="progress progress--sm">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 69%;" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                            <div class="widget24__action">
                                                <span class="widget24__change">
                                                    Change
                                                </span>
                                                <span class="widget24__number">
                                                    69%
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::New Orders-->
                                    </div>

                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::New Users-->
                                        <div class="widget24">
                                            <div class="widget24__details">
                                                <div class="widget24__info">
                                                    <h4 class="widget24__title">
                                                        New Users
                                                    </h4>
                                                    <span class="widget24__desc">
                                                        Joined New User
                                                    </span>
                                                </div>

                                                <span class="widget24__stats font-success">
                                                    276
                                                </span>
                                            </div>

                                            <div class="progress progress--sm">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 90%;" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                            <div class="widget24__action">
                                                <span class="widget24__change">
                                                    Change
                                                </span>
                                                <span class="widget24__number">
                                                    90%
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::New Users-->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Stats-->


                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card card--height-fluid">
                                    <div class="card-body">
                                        <!--begin::Widget -->
                                        <div class="widget33">
                                            <div class="widget33__head">
                                                <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                    data-toggle="dropdown">
                                                    <i class="fa fa-long-arrow-alt-left"></i>
                                                </a>
                                                <a href="#" class="widget33__title">Shopping Cart</a>
                                                <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                    data-toggle="dropdown">
                                                    <i class="fa fa-trash-restore"></i>
                                                </a>
                                            </div>

                                            <div class="widget33__body">
                                                <a href="#" class="widget33__title">
                                                    Your Cart
                                                </a>
                                                <span class="widget33__desc">
                                                    You have 3 items in your cart
                                                </span>

                                                <div class="widget33__items">
                                                    <div class="widget33__item">
                                                        <img class="widget33__pic"
                                                            src="<?php echo CONF_WEBROOT_URL;?>images/product15.jpg"
                                                            alt="image">
                                                        <div class="widget33__content">
                                                            <span class="widget33__subtitle">
                                                                Three friends
                                                            </span>
                                                            <div class="widget33__action">
                                                                <button type="button" class="btn btn-info btn-sm"><i
                                                                        class="fa fa-minus"></i></button>&nbsp;
                                                                <button type="button" class="btn btn-success btn-sm"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <span>1</span>
                                                            </div>
                                                        </div>
                                                        <span class="widget33__price">
                                                            $42
                                                        </span>
                                                    </div>

                                                    <div class="widget33__item">
                                                        <img class="widget33__pic"
                                                            src="<?php echo CONF_WEBROOT_URL;?>images/product15.jpg"
                                                            alt="image">
                                                        <div class="widget33__content">
                                                            <span class="widget33__subtitle">
                                                                Chica &amp; Mica
                                                            </span>
                                                            <div class="widget33__action">
                                                                <button type="button" class="btn btn-info btn-sm"><i
                                                                        class="fa fa-minus"></i></button>&nbsp;
                                                                <button type="button" class="btn btn-success btn-sm"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <span>2</span>
                                                            </div>
                                                        </div>
                                                        <span class="widget33__price">
                                                            $37
                                                        </span>
                                                    </div>

                                                    <div class="widget33__item">
                                                        <img class="widget33__pic"
                                                            src="<?php echo CONF_WEBROOT_URL;?>images/product16.jpg"
                                                            alt="image">
                                                        <div class="widget33__content">
                                                            <span class="widget33__subtitle">
                                                                Little Lover
                                                            </span>
                                                            <div class="widget33__action">
                                                                <button type="button" class="btn btn-info btn-sm"><i
                                                                        class="fa fa-minus"></i></button>&nbsp;
                                                                <button type="button" class="btn btn-success btn-sm"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <span>3</span>
                                                            </div>
                                                        </div>
                                                        <span class="widget33__price">
                                                            $25
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget33__foot">
                                                <div class="widget33__section">
                                                    <span class="widget33__desc">
                                                        Subtotal
                                                    </span>
                                                    <span class="widget33__subtotal">
                                                        $104
                                                    </span>
                                                </div>
                                                <div class="widget33__button">
                                                    <button type="button" class="btn btn-brand btn-md  btn-bold">Check
                                                        Out</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Widget -->
                                    </div>
                                </div>
                                <!--End::card-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Blog-->
                                <div class="card card--height-fluid widget19">
                                    <div class="card-body card__body--fit card__body--unfill">
                                        <div class="widget19__pic card-fit--top card-fit--sides"
                                            style="min-height: 300px; background-image: url(media/product4.jpg)">
                                            <h3 class="widget19__title font-light">
                                                Introducing New Feature
                                            </h3>
                                            <div class="widget19__shadow"></div>
                                            <div class="widget19__labels">
                                                <a href="#" class="btn btn-label-light-o2 btn-bold ">Recent</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="widget19__wrapper">
                                            <div class="widget19__content">
                                                <div class="widget19__userpic">
                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/user1.jpg"
                                                        alt="">
                                                </div>
                                                <div class="widget19__info">
                                                    <a href="#" class="widget19__username">
                                                        Anna Krox
                                                    </a>
                                                    <span class="widget19__time">
                                                        UX/UI Designer, Google
                                                    </span>
                                                </div>
                                                <div class="widget19__stats">
                                                    <span class="widget19__number font-brand">
                                                        18
                                                    </span>
                                                    <a href="#" class="widget19__comment">
                                                        Comments
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="widget19__text">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting
                                                scrambled a type specimen book text of the dummy text of the printing
                                                printing and typesetting industry scrambled dummy text of the printing.
                                            </div>
                                        </div>
                                        <div class="widget19__action">
                                            <a href="#" class="btn btn-sm btn-label-brand btn-bold">Read More...</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Blog-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Announcements 2-->
                                <div class="card bg-danger card--skin-solid card--height-fluid">
                                    <div class="card-head card-head--noborder">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Announcements
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                                <i class="flaticon-more-1 font-light"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                                                <ul class="nav">
                                                    <li class="nav__section nav__section--first">
                                                        <span class="nav__section-text">Finance</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-graph-1"></i>
                                                            <span class="nav__link-text">Statistics</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Events</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-layers-1"></i>
                                                            <span class="nav__link-text">Reports</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__section">
                                                        <span class="nav__section-text">Customers</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Notifications</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-file-1"></i>
                                                            <span class="nav__link-text">Files</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Widget 7-->
                                        <div class="widget7 widget7--skin-light">
                                            <div class="widget7__desc">
                                                Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy
                                                euismod tinciduntut laoreet doloremagna
                                            </div>
                                            <div class="widget7__content">
                                                <div class="widget7__userpic">
                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_5.jpg"
                                                        alt="">
                                                </div>
                                                <div class="widget7__info">
                                                    <h3 class="widget7__username">
                                                        Nick Mana
                                                    </h3>
                                                    <span class="widget7__time">
                                                        6 hours ago
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="widget7__button">
                                                <a class="btn btn-brand" href="#" role="button">All Feeds</a>
                                            </div>
                                        </div>
                                        <!--end::Widget 7-->
                                    </div>
                                </div>
                                <!--end:: Widgets/Announcements 2-->
                            </div>
                        </div>
                        <!--End::Section-->

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Finance Summary-->
                                <div class="card card--height-fluid">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Finance Summary
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-label-brand btn-sm  btn-bold dropdown-toggle"
                                                data-toggle="dropdown">
                                                Latest
                                            </a>
                                            <div
                                                class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                                                <!--begin::Nav-->
                                                <ul class="nav">
                                                    <li class="nav__head">
                                                        Export Options
                                                        <span data-toggle="tooltip" data-placement="right" title=""
                                                            data-original-title="Click to learn more...">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1"
                                                                class="svg-icon svg-icon--brand svg-icon--md1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
                                                                        r="10"></circle>
                                                                    <rect fill="#000000" x="11" y="10" width="2"
                                                                        height="7" rx="1"></rect>
                                                                    <rect fill="#000000" x="11" y="7" width="2"
                                                                        height="2" rx="1"></rect>
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
                                                                <span
                                                                    class="badge badge--success badge--rounded">5</span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__separator"></li>
                                                    <li class="nav__foot">
                                                        <a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade
                                                            plan</a>
                                                        <a class="btn btn-clean btn-bold btn-sm" href="#"
                                                            data-toggle="tooltip" data-placement="right" title=""
                                                            data-original-title="Click to learn more...">Learn more</a>
                                                    </li>
                                                </ul>
                                                <!--end::Nav-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="widget12">
                                            <div class="widget12__content">
                                                <div class="widget12__item">
                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Annual Companies Taxes EMS</span>
                                                        <span class="widget12__value">$500,000</span>
                                                    </div>

                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Next Tax Review Date</span>
                                                        <span class="widget12__value">July 24,2017</span>
                                                    </div>
                                                </div>
                                                <div class="widget12__item">
                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Total Annual Profit Before
                                                            Tax</span>
                                                        <span class="widget12__value">$3,800,000</span>
                                                    </div>

                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Type Of Market Share</span>
                                                        <span class="widget12__value">Grossery</span>
                                                    </div>
                                                </div>
                                                <div class="widget12__item">
                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Avarage Product Price</span>
                                                        <span class="widget12__value">$60,70</span>
                                                    </div>

                                                    <div class="widget12__info">
                                                        <span class="widget12__desc">Satisfication Rate</span>
                                                        <span class="widget12__progress">
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-brand" role="progressbar"
                                                                    style="width: 63%" aria-valuenow="63"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="widget12__stat">
                                                                63%
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Finance Summary-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Announcements 1-->
                                <div class="card bg-brand card--skin-solid card--height-fluid">
                                    <div class="card-head card-head--noborder">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Announcements
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                                <i class="flaticon-more-1 font-light"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                                                <ul class="nav">
                                                    <li class="nav__section nav__section--first">
                                                        <span class="nav__section-text">Finance</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-graph-1"></i>
                                                            <span class="nav__link-text">Statistics</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Events</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-layers-1"></i>
                                                            <span class="nav__link-text">Reports</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__section">
                                                        <span class="nav__section-text">Customers</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Notifications</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-file-1"></i>
                                                            <span class="nav__link-text">Files</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Widget 7-->
                                        <div class="widget7 widget7--skin-light">
                                            <div class="widget7__desc">
                                                Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy
                                                euismod tinciduntut laoreet doloremagna
                                            </div>
                                            <div class="widget7__content">
                                                <div class="widget7__userpic">
                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg"
                                                        alt="">
                                                </div>
                                                <div class="widget7__info">
                                                    <h3 class="widget7__username">
                                                        Nick Mana
                                                    </h3>
                                                    <span class="widget7__time">
                                                        6 hours ago
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="widget7__button">
                                                <a class="btn btn-success" href="#" role="button">All Feeds</a>
                                            </div>
                                        </div>
                                        <!--end::Widget 7-->
                                    </div>
                                </div>
                                <!--end:: Widgets/Announcements 1-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Company Summary-->
                                <div class="card card--height-fluid">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Company Summary
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-label-brand btn-sm  btn-bold dropdown-toggle"
                                                data-toggle="dropdown">
                                                Export
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                                                <ul class="nav">
                                                    <li class="nav__section nav__section--first">
                                                        <span class="nav__section-text">Finance</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-graph-1"></i>
                                                            <span class="nav__link-text">Statistics</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Events</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-layers-1"></i>
                                                            <span class="nav__link-text">Reports</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__section">
                                                        <span class="nav__section-text">Customers</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Notifications</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-file-1"></i>
                                                            <span class="nav__link-text">Files</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="widget13">
                                            <div class="widget13__item">
                                                <span class="widget13__desc">
                                                    Company Name
                                                </span>
                                                <span class="widget13__text widget13__text--bold">
                                                    Loop Inc.
                                                </span>
                                            </div>
                                            <div class="widget13__item">
                                                <span class="widget13__desc align-right">
                                                    Annual Revenue:
                                                </span>
                                                <span class="widget13__text widget13__text--bold">
                                                    $520,000
                                                </span>
                                            </div>
                                            <div class="widget13__item">
                                                <span class="widget13__desc">
                                                    Business Description:
                                                </span>
                                                <span class="widget13__text">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry.
                                                </span>
                                            </div>
                                            <div class="widget13__item">
                                                <span class="widget13__desc">
                                                    Employee Amount:
                                                </span>
                                                <span class="widget13__text widget13__text--bold">
                                                    1,300
                                                </span>
                                            </div>
                                            <div class="widget13__item">
                                                <span class="widget13__desc">
                                                    Emal:
                                                </span>
                                                <span class="widget13__text">

                                                </span>
                                            </div>
                                            <div class="widget13__item">
                                                <span class="widget13__desc">
                                                    Phone:
                                                </span>
                                                <span class="widget13__text  font-brand widget13__text--bold">
                                                    (0) 123 456 78 90
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Company Summary-->
                            </div>
                        </div>
                        <!--End::Section-->

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Personal Income-->
                                <div class="card card--fit card--head-lg card--head-overlay card--height-fluid">
                                    <div class="card-head card__space-x">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title font-light">
                                                Personal Income
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-outline-light btn-sm btn-bold dropdown-toggle"
                                                data-toggle="dropdown">
                                                March, 2019
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
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
                                    <div class="card-body">
                                        <div class="widget27">
                                            <div class="widget27__visual">
                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/bg-4.jpg" alt="">
                                                <h3 class="widget27__title">
                                                    <span><span>$</span>256,100</span>
                                                </h3>
                                                <div class="widget27__btn">
                                                    <a href="#"
                                                        class="btn btn-pill btn-light btn-elevate btn-bold">Inclusive
                                                        All Earnings</a>
                                                </div>
                                            </div>
                                            <div class="widget27__container card__space-x">
                                                <ul class="nav nav-pills nav-fill" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="pill"
                                                            href="#personal_income_quater_1">Quater 1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill"
                                                            href="#personal_income_quater_2">Quater 2</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill"
                                                            href="#personal_income_quater_3">Quater 3</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill"
                                                            href="#personal_income_quater_4">Quater 4</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="personal_income_quater_1" class="tab-pane active">
                                                        <div class="widget11">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table">
                                                                    <!--begin::Thead-->
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Application</td>
                                                                            <td>Status</td>
                                                                            <td class="align-right">Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <!--end::Thead-->
                                                                    <!--begin::Tbody-->
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Vertex
                                                                                    2.0</a>
                                                                                <span class="widget11__sub">Vertex To By
                                                                                    Again</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--success badge--inline">pending</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $14,740</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Metronic</a>
                                                                                <span class="widget11__sub">Powerful
                                                                                    Admin Theme</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--brand badge--inline">new</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $16,010</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <!--end::Tbody-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="personal_income_quater_2" class="tab-pane fade">
                                                        <div class="widget11">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table">
                                                                    <!--begin::Thead-->
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Application</td>
                                                                            <td>Status</td>
                                                                            <td class="align-right">Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <!--end::Thead-->
                                                                    <!--begin::Tbody-->
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Vertex
                                                                                    2.0</a>
                                                                                <span class="widget11__sub">Vertex To By
                                                                                    Again</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--success badge--inline">pending</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $14,740</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Apex</a>
                                                                                <span class="widget11__sub">The Best
                                                                                    Selling App</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--warning badge--inline">in
                                                                                    process</span></td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $37,200</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <!--end::Tbody-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="personal_income_quater_3" class="tab-pane fade">
                                                        <div class="widget11">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table">
                                                                    <!--begin::Thead-->
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Application</td>
                                                                            <td>Status</td>
                                                                            <td class="align-right">Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <!--end::Thead-->
                                                                    <!--begin::Tbody-->
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Metronic</a>
                                                                                <span class="widget11__sub">Powerful
                                                                                    Admin Theme</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--brand badge--inline">new</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $16,010</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Apex</a>
                                                                                <span class="widget11__sub">The Best
                                                                                    Selling App</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--warning badge--inline">in
                                                                                    process</span></td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $37,200</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <!--end::Tbody-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="personal_income_quater_4" class="tab-pane fade">
                                                        <div class="widget11">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table">
                                                                    <!--begin::Thead-->
                                                                    <thead>
                                                                        <tr>
                                                                            <td>Application</td>
                                                                            <td>Status</td>
                                                                            <td class="align-right">Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <!--end::Thead-->
                                                                    <!--begin::Tbody-->
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Vertex
                                                                                    2.0</a>
                                                                                <span class="widget11__sub">Vertex To By
                                                                                    Again</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--success badge--inline">pending</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $14,740</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="widget11__title">Metronic</a>
                                                                                <span class="widget11__sub">Powerful
                                                                                    Admin Theme</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge--brand badge--inline">new</span>
                                                                            </td>
                                                                            <td
                                                                                class="align-right font-brand font-bold">
                                                                                $16,010</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <!--end::Tbody-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Personal Income-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Finance Stats-->
                                <div class="card card--fit card--head-lg card--head-overlay card--height-fluid">
                                    <div class="card-head card__space-x">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title font-light">
                                                Finance Stats
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-outline-light btn-sm btn-bold dropdown-toggle"
                                                data-toggle="dropdown">
                                                Revenue
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                                                <ul class="nav">
                                                    <li class="nav__section nav__section--first">
                                                        <span class="nav__section-text">Finance</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-graph-1"></i>
                                                            <span class="nav__link-text">Statistics</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Events</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-layers-1"></i>
                                                            <span class="nav__link-text">Reports</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__section">
                                                        <span class="nav__section-text">Customers</span>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                            <span class="nav__link-text">Notifications</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__item">
                                                        <a href="#" class="nav__link">
                                                            <i class="nav__link-icon flaticon2-file-1"></i>
                                                            <span class="nav__link-text">Files</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="widget28">
                                            <div class="widget28__visual"
                                                style="background-image: url(media/bg/bg-page-section.png)"></div>
                                            <div class="widget28__wrapper card__space-x">
                                                <!-- begin::Nav pills -->
                                                <ul class="nav nav-pills nav-fill card__space-x" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="pill"
                                                            href="#menu11"><span><i
                                                                    class="fa flaticon-pie-chart"></i></span><span>GMI
                                                                Taxes</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#menu21"><span><i
                                                                    class="fa flaticon-file-1"></i></span><span>IMT
                                                                Invoice</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#menu31"><span><i
                                                                    class="fa flaticon-clipboard"></i></span><span>Main
                                                                Notes</span></a>
                                                    </li>
                                                </ul>
                                                <!-- end::Nav pills -->

                                                <!-- begin::Tab Content -->
                                                <div class="tab-content">
                                                    <div id="menu11" class="tab-pane active">
                                                        <div class="widget28__tab-items">
                                                            <div class="widget28__tab-item">
                                                                <span>Company Name</span>
                                                                <span>SLT Back-end Solutions</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>INE Number</span>
                                                                <span>D330-1234562546</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Total Charges</span>
                                                                <span>USD 1,250.000</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Project Description</span>
                                                                <span>Creating Back-end Components</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="menu21" class="tab-pane fade">
                                                        <div class="widget28__tab-items">
                                                            <div class="widget28__tab-item">
                                                                <span>Project Description</span>
                                                                <span>Back-End Web Architecture</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Total Charges</span>
                                                                <span>USD 2,170.000</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>INE Number</span>
                                                                <span>D110-1234562546</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Company Name</span>
                                                                <span>SLT Back-end Solutions</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="menu31" class="tab-pane fade">
                                                        <div class="widget28__tab-items">
                                                            <div class="widget28__tab-item">
                                                                <span>Total Charges</span>
                                                                <span>USD 3,450.000</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Project Description</span>
                                                                <span>Creating Back-end Components</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>Company Name</span>
                                                                <span>SLT Back-end Solutions</span>
                                                            </div>
                                                            <div class="widget28__tab-item">
                                                                <span>INE Number</span>
                                                                <span>D510-7431562548</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end::Tab Content -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Finance Stats-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Packages-->
                                <div
                                    class="card card--skin-solid card--solid-warning card--head-lg card--head-overlay card--height-fluid">
                                    <div class="card-head card-head--noborder">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title font-light">
                                                Packages
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#"
                                                class="btn btn-outline-light btn-sm btn-hover-light btn-bold dropdown-toggle"
                                                data-toggle="dropdown">
                                                2019
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
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
                                    <div class="card-body margin-t-0 padding-t-0">
                                        <!--begin::Widget 29-->
                                        <div class="widget29">
                                            <div class="widget29__content">
                                                <h3 class="widget29__title">Monthly Income</h3>
                                                <div class="widget29__item">
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Total</span>
                                                        <span class="widget29__stats font-success">$680</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Change</span>
                                                        <span class="widget29__stats font-brand">+15%</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Licenses</span>
                                                        <span class="widget29__stats font-danger">29</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget29__content">
                                                <h3 class="widget29__title">Taxes info</h3>
                                                <div class="widget29__item">
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Total</span>
                                                        <span class="widget29__stats font-success">22.50</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Change</span>
                                                        <span class="widget29__stats font-brand">+15%</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Count</span>
                                                        <span class="widget29__stats font-danger">701</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget29__content">
                                                <h3 class="widget29__title">Partners Sale</h3>
                                                <div class="widget29__item">
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Total</span>
                                                        <span class="widget29__stats font-success">$680</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Change</span>
                                                        <span class="widget29__stats font-brand">+15%</span>
                                                    </div>
                                                    <div class="widget29__info">
                                                        <span class="widget29__subtitle">Licenses</span>
                                                        <span class="widget29__stats font-danger">29</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget29__actions align-right">
                                                <a href="#" class="btn btn-brand">View all packages</a>
                                            </div>
                                        </div>
                                        <!--end::Widget 29-->
                                    </div>
                                </div>
                                <!--end:: Packages-->


                            </div>
                        </div>
                        <!--End::Section-->

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Applications/User/Profile1-->
                                <div class="card card--height-fluid">
                                    <div class="card-head  card-head--noborder">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                data-toggle="dropdown">
                                                <i class="flaticon-more-1"></i>
                                            </a>
                                            <div
                                                class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                                                <!--begin::Nav-->
                                                <ul class="nav">
                                                    <li class="nav__head">
                                                        Export Options
                                                        <span data-toggle="tooltip" data-placement="right" title=""
                                                            data-original-title="Click to learn more...">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1"
                                                                class="svg-icon svg-icon--brand svg-icon--md1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
                                                                        r="10"></circle>
                                                                    <rect fill="#000000" x="11" y="10" width="2"
                                                                        height="7" rx="1"></rect>
                                                                    <rect fill="#000000" x="11" y="7" width="2"
                                                                        height="2" rx="1"></rect>
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
                                                                <span
                                                                    class="badge badge--success badge--rounded">5</span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="nav__separator"></li>
                                                    <li class="nav__foot">
                                                        <a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade
                                                            plan</a>
                                                        <a class="btn btn-clean btn-bold btn-sm" href="#"
                                                            data-toggle="tooltip" data-placement="right" title=""
                                                            data-original-title="Click to learn more...">Learn more</a>
                                                    </li>
                                                </ul>
                                                <!--end::Nav-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body card__body--fit-y">
                                        <!--begin::Widget -->
                                        <div class="widget widget--user-profile-1">
                                            <div class="widget__head">
                                                <div class="widget__media">
                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                        alt="image">
                                                </div>
                                                <div class="widget__content">
                                                    <div class="widget__section">
                                                        <a href="#" class="widget__username">
                                                            Jason Muller
                                                            <i class="flaticon2-correct font-success"></i>
                                                        </a>
                                                        <span class="widget__subtitle">
                                                            Head of Development
                                                        </span>
                                                    </div>

                                                    <div class="widget__action">
                                                        <button type="button"
                                                            class="btn btn-info btn-sm">chat</button>&nbsp;
                                                        <button type="button"
                                                            class="btn btn-success btn-sm">follow</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget__body">
                                                <div class="widget__content">
                                                    <div class="widget__info">
                                                        <span class="widget__label">Email:</span>
                                                        <a href="#" class="widget__data">matt@fifestudios.com</a>
                                                    </div>
                                                    <div class="widget__info">
                                                        <span class="widget__label">Phone:</span>
                                                        <a href="#" class="widget__data">44(76)34254578</a>
                                                    </div>
                                                    <div class="widget__info">
                                                        <span class="widget__label">Location:</span>
                                                        <span class="widget__data">Melbourne</span>
                                                    </div>
                                                </div>
                                                <div class="widget__items">
                                                    <a href="user/profile-1/overview.html"
                                                        class="widget__item widget__item--active">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                        <path
                                                                            d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                            fill="#000000" fill-rule="nonzero"></path>
                                                                        <path
                                                                            d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Profile Overview
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <a href="user/profile-1/personal-information.html"
                                                        class="widget__item ">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                        <path
                                                                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"></path>
                                                                        <path
                                                                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                            fill="#000000" fill-rule="nonzero"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Personal Information
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <a href="user/profile-1/account-information.html"
                                                        class="widget__item ">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <path
                                                                            d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                        <path
                                                                            d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                                            fill="#000000"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Account Information
                                                            </span>

                                                        </span></a>
                                                    <a href="user/profile-1/change-password.html" class="widget__item ">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <path
                                                                            d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                        <path
                                                                            d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                        <path
                                                                            d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Change Passwort
                                                            </span>
                                                        </span>
                                                        <span
                                                            class="badge badge--unified-danger badge--sm badge--rounded badge--bolder">5</span>
                                                    </a>
                                                    <a href="user/profile-1/email-settings.html" class="widget__item ">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <path
                                                                            d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                        <path
                                                                            d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                                                            fill="#000000"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Email settings
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="widget__item" data-toggle="tooltip" title=""
                                                        data-placement="right" data-original-title="Coming soon...">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <rect fill="#000000" x="2" y="5" width="19"
                                                                            height="4" rx="1"></rect>
                                                                        <rect fill="#000000" opacity="0.3" x="2" y="11"
                                                                            width="19" height="10" rx="1"></rect>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Saved Credit Cards
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="widget__item" data-toggle="tooltip" title=""
                                                        data-placement="right" data-original-title="Coming soon...">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                        <path
                                                                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"></path>
                                                                        <rect fill="#000000" x="6" y="11" width="9"
                                                                            height="2" rx="1"></rect>
                                                                        <rect fill="#000000" x="6" y="15" width="5"
                                                                            height="2" rx="1"></rect>
                                                                    </g>
                                                                </svg> </span>
                                                            <span href="#" class="widget__desc">Tax information</span>
                                                        </span>
                                                        <span
                                                            class="badge badge--unified-brand badge--inline badge--bolder">new</span>
                                                    </a>
                                                    <a href="#" class="widget__item" data-toggle="tooltip" title=""
                                                        data-placement="right" data-original-title="Coming soon...">
                                                        <span class="widget__section">
                                                            <span class="widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1" class="svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <rect fill="#000000" x="4" y="5" width="16"
                                                                            height="3" rx="1.5"></rect>
                                                                        <path
                                                                            d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                                                            fill="#000000" opacity="0.3"></path>
                                                                    </g>
                                                                </svg> </span>
                                                            <span class="widget__desc">
                                                                Statements
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Widget -->
                                    </div>
                                </div>
                                <!--end:: Widgets/Applications/User/Profile1-->

                            </div>
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Applications/User/Profile4-->
                                <div class="card card--height-fluid">
                                    <div class="card-body">
                                        <!--begin::Widget -->
                                        <div class="widget widget--user-profile-4">
                                            <div class="widget__head">
                                                <div class="widget__media">
                                                    <img class="widget__img hidden-"
                                                        src="<?php echo CONF_WEBROOT_URL;?>images/users/300_21.jpg"
                                                        alt="image">

                                                    <div
                                                        class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
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
                                                            <a href="#"
                                                                class="btn btn-icon btn-circle btn-label-facebook">
                                                                <i class="socicon-facebook"></i>
                                                            </a>
                                                            <a href="#"
                                                                class="btn btn-icon btn-circle btn-label-twitter">
                                                                <i class="socicon-twitter"></i>
                                                            </a>
                                                            <a href="#"
                                                                class="btn btn-icon btn-circle btn-label-google">
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
                            </div>
                            <div class="col-xl-4">
                                <!--Begin::card-->
                                <div class="card card--height-fluid">
                                    <div class="card-head card-head--noborder">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">

                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                data-toggle="dropdown">
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
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Widget -->
                                        <div class="widget widget--user-profile-2">
                                            <div class="widget__head">
                                                <div class="widget__media">
                                                    <img class="widget__img hidden-"
                                                        src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                        alt="image">
                                                    <div
                                                        class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                                        MP
                                                    </div>
                                                </div>
                                                <div class="widget__info">
                                                    <a href="#" class="widget__username">
                                                        Matt Peares
                                                    </a>
                                                    <span class="widget__desc">
                                                        Head of Development
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="widget__body">
                                                <div class="widget__section">
                                                    Contrary to popular belief, Lorem Ipsum is not simply random text.
                                                    It has roots in a piece of classical.
                                                </div>

                                                <div class="widget__content">
                                                    <div class="widget__stats margin-r-20">
                                                        <div class="widget__icon">
                                                            <i class="flaticon-piggy-bank"></i>
                                                        </div>
                                                        <div class="widget__details">
                                                            <span class="widget__title">Earnings</span>
                                                            <span class="widget__value"><span>$</span>249,500</span>
                                                        </div>
                                                    </div>

                                                    <div class="widget__stats">
                                                        <div class="widget__icon">
                                                            <i class="flaticon-pie-chart"></i>
                                                        </div>
                                                        <div class="widget__details">
                                                            <span class="widget__title">Net</span>
                                                            <span class="widget__value"><span>$</span>84,060</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__contact">
                                                        <span class="widget__label">Email:</span>
                                                        <a href="#" class="widget__data">matt@fifestudios.com</a>
                                                    </div>
                                                    <div class="widget__contact">
                                                        <span class="widget__label">Phone:</span>
                                                        <a href="#" class="widget__data">44(76)34254578</a>
                                                    </div>
                                                    <div class="widget__contact">
                                                        <span class="widget__label">Location:</span>
                                                        <span class="widget__data">Melbourne</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget__footer">
                                                <button type="button"
                                                    class="btn btn-label-success btn-lg btn-upper">write
                                                    message</button>
                                            </div>
                                        </div>
                                        <!--end::Widget -->

                                        <!--begin::Navigation -->
                                        <ul class="nav nav--bold nav--md-space margin-t-20 margin-b-20 hidden"
                                            role="tablist">
                                            <li class="nav__item nav__item--active">
                                                <a class="nav__link active" data-toggle="tab"
                                                    href="#profile_tab_personal_information" role="tab">
                                                    <span class="nav__link-icon"><i
                                                            class="flaticon2-calendar-3"></i></span>
                                                    <span class="nav__link-text">Personal Information</span>
                                                </a>
                                            </li>
                                            <li class="nav__item">
                                                <a class="nav__link" data-toggle="tab"
                                                    href="#profile_tab_account_information" role="tab">
                                                    <span class="nav__link-icon"><i
                                                            class="flaticon2-protected"></i></span>
                                                    <span class="nav__link-text">Acccount Information</span>
                                                </a>
                                            </li>
                                            <li class="nav__item">
                                                <a class="nav__link" href="#" role="tab" data-toggle="tooltip" title=""
                                                    data-placement="right"
                                                    data-original-title="This feature is coming soon!">
                                                    <span class="nav__link-icon"><i
                                                            class="flaticon2-hourglass-1"></i></span>
                                                    <span class="nav__link-text">Payments</span>
                                                </a>
                                            </li>
                                            <li class="nav__separator"></li>
                                            <li class="nav__item">
                                                <a class="nav__link" href="#" role="tab" data-toggle="tooltip" title=""
                                                    data-placement="right"
                                                    data-original-title="This feature is coming soon!">
                                                    <span class="nav__link-icon"><i class="flaticon2-bell-2"></i></span>
                                                    <span class="nav__link-text">Statements</span>
                                                </a>
                                            </li>
                                            <li class="nav__item">
                                                <a class="nav__link" href="#" role="tab" data-toggle="tooltip" title=""
                                                    data-placement="right"
                                                    data-original-title="This feature is coming soon!">
                                                    <span class="nav__link-icon"><i
                                                            class="flaticon2-medical-records-1"></i></span>
                                                    <span class="nav__link-text">Audit Log</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!--end::Navigation -->
                                    </div>
                                </div>
                                <!--End::card-->

                            </div>
                        </div>
                        <!--End::Section-->

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-12">
                                <!--begin:: Widgets/Applications/User/Profile3-->
                                <div class="card card--height-fluid">
                                    <div class="card-body">
                                        <div class="widget widget--user-profile-3">
                                            <div class="widget__top">
                                                <div class="widget__media hidden-">
                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                        alt="image">
                                                </div>
                                                <div
                                                    class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                                    JM
                                                </div>
                                                <div class="widget__content">
                                                    <div class="widget__head">
                                                        <a href="#" class="widget__username">
                                                            Jason Muller
                                                            <i class="flaticon2-correct"></i>
                                                        </a>

                                                        <div class="widget__action">
                                                            <button type="button"
                                                                class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                            <button type="button"
                                                                class="btn btn-brand btn-sm btn-upper">hire</button>
                                                        </div>
                                                    </div>

                                                    <div class="widget__subhead">
                                                        <a href="#"><i
                                                                class="flaticon2-new-email"></i>jason@siastudio.com</a>
                                                        <a href="#"><i class="flaticon2-calendar-3"></i>PR Manager </a>
                                                        <a href="#"><i class="flaticon2-placeholder"></i>Melbourne</a>
                                                    </div>

                                                    <div class="widget__info">
                                                        <div class="widget__desc">
                                                            I distinguish three main text objektive could be merely to
                                                            inform people.
                                                            <br> A second could be persuade people.You want people to
                                                            bay objective
                                                        </div>
                                                        <div class="widget__progress">
                                                            <div class="widget__text">
                                                                Progress
                                                            </div>
                                                            <div class="progress" style="height: 5px;width: 100%;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: 65%;" aria-valuenow="65"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <div class="widget__stats">
                                                                78%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget__bottom">
                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-piggy-bank"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <span class="widget__title">Earnings</span>
                                                        <span class="widget__value"><span>$</span>249,500</span>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-confetti"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <span class="widget__title">Expances</span>
                                                        <span class="widget__value"><span>$</span>164,700</span>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-pie-chart"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <span class="widget__title">Net</span>
                                                        <span class="widget__value"><span>$</span>164,700</span>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-file-2"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <span class="widget__title">73 Tasks</span>
                                                        <a href="#" class="widget__value font-brand">View</a>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-chat-1"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <span class="widget__title">648 Comments</span>
                                                        <a href="#" class="widget__value font-brand">View</a>
                                                    </div>
                                                </div>

                                                <div class="widget__item">
                                                    <div class="widget__icon">
                                                        <i class="flaticon-network"></i>
                                                    </div>
                                                    <div class="widget__details">
                                                        <div class="section__content section__content--solid">
                                                            <div class="media-group">
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="John Myer">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                                        alt="image">
                                                                </a>
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Alison Brandy">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg"
                                                                        alt="image">
                                                                </a>
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Selina Cranson">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg"
                                                                        alt="image">
                                                                </a>
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Luke Walls">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg"
                                                                        alt="image">
                                                                </a>
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Micheal York">
                                                                    <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg"
                                                                        alt="image">
                                                                </a>
                                                                <a href="#" class="media media--sm media--circle"
                                                                    data-toggle="tooltip" data-skin="brand"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Micheal York">
                                                                    <span>+3</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Applications/User/Profile3-->
                            </div>
                        </div>
                        <!--End::Section-->

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-6">
                                <!--begin:: Widgets/Product Sales-->
                                <div class="card card--bordered-semi card--space card--height-fluid">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Product Sales
                                                <small>total sales</small>
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <div class="dropdown dropdown-inline">
                                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="flaticon-more-1"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="nav">
                                                        <li class="nav__section nav__section--first">
                                                            <span class="nav__section-text">Finance</span>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-graph-1"></i>
                                                                <span class="nav__link-text">Statistics</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                                <span class="nav__link-text">Events</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-layers-1"></i>
                                                                <span class="nav__link-text">Reports</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__section">
                                                            <span class="nav__section-text">Customers</span>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-calendar-4"></i>
                                                                <span class="nav__link-text">Notifications</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a href="#" class="nav__link">
                                                                <i class="nav__link-icon flaticon2-file-1"></i>
                                                                <span class="nav__link-text">Files</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="widget25">
                                            <span class="widget25__stats m-font-brand">$237,650</span>
                                            <span class="widget25__subtitle">Total Revenue This Month</span>
                                            <div class="widget25__items">
                                                <div class="widget25__item">
                                                    <span class="widget25__number">
                                                        63%
                                                    </span>
                                                    <div class="progress progress--sm">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: 63%;" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="widget25__desc">
                                                        Sales Growth
                                                    </span>
                                                </div>

                                                <div class="widget25__item">
                                                    <span class="widget25__number">
                                                        39%
                                                    </span>
                                                    <div class="progress m-progress--sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 39%;" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="widget25__desc">
                                                        Product Growth
                                                    </span>
                                                </div>

                                                <div class="widget25__item">
                                                    <span class="widget25__number">
                                                        54%
                                                    </span>
                                                    <div class="progress m-progress--sm">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 54%;" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="widget25__desc">
                                                        Product Growth
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Product Sales-->
                            </div>
                            <div class="col-xl-6">
                                <!--begin:: card-->
                                <div class="card card--height-fluid">
                                    <div class="card-body card__body--fit">
                                        <!--begin::Widget -->
                                        <div class="widget widget--project-1">
                                            <div class="widget__head">
                                                <div class="widget__label">
                                                    <div class="widget__media">
                                                        <span class="media media--lg media--circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL;?>images/client-logos/1.png"
                                                                alt="image">
                                                        </span>
                                                    </div>
                                                    <div class="widget__info">
                                                        <a href="#" class="widget__title">
                                                            Financial Report For Emirates Airlines
                                                        </a>
                                                        <span class="widget__desc">
                                                            Awesome App For Project Management
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-head-toolbar">
                                                    <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                        data-toggle="dropdown">
                                                        <i class="flaticon-more-1"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
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

                                            <div class="widget__body">
                                                <div class="widget__stats">
                                                    <div class="widget__item">
                                                        <span class="widget__date">
                                                            Start Date
                                                        </span>
                                                        <div class="widget__label">
                                                            <span
                                                                class="btn btn-label-brand btn-sm btn-bold btn-upper">07
                                                                may, 18</span>
                                                        </div>
                                                    </div>

                                                    <div class="widget__item">
                                                        <span class="widget__date">
                                                            Due Date
                                                        </span>
                                                        <div class="widget__label">
                                                            <span
                                                                class="btn btn-label-danger btn-sm btn-bold btn-upper">07
                                                                0ct, 18</span>
                                                        </div>
                                                    </div>

                                                    <div class="widget__item flex-fill">
                                                        <span class="widget__subtitel">Progress</span>
                                                        <div class="widget__progress d-flex  align-items-center">
                                                            <div class="progress" style="height: 5px;width: 100%;">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: 78%;" aria-valuenow="100"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="widget__stat">
                                                                78%
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <span class="widget__text">
                                                    I distinguish three main text objecttives.First, your objective
                                                    could
                                                    be merely to inform people.A second be to persuade people.
                                                </span>

                                                <div class="widget__content">
                                                    <div class="widget__details">
                                                        <span class="widget__subtitle">Budget</span>
                                                        <span class="widget__value"><span>$</span>249,500</span>
                                                    </div>

                                                    <div class="widget__details">
                                                        <span class="widget__subtitle">Expances</span>
                                                        <span class="widget__value"><span>$</span>76,810</span>
                                                    </div>

                                                    <div class="widget__details">
                                                        <span class="widget__subtitle">Members</span>

                                                        <div class="media-group">
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="John Myer">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg"
                                                                    alt="image">
                                                            </a>
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="Alison Brandy">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg"
                                                                    alt="image">
                                                            </a>
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="Selina Cranson">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg"
                                                                    alt="image">
                                                            </a>
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="Luke Walls">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg"
                                                                    alt="image">
                                                            </a>
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="Micheal York">
                                                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg"
                                                                    alt="image">
                                                            </a>
                                                            <a href="#" class="media media--sm media--circle"
                                                                data-toggle="tooltip" data-skin="brand"
                                                                data-placement="top" title=""
                                                                data-original-title="Micheal York">
                                                                <span>+3</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget__footer">
                                                <div class="widget__wrapper">
                                                    <div class="widget__section">
                                                        <div class="widget__blog">
                                                            <i class="flaticon2-list-1"></i>
                                                            <a href="#" class="widget__value font-brand">72 Tasks</a>
                                                        </div>
                                                        <div class="widget__blog">
                                                            <i class="flaticon2-talk"></i>
                                                            <a href="#" class="widget__value font-brand">648
                                                                Comments</a>
                                                        </div>
                                                    </div>

                                                    <div class="widget__section">
                                                        <button type="button"
                                                            class="btn btn-brand btn-sm btn-upper btn-bold">details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Widget -->
                                    </div>
                                </div>
                                <!--end:: card-->
                            </div>
                        </div>
                        <!--End::Section-->

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