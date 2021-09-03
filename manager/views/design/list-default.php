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

                                List Default </h3>

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
                                    List - Default </a>
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
                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden-">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                        JM
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Jason Muller
                                                <i class="flaticon2-correct font-success"></i>
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>jason@siastudio.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>PR Manager </a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>Melbourne</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.
                                                <br> A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
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
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>164,700</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>782,300</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <span>+5</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden-">
                                        MP
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Matt Pears
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>matt@stream.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Designer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>America</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.
                                                <br> A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    53%
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
                                            <span class="widget__value"><span>$</span>145,200</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>274,230</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>461,120</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">45 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">968 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
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
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden-">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                        ChS
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Charlie Stone
                                                <i class="flaticon2-correct font-success"></i>
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>charlie@stone.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Web Developer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>London</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.
                                                <br> A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    76%
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
                                            <span class="widget__value"><span>$</span>542,500</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>675,500</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>412,400</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">35 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">598 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
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
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--brand font-brand font-boldest hidden-">
                                        SF
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Sergei Ford
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>sergei@ford .com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Angular Developer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>Germany</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.
                                                <br> A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-brand" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    46%
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
                                            <span class="widget__value"><span>$</span>349,900</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>654,200</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>876,323</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">54 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">683 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
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
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden-">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                        JM
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Jason Muller
                                                <i class="flaticon2-correct font-success"></i>
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>jason@siastudio.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>PR Manager </a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>Melbourne</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.<br>
                                                A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 56%;" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    56%
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
                                            <span class="widget__value"><span>$</span>559,500</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>435,700</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>642,300</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">53 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">348 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <span>+5</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden-">
                                        MP
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Matt Pears
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>matt@stream.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Designer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>America</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.<br>
                                                A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    53%
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
                                            <span class="widget__value"><span>$</span>145,200</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>274,230</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>461,120</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">45 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">968 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <span>+5</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden-">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">
                                        ChS
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Charlie Stone
                                                <i class="flaticon2-correct font-success"></i>
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>charlie@stone.com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Web Developer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>London</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.<br>
                                                A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    76%
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
                                            <span class="widget__value"><span>$</span>542,500</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>675,500</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>412,400</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">35 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">598 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <span>+5</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: card-->

                    <!--begin:: card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="widget widget--user-profile-3">
                                <div class="widget__top">
                                    <div class="widget__media hidden">
                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                    </div>
                                    <div class="widget__pic widget__pic--brand font-brand font-boldest hidden-">
                                        SF
                                    </div>
                                    <div class="widget__content">
                                        <div class="widget__head">
                                            <a href="#" class="widget__username">
                                                Sergei Ford
                                            </a>

                                            <div class="widget__action">
                                                <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                                <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                                            </div>
                                        </div>

                                        <div class="widget__subhead">
                                            <a href="#"><i class="flaticon2-new-email"></i>sergei@ford .com</a>
                                            <a href="#"><i class="flaticon2-calendar-3"></i>Angular Developer</a>
                                            <a href="#"><i class="flaticon2-placeholder"></i>Germany</a>
                                        </div>

                                        <div class="widget__info">
                                            <div class="widget__desc">
                                                I distinguish three main text objektive could be merely to inform people.<br>
                                                A second could be persuade people.You want people to bay objective
                                            </div>
                                            <div class="widget__progress">
                                                <div class="widget__text">
                                                    Progress
                                                </div>
                                                <div class="progress" style="height: 5px;width: 100%;">
                                                    <div class="progress-bar bg-brand" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="widget__stats">
                                                    46%
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
                                            <span class="widget__value"><span>$</span>349,900</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-confetti"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Expenses</span>
                                            <span class="widget__value"><span>$</span>654,200</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-pie-chart"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">Net</span>
                                            <span class="widget__value"><span>$</span>876,323</span>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-file-2"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">54 Tasks</span>
                                            <a href="#" class="widget__value font-brand">View</a>
                                        </div>
                                    </div>

                                    <div class="widget__item">
                                        <div class="widget__icon">
                                            <i class="flaticon-chat-1"></i>
                                        </div>
                                        <div class="widget__details">
                                            <span class="widget__title">683 Comments</span>
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
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                                                    </a>
                                                    <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                        <span>+5</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: card-->

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