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
                    <h3 class="subheader__title">List Default </h3>

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
                                <img src="media/users/100_1.jpg" alt="image">
                            </div>
                            <div class="widget__pic widget__pic--danger font-danger font-boldest font-light hidden">JM</div>
                            <div class="widget__content">
                                <div class="widget__head">
                                    <a href="#" class="widget__username">
                                        Jason Muller
                                        <i class="flaticon2-correct font-success"></i>
                                    </a>

                                    <div class="widget__action">
                                        <button type="button" class="btn btn-label-success btn-sm btn-upper">Reports</button>&nbsp;
                                        <button type="button" class="btn btn-brand btn-sm btn-upper">New Task</button>
                                    </div>
                                </div>

                                <div class="widget__subhead">
                                    <a href="#"><i class="flaticon2-new-email"></i>jason@siastudio.com</a>
                                    <a href="#"><i class="flaticon2-calendar-3"></i>PR Manager </a>
                                    <a href="#"><i class="flaticon2-placeholder"></i>Melbourne</a>
                                </div>

                                <div class="widget__info">
                                    <div class="widget__desc">
                                        I distinguish three main text objective could be merely to inform people.
                                        <br> A second could be persuade people.You want people to bay objective
                                    </div>

                                    <div class="widget_date">
                                    <div class="widget_date_box">
                                    <label><strong>Start Date</strong></label>
                                    <span class="badge badge--inline badge--primary">11/09/2020</span>
                                    </div>
                                    <div class="widget_date_box">
                                    <label><strong>Due Date</strong></label>
                                    <span class="badge badge--inline badge--danger">16/09/2020</span>
                                    </div>
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
                                                <img src="media/users/100_1.jpg" alt="image">
                                            </a>
                                            <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                                <img src="media/users/100_10.jpg" alt="image">
                                            </a>
                                            <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                                <img src="media/users/100_11.jpg" alt="image">
                                            </a>
                                            <a href="#" class="media media--sm media--circle" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                                <img src="media/users/100_3.jpg" alt="image">
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

            <!-- Begin:: card-->
            <div class="row">
                <div class="col-xl-8">
                    <!--begin:: Widgets/New Arrivals-->
                        <div class="card card--height-fluid">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                    New Arrivals
                                    </h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        Add New Member
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card__body--fluid">
                                <div class="widget12">
                                    <div class="widget12__content">
                                        <table class="table tbl-responsive-custom thead-bg">
                                            <thead>
                                                <tr>
                                                    <th>PRODUCTS</th>
                                                    <th>PRICE</th>
                                                    <th>DEPOSIT</th>
                                                    <th>AGENT</th>
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="pro-td">
                                                        <a href="#" class="pro-td-title">Sant Extreanet Solution</a>
                                                        <span class="pro-td-subtitle">HTML, JS, ReactJS</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$2,790</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$520</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">Bradly Beal</span>
                                                        <span class="pro-td-subtitle">Insurance</span>
                                                    </div>
                                                    </td>
                                                    <td><span class="badge badge--inline badge--success">Success</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="pro-td">
                                                        <a href="#" class="pro-td-title">Sant Extreanet Solution</a>
                                                        <span class="pro-td-subtitle">HTML, JS, ReactJS</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$2,790</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$520</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">Bradly Beal</span>
                                                        <span class="pro-td-subtitle">Insurance</span>
                                                    </div>
                                                    </td>
                                                    <td><span class="badge badge--inline badge--warning">In Progress</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="pro-td">
                                                        <a href="#" class="pro-td-title">Sant Extreanet Solution</a>
                                                        <span class="pro-td-subtitle">HTML, JS, ReactJS</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$2,790</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$520</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">Bradly Beal</span>
                                                        <span class="pro-td-subtitle">Insurance</span>
                                                    </div>
                                                    </td>
                                                    <td><span class="badge badge--inline badge--primary">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="pro-td">
                                                        <a href="#" class="pro-td-title">Sant Extreanet Solution</a>
                                                        <span class="pro-td-subtitle">HTML, JS, ReactJS</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$2,790</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">$520</span>
                                                        <span class="pro-td-subtitle">Paid</span>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <div class="pro-td">
                                                        <span href="#" class="pro-td-title">Bradly Beal</span>
                                                        <span class="pro-td-subtitle">Insurance</span>
                                                    </div>
                                                    </td>
                                                    <td><span class="badge badge--inline badge--danger">Rejected</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <div class="widget12__chart">
                                        <div class="ct-chart ct-chart-order-statistics"></div>
                                    </div>
                                </div>
                            </div>
                        </div>                               
                        <div class="col-xl-4">
                                <div class="card card--height-fluid">
                                    <div class="card-head">
                                    <div class="card-head-label">
                                    <h3 class="card-head-title">Recent Orders</h3>
                                    </div>
                                    </div>
                                    <div class="card-body card__body--fluid">
                                    <div class="widget26">
                                            <div class="widget26__content">
                                            <div class="widget__chart">
                                            <span class="home-media">
                                            <svg id="SvgjsSvg1536" width="543" height="350" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable hovering-zoom" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1538" class="apexcharts-inner apexcharts-graphical" transform="translate(46.390625, 30)"><defs id="SvgjsDefs1537"><clipPath id="gridRectMaskvvh3d2zm"><rect id="SvgjsRect1542" width="480.6640625" height="280.494" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMaskvvh3d2zm"><rect id="SvgjsRect1543" width="477.6640625" height="281.494" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1550" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1551" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1553" font-family="Poppins" x="0" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1554">Feb</tspan><title>Feb</title></text><text id="SvgjsText1556" font-family="Poppins" x="78.94401041666666" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1557">Mar</tspan><title>Mar</title></text><text id="SvgjsText1559" font-family="Poppins" x="157.88802083333334" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1560">Apr</tspan><title>Apr</title></text><text id="SvgjsText1562" font-family="Poppins" x="236.83203125000003" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1563">May</tspan><title>May</title></text><text id="SvgjsText1565" font-family="Poppins" x="315.77604166666674" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1566">Jun</tspan><title>Jun</title></text><text id="SvgjsText1568" font-family="Poppins" x="394.7200520833334" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1569">Jul</tspan><title>Jul</title></text><text id="SvgjsText1571" font-family="Poppins" x="473.66406250000006" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1572">Aug</tspan><title>Aug</title></text></g></g><g id="SvgjsG1585" class="apexcharts-grid"><g id="SvgjsG1586" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine1588" x1="0" y1="0" x2="473.6640625" y2="0" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1589" x1="0" y1="69.3735" x2="473.6640625" y2="69.3735" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1590" x1="0" y1="138.747" x2="473.6640625" y2="138.747" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1591" x1="0" y1="208.12050000000002" x2="473.6640625" y2="208.12050000000002" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1592" x1="0" y1="277.494" x2="473.6640625" y2="277.494" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line></g><g id="SvgjsG1587" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine1594" x1="0" y1="277.494" x2="473.6640625" y2="277.494" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1593" x1="0" y1="1" x2="0" y2="277.494" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1544" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1545" class="apexcharts-series" seriesName="NetxProfit" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1548" d="M 0 277.494L 0 242.80725000000007C 27.630403645833333 242.80725000000007 51.31360677083334 208.12050000000005 78.94401041666667 208.12050000000005C 106.57441406250001 208.12050000000005 130.25761718750002 208.12050000000005 157.88802083333334 208.12050000000005C 185.5184244791667 208.12050000000005 209.20162760416667 34.68675000000002 236.83203125000003 34.68675000000002C 264.4624348958334 34.68675000000002 288.14563802083336 34.68675000000002 315.7760416666667 34.68675000000002C 343.4064453125 34.68675000000002 367.08964843750005 104.06025000000002 394.72005208333337 104.06025000000002C 422.3504557291667 104.06025000000002 446.03365885416673 104.06025000000002 473.66406250000006 104.06025000000002C 473.66406250000006 104.06025000000002 473.66406250000006 104.06025000000002 473.66406250000006 277.494M 473.66406250000006 104.06025000000002z" fill="rgba(238,229,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskvvh3d2zm)" pathTo="M 0 277.494L 0 242.80725000000007C 27.630403645833333 242.80725000000007 51.31360677083334 208.12050000000005 78.94401041666667 208.12050000000005C 106.57441406250001 208.12050000000005 130.25761718750002 208.12050000000005 157.88802083333334 208.12050000000005C 185.5184244791667 208.12050000000005 209.20162760416667 34.68675000000002 236.83203125000003 34.68675000000002C 264.4624348958334 34.68675000000002 288.14563802083336 34.68675000000002 315.7760416666667 34.68675000000002C 343.4064453125 34.68675000000002 367.08964843750005 104.06025000000002 394.72005208333337 104.06025000000002C 422.3504557291667 104.06025000000002 446.03365885416673 104.06025000000002 473.66406250000006 104.06025000000002C 473.66406250000006 104.06025000000002 473.66406250000006 104.06025000000002 473.66406250000006 277.494M 473.66406250000006 104.06025000000002z" pathFrom="M -1 346.86750000000006L -1 346.86750000000006L 78.94401041666667 346.86750000000006L 157.88802083333334 346.86750000000006L 236.83203125000003 346.86750000000006L 315.7760416666667 346.86750000000006L 394.72005208333337 346.86750000000006L 473.66406250000006 346.86750000000006"></path><path id="SvgjsPath1549" d="M 0 242.80725000000007C 27.630403645833333 242.80725000000007 51.31360677083334 208.12050000000005 78.94401041666667 208.12050000000005C 106.57441406250001 208.12050000000005 130.25761718750002 208.12050000000005 157.88802083333334 208.12050000000005C 185.5184244791667 208.12050000000005 209.20162760416667 34.68675000000002 236.83203125000003 34.68675000000002C 264.4624348958334 34.68675000000002 288.14563802083336 34.68675000000002 315.7760416666667 34.68675000000002C 343.4064453125 34.68675000000002 367.08964843750005 104.06025000000002 394.72005208333337 104.06025000000002C 422.3504557291667 104.06025000000002 446.03365885416673 104.06025000000002 473.66406250000006 104.06025000000002" fill="none" fill-opacity="1" stroke="#8950fc" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskvvh3d2zm)" pathTo="M 0 242.80725000000007C 27.630403645833333 242.80725000000007 51.31360677083334 208.12050000000005 78.94401041666667 208.12050000000005C 106.57441406250001 208.12050000000005 130.25761718750002 208.12050000000005 157.88802083333334 208.12050000000005C 185.5184244791667 208.12050000000005 209.20162760416667 34.68675000000002 236.83203125000003 34.68675000000002C 264.4624348958334 34.68675000000002 288.14563802083336 34.68675000000002 315.7760416666667 34.68675000000002C 343.4064453125 34.68675000000002 367.08964843750005 104.06025000000002 394.72005208333337 104.06025000000002C 422.3504557291667 104.06025000000002 446.03365885416673 104.06025000000002 473.66406250000006 104.06025000000002" pathFrom="M -1 346.86750000000006L -1 346.86750000000006L 78.94401041666667 346.86750000000006L 157.88802083333334 346.86750000000006L 236.83203125000003 346.86750000000006L 315.7760416666667 346.86750000000006L 394.72005208333337 346.86750000000006L 473.66406250000006 346.86750000000006"></path><g id="SvgjsG1546" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1602" r="0" cx="78.94401041666667" cy="208.12050000000005" class="apexcharts-marker wng1m3fax no-pointer-events" stroke="#8950fc" fill="#eee5ff" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1547" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1596" x1="78.44401041666667" y1="0" x2="78.44401041666667" y2="277.494" stroke="#8950fc" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="78.44401041666667" y="0" width="1" height="277.494" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><line id="SvgjsLine1597" x1="0" y1="0" x2="473.6640625" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1598" x1="0" y1="0" x2="473.6640625" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1599" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1600" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1601" class="apexcharts-point-annotations"></g><rect id="SvgjsRect1603" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect1604" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG1573" class="apexcharts-yaxis" rel="0" transform="translate(16.390625, 0)"><g id="SvgjsG1574" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1575" font-family="Poppins" x="20" y="31.4" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1576">100</tspan></text><text id="SvgjsText1577" font-family="Poppins" x="20" y="100.77350000000001" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1578">80</tspan></text><text id="SvgjsText1579" font-family="Poppins" x="20" y="170.14700000000002" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1580">60</tspan></text><text id="SvgjsText1581" font-family="Poppins" x="20" y="239.52050000000003" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1582">40</tspan></text><text id="SvgjsText1583" font-family="Poppins" x="20" y="308.894" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1584">20</tspan></text></g></g><rect id="SvgjsRect1595" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1539" class="apexcharts-annotations"></g></svg>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        <!--end:: Widgets/New Arrivals--> 

                        <!-- BEGIN PORTAL -->
                        <div class="row">
                        <div class="col-xl-4">

