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
            <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
                <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

                    <!-- begin:: Subheader -->
                    <div class="subheader   grid__item" id="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title">

                                    Bootstrap Daterangepicker </h3>

                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Crud </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Forms &amp; Controls </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Form Widgets </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Daterangepicker </a>
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
                    <div class="container  grid__item grid__item--fluid">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-light alert-elevate fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                    <div class="alert-text">
                                        A JavaScript component for choosing date ranges, dates and times.
                                        <br>
                                        For more info please visit the plugin's <a class="link font-bold"
                                            href="http://www.daterangepicker.com/" target="_blank">Demo Page</a> or <a
                                            class="link font-bold" href="https://github.com/dangrossman/daterangepicker"
                                            target="_blank">Github Repo</a>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::card-->
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        Bootstrap Date Range Picker Examples
                                    </h3>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <form class="form form--label-right">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <input type="text" class="form-control" id="daterangepicker_1" readonly=""
                                                placeholder="Select time">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Input Group Setup</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group" id="daterangepicker_2">
                                                <input type="text" class="form-control" readonly=""
                                                    placeholder="Select date range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Icon Input</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-icon pull-right" id="daterangepicker_3">
                                                <input type="text" class="form-control " placeholder="Email">
                                                <span class="input-icon__icon input-icon__icon--right"><span><i
                                                            class="la la-calendar-check-o"></i></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Date &amp; Time Picker</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group pull-right" id="daterangepicker_4">
                                                <input type="text" class="form-control" readonly=""
                                                    placeholder="Select date &amp; time range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Date Picker</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group pull-right" id="daterangepicker_5">
                                                <input type="text" class="form-control" readonly=""
                                                    placeholder="Select date range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Predefined Ranges</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group pull-right" id="daterangepicker_6">
                                                <input type="text" class="form-control" readonly=""
                                                    placeholder="Select date range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <a href="" class="btn btn-label-brand" data-toggle="modal"
                                                data-target="#daterangepicker_modal">Launch modal Date Range Pickers</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__foot">
                                    <div class="form__actions">
                                        <div class="row">
                                            <div class="col-lg-9 ml-lg-auto">
                                                <button type="submit" class="btn btn-brand">Submit</button>
                                                <button type="submit" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::card-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="daterangepicker_modal" tabindex="-1" role="dialog"
                            aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="">Bootstrap Date Range Picker Examples</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="la la-remove"></span>
                                        </button>
                                    </div>
                                    <form class="form form--fit form--label-right">
                                        <div class="modal-body">
                                            <div class="form-group row margin-t-20">
                                                <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <input type="text" class="form-control" id="daterangepicker_1_modal"
                                                        readonly="" placeholder="Select time">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Input Group
                                                    Setup</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group" id="daterangepicker_2_modal">
                                                        <input type="text" class="form-control" readonly=""
                                                            placeholder="Select date range">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="la la-calendar-check-o"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row margin-b-20">
                                                <label class="col-form-label col-lg-3 col-sm-12">Icon Input</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-icon pull-right" id="daterangepicker_3_modal">
                                                        <input type="text" class="form-control " placeholder="Email">
                                                        <span class="input-icon__icon input-icon__icon--right"><span><i
                                                                    class="la la-calendar-check-o"></i></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-brand"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-secondary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::card-->
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        Validation State Examples
                                    </h3>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <form class="form form--label-right">
                                <div class="card-body">
                                    <div class="form-group row has-success">
                                        <label class="col-form-label col-lg-3 col-sm-12">Success State</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group" id="daterangepicker_1_validate">
                                                <input type="text" class="form-control is-valid" readonly=""
                                                    placeholder="Select date range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                                <div class="valid-feedback">Success! You've done it.</div>
                                            </div>
                                            <span class="form-text text-muted">Example help text that remains
                                                unchanged.</span>
                                        </div>
                                    </div>
                                    <div class="form-group row has-danger">
                                        <label class="col-form-label col-lg-3 col-sm-12">Danger State</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group" id="daterangepicker_2_validate">
                                                <input type="text" class="form-control is-invalid" readonly=""
                                                    placeholder="Select date range">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span>
                                                </div>
                                                <div class="invalid-feedback">Sorry, that username's taken. Try another?
                                                </div>
                                            </div>
                                            <span class="form-text text-muted">Example help text that remains
                                                unchanged.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__foot">
                                    <div class="form__actions">
                                        <div class="row">
                                            <div class="col-lg-9 ml-lg-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="submit" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::card-->
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