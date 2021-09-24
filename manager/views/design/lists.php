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

                                    Lists </h3>

                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Components </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Custom </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Lists </a>
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
                        <div class="row">
                            <div class="col-lg-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Timeline List
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Timeline 1-->
                                        <div class="list-timeline">
                                            <div class="list-timeline__items">
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">12 new users registered and
                                                        pending for activation</span>
                                                    <span class="list-timeline__time">Just now</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">Scheduled system reboot completed
                                                        <span
                                                            class="badge badge--brand badge--inline">completed</span></span>
                                                    <span class="list-timeline__time">14 mins</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">New order has been planced and
                                                        pending for processing</span>
                                                    <span class="list-timeline__time">20 mins</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">Database server overloaded 80% and
                                                        requires quick reboot <span
                                                            class="badge badge--danger badge--inline">settled</span></span>
                                                    <span class="list-timeline__time">1 hr</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">System error occured and hard
                                                        drive has been shutdown - <a href="#"
                                                            class="link">Check</a></span>
                                                    <span class="list-timeline__time">2 hrs</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span class="list-timeline__badge"></span>
                                                    <span class="list-timeline__text">Production server is
                                                        rebooting...</span>
                                                    <span class="list-timeline__time">3 hrs</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end::Timeline 1-->

                                        <div class="separator separator--space-lg separator--border-dashed"></div>

                                        <!--begin::Dropdown-->
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                Dropdown example
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl padding-20"
                                                aria-labelledby="dropdownMenuButton">
                                                <div class="scroll scroll-y" data-scroll="true" data-height="200"
                                                    style="height: 200px;">
                                                    <div class="list-timeline">
                                                        <div class="list-timeline__items">
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">12 new users
                                                                    registered and pending for activation</span>
                                                                <span class="list-timeline__time">Just now</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Scheduled system
                                                                    reboot completed <span
                                                                        class="badge badge--success badge--inline">completed</span></span>
                                                                <span class="list-timeline__time">14 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">New order has been
                                                                    planced and pending for processing</span>
                                                                <span class="list-timeline__time">20 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Database server
                                                                    overloaded 80% and requires quick reboot <span
                                                                        class="badge badge--info badge--inline">settled</span></span>
                                                                <span class="list-timeline__time">1 hr</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">System error occured
                                                                    and hard drive has been shutdown - <a href="#"
                                                                        class="link">Check</a></span>
                                                                <span class="list-timeline__time">2 hrs</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Production server is
                                                                    rebooting...</span>
                                                                <span class="list-timeline__time">3 hrs</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Timeline List <small>state colors</small>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Timeline 1-->
                                        <div class="list-timeline">
                                            <div class="list-timeline__items">
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--success"></span>
                                                    <span class="list-timeline__text">12 new users registered and
                                                        pending for activation</span>
                                                    <span class="list-timeline__time">Just now</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--danger"></span>
                                                    <span class="list-timeline__text">Scheduled system reboot completed
                                                        <span
                                                            class="badge badge--success badge--inline">completed</span></span>
                                                    <span class="list-timeline__time">14 mins</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--warning"></span>
                                                    <span class="list-timeline__text">New order has been planced and
                                                        pending for processing</span>
                                                    <span class="list-timeline__time">20 mins</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--primary"></span>
                                                    <span class="list-timeline__text">Database server overloaded 80% and
                                                        requires quick reboot <span
                                                            class="badge badge--info badge--inline">settled</span></span>
                                                    <span class="list-timeline__time">1 hr</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--brand"></span>
                                                    <span class="list-timeline__text">System error occured and hard
                                                        drive has been shutdown - <a href="#"
                                                            class="link">Check</a></span>
                                                    <span class="list-timeline__time">2 hrs</span>
                                                </div>
                                                <div class="list-timeline__item">
                                                    <span
                                                        class="list-timeline__badge list-timeline__badge--success"></span>
                                                    <span class="list-timeline__text">Production server is
                                                        rebooting...</span>
                                                    <span class="list-timeline__time">3 hrs</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Timeline 1-->

                                        <div class="separator separator--space-lg separator--border-dashed"></div>

                                        <!--begin::Dropdown-->
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                Dropdown example
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl padding-20"
                                                aria-labelledby="dropdownMenuButton">
                                                <div class="scroll scroll-y" data-scroll="true" data-height="200"
                                                    style="height: 200px;">
                                                    <div class="list-timeline">
                                                        <div class="list-timeline__items">
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">12 new users
                                                                    registered and pending for activation</span>
                                                                <span class="list-timeline__time">Just now</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Scheduled system
                                                                    reboot completed <span
                                                                        class="badge badge--success badge--inline">completed</span></span>
                                                                <span class="list-timeline__time">14 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">New order has been
                                                                    planced and pending for processing</span>
                                                                <span class="list-timeline__time">20 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Database server
                                                                    overloaded 80% and requires quick reboot <span
                                                                        class="badge badge--info badge--inline">settled</span></span>
                                                                <span class="list-timeline__time">1 hr</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">System error occured
                                                                    and hard drive has been shutdown - <a href="#"
                                                                        class="link">Check</a></span>
                                                                <span class="list-timeline__time">2 hrs</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span class="list-timeline__badge"></span>
                                                                <span class="list-timeline__text">Production server is
                                                                    rebooting...</span>
                                                                <span class="list-timeline__time">3 hrs</span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Timeline List <small>with icons</small>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Preview-->
                                        <div class="demo">
                                            <div class="demo__preview">
                                                <div class="list-timeline">
                                                    <div class="list-timeline__items">
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--success"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-graph-1 font-success"></span>
                                                            <span class="list-timeline__text">12 new users registered
                                                                and pending for activation</span>
                                                            <span class="list-timeline__time">Just now</span>
                                                        </div>
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--danger"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-position font-danger"></span>
                                                            <span class="list-timeline__text">Scheduled system reboot
                                                                completed <span
                                                                    class="badge badge--success badge--inline">completed</span></span>
                                                            <span class="list-timeline__time">14 mins</span>
                                                        </div>
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--warning"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-lock font-warning"></span>
                                                            <span class="list-timeline__text">New order has been planced
                                                                and pending for processing</span>
                                                            <span class="list-timeline__time">20 mins</span>
                                                        </div>
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--primary"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-note font-primary"></span>
                                                            <span class="list-timeline__text">Database server overloaded
                                                                80% and requires quick reboot <span
                                                                    class="badge badge--info badge--inline">settled</span></span>
                                                            <span class="list-timeline__time">1 hr</span>
                                                        </div>
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--brand"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-attention font-brand"></span>
                                                            <span class="list-timeline__text">System error occured and
                                                                hard drive has been shutdown - <a href="#"
                                                                    class="link">Check</a></span>
                                                            <span class="list-timeline__time">2 hrs</span>
                                                        </div>
                                                        <div class="list-timeline__item">
                                                            <span
                                                                class="list-timeline__badge list-timeline__badge--success"></span>
                                                            <span
                                                                class="list-timeline__icon flaticon2-new-email font-success"></span>
                                                            <span class="list-timeline__text">Production server is
                                                                rebooting...</span>
                                                            <span class="list-timeline__time">3 hrs</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Preview-->

                                        <div class="separator separator--space-lg separator--border-dashed"></div>

                                        <!--begin::Dropdown-->
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                Dropdown example
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl padding-20"
                                                aria-labelledby="dropdownMenuButton">
                                                <div class="scroll scroll-y" data-scroll="true" data-height="300"
                                                    style="height: 300px;">
                                                    <div class="list-timeline">
                                                        <div class="list-timeline__items">
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--success"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-graph-1 font-success"></span>
                                                                <span class="list-timeline__text">12 new users
                                                                    registered and pending for activation</span>
                                                                <span class="list-timeline__time">Just now</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--danger"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-position font-danger"></span>
                                                                <span class="list-timeline__text">Scheduled system
                                                                    reboot completed <span
                                                                        class="badge badge--success badge--inline">completed</span></span>
                                                                <span class="list-timeline__time">14 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--warning"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-lock font-warning"></span>
                                                                <span class="list-timeline__text">New order has been
                                                                    planced and pending for processing</span>
                                                                <span class="list-timeline__time">20 mins</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--primary"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-note font-primary"></span>
                                                                <span class="list-timeline__text">Database server
                                                                    overloaded 80% and requires quick reboot <span
                                                                        class="badge badge--info badge--inline">settled</span></span>
                                                                <span class="list-timeline__time">1 hr</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--brand"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-attention font-brand"></span>
                                                                <span class="list-timeline__text">System error occured
                                                                    and hard drive has been shutdown - <a href="#"
                                                                        class="link">Check</a></span>
                                                                <span class="list-timeline__time">2 hrs</span>
                                                            </div>
                                                            <div class="list-timeline__item">
                                                                <span
                                                                    class="list-timeline__badge list-timeline__badge--success"></span>
                                                                <span
                                                                    class="list-timeline__icon flaticon2-new-email font-success"></span>
                                                                <span class="list-timeline__text">Production server is
                                                                    rebooting...</span>
                                                                <span class="list-timeline__time">3 hrs</span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </div>
                                <!--end::card-->
                            </div>

                            <div class="col-lg-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Notifications v1
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
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
                                            <a href="#" class="notification__item">
                                                <div class="notification__item-icon">
                                                    <i class="flaticon2-image-file font-warning"></i>
                                                </div>
                                                <div class="notification__item-details">
                                                    <div class="notification__item-title">
                                                        New file has been uploaded
                                                    </div>
                                                    <div class="notification__item-time">
                                                        5 hrs ago
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="notification__item">
                                                <div class="notification__item-icon">
                                                    <i class="flaticon2-bar-chart font-info"></i>
                                                </div>
                                                <div class="notification__item-details">
                                                    <div class="notification__item-title">
                                                        New user feedback received
                                                    </div>
                                                    <div class="notification__item-time">
                                                        8 hrs ago
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="separator separator--space-lg separator--border-dashed"></div>

                                        <!--begin::Dropdown-->
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                Dropdown example
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-xl"
                                                aria-labelledby="dropdownMenuButton">
                                                <div class="notification">
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
                                                    <a href="#" class="notification__item">
                                                        <div class="notification__item-icon">
                                                            <i class="flaticon2-image-file font-warning"></i>
                                                        </div>
                                                        <div class="notification__item-details">
                                                            <div class="notification__item-title">
                                                                New file has been uploaded
                                                            </div>
                                                            <div class="notification__item-time">
                                                                5 hrs ago
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="notification__item">
                                                        <div class="notification__item-icon">
                                                            <i class="flaticon2-bar-chart font-info"></i>
                                                        </div>
                                                        <div class="notification__item-details">
                                                            <div class="notification__item-title">
                                                                New user feedback received
                                                            </div>
                                                            <div class="notification__item-time">
                                                                8 hrs ago
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Notifications v2
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="notification-v2">
                                            <a href="#" class="notification-v2__item">
                                                <div class="notification-v2__item-icon">
                                                    <i class="flaticon-bell font-success"></i>
                                                </div>
                                                <div class="notification-v2__itek-wrapper">
                                                    <div class="notification-v2__item-title">
                                                        5 new user generated report
                                                    </div>
                                                    <div class="notification-v2__item-desc">
                                                        Reports based on sales
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#" class="notification-v2__item">
                                                <div class="notification-v2__item-icon">
                                                    <i class="flaticon2-box font-danger"></i>
                                                </div>
                                                <div class="notification-v2__itek-wrapper">
                                                    <div class="notification-v2__item-title">
                                                        2 new items submited
                                                    </div>
                                                    <div class="notification-v2__item-desc">
                                                        by Grog John
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#" class="notification-v2__item">
                                                <div class="notification-v2__item-icon">
                                                    <i class="flaticon-psd font-brand"></i>
                                                </div>
                                                <div class="notification-v2__itek-wrapper">
                                                    <div class="notification-v2__item-title">
                                                        79 PSD files generated
                                                    </div>
                                                    <div class="notification-v2__item-desc">
                                                        Reports based on sales
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#" class="notification-v2__item">
                                                <div class="notification-v2__item-icon">
                                                    <i class="flaticon2-supermarket font-warning"></i>
                                                </div>
                                                <div class="notification-v2__itek-wrapper">
                                                    <div class="notification-v2__item-title">
                                                        $2900 worth producucts sold
                                                    </div>
                                                    <div class="notification-v2__item-desc">
                                                        Total 234 items
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#" class="notification-v2__item">
                                                <div class="notification-v2__item-icon">
                                                    <i class="flaticon-paper-plane-1 font-success"></i>
                                                </div>
                                                <div class="notification-v2__itek-wrapper">
                                                    <div class="notification-v2__item-title">
                                                        4.5h-avarage response time
                                                    </div>
                                                    <div class="notification-v2__item-desc">
                                                        Fostest is Barry
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="separator separator--space-lg separator--border-dashed"></div>

                                        <!--begin::Dropdown-->
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                Dropdown example
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl"
                                                aria-labelledby="dropdownMenuButton">
                                                <div class="notification-v2">
                                                    <a href="#" class="notification-v2__item">
                                                        <div class="notification-v2__item-icon">
                                                            <i class="flaticon-bell font-success"></i>
                                                        </div>
                                                        <div class="notification-v2__itek-wrapper">
                                                            <div class="notification-v2__item-title">
                                                                5 new user generated report
                                                            </div>
                                                            <div class="notification-v2__item-desc">
                                                                Reports based on sales
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <a href="#" class="notification-v2__item">
                                                        <div class="notification-v2__item-icon">
                                                            <i class="flaticon2-box font-danger"></i>
                                                        </div>
                                                        <div class="notification-v2__itek-wrapper">
                                                            <div class="notification-v2__item-title">
                                                                2 new items submited
                                                            </div>
                                                            <div class="notification-v2__item-desc">
                                                                by Grog John
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <a href="#" class="notification-v2__item">
                                                        <div class="notification-v2__item-icon">
                                                            <i class="flaticon-psd font-brand"></i>
                                                        </div>
                                                        <div class="notification-v2__itek-wrapper">
                                                            <div class="notification-v2__item-title">
                                                                79 PSD files generated
                                                            </div>
                                                            <div class="notification-v2__item-desc">
                                                                Reports based on sales
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <a href="#" class="notification-v2__item">
                                                        <div class="notification-v2__item-icon">
                                                            <i class="flaticon2-supermarket font-warning"></i>
                                                        </div>
                                                        <div class="notification-v2__itek-wrapper">
                                                            <div class="notification-v2__item-title">
                                                                $2900 worth producucts sold
                                                            </div>
                                                            <div class="notification-v2__item-desc">
                                                                Total 234 items
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <a href="#" class="notification-v2__item">
                                                        <div class="notification-v2__item-icon">
                                                            <i class="flaticon-paper-plane-1 font-success"></i>
                                                        </div>
                                                        <div class="notification-v2__itek-wrapper">
                                                            <div class="notification-v2__item-title">
                                                                4.5h-avarage response time
                                                            </div>
                                                            <div class="notification-v2__item-desc">
                                                                Fostest is Barry
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
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