<!--begin:: Widgets/Sales Stats-->
<div class="card card--head--noborder card--height-fluid">
<div class="card-head card-head--noborder">
<div class="card-head-label">
    <h3 class="card-head-title">Market Leaders</h3>
</div>
<div class="card-head-toolbar">
    <div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="flaticon-more-1"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 33px, 0px);">
            <ul class="nav nav--block">
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
                <li class="nav__section nav__section--first">
                    <span class="nav__section-text">HR</span>
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
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label">
<img src="media/project/mark-symbol.jpg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Cup & Green</a>
<span class="pro-td-subtitle">Local, clean & environmental</span>
<span class="pro-td-subtitle">Created by: <span class="text-primary">CoreAd</span> </span>
</div>
<!-- TITLE END -->

<!-- INFO START -->
<div class="pro-td flex-0">
<span class="pro-td-title pro-text-lg align-right">24,900</span>
<span class="pro-td-subtitle pro-text-lg align-right">votes</span>
</div>
<!-- INFO END -->
</div>

<!-- WIDGET ROW END -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label">
<img src="media/project/mark-symbol.jpg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Cup & Green</a>
<span class="pro-td-subtitle">Local, clean & environmental</span>
<span class="pro-td-subtitle">Created by: <span class="text-primary">CoreAd</span> </span>
</div>
<!-- TITLE END -->

