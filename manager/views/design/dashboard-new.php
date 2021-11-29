<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

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
            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
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
                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">

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
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card card-tabs">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Statistics</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#statistics-1" role="tab">
                                                    Sales
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#statistics-2" role="tab">
                                                    Sales Earnings
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#statistics-3" role="tab">
                                                    Buyer/seller Signups
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#statistics-4" role="tab">
                                                    Affiliate Signups
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#statistics-5" role="tab">
                                                    Products
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="statistics-1">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-2">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-3">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-4">
                                            <div class="statistics js-statistics"> </div>
                                        </div>
                                        <div class="tab-pane" id="statistics-5">
                                            <div class="statistics js-statistics"> </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Sales <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div class="sales js-sales">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row row-full-height">
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Sales <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-1" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 96.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Orders <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-2" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-danger"><i class="la la-arrow-down"></i> 2.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Online store visitors <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-3" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    13%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 50.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Repeat
                                                                Customer Rate <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-4" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:25%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:65%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 15%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$9581</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 2.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Average
                                                                Order Value <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"></div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-5" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body card__body--fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget26">
                                                <div class="widget26__content">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__number">$81</span></div>
                                                        <div class="col-auto">
                                                            <span class="widget26__cents font-success"><i class="la la-arrow-up"></i> 8.6%</span>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col"><span class="widget26__desc">Total
                                                                Sales Attributed to marketing campaigns <i class="fa fa-question-circle"></i></span>
                                                        </div>
                                                        <div class="col-auto"><a class="link" href="#">View
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget__chart">
                                                    <div id="chart-6" class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="widget15 mt-4">
                                                <div class="widget15__items">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    63%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Online Store
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress widget15__chart-progress--sm">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    54%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Facebook
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    41%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Profit Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="widget15__item">
                                                                <span class="widget15__stats">
                                                                    79%
                                                                </span>
                                                                <span class="widget15__text">
                                                                    Member Grow
                                                                </span>
                                                                <div class="space-10"></div>
                                                                <div class="progress progress--sm">
                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="widget15__desc">
                                                                * lorem ipsum dolor sit amet consectetuer sediat
                                                                elit
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-5">
                            <!--begin:: Widgets/Sale Reports-->
                            <div class="card card-tabs card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Online store visits by location</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#widget11_tab1_content" role="tab">
                                                    Last Month
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#widget11_tab2_content" role="tab">
                                                    All Time
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--Begin::Tab Content-->
                                    <div class="tab-content">
                                        <!--begin::tab 1 content-->
                                        <div class="tab-pane active" id="widget11_tab1_content">
                                            <!--begin::Widget 11-->
                                            <div class="widget11">
                                                <div class="table-responsive">
                                                    <table class="table js--table-scrollable">
                                                        <tbody>
                                                            <tr>
                                                                <td>USA</td>
                                                                <td>1.458</td>
                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        75.5%</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Canada</td>
                                                                <td>1.458</td>
                                                                <td class="align-right">
                                                                    <span class="font-danger"><i class="la la-arrow-down"></i>
                                                                        25.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Germany
                                                                </td>
                                                                <td>
                                                                    85.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        15.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Maxico
                                                                </td>
                                                                <td>
                                                                    12.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-danger"><i class="la la-arrow-down"></i>
                                                                        67.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    France
                                                                </td>
                                                                <td>
                                                                    89.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        5.5%</span>
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="widget11__action align-right">
                                                    <button type="button" class="btn btn-outline-brand btn-bold btn-sm">Import
                                                        Report</button>
                                                </div>
                                            </div>
                                            <!--end::Widget 11-->
                                        </div>
                                        <!--end::tab 1 content-->
                                        <!--begin::tab 2 content-->
                                        <div class="tab-pane" id="widget11_tab2_content">
                                            <!--begin::Widget 11-->
                                            <div class="widget11">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>

                                                            <tr>
                                                                <td>Canada</td>
                                                                <td>1.458</td>
                                                                <td class="align-right">
                                                                    <span class="font-danger"><i class="la la-arrow-down"></i>
                                                                        25.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Germany
                                                                </td>
                                                                <td>
                                                                    85.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        15.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>USA</td>
                                                                <td>1.458</td>
                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        75.5%</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Maxico
                                                                </td>
                                                                <td>
                                                                    12.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-danger"><i class="la la-arrow-down"></i>
                                                                        67.5%</span>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    France
                                                                </td>
                                                                <td>
                                                                    89.458
                                                                </td>

                                                                <td class="align-right">
                                                                    <span class="font-success"><i class="la la-arrow-up"></i>
                                                                        5.5%</span>
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="widget11__action align-right">
                                                    <button type="button" class="btn btn-label-success btn-bold btn-sm">Generate
                                                        Report</button>
                                                </div>
                                            </div>

                                            <!--end::Widget 11-->
                                        </div>
                                        <!--end::tab 2 content-->

                                    </div>

                                    <!--End::Tab Content-->
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-7">
                            <!--begin:: Widgets/Product Sales-->
                            <div class="card card--bordered-semi card--space card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Online store conversion rate <i class="fa fa-question-circle"></i>
                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <button type="button" class="btn btn-outline-brand btn-bold btn-sm">View
                                            All</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget25">
                                        <span class="widget25__stats m-font-brand">37.5% </span>
                                        <span class="widget25__subtitle"><span class="font-success"><i class="la la-arrow-up"></i> 50.6%</span></span>
                                        <div class="widget25__items">
                                            <div class="widget25__item">
                                                <span class="widget25__number">
                                                    63%
                                                </span> <span class="widget25__cents"><span class="font-success"><i class="la la-arrow-up"></i>
                                                        50.6%</span></span>

                                                <span class="widget25__desc">
                                                    Added to cart
                                                </span>
                                            </div>

                                            <div class="widget25__item">
                                                <span class="widget25__number">
                                                    39%
                                                </span><span class="widget25__cents"><span class="font-danger"><i class="la la-arrow-down"></i>
                                                        50.6%</span></span>

                                                <span class="widget25__desc">
                                                    Reached checkout
                                                </span>
                                            </div>

                                            <div class="widget25__item">
                                                <span class="widget25__number">
                                                    54%
                                                </span><span class="widget25__cents"><span class="font-success"><i class="la la-arrow-up"></i>
                                                        50.6%</span></span>

                                                <span class="widget25__desc">
                                                    Purchased
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Product Sales-->
                        </div>
                    </div>

                    <!--End::Section-->

                    <!--Begin::Section-->
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Top Products by units sold</h3>
                                    </div>
                                    <div class="card-head-toolbar">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Online store visits by traffic source</h3>
                                    </div>
                                    <div class="card-head-toolbar">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Sales by traffic source</h3>
                                    </div>
                                    <div class="card-head-toolbar">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Top landing pages by visits</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <button type="button" class="btn btn-outline-brand btn-bold btn-sm">View
                                            Report</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Online store visits by device type</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <button type="button" class="btn btn-outline-brand btn-bold btn-sm">View
                                            Report</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-4">
                            <div class="card card--height-fluid">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Online store visits from social sources</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <button type="button" class="btn btn-outline-brand btn-bold btn-sm">View
                                            Report</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="widget11">
                                        <div class="table-responsive">
                                            <table class="table js--table-scrollable">
                                                <tbody>
                                                    <tr>
                                                        <td>Woo Shirt heavy</td>
                                                        <td>558</td>
                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 75.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Woo long sleeve</td>
                                                        <td>1.458</td>
                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 25.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Shorts
                                                        </td>
                                                        <td>
                                                            85.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 15.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Maxico
                                                        </td>
                                                        <td>
                                                            12.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-danger"><i class="la la-arrow-down"></i> 67.5%</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Socks
                                                        </td>
                                                        <td>
                                                            89.458
                                                        </td>

                                                        <td class="align-right">
                                                            <span class="font-success"><i class="la la-arrow-up"></i> 5.5%</span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include 'includes/footer.php';
            ?>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script>
        new Chartist.Line('.js-statistics', {
            labels: [1, 2, 3, 4, 5, 6, 7, 8],
            series: [
                [1, 2, 3, 1, -2, 0, 1, 0],
                [-2, -1, -2, -1, -2.5, -1, -2, -1],
                [0, 0, 0, 1, 2, 2.5, 2, 1],
                [2.5, 2, 1, 0.5, 1, 0.5, -1, -2.5]
            ]
        }, {
            high: 3,
            low: -3,
            showArea: true,
            showLine: false,
            showPoint: false,
            fullWidth: true,
            axisX: {
                showLabel: false,
                showGrid: false
            }
        });

        new Chartist.Line('.js-sales', {
  labels: [1, 2, 3, 4, 5, 6, 7, 8],
  series: [
    [5, 9, 7, 8, 5, 3, 5, 4]
  ]
}, {
  low: 0,
  showArea: true
});
    </script>

</body>

</html>