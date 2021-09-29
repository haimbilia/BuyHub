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

    <body class="fb-body">
        <div class="app">
            <?php
        include 'includes/sidebar.php';
        ?>

            <div class="wrap">
                <?php
        include 'includes/new-header.php';
        ?>
                <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                    <span class="help_label">Help</span>
                </button>

                <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help"
                    aria-hidden="true">

                    <div class="modal-dialog modal-dialog-vertical" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="help-window">
                                            <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/no-data-cuate.svg"
                                                alt="">
                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...</h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.</li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <main class="main">
                    <div class="container">
                        <div class="grid grid--desktop grid--ver grid--ver-desktop app">
                            <!--Begin:: App Aside Mobile Toggle-->
                            <button class="app__aside-close d-none" id="user_profile_aside_close">
                                <i class="la la-close"></i>
                            </button>



                            <div class="grid__item app__toggle app__aside" id="user_profile_aside" style="opacity: 1;">

                                <div class="card card--height-fluid-">

                                    <div class="card-body">
                                        <!--begin::Widget -->
                                        <div class="widget widget--user-profile-1">
                                            <div class="widget__head">
                                                <div class="widget__media">
                                                    <img src="/yokart/manager/images/users/100_4.jpg" alt="image">
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
                                                    <a href="profile-overview.php" class="widget__item ">
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
                                                    <a href="profile-personal-information.php" class="widget__item ">
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
                                                    <a href="profile-account-information.php"
                                                        class="widget__item widget__item--active">
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
                                                    <a href="profile-change-password.php" class="widget__item ">
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
                                                    <a href="profile-email-settings.php" class="widget__item ">
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

                            </div>

                            <div class="grid__item grid__item--fluid app__content">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">

                                            <div class="card-head">

                                                <div class="card-head-label">
                                                    <h3 class="card-head-title">Profile Details</h3>
                                                </div>

                                            </div>



                                            <form id="_form" class="form form-horizontal" novalidate="novalidate">

                                                <div class="card-body">
                                                    <!--begin::Input group-->
                                                    <div class="row form-group justify-content-center">

                                                        <div class="col-lg-3 text-center">
                                                            <!--begin::Image input-->
                                                            <div class="avatar avatar-outline avatar-circle"
                                                                id="user_avatar_3">
                                                                <div class="avatar__holder"
                                                                    style="background-image: url(<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg)">
                                                                </div>
                                                                <label class="avatar__upload" data-toggle="tooltip"
                                                                    title="" data-original-title="Change avatar">
                                                                    <i class="fa fa-pen"></i>
                                                                    <input type="file" name="profile_avatar"
                                                                        accept=".png, .jpg, .jpeg">
                                                                </label>
                                                                <span class="avatar__cancel" data-toggle="tooltip"
                                                                    title="" data-original-title="Cancel avatar">
                                                                    <i class="fa fa-times"></i>
                                                                </span>
                                                            </div>
                                                            <!--end::Image input-->
                                                            <!--begin::Hint-->
                                                            <div class="form-text">Allowed file types: png,
                                                                jpg,
                                                                jpeg.</div>
                                                            <!--end::Hint-->
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label required">Full Name</label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Company</label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Full Name</label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Full Name</label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Contact Phone</label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Company Site </label>
                                                                <input type="text" class="form-control " placeholder=" "
                                                                    value="">
                                                                <!--end::Label-->

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Country </label>

                                                                <select name="country" aria-label="Select a Country"
                                                                    data-control="select2"
                                                                    data-placeholder="Select a country..."
                                                                    class="form-select form-select-solid form-select-lg fw-bold select2-hidden-accessible"
                                                                    data-select2-id="select2-data-10-05tw" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option value=""
                                                                        data-select2-id="select2-data-12-9o7l">Select a
                                                                        Country...</option>
                                                                    <option data-flag="flags/afghanistan.svg" value="AF"
                                                                        data-select2-id="select2-data-85-rj63">
                                                                        Afghanistan</option>
                                                                    <option data-flag="flags/aland-islands.svg"
                                                                        value="AX"
                                                                        data-select2-id="select2-data-86-49hi">Aland
                                                                        Islands</option>
                                                                    <option data-flag="flags/albania.svg" value="AL"
                                                                        data-select2-id="select2-data-87-au6n">Albania
                                                                    </option>
                                                                    <option data-flag="flags/algeria.svg" value="DZ"
                                                                        data-select2-id="select2-data-88-9gnr">Algeria
                                                                    </option>
                                                                    <option data-flag="flags/american-samoa.svg"
                                                                        value="AS"
                                                                        data-select2-id="select2-data-89-ktc6">American
                                                                        Samoa</option>
                                                                    <option data-flag="flags/andorra.svg" value="AD"
                                                                        data-select2-id="select2-data-90-b702">Andorra
                                                                    </option>
                                                                    <option data-flag="flags/angola.svg" value="AO"
                                                                        data-select2-id="select2-data-91-wixq">Angola
                                                                    </option>
                                                                    <option data-flag="flags/anguilla.svg" value="AI"
                                                                        data-select2-id="select2-data-92-9zzk">Anguilla
                                                                    </option>
                                                                    <option data-flag="flags/antigua-and-barbuda.svg"
                                                                        value="AG"
                                                                        data-select2-id="select2-data-93-gqhf">Antigua
                                                                        and Barbuda</option>
                                                                    <option data-flag="flags/argentina.svg" value="AR"
                                                                        data-select2-id="select2-data-94-rmtd">Argentina
                                                                    </option>
                                                                    <option data-flag="flags/armenia.svg" value="AM"
                                                                        data-select2-id="select2-data-95-948k">Armenia
                                                                    </option>
                                                                    <option data-flag="flags/aruba.svg" value="AW"
                                                                        data-select2-id="select2-data-96-nh7v">Aruba
                                                                    </option>
                                                                    <option data-flag="flags/australia.svg" value="AU"
                                                                        data-select2-id="select2-data-97-lzki">Australia
                                                                    </option>
                                                                    <option data-flag="flags/austria.svg" value="AT"
                                                                        data-select2-id="select2-data-98-blf2">Austria
                                                                    </option>
                                                                    <option data-flag="flags/azerbaijan.svg" value="AZ"
                                                                        data-select2-id="select2-data-99-1982">
                                                                        Azerbaijan</option>
                                                                    <option data-flag="flags/bahamas.svg" value="BS"
                                                                        data-select2-id="select2-data-100-t7xs">Bahamas
                                                                    </option>
                                                                    <option data-flag="flags/bahrain.svg" value="BH"
                                                                        data-select2-id="select2-data-101-tv4l">Bahrain
                                                                    </option>
                                                                    <option data-flag="flags/bangladesh.svg" value="BD"
                                                                        data-select2-id="select2-data-102-0pc7">
                                                                        Bangladesh</option>
                                                                    <option data-flag="flags/barbados.svg" value="BB"
                                                                        data-select2-id="select2-data-103-l7as">Barbados
                                                                    </option>
                                                                    <option data-flag="flags/belarus.svg" value="BY"
                                                                        data-select2-id="select2-data-104-b6mg">Belarus
                                                                    </option>
                                                                    <option data-flag="flags/belgium.svg" value="BE"
                                                                        data-select2-id="select2-data-105-hm28">Belgium
                                                                    </option>
                                                                    <option data-flag="flags/belize.svg" value="BZ"
                                                                        data-select2-id="select2-data-106-yh6f">Belize
                                                                    </option>
                                                                    <option data-flag="flags/benin.svg" value="BJ"
                                                                        data-select2-id="select2-data-107-ebqx">Benin
                                                                    </option>
                                                                    <option data-flag="flags/bermuda.svg" value="BM"
                                                                        data-select2-id="select2-data-108-1kdq">Bermuda
                                                                    </option>
                                                                    <option data-flag="flags/bhutan.svg" value="BT"
                                                                        data-select2-id="select2-data-109-ockh">Bhutan
                                                                    </option>
                                                                    <option data-flag="flags/bolivia.svg" value="BO"
                                                                        data-select2-id="select2-data-110-hgmx">Bolivia,
                                                                        Plurinational State of</option>
                                                                    <option data-flag="flags/bonaire.svg" value="BQ"
                                                                        data-select2-id="select2-data-111-qgwf">Bonaire,
                                                                        Sint Eustatius and Saba</option>
                                                                    <option data-flag="flags/bosnia-and-herzegovina.svg"
                                                                        value="BA"
                                                                        data-select2-id="select2-data-112-sq64">Bosnia
                                                                        and Herzegovina</option>
                                                                    <option data-flag="flags/botswana.svg" value="BW"
                                                                        data-select2-id="select2-data-113-53co">Botswana
                                                                    </option>
                                                                    <option data-flag="flags/brazil.svg" value="BR"
                                                                        data-select2-id="select2-data-114-t69m">Brazil
                                                                    </option>
                                                                    <option
                                                                        data-flag="flags/british-indian-ocean-territory.svg"
                                                                        value="IO"
                                                                        data-select2-id="select2-data-115-rgei">British
                                                                        Indian Ocean Territory</option>
                                                                    <option data-flag="flags/brunei.svg" value="BN"
                                                                        data-select2-id="select2-data-116-59vx">Brunei
                                                                        Darussalam</option>
                                                                    <option data-flag="flags/bulgaria.svg" value="BG"
                                                                        data-select2-id="select2-data-117-4v3x">Bulgaria
                                                                    </option>
                                                                    <option data-flag="flags/burkina-faso.svg"
                                                                        value="BF"
                                                                        data-select2-id="select2-data-118-8mms">Burkina
                                                                        Faso</option>
                                                                    <option data-flag="flags/burundi.svg" value="BI"
                                                                        data-select2-id="select2-data-119-3kds">Burundi
                                                                    </option>
                                                                    <option data-flag="flags/cambodia.svg" value="KH"
                                                                        data-select2-id="select2-data-120-o6al">Cambodia
                                                                    </option>
                                                                    <option data-flag="flags/cameroon.svg" value="CM"
                                                                        data-select2-id="select2-data-121-y18j">Cameroon
                                                                    </option>
                                                                    <option data-flag="flags/canada.svg" value="CA"
                                                                        data-select2-id="select2-data-122-iq6g">Canada
                                                                    </option>
                                                                    <option data-flag="flags/cape-verde.svg" value="CV"
                                                                        data-select2-id="select2-data-123-wii1">Cape
                                                                        Verde</option>
                                                                    <option data-flag="flags/cayman-islands.svg"
                                                                        value="KY"
                                                                        data-select2-id="select2-data-124-dqlu">Cayman
                                                                        Islands</option>
                                                                    <option
                                                                        data-flag="flags/central-african-republic.svg"
                                                                        value="CF"
                                                                        data-select2-id="select2-data-125-fr0d">Central
                                                                        African Republic</option>
                                                                    <option data-flag="flags/chad.svg" value="TD"
                                                                        data-select2-id="select2-data-126-t26b">Chad
                                                                    </option>
                                                                    <option data-flag="flags/chile.svg" value="CL"
                                                                        data-select2-id="select2-data-127-4g75">Chile
                                                                    </option>
                                                                    <option data-flag="flags/china.svg" value="CN"
                                                                        data-select2-id="select2-data-128-2ihw">China
                                                                    </option>
                                                                    <option data-flag="flags/christmas-island.svg"
                                                                        value="CX"
                                                                        data-select2-id="select2-data-129-h7ai">
                                                                        Christmas Island</option>
                                                                    <option data-flag="flags/cocos-island.svg"
                                                                        value="CC"
                                                                        data-select2-id="select2-data-130-fx7e">Cocos
                                                                        (Keeling) Islands</option>
                                                                    <option data-flag="flags/colombia.svg" value="CO"
                                                                        data-select2-id="select2-data-131-03by">Colombia
                                                                    </option>
                                                                    <option data-flag="flags/comoros.svg" value="KM"
                                                                        data-select2-id="select2-data-132-brku">Comoros
                                                                    </option>
                                                                    <option data-flag="flags/cook-islands.svg"
                                                                        value="CK"
                                                                        data-select2-id="select2-data-133-jtv2">Cook
                                                                        Islands</option>
                                                                    <option data-flag="flags/costa-rica.svg" value="CR"
                                                                        data-select2-id="select2-data-134-c53z">Costa
                                                                        Rica</option>
                                                                    <option data-flag="flags/ivory-coast.svg" value="CI"
                                                                        data-select2-id="select2-data-135-0nyy">Côte
                                                                        d'Ivoire</option>
                                                                    <option data-flag="flags/croatia.svg" value="HR"
                                                                        data-select2-id="select2-data-136-ab5z">Croatia
                                                                    </option>
                                                                    <option data-flag="flags/cuba.svg" value="CU"
                                                                        data-select2-id="select2-data-137-r3qj">Cuba
                                                                    </option>
                                                                    <option data-flag="flags/curacao.svg" value="CW"
                                                                        data-select2-id="select2-data-138-l3yh">Curaçao
                                                                    </option>
                                                                    <option data-flag="flags/czech-republic.svg"
                                                                        value="CZ"
                                                                        data-select2-id="select2-data-139-8dfc">Czech
                                                                        Republic</option>
                                                                    <option data-flag="flags/denmark.svg" value="DK"
                                                                        data-select2-id="select2-data-140-92sj">Denmark
                                                                    </option>
                                                                    <option data-flag="flags/djibouti.svg" value="DJ"
                                                                        data-select2-id="select2-data-141-noa7">Djibouti
                                                                    </option>
                                                                    <option data-flag="flags/dominica.svg" value="DM"
                                                                        data-select2-id="select2-data-142-xizb">Dominica
                                                                    </option>
                                                                    <option data-flag="flags/dominican-republic.svg"
                                                                        value="DO"
                                                                        data-select2-id="select2-data-143-k6ze">
                                                                        Dominican Republic</option>
                                                                    <option data-flag="flags/ecuador.svg" value="EC"
                                                                        data-select2-id="select2-data-144-0fst">Ecuador
                                                                    </option>
                                                                    <option data-flag="flags/egypt.svg" value="EG"
                                                                        data-select2-id="select2-data-145-q3pq">Egypt
                                                                    </option>
                                                                    <option data-flag="flags/el-salvador.svg" value="SV"
                                                                        data-select2-id="select2-data-146-0fql">El
                                                                        Salvador</option>
                                                                    <option data-flag="flags/equatorial-guinea.svg"
                                                                        value="GQ"
                                                                        data-select2-id="select2-data-147-1do4">
                                                                        Equatorial Guinea</option>
                                                                    <option data-flag="flags/eritrea.svg" value="ER"
                                                                        data-select2-id="select2-data-148-dhrc">Eritrea
                                                                    </option>
                                                                    <option data-flag="flags/estonia.svg" value="EE"
                                                                        data-select2-id="select2-data-149-um31">Estonia
                                                                    </option>
                                                                    <option data-flag="flags/ethiopia.svg" value="ET"
                                                                        data-select2-id="select2-data-150-10jo">Ethiopia
                                                                    </option>
                                                                    <option data-flag="flags/falkland-islands.svg"
                                                                        value="FK"
                                                                        data-select2-id="select2-data-151-lall">Falkland
                                                                        Islands (Malvinas)</option>
                                                                    <option data-flag="flags/fiji.svg" value="FJ"
                                                                        data-select2-id="select2-data-152-kj3j">Fiji
                                                                    </option>
                                                                    <option data-flag="flags/finland.svg" value="FI"
                                                                        data-select2-id="select2-data-153-2x67">Finland
                                                                    </option>
                                                                    <option data-flag="flags/france.svg" value="FR"
                                                                        data-select2-id="select2-data-154-5gpv">France
                                                                    </option>
                                                                    <option data-flag="flags/french-polynesia.svg"
                                                                        value="PF"
                                                                        data-select2-id="select2-data-155-eh5s">French
                                                                        Polynesia</option>
                                                                    <option data-flag="flags/gabon.svg" value="GA"
                                                                        data-select2-id="select2-data-156-5yp9">Gabon
                                                                    </option>
                                                                    <option data-flag="flags/gambia.svg" value="GM"
                                                                        data-select2-id="select2-data-157-anyv">Gambia
                                                                    </option>
                                                                    <option data-flag="flags/georgia.svg" value="GE"
                                                                        data-select2-id="select2-data-158-8759">Georgia
                                                                    </option>
                                                                    <option data-flag="flags/germany.svg" value="DE"
                                                                        data-select2-id="select2-data-159-dzud">Germany
                                                                    </option>
                                                                    <option data-flag="flags/ghana.svg" value="GH"
                                                                        data-select2-id="select2-data-160-rqy9">Ghana
                                                                    </option>
                                                                    <option data-flag="flags/gibraltar.svg" value="GI"
                                                                        data-select2-id="select2-data-161-j33b">
                                                                        Gibraltar</option>
                                                                    <option data-flag="flags/greece.svg" value="GR"
                                                                        data-select2-id="select2-data-162-g8n5">Greece
                                                                    </option>
                                                                    <option data-flag="flags/greenland.svg" value="GL"
                                                                        data-select2-id="select2-data-163-obvi">
                                                                        Greenland</option>
                                                                    <option data-flag="flags/grenada.svg" value="GD"
                                                                        data-select2-id="select2-data-164-waxl">Grenada
                                                                    </option>
                                                                    <option data-flag="flags/guam.svg" value="GU"
                                                                        data-select2-id="select2-data-165-d5mt">Guam
                                                                    </option>
                                                                    <option data-flag="flags/guatemala.svg" value="GT"
                                                                        data-select2-id="select2-data-166-c0d6">
                                                                        Guatemala</option>
                                                                    <option data-flag="flags/guernsey.svg" value="GG"
                                                                        data-select2-id="select2-data-167-n6e0">Guernsey
                                                                    </option>
                                                                    <option data-flag="flags/guinea.svg" value="GN"
                                                                        data-select2-id="select2-data-168-9na9">Guinea
                                                                    </option>
                                                                    <option data-flag="flags/guinea-bissau.svg"
                                                                        value="GW"
                                                                        data-select2-id="select2-data-169-d6hv">
                                                                        Guinea-Bissau</option>
                                                                    <option data-flag="flags/haiti.svg" value="HT"
                                                                        data-select2-id="select2-data-170-4d5b">Haiti
                                                                    </option>
                                                                    <option data-flag="flags/vatican-city.svg"
                                                                        value="VA"
                                                                        data-select2-id="select2-data-171-q44w">Holy See
                                                                        (Vatican City State)</option>
                                                                    <option data-flag="flags/honduras.svg" value="HN"
                                                                        data-select2-id="select2-data-172-hgya">Honduras
                                                                    </option>
                                                                    <option data-flag="flags/hong-kong.svg" value="HK"
                                                                        data-select2-id="select2-data-173-01g2">Hong
                                                                        Kong</option>
                                                                    <option data-flag="flags/hungary.svg" value="HU"
                                                                        data-select2-id="select2-data-174-lril">Hungary
                                                                    </option>
                                                                    <option data-flag="flags/iceland.svg" value="IS"
                                                                        data-select2-id="select2-data-175-2tgc">Iceland
                                                                    </option>
                                                                    <option data-flag="flags/india.svg" value="IN"
                                                                        data-select2-id="select2-data-176-34yp">India
                                                                    </option>
                                                                    <option data-flag="flags/indonesia.svg" value="ID"
                                                                        data-select2-id="select2-data-177-z5gl">
                                                                        Indonesia</option>
                                                                    <option data-flag="flags/iran.svg" value="IR"
                                                                        data-select2-id="select2-data-178-e4pu">Iran,
                                                                        Islamic Republic of</option>
                                                                    <option data-flag="flags/iraq.svg" value="IQ"
                                                                        data-select2-id="select2-data-179-n6rx">Iraq
                                                                    </option>
                                                                    <option data-flag="flags/ireland.svg" value="IE"
                                                                        data-select2-id="select2-data-180-67kc">Ireland
                                                                    </option>
                                                                    <option data-flag="flags/isle-of-man.svg" value="IM"
                                                                        data-select2-id="select2-data-181-ztnb">Isle of
                                                                        Man</option>
                                                                    <option data-flag="flags/israel.svg" value="IL"
                                                                        data-select2-id="select2-data-182-60ef">Israel
                                                                    </option>
                                                                    <option data-flag="flags/italy.svg" value="IT"
                                                                        data-select2-id="select2-data-183-17hq">Italy
                                                                    </option>
                                                                    <option data-flag="flags/jamaica.svg" value="JM"
                                                                        data-select2-id="select2-data-184-1u9h">Jamaica
                                                                    </option>
                                                                    <option data-flag="flags/japan.svg" value="JP"
                                                                        data-select2-id="select2-data-185-id9k">Japan
                                                                    </option>
                                                                    <option data-flag="flags/jersey.svg" value="JE"
                                                                        data-select2-id="select2-data-186-y4if">Jersey
                                                                    </option>
                                                                    <option data-flag="flags/jordan.svg" value="JO"
                                                                        data-select2-id="select2-data-187-t7aa">Jordan
                                                                    </option>
                                                                    <option data-flag="flags/kazakhstan.svg" value="KZ"
                                                                        data-select2-id="select2-data-188-xhgq">
                                                                        Kazakhstan</option>
                                                                    <option data-flag="flags/kenya.svg" value="KE"
                                                                        data-select2-id="select2-data-189-newy">Kenya
                                                                    </option>
                                                                    <option data-flag="flags/kiribati.svg" value="KI"
                                                                        data-select2-id="select2-data-190-5hdk">Kiribati
                                                                    </option>
                                                                    <option data-flag="flags/north-korea.svg" value="KP"
                                                                        data-select2-id="select2-data-191-rcsm">Korea,
                                                                        Democratic People's Republic of</option>
                                                                    <option data-flag="flags/kuwait.svg" value="KW"
                                                                        data-select2-id="select2-data-192-akki">Kuwait
                                                                    </option>
                                                                    <option data-flag="flags/kyrgyzstan.svg" value="KG"
                                                                        data-select2-id="select2-data-193-atju">
                                                                        Kyrgyzstan</option>
                                                                    <option data-flag="flags/laos.svg" value="LA"
                                                                        data-select2-id="select2-data-194-mple">Lao
                                                                        People's Democratic Republic</option>
                                                                    <option data-flag="flags/latvia.svg" value="LV"
                                                                        data-select2-id="select2-data-195-da4z">Latvia
                                                                    </option>
                                                                    <option data-flag="flags/lebanon.svg" value="LB"
                                                                        data-select2-id="select2-data-196-fwef">Lebanon
                                                                    </option>
                                                                    <option data-flag="flags/lesotho.svg" value="LS"
                                                                        data-select2-id="select2-data-197-30q7">Lesotho
                                                                    </option>
                                                                    <option data-flag="flags/liberia.svg" value="LR"
                                                                        data-select2-id="select2-data-198-l2pw">Liberia
                                                                    </option>
                                                                    <option data-flag="flags/libya.svg" value="LY"
                                                                        data-select2-id="select2-data-199-81az">Libya
                                                                    </option>
                                                                    <option data-flag="flags/liechtenstein.svg"
                                                                        value="LI"
                                                                        data-select2-id="select2-data-200-m3dc">
                                                                        Liechtenstein</option>
                                                                    <option data-flag="flags/lithuania.svg" value="LT"
                                                                        data-select2-id="select2-data-201-vtdo">
                                                                        Lithuania</option>
                                                                    <option data-flag="flags/luxembourg.svg" value="LU"
                                                                        data-select2-id="select2-data-202-phaj">
                                                                        Luxembourg</option>
                                                                    <option data-flag="flags/macao.svg" value="MO"
                                                                        data-select2-id="select2-data-203-o1ih">Macao
                                                                    </option>
                                                                    <option data-flag="flags/madagascar.svg" value="MG"
                                                                        data-select2-id="select2-data-204-4uw9">
                                                                        Madagascar</option>
                                                                    <option data-flag="flags/malawi.svg" value="MW"
                                                                        data-select2-id="select2-data-205-ohrk">Malawi
                                                                    </option>
                                                                    <option data-flag="flags/malaysia.svg" value="MY"
                                                                        data-select2-id="select2-data-206-2cf7">Malaysia
                                                                    </option>
                                                                    <option data-flag="flags/maldives.svg" value="MV"
                                                                        data-select2-id="select2-data-207-hqyw">Maldives
                                                                    </option>
                                                                    <option data-flag="flags/mali.svg" value="ML"
                                                                        data-select2-id="select2-data-208-2dnb">Mali
                                                                    </option>
                                                                    <option data-flag="flags/malta.svg" value="MT"
                                                                        data-select2-id="select2-data-209-hvcu">Malta
                                                                    </option>
                                                                    <option data-flag="flags/marshall-island.svg"
                                                                        value="MH"
                                                                        data-select2-id="select2-data-210-yhl8">Marshall
                                                                        Islands</option>
                                                                    <option data-flag="flags/martinique.svg" value="MQ"
                                                                        data-select2-id="select2-data-211-vhft">
                                                                        Martinique</option>
                                                                    <option data-flag="flags/mauritania.svg" value="MR"
                                                                        data-select2-id="select2-data-212-ojj0">
                                                                        Mauritania</option>
                                                                    <option data-flag="flags/mauritius.svg" value="MU"
                                                                        data-select2-id="select2-data-213-b0r5">
                                                                        Mauritius</option>
                                                                    <option data-flag="flags/mexico.svg" value="MX"
                                                                        data-select2-id="select2-data-214-26sa">Mexico
                                                                    </option>
                                                                    <option data-flag="flags/micronesia.svg" value="FM"
                                                                        data-select2-id="select2-data-215-du51">
                                                                        Micronesia, Federated States of</option>
                                                                    <option data-flag="flags/moldova.svg" value="MD"
                                                                        data-select2-id="select2-data-216-pbrg">Moldova,
                                                                        Republic of</option>
                                                                    <option data-flag="flags/monaco.svg" value="MC"
                                                                        data-select2-id="select2-data-217-itwj">Monaco
                                                                    </option>
                                                                    <option data-flag="flags/mongolia.svg" value="MN"
                                                                        data-select2-id="select2-data-218-gtpl">Mongolia
                                                                    </option>
                                                                    <option data-flag="flags/montenegro.svg" value="ME"
                                                                        data-select2-id="select2-data-219-b86b">
                                                                        Montenegro</option>
                                                                    <option data-flag="flags/montserrat.svg" value="MS"
                                                                        data-select2-id="select2-data-220-7bdv">
                                                                        Montserrat</option>
                                                                    <option data-flag="flags/morocco.svg" value="MA"
                                                                        data-select2-id="select2-data-221-2mru">Morocco
                                                                    </option>
                                                                    <option data-flag="flags/mozambique.svg" value="MZ"
                                                                        data-select2-id="select2-data-222-4j9c">
                                                                        Mozambique</option>
                                                                    <option data-flag="flags/myanmar.svg" value="MM"
                                                                        data-select2-id="select2-data-223-9qe9">Myanmar
                                                                    </option>
                                                                    <option data-flag="flags/namibia.svg" value="NA"
                                                                        data-select2-id="select2-data-224-k8e5">Namibia
                                                                    </option>
                                                                    <option data-flag="flags/nauru.svg" value="NR"
                                                                        data-select2-id="select2-data-225-e9bc">Nauru
                                                                    </option>
                                                                    <option data-flag="flags/nepal.svg" value="NP"
                                                                        data-select2-id="select2-data-226-hyn4">Nepal
                                                                    </option>
                                                                    <option data-flag="flags/netherlands.svg" value="NL"
                                                                        data-select2-id="select2-data-227-99y9">
                                                                        Netherlands</option>
                                                                    <option data-flag="flags/new-zealand.svg" value="NZ"
                                                                        data-select2-id="select2-data-228-w45t">New
                                                                        Zealand</option>
                                                                    <option data-flag="flags/nicaragua.svg" value="NI"
                                                                        data-select2-id="select2-data-229-b9bx">
                                                                        Nicaragua</option>
                                                                    <option data-flag="flags/niger.svg" value="NE"
                                                                        data-select2-id="select2-data-230-cam3">Niger
                                                                    </option>
                                                                    <option data-flag="flags/nigeria.svg" value="NG"
                                                                        data-select2-id="select2-data-231-ypwc">Nigeria
                                                                    </option>
                                                                    <option data-flag="flags/niue.svg" value="NU"
                                                                        data-select2-id="select2-data-232-aez6">Niue
                                                                    </option>
                                                                    <option data-flag="flags/norfolk-island.svg"
                                                                        value="NF"
                                                                        data-select2-id="select2-data-233-c25q">Norfolk
                                                                        Island</option>
                                                                    <option
                                                                        data-flag="flags/northern-mariana-islands.svg"
                                                                        value="MP"
                                                                        data-select2-id="select2-data-234-z7wy">Northern
                                                                        Mariana Islands</option>
                                                                    <option data-flag="flags/norway.svg" value="NO"
                                                                        data-select2-id="select2-data-235-dj8x">Norway
                                                                    </option>
                                                                    <option data-flag="flags/oman.svg" value="OM"
                                                                        data-select2-id="select2-data-236-65cn">Oman
                                                                    </option>
                                                                    <option data-flag="flags/pakistan.svg" value="PK"
                                                                        data-select2-id="select2-data-237-d4n3">Pakistan
                                                                    </option>
                                                                    <option data-flag="flags/palau.svg" value="PW"
                                                                        data-select2-id="select2-data-238-il3z">Palau
                                                                    </option>
                                                                    <option data-flag="flags/palestine.svg" value="PS"
                                                                        data-select2-id="select2-data-239-y6o5">
                                                                        Palestinian Territory, Occupied</option>
                                                                    <option data-flag="flags/panama.svg" value="PA"
                                                                        data-select2-id="select2-data-240-hfsn">Panama
                                                                    </option>
                                                                    <option data-flag="flags/papua-new-guinea.svg"
                                                                        value="PG"
                                                                        data-select2-id="select2-data-241-bl8q">Papua
                                                                        New Guinea</option>
                                                                    <option data-flag="flags/paraguay.svg" value="PY"
                                                                        data-select2-id="select2-data-242-t9x6">Paraguay
                                                                    </option>
                                                                    <option data-flag="flags/peru.svg" value="PE"
                                                                        data-select2-id="select2-data-243-vxca">Peru
                                                                    </option>
                                                                    <option data-flag="flags/philippines.svg" value="PH"
                                                                        data-select2-id="select2-data-244-ekrc">
                                                                        Philippines</option>
                                                                    <option data-flag="flags/poland.svg" value="PL"
                                                                        data-select2-id="select2-data-245-sken">Poland
                                                                    </option>
                                                                    <option data-flag="flags/portugal.svg" value="PT"
                                                                        data-select2-id="select2-data-246-yg2q">Portugal
                                                                    </option>
                                                                    <option data-flag="flags/puerto-rico.svg" value="PR"
                                                                        data-select2-id="select2-data-247-qq68">Puerto
                                                                        Rico</option>
                                                                    <option data-flag="flags/qatar.svg" value="QA"
                                                                        data-select2-id="select2-data-248-lrgn">Qatar
                                                                    </option>
                                                                    <option data-flag="flags/romania.svg" value="RO"
                                                                        data-select2-id="select2-data-249-cwo9">Romania
                                                                    </option>
                                                                    <option data-flag="flags/russia.svg" value="RU"
                                                                        data-select2-id="select2-data-250-tqtx">Russian
                                                                        Federation</option>
                                                                    <option data-flag="flags/rwanda.svg" value="RW"
                                                                        data-select2-id="select2-data-251-6kxy">Rwanda
                                                                    </option>
                                                                    <option data-flag="flags/st-barts.svg" value="BL"
                                                                        data-select2-id="select2-data-252-7mje">Saint
                                                                        Barthélemy</option>
                                                                    <option data-flag="flags/saint-kitts-and-nevis.svg"
                                                                        value="KN"
                                                                        data-select2-id="select2-data-253-ct41">Saint
                                                                        Kitts and Nevis</option>
                                                                    <option data-flag="flags/st-lucia.svg" value="LC"
                                                                        data-select2-id="select2-data-254-zkf4">Saint
                                                                        Lucia</option>
                                                                    <option data-flag="flags/sint-maarten.svg"
                                                                        value="MF"
                                                                        data-select2-id="select2-data-255-yyrg">Saint
                                                                        Martin (French part)</option>
                                                                    <option
                                                                        data-flag="flags/st-vincent-and-the-grenadines.svg"
                                                                        value="VC"
                                                                        data-select2-id="select2-data-256-rlj5">Saint
                                                                        Vincent and the Grenadines</option>
                                                                    <option data-flag="flags/samoa.svg" value="WS"
                                                                        data-select2-id="select2-data-257-e51j">Samoa
                                                                    </option>
                                                                    <option data-flag="flags/san-marino.svg" value="SM"
                                                                        data-select2-id="select2-data-258-jbx7">San
                                                                        Marino</option>
                                                                    <option data-flag="flags/sao-tome-and-prince.svg"
                                                                        value="ST"
                                                                        data-select2-id="select2-data-259-gi5q">Sao Tome
                                                                        and Principe</option>
                                                                    <option data-flag="flags/saudi-arabia.svg"
                                                                        value="SA"
                                                                        data-select2-id="select2-data-260-v9p1">Saudi
                                                                        Arabia</option>
                                                                    <option data-flag="flags/senegal.svg" value="SN"
                                                                        data-select2-id="select2-data-261-b88o">Senegal
                                                                    </option>
                                                                    <option data-flag="flags/serbia.svg" value="RS"
                                                                        data-select2-id="select2-data-262-ftrm">Serbia
                                                                    </option>
                                                                    <option data-flag="flags/seychelles.svg" value="SC"
                                                                        data-select2-id="select2-data-263-ite9">
                                                                        Seychelles</option>
                                                                    <option data-flag="flags/sierra-leone.svg"
                                                                        value="SL"
                                                                        data-select2-id="select2-data-264-d1rz">Sierra
                                                                        Leone</option>
                                                                    <option data-flag="flags/singapore.svg" value="SG"
                                                                        data-select2-id="select2-data-265-0ksm">
                                                                        Singapore</option>
                                                                    <option data-flag="flags/sint-maarten.svg"
                                                                        value="SX"
                                                                        data-select2-id="select2-data-266-8x5z">Sint
                                                                        Maarten (Dutch part)</option>
                                                                    <option data-flag="flags/slovakia.svg" value="SK"
                                                                        data-select2-id="select2-data-267-7q70">Slovakia
                                                                    </option>
                                                                    <option data-flag="flags/slovenia.svg" value="SI"
                                                                        data-select2-id="select2-data-268-6k6a">Slovenia
                                                                    </option>
                                                                    <option data-flag="flags/solomon-islands.svg"
                                                                        value="SB"
                                                                        data-select2-id="select2-data-269-bzi2">Solomon
                                                                        Islands</option>
                                                                    <option data-flag="flags/somalia.svg" value="SO"
                                                                        data-select2-id="select2-data-270-42zq">Somalia
                                                                    </option>
                                                                    <option data-flag="flags/south-africa.svg"
                                                                        value="ZA"
                                                                        data-select2-id="select2-data-271-449l">South
                                                                        Africa</option>
                                                                    <option data-flag="flags/south-korea.svg" value="KR"
                                                                        data-select2-id="select2-data-272-vwct">South
                                                                        Korea</option>
                                                                    <option data-flag="flags/south-sudan.svg" value="SS"
                                                                        data-select2-id="select2-data-273-wnmn">South
                                                                        Sudan</option>
                                                                    <option data-flag="flags/spain.svg" value="ES"
                                                                        data-select2-id="select2-data-274-xgyv">Spain
                                                                    </option>
                                                                    <option data-flag="flags/sri-lanka.svg" value="LK"
                                                                        data-select2-id="select2-data-275-gp3t">Sri
                                                                        Lanka</option>
                                                                    <option data-flag="flags/sudan.svg" value="SD"
                                                                        data-select2-id="select2-data-276-id23">Sudan
                                                                    </option>
                                                                    <option data-flag="flags/suriname.svg" value="SR"
                                                                        data-select2-id="select2-data-277-fepa">Suriname
                                                                    </option>
                                                                    <option data-flag="flags/swaziland.svg" value="SZ"
                                                                        data-select2-id="select2-data-278-r1s9">
                                                                        Swaziland</option>
                                                                    <option data-flag="flags/sweden.svg" value="SE"
                                                                        data-select2-id="select2-data-279-wssd">Sweden
                                                                    </option>
                                                                    <option data-flag="flags/switzerland.svg" value="CH"
                                                                        data-select2-id="select2-data-280-2pfk">
                                                                        Switzerland</option>
                                                                    <option data-flag="flags/syria.svg" value="SY"
                                                                        data-select2-id="select2-data-281-a6im">Syrian
                                                                        Arab Republic</option>
                                                                    <option data-flag="flags/taiwan.svg" value="TW"
                                                                        data-select2-id="select2-data-282-18t6">Taiwan,
                                                                        Province of China</option>
                                                                    <option data-flag="flags/tajikistan.svg" value="TJ"
                                                                        data-select2-id="select2-data-283-c4m7">
                                                                        Tajikistan</option>
                                                                    <option data-flag="flags/tanzania.svg" value="TZ"
                                                                        data-select2-id="select2-data-284-li3u">
                                                                        Tanzania, United Republic of</option>
                                                                    <option data-flag="flags/thailand.svg" value="TH"
                                                                        data-select2-id="select2-data-285-l0pp">Thailand
                                                                    </option>
                                                                    <option data-flag="flags/togo.svg" value="TG"
                                                                        data-select2-id="select2-data-286-0019">Togo
                                                                    </option>
                                                                    <option data-flag="flags/tokelau.svg" value="TK"
                                                                        data-select2-id="select2-data-287-ebso">Tokelau
                                                                    </option>
                                                                    <option data-flag="flags/tonga.svg" value="TO"
                                                                        data-select2-id="select2-data-288-yovi">Tonga
                                                                    </option>
                                                                    <option data-flag="flags/trinidad-and-tobago.svg"
                                                                        value="TT"
                                                                        data-select2-id="select2-data-289-s4k3">Trinidad
                                                                        and Tobago</option>
                                                                    <option data-flag="flags/tunisia.svg" value="TN"
                                                                        data-select2-id="select2-data-290-8jv9">Tunisia
                                                                    </option>
                                                                    <option data-flag="flags/turkey.svg" value="TR"
                                                                        data-select2-id="select2-data-291-oudi">Turkey
                                                                    </option>
                                                                    <option data-flag="flags/turkmenistan.svg"
                                                                        value="TM"
                                                                        data-select2-id="select2-data-292-hu3m">
                                                                        Turkmenistan</option>
                                                                    <option data-flag="flags/turks-and-caicos.svg"
                                                                        value="TC"
                                                                        data-select2-id="select2-data-293-fu7a">Turks
                                                                        and Caicos Islands</option>
                                                                    <option data-flag="flags/tuvalu.svg" value="TV"
                                                                        data-select2-id="select2-data-294-3asw">Tuvalu
                                                                    </option>
                                                                    <option data-flag="flags/uganda.svg" value="UG"
                                                                        data-select2-id="select2-data-295-g1rp">Uganda
                                                                    </option>
                                                                    <option data-flag="flags/ukraine.svg" value="UA"
                                                                        data-select2-id="select2-data-296-mu4r">Ukraine
                                                                    </option>
                                                                    <option data-flag="flags/united-arab-emirates.svg"
                                                                        value="AE"
                                                                        data-select2-id="select2-data-297-ke56">United
                                                                        Arab Emirates</option>
                                                                    <option data-flag="flags/united-kingdom.svg"
                                                                        value="GB"
                                                                        data-select2-id="select2-data-298-g3ly">United
                                                                        Kingdom</option>
                                                                    <option data-flag="flags/united-states.svg"
                                                                        value="US"
                                                                        data-select2-id="select2-data-299-6o6j">United
                                                                        States</option>
                                                                    <option data-flag="flags/uruguay.svg" value="UY"
                                                                        data-select2-id="select2-data-300-ti37">Uruguay
                                                                    </option>
                                                                    <option data-flag="flags/uzbekistan.svg" value="UZ"
                                                                        data-select2-id="select2-data-301-067q">
                                                                        Uzbekistan</option>
                                                                    <option data-flag="flags/vanuatu.svg" value="VU"
                                                                        data-select2-id="select2-data-302-mnji">Vanuatu
                                                                    </option>
                                                                    <option data-flag="flags/venezuela.svg" value="VE"
                                                                        data-select2-id="select2-data-303-o0ip">
                                                                        Venezuela, Bolivarian Republic of</option>
                                                                    <option data-flag="flags/vietnam.svg" value="VN"
                                                                        data-select2-id="select2-data-304-14ka">Vietnam
                                                                    </option>
                                                                    <option data-flag="flags/virgin-islands.svg"
                                                                        value="VI"
                                                                        data-select2-id="select2-data-305-6ohb">Virgin
                                                                        Islands</option>
                                                                    <option data-flag="flags/yemen.svg" value="YE"
                                                                        data-select2-id="select2-data-306-ccpf">Yemen
                                                                    </option>
                                                                    <option data-flag="flags/zambia.svg" value="ZM"
                                                                        data-select2-id="select2-data-307-za0j">Zambia
                                                                    </option>
                                                                    <option data-flag="flags/zimbabwe.svg" value="ZW"
                                                                        data-select2-id="select2-data-308-dmbt">Zimbabwe
                                                                    </option>
                                                                </select>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Language</label>
                                                                <select name="language" aria-label="Select a Language"
                                                                    data-control="select2"
                                                                    data-placeholder="Select a language..."
                                                                    class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                                                                    data-select2-id="select2-data-13-roqs" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option value=""
                                                                        data-select2-id="select2-data-15-2j21">Select a
                                                                        Language...</option>
                                                                    <option data-flag="flags/indonesia.svg" value="id"
                                                                        data-select2-id="select2-data-313-cf0i">Bahasa
                                                                        Indonesia - Indonesian</option>
                                                                    <option data-flag="flags/malaysia.svg" value="msa"
                                                                        data-select2-id="select2-data-314-ts07">Bahasa
                                                                        Melayu - Malay</option>
                                                                    <option data-flag="flags/canada.svg" value="ca"
                                                                        data-select2-id="select2-data-315-5z2y">Català -
                                                                        Catalan</option>
                                                                    <option data-flag="flags/czech-republic.svg"
                                                                        value="cs"
                                                                        data-select2-id="select2-data-316-3xmd">Čeština
                                                                        - Czech</option>
                                                                    <option data-flag="flags/netherlands.svg" value="da"
                                                                        data-select2-id="select2-data-317-v8z6">Dansk -
                                                                        Danish</option>
                                                                    <option data-flag="flags/germany.svg" value="de"
                                                                        data-select2-id="select2-data-318-90jt">Deutsch
                                                                        - German</option>
                                                                    <option data-flag="flags/united-kingdom.svg"
                                                                        value="en"
                                                                        data-select2-id="select2-data-319-wspg">English
                                                                    </option>
                                                                    <option data-flag="flags/united-kingdom.svg"
                                                                        value="en-gb"
                                                                        data-select2-id="select2-data-320-dhpm">English
                                                                        UK - British English</option>
                                                                    <option data-flag="flags/spain.svg" value="es"
                                                                        data-select2-id="select2-data-321-l3ym">Español
                                                                        - Spanish</option>
                                                                    <option data-flag="flags/philippines.svg"
                                                                        value="fil"
                                                                        data-select2-id="select2-data-322-sfd2">Filipino
                                                                    </option>
                                                                    <option data-flag="flags/france.svg" value="fr"
                                                                        data-select2-id="select2-data-323-67eq">Français
                                                                        - French</option>
                                                                    <option data-flag="flags/gabon.svg" value="ga"
                                                                        data-select2-id="select2-data-324-3vmb">Gaeilge
                                                                        - Irish (beta)</option>
                                                                    <option data-flag="flags/greenland.svg" value="gl"
                                                                        data-select2-id="select2-data-325-d1ds">Galego -
                                                                        Galician (beta)</option>
                                                                    <option data-flag="flags/croatia.svg" value="hr"
                                                                        data-select2-id="select2-data-326-r5b2">Hrvatski
                                                                        - Croatian</option>
                                                                    <option data-flag="flags/italy.svg" value="it"
                                                                        data-select2-id="select2-data-327-4d50">Italiano
                                                                        - Italian</option>
                                                                    <option data-flag="flags/hungary.svg" value="hu"
                                                                        data-select2-id="select2-data-328-wxi8">Magyar -
                                                                        Hungarian</option>
                                                                    <option data-flag="flags/netherlands.svg" value="nl"
                                                                        data-select2-id="select2-data-329-bzr8">
                                                                        Nederlands - Dutch</option>
                                                                    <option data-flag="flags/norway.svg" value="no"
                                                                        data-select2-id="select2-data-330-li2q">Norsk -
                                                                        Norwegian</option>
                                                                    <option data-flag="flags/poland.svg" value="pl"
                                                                        data-select2-id="select2-data-331-2ya8">Polski -
                                                                        Polish</option>
                                                                    <option data-flag="flags/portugal.svg" value="pt"
                                                                        data-select2-id="select2-data-332-6xgo">
                                                                        Português - Portuguese</option>
                                                                    <option data-flag="flags/romania.svg" value="ro"
                                                                        data-select2-id="select2-data-333-xk7k">Română -
                                                                        Romanian</option>
                                                                    <option data-flag="flags/slovakia.svg" value="sk"
                                                                        data-select2-id="select2-data-334-ec5x">
                                                                        Slovenčina - Slovak</option>
                                                                    <option data-flag="flags/finland.svg" value="fi"
                                                                        data-select2-id="select2-data-335-y5zm">Suomi -
                                                                        Finnish</option>
                                                                    <option data-flag="flags/el-salvador.svg" value="sv"
                                                                        data-select2-id="select2-data-336-hmpe">Svenska
                                                                        - Swedish</option>
                                                                    <option data-flag="flags/virgin-islands.svg"
                                                                        value="vi"
                                                                        data-select2-id="select2-data-337-e7is">Tiếng
                                                                        Việt - Vietnamese</option>
                                                                    <option data-flag="flags/turkey.svg" value="tr"
                                                                        data-select2-id="select2-data-338-e8vt">Türkçe -
                                                                        Turkish</option>
                                                                    <option data-flag="flags/greece.svg" value="el"
                                                                        data-select2-id="select2-data-339-3h3c">Ελληνικά
                                                                        - Greek</option>
                                                                    <option data-flag="flags/bulgaria.svg" value="bg"
                                                                        data-select2-id="select2-data-340-g35c">
                                                                        Български език - Bulgarian</option>
                                                                    <option data-flag="flags/russia.svg" value="ru"
                                                                        data-select2-id="select2-data-341-ek68">Русский
                                                                        - Russian</option>
                                                                    <option data-flag="flags/suriname.svg" value="sr"
                                                                        data-select2-id="select2-data-342-ensf">Српски -
                                                                        Serbian</option>
                                                                    <option data-flag="flags/ukraine.svg" value="uk"
                                                                        data-select2-id="select2-data-343-u3n3">
                                                                        Українська мова - Ukrainian</option>
                                                                    <option data-flag="flags/israel.svg" value="he"
                                                                        data-select2-id="select2-data-344-uf4e">עִבְרִית
                                                                        - Hebrew</option>
                                                                    <option data-flag="flags/pakistan.svg" value="ur"
                                                                        data-select2-id="select2-data-345-oghb">اردو -
                                                                        Urdu (beta)</option>
                                                                    <option data-flag="flags/argentina.svg" value="ar"
                                                                        data-select2-id="select2-data-346-yc4e">العربية
                                                                        - Arabic</option>
                                                                    <option data-flag="flags/argentina.svg" value="fa"
                                                                        data-select2-id="select2-data-347-9p3u">فارسی -
                                                                        Persian</option>
                                                                    <option data-flag="flags/mauritania.svg" value="mr"
                                                                        data-select2-id="select2-data-348-kpgg">मराठी -
                                                                        Marathi</option>
                                                                    <option data-flag="flags/india.svg" value="hi"
                                                                        data-select2-id="select2-data-349-yhl8">हिन्दी -
                                                                        Hindi</option>
                                                                    <option data-flag="flags/bangladesh.svg" value="bn"
                                                                        data-select2-id="select2-data-350-eag2">বাংলা -
                                                                        Bangla</option>
                                                                    <option data-flag="flags/guam.svg" value="gu"
                                                                        data-select2-id="select2-data-351-gh3n">ગુજરાતી
                                                                        - Gujarati</option>
                                                                    <option data-flag="flags/india.svg" value="ta"
                                                                        data-select2-id="select2-data-352-4w6a">தமிழ் -
                                                                        Tamil</option>
                                                                    <option data-flag="flags/saint-kitts-and-nevis.svg"
                                                                        value="kn"
                                                                        data-select2-id="select2-data-353-uaup">ಕನ್ನಡ -
                                                                        Kannada</option>
                                                                    <option data-flag="flags/thailand.svg" value="th"
                                                                        data-select2-id="select2-data-354-11y4">ภาษาไทย
                                                                        - Thai</option>
                                                                    <option data-flag="flags/south-korea.svg" value="ko"
                                                                        data-select2-id="select2-data-355-zt73">한국어 -
                                                                        Korean</option>
                                                                    <option data-flag="flags/japan.svg" value="ja"
                                                                        data-select2-id="select2-data-356-94xb">日本語 -
                                                                        Japanese</option>
                                                                    <option data-flag="flags/china.svg" value="zh-cn"
                                                                        data-select2-id="select2-data-357-c1q2">简体中文 -
                                                                        Simplified Chinese</option>
                                                                    <option data-flag="flags/taiwan.svg" value="zh-tw"
                                                                        data-select2-id="select2-data-358-8cr9">繁體中文 -
                                                                        Traditional Chinese</option>
                                                                </select>
                                                                <!--end::Label-->

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Time Zone </label>
                                                                <select name="timezone" aria-label="Select a Timezone"
                                                                    data-control="select2"
                                                                    data-placeholder="Select a timezone.."
                                                                    class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                                                                    data-select2-id="select2-data-16-clw5" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option value=""
                                                                        data-select2-id="select2-data-18-f0s1">Select a
                                                                        Timezone..</option>
                                                                    <option data-bs-offset="-39600"
                                                                        value="International Date Line West"
                                                                        data-select2-id="select2-data-360-brf3">
                                                                        (GMT-11:00) International Date Line West
                                                                    </option>
                                                                    <option data-bs-offset="-39600"
                                                                        value="Midway Island"
                                                                        data-select2-id="select2-data-361-vd7j">
                                                                        (GMT-11:00) Midway Island</option>
                                                                    <option data-bs-offset="-39600" value="Samoa"
                                                                        data-select2-id="select2-data-362-jvpk">
                                                                        (GMT-11:00) Samoa</option>
                                                                    <option data-bs-offset="-36000" value="Hawaii"
                                                                        data-select2-id="select2-data-363-191z">
                                                                        (GMT-10:00) Hawaii</option>
                                                                    <option data-bs-offset="-28800" value="Alaska"
                                                                        data-select2-id="select2-data-364-no9u">
                                                                        (GMT-08:00) Alaska</option>
                                                                    <option data-bs-offset="-25200"
                                                                        value="Pacific Time (US &amp; Canada)"
                                                                        data-select2-id="select2-data-365-jhce">
                                                                        (GMT-07:00) Pacific Time (US &amp; Canada)
                                                                    </option>
                                                                    <option data-bs-offset="-25200" value="Tijuana"
                                                                        data-select2-id="select2-data-366-fd0n">
                                                                        (GMT-07:00) Tijuana</option>
                                                                    <option data-bs-offset="-25200" value="Arizona"
                                                                        data-select2-id="select2-data-367-u0hy">
                                                                        (GMT-07:00) Arizona</option>
                                                                    <option data-bs-offset="-21600"
                                                                        value="Mountain Time (US &amp; Canada)"
                                                                        data-select2-id="select2-data-368-mwsu">
                                                                        (GMT-06:00) Mountain Time (US &amp; Canada)
                                                                    </option>
                                                                    <option data-bs-offset="-21600" value="Chihuahua"
                                                                        data-select2-id="select2-data-369-wmf6">
                                                                        (GMT-06:00) Chihuahua</option>
                                                                    <option data-bs-offset="-21600" value="Mazatlan"
                                                                        data-select2-id="select2-data-370-pc04">
                                                                        (GMT-06:00) Mazatlan</option>
                                                                    <option data-bs-offset="-21600" value="Saskatchewan"
                                                                        data-select2-id="select2-data-371-d6qw">
                                                                        (GMT-06:00) Saskatchewan</option>
                                                                    <option data-bs-offset="-21600"
                                                                        value="Central America"
                                                                        data-select2-id="select2-data-372-y1jz">
                                                                        (GMT-06:00) Central America</option>
                                                                    <option data-bs-offset="-18000"
                                                                        value="Central Time (US &amp; Canada)"
                                                                        data-select2-id="select2-data-373-3nlh">
                                                                        (GMT-05:00) Central Time (US &amp; Canada)
                                                                    </option>
                                                                    <option data-bs-offset="-18000" value="Guadalajara"
                                                                        data-select2-id="select2-data-374-sm5z">
                                                                        (GMT-05:00) Guadalajara</option>
                                                                    <option data-bs-offset="-18000" value="Mexico City"
                                                                        data-select2-id="select2-data-375-0zjc">
                                                                        (GMT-05:00) Mexico City</option>
                                                                    <option data-bs-offset="-18000" value="Monterrey"
                                                                        data-select2-id="select2-data-376-cbi6">
                                                                        (GMT-05:00) Monterrey</option>
                                                                    <option data-bs-offset="-18000" value="Bogota"
                                                                        data-select2-id="select2-data-377-23oc">
                                                                        (GMT-05:00) Bogota</option>
                                                                    <option data-bs-offset="-18000" value="Lima"
                                                                        data-select2-id="select2-data-378-lyov">
                                                                        (GMT-05:00) Lima</option>
                                                                    <option data-bs-offset="-18000" value="Quito"
                                                                        data-select2-id="select2-data-379-kouw">
                                                                        (GMT-05:00) Quito</option>
                                                                    <option data-bs-offset="-14400"
                                                                        value="Eastern Time (US &amp; Canada)"
                                                                        data-select2-id="select2-data-380-c30w">
                                                                        (GMT-04:00) Eastern Time (US &amp; Canada)
                                                                    </option>
                                                                    <option data-bs-offset="-14400"
                                                                        value="Indiana (East)"
                                                                        data-select2-id="select2-data-381-e3ph">
                                                                        (GMT-04:00) Indiana (East)</option>
                                                                    <option data-bs-offset="-14400" value="Caracas"
                                                                        data-select2-id="select2-data-382-d4zp">
                                                                        (GMT-04:00) Caracas</option>
                                                                    <option data-bs-offset="-14400" value="La Paz"
                                                                        data-select2-id="select2-data-383-v2ak">
                                                                        (GMT-04:00) La Paz</option>
                                                                    <option data-bs-offset="-14400" value="Georgetown"
                                                                        data-select2-id="select2-data-384-mtiu">
                                                                        (GMT-04:00) Georgetown</option>
                                                                    <option data-bs-offset="-10800"
                                                                        value="Atlantic Time (Canada)"
                                                                        data-select2-id="select2-data-385-xfjc">
                                                                        (GMT-03:00) Atlantic Time (Canada)</option>
                                                                    <option data-bs-offset="-10800" value="Santiago"
                                                                        data-select2-id="select2-data-386-tddt">
                                                                        (GMT-03:00) Santiago</option>
                                                                    <option data-bs-offset="-10800" value="Brasilia"
                                                                        data-select2-id="select2-data-387-1ok5">
                                                                        (GMT-03:00) Brasilia</option>
                                                                    <option data-bs-offset="-10800" value="Buenos Aires"
                                                                        data-select2-id="select2-data-388-c6dh">
                                                                        (GMT-03:00) Buenos Aires</option>
                                                                    <option data-bs-offset="-9000" value="Newfoundland"
                                                                        data-select2-id="select2-data-389-6yze">
                                                                        (GMT-02:30) Newfoundland</option>
                                                                    <option data-bs-offset="-7200" value="Greenland"
                                                                        data-select2-id="select2-data-390-uint">
                                                                        (GMT-02:00) Greenland</option>
                                                                    <option data-bs-offset="-7200" value="Mid-Atlantic"
                                                                        data-select2-id="select2-data-391-85x0">
                                                                        (GMT-02:00) Mid-Atlantic</option>
                                                                    <option data-bs-offset="-3600"
                                                                        value="Cape Verde Is."
                                                                        data-select2-id="select2-data-392-kxlj">
                                                                        (GMT-01:00) Cape Verde Is.</option>
                                                                    <option data-bs-offset="0" value="Azores"
                                                                        data-select2-id="select2-data-393-6pgf">(GMT)
                                                                        Azores</option>
                                                                    <option data-bs-offset="0" value="Monrovia"
                                                                        data-select2-id="select2-data-394-tvhk">(GMT)
                                                                        Monrovia</option>
                                                                    <option data-bs-offset="0" value="UTC"
                                                                        data-select2-id="select2-data-395-hhim">(GMT)
                                                                        UTC</option>
                                                                    <option data-bs-offset="3600" value="Dublin"
                                                                        data-select2-id="select2-data-396-aoqn">
                                                                        (GMT+01:00) Dublin</option>
                                                                    <option data-bs-offset="3600" value="Edinburgh"
                                                                        data-select2-id="select2-data-397-0jj5">
                                                                        (GMT+01:00) Edinburgh</option>
                                                                    <option data-bs-offset="3600" value="Lisbon"
                                                                        data-select2-id="select2-data-398-lp11">
                                                                        (GMT+01:00) Lisbon</option>
                                                                    <option data-bs-offset="3600" value="London"
                                                                        data-select2-id="select2-data-399-3l6z">
                                                                        (GMT+01:00) London</option>
                                                                    <option data-bs-offset="3600" value="Casablanca"
                                                                        data-select2-id="select2-data-400-3kkm">
                                                                        (GMT+01:00) Casablanca</option>
                                                                    <option data-bs-offset="3600"
                                                                        value="West Central Africa"
                                                                        data-select2-id="select2-data-401-ycal">
                                                                        (GMT+01:00) West Central Africa</option>
                                                                    <option data-bs-offset="7200" value="Belgrade"
                                                                        data-select2-id="select2-data-402-xkwl">
                                                                        (GMT+02:00) Belgrade</option>
                                                                    <option data-bs-offset="7200" value="Bratislava"
                                                                        data-select2-id="select2-data-403-5u9u">
                                                                        (GMT+02:00) Bratislava</option>
                                                                    <option data-bs-offset="7200" value="Budapest"
                                                                        data-select2-id="select2-data-404-gpp4">
                                                                        (GMT+02:00) Budapest</option>
                                                                    <option data-bs-offset="7200" value="Ljubljana"
                                                                        data-select2-id="select2-data-405-gczg">
                                                                        (GMT+02:00) Ljubljana</option>
                                                                    <option data-bs-offset="7200" value="Prague"
                                                                        data-select2-id="select2-data-406-wlaq">
                                                                        (GMT+02:00) Prague</option>
                                                                    <option data-bs-offset="7200" value="Sarajevo"
                                                                        data-select2-id="select2-data-407-8e0w">
                                                                        (GMT+02:00) Sarajevo</option>
                                                                    <option data-bs-offset="7200" value="Skopje"
                                                                        data-select2-id="select2-data-408-j6zd">
                                                                        (GMT+02:00) Skopje</option>
                                                                    <option data-bs-offset="7200" value="Warsaw"
                                                                        data-select2-id="select2-data-409-6ro2">
                                                                        (GMT+02:00) Warsaw</option>
                                                                    <option data-bs-offset="7200" value="Zagreb"
                                                                        data-select2-id="select2-data-410-1uk5">
                                                                        (GMT+02:00) Zagreb</option>
                                                                    <option data-bs-offset="7200" value="Brussels"
                                                                        data-select2-id="select2-data-411-h8k4">
                                                                        (GMT+02:00) Brussels</option>
                                                                    <option data-bs-offset="7200" value="Copenhagen"
                                                                        data-select2-id="select2-data-412-q2if">
                                                                        (GMT+02:00) Copenhagen</option>
                                                                    <option data-bs-offset="7200" value="Madrid"
                                                                        data-select2-id="select2-data-413-7rz8">
                                                                        (GMT+02:00) Madrid</option>
                                                                    <option data-bs-offset="7200" value="Paris"
                                                                        data-select2-id="select2-data-414-sku0">
                                                                        (GMT+02:00) Paris</option>
                                                                    <option data-bs-offset="7200" value="Amsterdam"
                                                                        data-select2-id="select2-data-415-yrzp">
                                                                        (GMT+02:00) Amsterdam</option>
                                                                    <option data-bs-offset="7200" value="Berlin"
                                                                        data-select2-id="select2-data-416-75ou">
                                                                        (GMT+02:00) Berlin</option>
                                                                    <option data-bs-offset="7200" value="Bern"
                                                                        data-select2-id="select2-data-417-dz4d">
                                                                        (GMT+02:00) Bern</option>
                                                                    <option data-bs-offset="7200" value="Rome"
                                                                        data-select2-id="select2-data-418-jycf">
                                                                        (GMT+02:00) Rome</option>
                                                                    <option data-bs-offset="7200" value="Stockholm"
                                                                        data-select2-id="select2-data-419-77sb">
                                                                        (GMT+02:00) Stockholm</option>
                                                                    <option data-bs-offset="7200" value="Vienna"
                                                                        data-select2-id="select2-data-420-84dw">
                                                                        (GMT+02:00) Vienna</option>
                                                                    <option data-bs-offset="7200" value="Cairo"
                                                                        data-select2-id="select2-data-421-poez">
                                                                        (GMT+02:00) Cairo</option>
                                                                    <option data-bs-offset="7200" value="Harare"
                                                                        data-select2-id="select2-data-422-7vy6">
                                                                        (GMT+02:00) Harare</option>
                                                                    <option data-bs-offset="7200" value="Pretoria"
                                                                        data-select2-id="select2-data-423-8gl8">
                                                                        (GMT+02:00) Pretoria</option>
                                                                    <option data-bs-offset="10800" value="Bucharest"
                                                                        data-select2-id="select2-data-424-4lei">
                                                                        (GMT+03:00) Bucharest</option>
                                                                    <option data-bs-offset="10800" value="Helsinki"
                                                                        data-select2-id="select2-data-425-aj1u">
                                                                        (GMT+03:00) Helsinki</option>
                                                                    <option data-bs-offset="10800" value="Kiev"
                                                                        data-select2-id="select2-data-426-3px0">
                                                                        (GMT+03:00) Kiev</option>
                                                                    <option data-bs-offset="10800" value="Kyiv"
                                                                        data-select2-id="select2-data-427-tqc1">
                                                                        (GMT+03:00) Kyiv</option>
                                                                    <option data-bs-offset="10800" value="Riga"
                                                                        data-select2-id="select2-data-428-0cmn">
                                                                        (GMT+03:00) Riga</option>
                                                                    <option data-bs-offset="10800" value="Sofia"
                                                                        data-select2-id="select2-data-429-ezhj">
                                                                        (GMT+03:00) Sofia</option>
                                                                    <option data-bs-offset="10800" value="Tallinn"
                                                                        data-select2-id="select2-data-430-6ug6">
                                                                        (GMT+03:00) Tallinn</option>
                                                                    <option data-bs-offset="10800" value="Vilnius"
                                                                        data-select2-id="select2-data-431-4lrf">
                                                                        (GMT+03:00) Vilnius</option>
                                                                    <option data-bs-offset="10800" value="Athens"
                                                                        data-select2-id="select2-data-432-t74z">
                                                                        (GMT+03:00) Athens</option>
                                                                    <option data-bs-offset="10800" value="Istanbul"
                                                                        data-select2-id="select2-data-433-jljs">
                                                                        (GMT+03:00) Istanbul</option>
                                                                    <option data-bs-offset="10800" value="Minsk"
                                                                        data-select2-id="select2-data-434-2nk4">
                                                                        (GMT+03:00) Minsk</option>
                                                                    <option data-bs-offset="10800" value="Jerusalem"
                                                                        data-select2-id="select2-data-435-grjr">
                                                                        (GMT+03:00) Jerusalem</option>
                                                                    <option data-bs-offset="10800" value="Moscow"
                                                                        data-select2-id="select2-data-436-nsfz">
                                                                        (GMT+03:00) Moscow</option>
                                                                    <option data-bs-offset="10800"
                                                                        value="St. Petersburg"
                                                                        data-select2-id="select2-data-437-3qnb">
                                                                        (GMT+03:00) St. Petersburg</option>
                                                                    <option data-bs-offset="10800" value="Volgograd"
                                                                        data-select2-id="select2-data-438-2i9z">
                                                                        (GMT+03:00) Volgograd</option>
                                                                    <option data-bs-offset="10800" value="Kuwait"
                                                                        data-select2-id="select2-data-439-b7vt">
                                                                        (GMT+03:00) Kuwait</option>
                                                                    <option data-bs-offset="10800" value="Riyadh"
                                                                        data-select2-id="select2-data-440-zkow">
                                                                        (GMT+03:00) Riyadh</option>
                                                                    <option data-bs-offset="10800" value="Nairobi"
                                                                        data-select2-id="select2-data-441-z6al">
                                                                        (GMT+03:00) Nairobi</option>
                                                                    <option data-bs-offset="10800" value="Baghdad"
                                                                        data-select2-id="select2-data-442-au2o">
                                                                        (GMT+03:00) Baghdad</option>
                                                                    <option data-bs-offset="14400" value="Abu Dhabi"
                                                                        data-select2-id="select2-data-443-1snx">
                                                                        (GMT+04:00) Abu Dhabi</option>
                                                                    <option data-bs-offset="14400" value="Muscat"
                                                                        data-select2-id="select2-data-444-uvwk">
                                                                        (GMT+04:00) Muscat</option>
                                                                    <option data-bs-offset="14400" value="Baku"
                                                                        data-select2-id="select2-data-445-4uxz">
                                                                        (GMT+04:00) Baku</option>
                                                                    <option data-bs-offset="14400" value="Tbilisi"
                                                                        data-select2-id="select2-data-446-hopw">
                                                                        (GMT+04:00) Tbilisi</option>
                                                                    <option data-bs-offset="14400" value="Yerevan"
                                                                        data-select2-id="select2-data-447-kejw">
                                                                        (GMT+04:00) Yerevan</option>
                                                                    <option data-bs-offset="16200" value="Tehran"
                                                                        data-select2-id="select2-data-448-4keu">
                                                                        (GMT+04:30) Tehran</option>
                                                                    <option data-bs-offset="16200" value="Kabul"
                                                                        data-select2-id="select2-data-449-ujpj">
                                                                        (GMT+04:30) Kabul</option>
                                                                    <option data-bs-offset="18000" value="Ekaterinburg"
                                                                        data-select2-id="select2-data-450-on5w">
                                                                        (GMT+05:00) Ekaterinburg</option>
                                                                    <option data-bs-offset="18000" value="Islamabad"
                                                                        data-select2-id="select2-data-451-80q9">
                                                                        (GMT+05:00) Islamabad</option>
                                                                    <option data-bs-offset="18000" value="Karachi"
                                                                        data-select2-id="select2-data-452-owrq">
                                                                        (GMT+05:00) Karachi</option>
                                                                    <option data-bs-offset="18000" value="Tashkent"
                                                                        data-select2-id="select2-data-453-j16r">
                                                                        (GMT+05:00) Tashkent</option>
                                                                    <option data-bs-offset="19800" value="Chennai"
                                                                        data-select2-id="select2-data-454-fbp5">
                                                                        (GMT+05:30) Chennai</option>
                                                                    <option data-bs-offset="19800" value="Kolkata"
                                                                        data-select2-id="select2-data-455-dw3b">
                                                                        (GMT+05:30) Kolkata</option>
                                                                    <option data-bs-offset="19800" value="Mumbai"
                                                                        data-select2-id="select2-data-456-xuev">
                                                                        (GMT+05:30) Mumbai</option>
                                                                    <option data-bs-offset="19800" value="New Delhi"
                                                                        data-select2-id="select2-data-457-hfbx">
                                                                        (GMT+05:30) New Delhi</option>
                                                                    <option data-bs-offset="19800"
                                                                        value="Sri Jayawardenepura"
                                                                        data-select2-id="select2-data-458-vlyn">
                                                                        (GMT+05:30) Sri Jayawardenepura</option>
                                                                    <option data-bs-offset="20700" value="Kathmandu"
                                                                        data-select2-id="select2-data-459-qbq4">
                                                                        (GMT+05:45) Kathmandu</option>
                                                                    <option data-bs-offset="21600" value="Astana"
                                                                        data-select2-id="select2-data-460-6htk">
                                                                        (GMT+06:00) Astana</option>
                                                                    <option data-bs-offset="21600" value="Dhaka"
                                                                        data-select2-id="select2-data-461-nhps">
                                                                        (GMT+06:00) Dhaka</option>
                                                                    <option data-bs-offset="21600" value="Almaty"
                                                                        data-select2-id="select2-data-462-d82i">
                                                                        (GMT+06:00) Almaty</option>
                                                                    <option data-bs-offset="21600" value="Urumqi"
                                                                        data-select2-id="select2-data-463-9yx6">
                                                                        (GMT+06:00) Urumqi</option>
                                                                    <option data-bs-offset="23400" value="Rangoon"
                                                                        data-select2-id="select2-data-464-220s">
                                                                        (GMT+06:30) Rangoon</option>
                                                                    <option data-bs-offset="25200" value="Novosibirsk"
                                                                        data-select2-id="select2-data-465-iidl">
                                                                        (GMT+07:00) Novosibirsk</option>
                                                                    <option data-bs-offset="25200" value="Bangkok"
                                                                        data-select2-id="select2-data-466-ob3q">
                                                                        (GMT+07:00) Bangkok</option>
                                                                    <option data-bs-offset="25200" value="Hanoi"
                                                                        data-select2-id="select2-data-467-49yh">
                                                                        (GMT+07:00) Hanoi</option>
                                                                    <option data-bs-offset="25200" value="Jakarta"
                                                                        data-select2-id="select2-data-468-rl9b">
                                                                        (GMT+07:00) Jakarta</option>
                                                                    <option data-bs-offset="25200" value="Krasnoyarsk"
                                                                        data-select2-id="select2-data-469-n5xn">
                                                                        (GMT+07:00) Krasnoyarsk</option>
                                                                    <option data-bs-offset="28800" value="Beijing"
                                                                        data-select2-id="select2-data-470-w6v1">
                                                                        (GMT+08:00) Beijing</option>
                                                                    <option data-bs-offset="28800" value="Chongqing"
                                                                        data-select2-id="select2-data-471-h0of">
                                                                        (GMT+08:00) Chongqing</option>
                                                                    <option data-bs-offset="28800" value="Hong Kong"
                                                                        data-select2-id="select2-data-472-zrs2">
                                                                        (GMT+08:00) Hong Kong</option>
                                                                    <option data-bs-offset="28800" value="Kuala Lumpur"
                                                                        data-select2-id="select2-data-473-2739">
                                                                        (GMT+08:00) Kuala Lumpur</option>
                                                                    <option data-bs-offset="28800" value="Singapore"
                                                                        data-select2-id="select2-data-474-w6ay">
                                                                        (GMT+08:00) Singapore</option>
                                                                    <option data-bs-offset="28800" value="Taipei"
                                                                        data-select2-id="select2-data-475-e4x3">
                                                                        (GMT+08:00) Taipei</option>
                                                                    <option data-bs-offset="28800" value="Perth"
                                                                        data-select2-id="select2-data-476-3k7g">
                                                                        (GMT+08:00) Perth</option>
                                                                    <option data-bs-offset="28800" value="Irkutsk"
                                                                        data-select2-id="select2-data-477-b0ik">
                                                                        (GMT+08:00) Irkutsk</option>
                                                                    <option data-bs-offset="28800" value="Ulaan Bataar"
                                                                        data-select2-id="select2-data-478-gvnv">
                                                                        (GMT+08:00) Ulaan Bataar</option>
                                                                    <option data-bs-offset="32400" value="Seoul"
                                                                        data-select2-id="select2-data-479-mbrk">
                                                                        (GMT+09:00) Seoul</option>
                                                                    <option data-bs-offset="32400" value="Osaka"
                                                                        data-select2-id="select2-data-480-rffa">
                                                                        (GMT+09:00) Osaka</option>
                                                                    <option data-bs-offset="32400" value="Sapporo"
                                                                        data-select2-id="select2-data-481-jx9h">
                                                                        (GMT+09:00) Sapporo</option>
                                                                    <option data-bs-offset="32400" value="Tokyo"
                                                                        data-select2-id="select2-data-482-jfma">
                                                                        (GMT+09:00) Tokyo</option>
                                                                    <option data-bs-offset="32400" value="Yakutsk"
                                                                        data-select2-id="select2-data-483-81hj">
                                                                        (GMT+09:00) Yakutsk</option>
                                                                    <option data-bs-offset="34200" value="Darwin"
                                                                        data-select2-id="select2-data-484-ymmi">
                                                                        (GMT+09:30) Darwin</option>
                                                                    <option data-bs-offset="34200" value="Adelaide"
                                                                        data-select2-id="select2-data-485-c5rp">
                                                                        (GMT+09:30) Adelaide</option>
                                                                    <option data-bs-offset="36000" value="Canberra"
                                                                        data-select2-id="select2-data-486-ukyk">
                                                                        (GMT+10:00) Canberra</option>
                                                                    <option data-bs-offset="36000" value="Melbourne"
                                                                        data-select2-id="select2-data-487-0z76">
                                                                        (GMT+10:00) Melbourne</option>
                                                                    <option data-bs-offset="36000" value="Sydney"
                                                                        data-select2-id="select2-data-488-vfb9">
                                                                        (GMT+10:00) Sydney</option>
                                                                    <option data-bs-offset="36000" value="Brisbane"
                                                                        data-select2-id="select2-data-489-oxdh">
                                                                        (GMT+10:00) Brisbane</option>
                                                                    <option data-bs-offset="36000" value="Hobart"
                                                                        data-select2-id="select2-data-490-qkvw">
                                                                        (GMT+10:00) Hobart</option>
                                                                    <option data-bs-offset="36000" value="Vladivostok"
                                                                        data-select2-id="select2-data-491-h08c">
                                                                        (GMT+10:00) Vladivostok</option>
                                                                    <option data-bs-offset="36000" value="Guam"
                                                                        data-select2-id="select2-data-492-3xg0">
                                                                        (GMT+10:00) Guam</option>
                                                                    <option data-bs-offset="36000" value="Port Moresby"
                                                                        data-select2-id="select2-data-493-cp8m">
                                                                        (GMT+10:00) Port Moresby</option>
                                                                    <option data-bs-offset="36000" value="Solomon Is."
                                                                        data-select2-id="select2-data-494-zair">
                                                                        (GMT+10:00) Solomon Is.</option>
                                                                    <option data-bs-offset="39600" value="Magadan"
                                                                        data-select2-id="select2-data-495-t8ht">
                                                                        (GMT+11:00) Magadan</option>
                                                                    <option data-bs-offset="39600" value="New Caledonia"
                                                                        data-select2-id="select2-data-496-zwzo">
                                                                        (GMT+11:00) New Caledonia</option>
                                                                    <option data-bs-offset="43200" value="Fiji"
                                                                        data-select2-id="select2-data-497-rdmg">
                                                                        (GMT+12:00) Fiji</option>
                                                                    <option data-bs-offset="43200" value="Kamchatka"
                                                                        data-select2-id="select2-data-498-0d2g">
                                                                        (GMT+12:00) Kamchatka</option>
                                                                    <option data-bs-offset="43200" value="Marshall Is."
                                                                        data-select2-id="select2-data-499-irti">
                                                                        (GMT+12:00) Marshall Is.</option>
                                                                    <option data-bs-offset="43200" value="Auckland"
                                                                        data-select2-id="select2-data-500-jd5d">
                                                                        (GMT+12:00) Auckland</option>
                                                                    <option data-bs-offset="43200" value="Wellington"
                                                                        data-select2-id="select2-data-501-mfjr">
                                                                        (GMT+12:00) Wellington</option>
                                                                    <option data-bs-offset="46800" value="Nuku'alofa"
                                                                        data-select2-id="select2-data-502-lkq9">
                                                                        (GMT+13:00) Nuku'alofa</option>
                                                                </select>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Currency</label>
                                                                <select name="currnecy" aria-label="Select a Timezone"
                                                                    data-control="select2"
                                                                    data-placeholder="Select a currency.."
                                                                    class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                                                                    data-select2-id="select2-data-19-2amk" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option value=""
                                                                        data-select2-id="select2-data-21-fjs2">Select a
                                                                        currency..</option>
                                                                    <option data-flag="flags/united-states.svg"
                                                                        value="USD"
                                                                        data-select2-id="select2-data-506-bz2b">
                                                                        USD&nbsp;-&nbsp;USA dollar</option>
                                                                    <option data-flag="flags/united-kingdom.svg"
                                                                        value="GBP"
                                                                        data-select2-id="select2-data-507-q71a">
                                                                        GBP&nbsp;-&nbsp;British pound</option>
                                                                    <option data-flag="flags/australia.svg" value="AUD"
                                                                        data-select2-id="select2-data-508-0326">
                                                                        AUD&nbsp;-&nbsp;Australian dollar</option>
                                                                    <option data-flag="flags/japan.svg" value="JPY"
                                                                        data-select2-id="select2-data-509-wie1">
                                                                        JPY&nbsp;-&nbsp;Japanese yen</option>
                                                                    <option data-flag="flags/sweden.svg" value="SEK"
                                                                        data-select2-id="select2-data-510-7z3f">
                                                                        SEK&nbsp;-&nbsp;Swedish krona</option>
                                                                    <option data-flag="flags/canada.svg" value="CAD"
                                                                        data-select2-id="select2-data-511-z6hb">
                                                                        CAD&nbsp;-&nbsp;Canadian dollar</option>
                                                                    <option data-flag="flags/switzerland.svg"
                                                                        value="CHF"
                                                                        data-select2-id="select2-data-512-8uqu">
                                                                        CHF&nbsp;-&nbsp;Swiss franc</option>
                                                                </select>
                                                                <!--end::Label-->

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Communication</label>
                                                                <div class="">
                                                                    <ul>
                                                                        <li>
                                                                            <span class="switch switch-sm switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"
                                                                                        checked="checked" name="">
                                                                                    <span></span>Email
                                                                                </label>
                                                                            </span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="switch switch-sm switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"
                                                                                        checked="checked" name="">
                                                                                    <span></span>Phone
                                                                                </label>
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->

                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <!--begin::Label-->
                                                                <label class="label">Allow Marketing</label>
                                                                <div class="">
                                                                    <span class="switch switch-sm switch-icon">
                                                                        <label>
                                                                            <input type="checkbox" checked="checked"
                                                                                name="">
                                                                            <span></span>
                                                                        </label>
                                                                    </span>
                                                                </div>
                                                                <!--end::Label-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                                <!--begin::Actions-->
                                                <div class="card-foot">
                                                    <div class="row">
                                                        <div class="col"><button type="reset"
                                                                class="btn btn-outline-brand">Cancel</button>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="submit"
                                                                class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end::Actions-->
                                                <input type="hidden">
                                                <div></div>
                                            </form>
                                            <!--end::Form-->

                                            <!--end::Content-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End:: App Content-->
                        </div>

                    </div>
                </main>
                <?php
        include 'includes/footer.php';
        ?>


            </div>

        </div>

    </body>

</html>