<!-- INFO START -->
<div class="pro-td flex-0">
<span class="pro-td-title pro-text-lg align-right">24,900</span>
<span class="pro-td-subtitle pro-text-lg align-right">votes</span>
</div>
<!-- INFO END -->
</div>
<!-- WIDGET ROW END -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label">
<img src="media/project/mark-symbol.jpg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Cup & Green</a>
<span class="pro-td-subtitle">Local, clean & environmental</span>
<span class="pro-td-subtitle">Created by: <span class="text-primary">CoreAd</span> </span>
</div>
<!-- TITLE END -->

<!-- INFO START -->
<div class="pro-td flex-0">
<span class="pro-td-title pro-text-lg align-right">24,900</span>
<span class="pro-td-subtitle pro-text-lg align-right">votes</span>
</div>
<!-- INFO END -->
</div>
<!-- WIDGET ROW END -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label">
<img src="media/project/mark-symbol.jpg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Cup & Green</a>
<span class="pro-td-subtitle">Local, clean & environmental</span>
<span class="pro-td-subtitle">Created by: <span class="text-primary">CoreAd</span> </span>
</div>
<!-- TITLE END -->

<!-- INFO START -->
<div class="pro-td flex-0">
<span class="pro-td-title pro-text-lg align-right">24,900</span>
<span class="pro-td-subtitle pro-text-lg align-right">votes</span>
</div>
<!-- INFO END -->
</div>
<!-- WIDGET ROW END -->
<!-- WIDGET ROW START -->
<div class="widget_custom">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label">
<img src="media/project/mark-symbol.jpg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Cup & Green</a>
<span class="pro-td-subtitle">Local, clean & environmental</span>
<span class="pro-td-subtitle">Created by: <span class="text-primary">CoreAd</span> </span>
</div>
<!-- TITLE END -->

<!-- INFO START -->
<div class="pro-td flex-0">
<span class="pro-td-title pro-text-lg align-right">24,900</span>
<span class="pro-td-subtitle pro-text-lg align-right">votes</span>
</div>
<!-- INFO END -->
</div> 
<!-- WIDGET ROW END -->
</div>

</div>

<!--end:: Widgets/Sales Stats-->
</div>


<div class="col-xl-4">    
<!--begin:: Widgets/Sales Stats-->
<div class="card card--head--noborder card--height-fluid">
<div class="card-head card-head--noborder">
<div class="card-head-label">
<h3 class="card-head-title">Recent Stats</h3>
</div>
<div class="card-head-toolbar">
<div class="dropdown dropdown-inline">
<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="flaticon-more-1"></i>
</button>
<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 33px, 0px);">
<ul class="nav nav--block">
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
<li class="nav__section nav__section--first">
<span class="nav__section-text">HR</span>
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
<span class="home-media">
<svg id="SvgjsSvg1152" width="543" height="350" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1154" class="apexcharts-inner apexcharts-graphical" transform="translate(45.75, 30)"><defs id="SvgjsDefs1153"><linearGradient id="SvgjsLinearGradient1158" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1159" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1160" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1161" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskxwmlhubr"><rect id="SvgjsRect1163" width="493.25" height="279.494" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMaskxwmlhubr"><rect id="SvgjsRect1164" width="491.25" height="281.494" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1162" width="12.18125" height="277.494" x="25.791678873697922" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1158)" class="apexcharts-xcrosshairs" y2="277.494" filter="none" fill-opacity="0.9" x1="25.791678873697922" x2="25.791678873697922"></rect><g id="SvgjsG1182" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1183" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1185" font-family="Poppins" x="40.604166666666664" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1186">Feb</tspan><title>Feb</title></text><text id="SvgjsText1188" font-family="Poppins" x="121.8125" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1189">Mar</tspan><title>Mar</title></text><text id="SvgjsText1191" font-family="Poppins" x="203.02083333333334" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1192">Apr</tspan><title>Apr</title></text><text id="SvgjsText1194" font-family="Poppins" x="284.22916666666663" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1195">May</tspan><title>May</title></text><text id="SvgjsText1197" font-family="Poppins" x="365.43749999999994" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1198">Jun</tspan><title>Jun</title></text><text id="SvgjsText1200" font-family="Poppins" x="446.64583333333326" y="306.494" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1201">Jul</tspan><title>Jul</title></text></g></g><g id="SvgjsG1214" class="apexcharts-grid"><g id="SvgjsG1215" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine1217" x1="0" y1="0" x2="487.25" y2="0" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1218" x1="0" y1="69.3735" x2="487.25" y2="69.3735" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1219" x1="0" y1="138.747" x2="487.25" y2="138.747" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1220" x1="0" y1="208.12050000000002" x2="487.25" y2="208.12050000000002" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line><line id="SvgjsLine1221" x1="0" y1="277.494" x2="487.25" y2="277.494" stroke="#ecf0f3" stroke-dasharray="4" class="apexcharts-gridline"></line></g><g id="SvgjsG1216" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine1223" x1="0" y1="277.494" x2="487.25" y2="277.494" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1222" x1="0" y1="1" x2="0" y2="277.494" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1165" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1166" class="apexcharts-series" rel="1" seriesName="NetxProfit" data:realIndex="0"><path id="SvgjsPath1168" d="M 28.422916666666666 277.494L 28.422916666666666 177.7915125Q 33.51354166666667 173.70088750000002 38.604166666666664 177.7915125L 38.604166666666664 177.7915125L 38.604166666666664 277.494L 38.604166666666664 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 28.422916666666666 277.494L 28.422916666666666 177.7915125Q 33.51354166666667 173.70088750000002 38.604166666666664 177.7915125L 38.604166666666664 177.7915125L 38.604166666666664 277.494L 38.604166666666664 277.494z" pathFrom="M 28.422916666666666 277.494L 28.422916666666666 277.494L 38.604166666666664 277.494L 38.604166666666664 277.494L 38.604166666666664 277.494L 28.422916666666666 277.494" cy="175.74620000000002" cx="108.63125" j="0" val="44" barHeight="101.74780000000001" barWidth="12.18125"></path><path id="SvgjsPath1169" d="M 109.63125 277.494L 109.63125 152.35456250000001Q 114.721875 148.26393750000003 119.8125 152.35456250000001L 119.8125 152.35456250000001L 119.8125 277.494L 119.8125 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 109.63125 277.494L 109.63125 152.35456250000001Q 114.721875 148.26393750000003 119.8125 152.35456250000001L 119.8125 152.35456250000001L 119.8125 277.494L 119.8125 277.494z" pathFrom="M 109.63125 277.494L 109.63125 277.494L 119.8125 277.494L 119.8125 277.494L 119.8125 277.494L 109.63125 277.494" cy="150.30925000000002" cx="189.83958333333334" j="1" val="55" barHeight="127.18475000000001" barWidth="12.18125"></path><path id="SvgjsPath1170" d="M 190.83958333333334 277.494L 190.83958333333334 147.72966250000002Q 195.93020833333333 143.63903750000003 201.02083333333334 147.72966250000002L 201.02083333333334 147.72966250000002L 201.02083333333334 277.494L 201.02083333333334 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 190.83958333333334 277.494L 190.83958333333334 147.72966250000002Q 195.93020833333333 143.63903750000003 201.02083333333334 147.72966250000002L 201.02083333333334 147.72966250000002L 201.02083333333334 277.494L 201.02083333333334 277.494z" pathFrom="M 190.83958333333334 277.494L 190.83958333333334 277.494L 201.02083333333334 277.494L 201.02083333333334 277.494L 201.02083333333334 277.494L 190.83958333333334 277.494" cy="145.68435000000002" cx="271.04791666666665" j="2" val="57" barHeight="131.80965" barWidth="12.18125"></path><path id="SvgjsPath1171" d="M 272.04791666666665 277.494L 272.04791666666665 150.0421125Q 277.13854166666664 145.9514875 282.22916666666663 150.0421125L 282.22916666666663 150.0421125L 282.22916666666663 277.494L 282.22916666666663 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 272.04791666666665 277.494L 272.04791666666665 150.0421125Q 277.13854166666664 145.9514875 282.22916666666663 150.0421125L 282.22916666666663 150.0421125L 282.22916666666663 277.494L 282.22916666666663 277.494z" pathFrom="M 272.04791666666665 277.494L 272.04791666666665 277.494L 282.22916666666663 277.494L 282.22916666666663 277.494L 282.22916666666663 277.494L 272.04791666666665 277.494" cy="147.9968" cx="352.25624999999997" j="3" val="56" barHeight="129.49720000000002" barWidth="12.18125"></path><path id="SvgjsPath1172" d="M 353.25624999999997 277.494L 353.25624999999997 138.4798625Q 358.34687499999995 134.3892375 363.43749999999994 138.4798625L 363.43749999999994 138.4798625L 363.43749999999994 277.494L 363.43749999999994 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 353.25624999999997 277.494L 353.25624999999997 138.4798625Q 358.34687499999995 134.3892375 363.43749999999994 138.4798625L 363.43749999999994 138.4798625L 363.43749999999994 277.494L 363.43749999999994 277.494z" pathFrom="M 353.25624999999997 277.494L 353.25624999999997 277.494L 363.43749999999994 277.494L 363.43749999999994 277.494L 363.43749999999994 277.494L 353.25624999999997 277.494" cy="136.43455" cx="433.4645833333333" j="4" val="61" barHeight="141.05945000000003" barWidth="12.18125"></path><path id="SvgjsPath1173" d="M 434.4645833333333 277.494L 434.4645833333333 145.4172125Q 439.55520833333327 141.32658750000002 444.64583333333326 145.4172125L 444.64583333333326 145.4172125L 444.64583333333326 277.494L 444.64583333333326 277.494z" fill="rgba(27,197,189,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 434.4645833333333 277.494L 434.4645833333333 145.4172125Q 439.55520833333327 141.32658750000002 444.64583333333326 145.4172125L 444.64583333333326 145.4172125L 444.64583333333326 277.494L 444.64583333333326 277.494z" pathFrom="M 434.4645833333333 277.494L 434.4645833333333 277.494L 444.64583333333326 277.494L 444.64583333333326 277.494L 444.64583333333326 277.494L 434.4645833333333 277.494" cy="143.3719" cx="514.6729166666667" j="5" val="58" barHeight="134.12210000000002" barWidth="12.18125"></path></g><g id="SvgjsG1174" class="apexcharts-series" rel="2" seriesName="Revenue" data:realIndex="1"><path id="SvgjsPath1176" d="M 40.604166666666664 277.494L 40.604166666666664 103.7931125Q 45.69479166666667 99.7024875 50.78541666666666 103.7931125L 50.78541666666666 103.7931125L 50.78541666666666 277.494L 50.78541666666666 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 40.604166666666664 277.494L 40.604166666666664 103.7931125Q 45.69479166666667 99.7024875 50.78541666666666 103.7931125L 50.78541666666666 103.7931125L 50.78541666666666 277.494L 50.78541666666666 277.494z" pathFrom="M 40.604166666666664 277.494L 40.604166666666664 277.494L 50.78541666666666 277.494L 50.78541666666666 277.494L 50.78541666666666 277.494L 40.604166666666664 277.494" cy="101.74780000000001" cx="120.8125" j="0" val="76" barHeight="175.74620000000002" barWidth="12.18125"></path><path id="SvgjsPath1177" d="M 121.8125 277.494L 121.8125 82.98106250000001Q 126.903125 78.8904375 131.99375 82.98106250000001L 131.99375 82.98106250000001L 131.99375 277.494L 131.99375 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 121.8125 277.494L 121.8125 82.98106250000001Q 126.903125 78.8904375 131.99375 82.98106250000001L 131.99375 82.98106250000001L 131.99375 277.494L 131.99375 277.494z" pathFrom="M 121.8125 277.494L 121.8125 277.494L 131.99375 277.494L 131.99375 277.494L 131.99375 277.494L 121.8125 277.494" cy="80.93575000000001" cx="202.02083333333334" j="1" val="85" barHeight="196.55825000000002" barWidth="12.18125"></path><path id="SvgjsPath1178" d="M 203.02083333333334 277.494L 203.02083333333334 45.98186250000001Q 208.11145833333333 41.89123750000001 213.20208333333335 45.98186250000001L 213.20208333333335 45.98186250000001L 213.20208333333335 277.494L 213.20208333333335 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 203.02083333333334 277.494L 203.02083333333334 45.98186250000001Q 208.11145833333333 41.89123750000001 213.20208333333335 45.98186250000001L 213.20208333333335 45.98186250000001L 213.20208333333335 277.494L 213.20208333333335 277.494z" pathFrom="M 203.02083333333334 277.494L 203.02083333333334 277.494L 213.20208333333335 277.494L 213.20208333333335 277.494L 213.20208333333335 277.494L 203.02083333333334 277.494" cy="43.93655000000001" cx="283.22916666666663" j="2" val="101" barHeight="233.55745000000002" barWidth="12.18125"></path><path id="SvgjsPath1179" d="M 284.22916666666663 277.494L 284.22916666666663 52.91921249999999Q 289.3197916666666 48.82858749999999 294.4104166666666 52.91921249999999L 294.4104166666666 52.91921249999999L 294.4104166666666 277.494L 294.4104166666666 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 284.22916666666663 277.494L 284.22916666666663 52.91921249999999Q 289.3197916666666 48.82858749999999 294.4104166666666 52.91921249999999L 294.4104166666666 52.91921249999999L 294.4104166666666 277.494L 294.4104166666666 277.494z" pathFrom="M 284.22916666666663 277.494L 284.22916666666663 277.494L 294.4104166666666 277.494L 294.4104166666666 277.494L 294.4104166666666 277.494L 284.22916666666663 277.494" cy="50.87389999999999" cx="364.43749999999994" j="3" val="98" barHeight="226.62010000000004" barWidth="12.18125"></path><path id="SvgjsPath1180" d="M 365.43749999999994 277.494L 365.43749999999994 78.35616250000001Q 370.52812499999993 74.26553750000001 375.6187499999999 78.35616250000001L 375.6187499999999 78.35616250000001L 375.6187499999999 277.494L 375.6187499999999 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 365.43749999999994 277.494L 365.43749999999994 78.35616250000001Q 370.52812499999993 74.26553750000001 375.6187499999999 78.35616250000001L 375.6187499999999 78.35616250000001L 375.6187499999999 277.494L 375.6187499999999 277.494z" pathFrom="M 365.43749999999994 277.494L 365.43749999999994 277.494L 375.6187499999999 277.494L 375.6187499999999 277.494L 375.6187499999999 277.494L 365.43749999999994 277.494" cy="76.31085000000002" cx="445.64583333333326" j="4" val="87" barHeight="201.18315" barWidth="12.18125"></path><path id="SvgjsPath1181" d="M 446.64583333333326 277.494L 446.64583333333326 36.73206249999999Q 451.73645833333325 32.64143749999999 456.82708333333323 36.73206249999999L 456.82708333333323 36.73206249999999L 456.82708333333323 277.494L 456.82708333333323 277.494z" fill="rgba(229,234,238,1)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="square" stroke-width="2" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxwmlhubr)" pathTo="M 446.64583333333326 277.494L 446.64583333333326 36.73206249999999Q 451.73645833333325 32.64143749999999 456.82708333333323 36.73206249999999L 456.82708333333323 36.73206249999999L 456.82708333333323 277.494L 456.82708333333323 277.494z" pathFrom="M 446.64583333333326 277.494L 446.64583333333326 277.494L 456.82708333333323 277.494L 456.82708333333323 277.494L 456.82708333333323 277.494L 446.64583333333326 277.494" cy="34.68674999999999" cx="526.8541666666666" j="5" val="105" barHeight="242.80725000000004" barWidth="12.18125"></path></g><g id="SvgjsG1167" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1175" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine1224" x1="0" y1="0" x2="487.25" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1225" x1="0" y1="0" x2="487.25" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1226" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1227" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1228" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1202" class="apexcharts-yaxis" rel="0" transform="translate(15.75, 0)"><g id="SvgjsG1203" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1204" font-family="Poppins" x="20" y="31.4" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1205">120</tspan></text><text id="SvgjsText1206" font-family="Poppins" x="20" y="100.77350000000001" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1207">90</tspan></text><text id="SvgjsText1208" font-family="Poppins" x="20" y="170.14700000000002" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1209">60</tspan></text><text id="SvgjsText1210" font-family="Poppins" x="20" y="239.52050000000003" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1211">30</tspan></text><text id="SvgjsText1212" font-family="Poppins" x="20" y="308.894" text-anchor="end" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b5b5c3" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Poppins;"><tspan id="SvgjsTspan1213">0</tspan></text></g></g><g id="SvgjsG1155" class="apexcharts-annotations"></g></svg>
</span>

</div>

</div>

<!--end:: Widgets/Sales Stats-->
</div>

<div class="col-xl-4">    
<!--begin:: Widgets/Sales Stats-->
<div class="card card--head--noborder card--height-fluid">
<div class="card-head card-head--noborder">
<div class="card-head-label">
    <h3 class="card-head-title">Trends</h3>
</div>
<div class="card-head-toolbar">
    <div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="flaticon-more-1"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 33px, 0px);">
            <ul class="nav nav--block">
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
                <li class="nav__section nav__section--first">
                    <span class="nav__section-text">HR</span>
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
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label-sm">
<img src="media/project/plurk.svg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Top Authors</a>
<span class="pro-td-subtitle">5 day ago</span>
</div>
<!-- TITLE END -->
</div>
<!-- WIDGET ROW END -->
<!-- brief write up start -->
<p>A brief write up about the top Authors that fits within this section</p>
<!-- brief write up end -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label-sm">
<img src="media/project/plurk.svg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Top Authors</a>
<span class="pro-td-subtitle">5 day ago</span>
</div>
<!-- TITLE END -->
</div>
<!-- WIDGET ROW END -->
<!-- brief write up start -->
<p>A brief write up about the top Authors that fits within this section</p>
<!-- brief write up end -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label-sm">
<img src="media/project/plurk.svg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Top Authors</a>
<span class="pro-td-subtitle">5 day ago</span>
</div>
<!-- TITLE END -->
</div>
<!-- WIDGET ROW END -->
<!-- brief write up start -->
<p>A brief write up about the top Authors that fits within this section</p>
<!-- brief write up end -->
<!-- WIDGET ROW START -->
<div class="widget_custom mb-20">
<!-- MARK START -->
<div class="product-mark mr-15">
<div class="product-mark-label-sm">
<img src="media/project/plurk.svg">
</div>
</div>
<!-- MARK END -->

<!-- TITLE START -->
<div class="pro-td mr-15">
<a href="#" class="pro-td-title">Top Authors</a>
<span class="pro-td-subtitle">5 day ago</span>
</div>
<!-- TITLE END -->
</div>
<!-- WIDGET ROW END -->
<!-- brief write up start -->
<p>A brief write up about the top Authors that fits within this section</p>
<!-- brief write up end -->
</div>

</div>

<!--end:: Widgets/Sales Stats-->
</div>


</div>
<!-- END PORTAL -->
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
<script src="js/vendors/chartist.js"></script>
<script src="js/index-charts.js"></script>

</body>


</html>