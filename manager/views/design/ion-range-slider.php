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

        <div class="body " id="body">
            <div class="content " id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">

                                ion Range Slider </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Forms &amp; Controls </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Form Widgets 2 </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Ion Range Slider </a>
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
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                <div class="alert-text">
                                    Easy to use, flexible and responsive range slider with skin support.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="http://ionden.com/a/plugins/ion.rangeSlider/demo.html" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/IonDen/ion.rangeSlider" target="_blank">Github Repo</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    ion Range Slider Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Basic Example</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-0"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: hidden;">10</span><span class="irs-max" style="visibility: visible;">100</span><span class="irs-from" style="visibility: hidden;">0</span><span class="irs-to" style="visibility: hidden;">0</span><span class="irs-single" style="left: -0.30506%;">10</span></span><span class="irs-grid"></span><span class="irs-bar irs-bar--single" style="left: 0px; width: 0.952381%;"></span><span class="irs-shadow shadow-single" style="display: none;"></span><span class="irs-handle single" style="left: 0%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_1" class="irs-hidden-input" tabindex="-1" readonly="" value="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Min &amp; Max Values</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <span class="irs irs--flat js-irs-1"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">100</span><span class="irs-max" style="visibility: visible;">1 000</span><span class="irs-from" style="visibility: hidden;">0</span><span class="irs-to" style="visibility: hidden;">0</span><span class="irs-single" style="left: 48.4115%;">550</span></span><span class="irs-grid"></span><span class="irs-bar irs-bar--single" style="left: 0px; width: 50%;"></span><span class="irs-shadow shadow-single" style="display: none;"></span><span class="irs-handle single" style="left: 49.0476%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_2" class="irs-hidden-input" tabindex="-1" readonly="" value="550">
                                        <div class="ion-range-slider">
                                            <input type="hidden" id="slider_2">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Custom Prefix</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-2 irs-with-grid"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">$0</span><span class="irs-max" style="visibility: visible;">$1 000</span><span class="irs-from" style="visibility: visible; left: 18.6518%;">$200</span><span class="irs-to" style="visibility: visible; left: 77.5089%;">$800</span><span class="irs-single" style="visibility: hidden; left: 45.8296%;">$200 — $800</span></span><span class="irs-grid" style="width: 98.0952%; left: 0.852381%;"><span class="irs-grid-pol" style="left: 0%"></span><span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: -0.65569%;">0</span><span class="irs-grid-pol small" style="left: 20%"></span><span class="irs-grid-pol small" style="left: 15%"></span><span class="irs-grid-pol small" style="left: 10%"></span><span class="irs-grid-pol small" style="left: 5%"></span><span class="irs-grid-pol" style="left: 25%"></span><span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: -1.25186%;">250</span><span class="irs-grid-pol small" style="left: 45%"></span><span class="irs-grid-pol small" style="left: 40%"></span><span class="irs-grid-pol small" style="left: 35%"></span><span class="irs-grid-pol small" style="left: 30%"></span><span class="irs-grid-pol" style="left: 50%"></span><span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: -1.25186%;">500</span><span class="irs-grid-pol small" style="left: 70%"></span><span class="irs-grid-pol small" style="left: 65%"></span><span class="irs-grid-pol small" style="left: 60%"></span><span class="irs-grid-pol small" style="left: 55%"></span><span class="irs-grid-pol" style="left: 75%"></span><span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: -1.25186%;">750</span><span class="irs-grid-pol small" style="left: 95%"></span><span class="irs-grid-pol small" style="left: 90%"></span><span class="irs-grid-pol small" style="left: 85%"></span><span class="irs-grid-pol small" style="left: 80%"></span><span class="irs-grid-pol" style="left: 100%"></span><span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: -1.69829%;">1 000</span></span><span class="irs-bar" style="left: 20.5714%; width: 58.8571%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 19.619%;"><i></i><i></i><i></i></span><span class="irs-handle to type_last" style="left: 78.4762%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_3" class="irs-hidden-input" tabindex="-1" readonly="" value="200;800">
                                        </div>
                                        <div class="form-text text-muted">
                                            Set type to double and specify range, also showing grid and adding prefix "$"
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Range &amp; Step</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-3 irs-with-grid"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">-1 000</span><span class="irs-max" style="visibility: visible;">1 000</span><span class="irs-from" style="visibility: visible; left: 23.6895%;">-500</span><span class="irs-to" style="visibility: visible; left: 72.9353%;">500</span><span class="irs-single" style="visibility: hidden; left: 46.1947%;">-500 — 500</span></span><span class="irs-grid" style="width: 98.0952%; left: 0.852381%;"><span class="irs-grid-pol" style="left: 0%"></span><span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: -1.87686%;">-1 000</span><span class="irs-grid-pol small" style="left: 20%"></span><span class="irs-grid-pol small" style="left: 15%"></span><span class="irs-grid-pol small" style="left: 10%"></span><span class="irs-grid-pol small" style="left: 5%"></span><span class="irs-grid-pol" style="left: 25%"></span><span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: -1.4295%;">-500</span><span class="irs-grid-pol small" style="left: 45%"></span><span class="irs-grid-pol small" style="left: 40%"></span><span class="irs-grid-pol small" style="left: 35%"></span><span class="irs-grid-pol small" style="left: 30%"></span><span class="irs-grid-pol" style="left: 50%"></span><span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: -0.65569%;">0</span><span class="irs-grid-pol small" style="left: 70%"></span><span class="irs-grid-pol small" style="left: 65%"></span><span class="irs-grid-pol small" style="left: 60%"></span><span class="irs-grid-pol small" style="left: 55%"></span><span class="irs-grid-pol" style="left: 75%"></span><span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: -1.25186%;">500</span><span class="irs-grid-pol small" style="left: 95%"></span><span class="irs-grid-pol small" style="left: 90%"></span><span class="irs-grid-pol small" style="left: 85%"></span><span class="irs-grid-pol small" style="left: 80%"></span><span class="irs-grid-pol" style="left: 100%"></span><span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: -1.69829%;">1 000</span></span><span class="irs-bar" style="left: 25.4762%; width: 49.0476%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 24.5238%;"><i></i><i></i><i></i></span><span class="irs-handle to type_last" style="left: 73.5714%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_4" class="irs-hidden-input" tabindex="-1" readonly="" value="-500;500">
                                        </div>
                                        <div class="form-text text-muted">
                                            Set up range with negative values
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Fractional Range &amp; Step</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-4 irs-with-grid"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">-12.8</span><span class="irs-max" style="visibility: visible;">12.8</span><span class="irs-from" style="visibility: visible; left: 36.117%;">-3.2</span><span class="irs-to" style="visibility: visible; left: 60.8389%;">3.2</span><span class="irs-single" style="visibility: hidden; left: 46.5258%;">-3.2 — 3.2</span></span><span class="irs-grid" style="width: 98.0952%; left: 0.852381%;"><span class="irs-grid-pol" style="left: 0%"></span><span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: -1.57831%;">-12.8</span><span class="irs-grid-pol small" style="left: 20%"></span><span class="irs-grid-pol small" style="left: 15%"></span><span class="irs-grid-pol small" style="left: 10%"></span><span class="irs-grid-pol small" style="left: 5%"></span><span class="irs-grid-pol" style="left: 25%"></span><span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: -1.28069%;">-6.4</span><span class="irs-grid-pol small" style="left: 45%"></span><span class="irs-grid-pol small" style="left: 40%"></span><span class="irs-grid-pol small" style="left: 35%"></span><span class="irs-grid-pol small" style="left: 30%"></span><span class="irs-grid-pol" style="left: 50%"></span><span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: -0.65569%;">0</span><span class="irs-grid-pol small" style="left: 70%"></span><span class="irs-grid-pol small" style="left: 65%"></span><span class="irs-grid-pol small" style="left: 60%"></span><span class="irs-grid-pol small" style="left: 55%"></span><span class="irs-grid-pol" style="left: 75%"></span><span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: -1.10212%;">6.4</span><span class="irs-grid-pol small" style="left: 95%"></span><span class="irs-grid-pol small" style="left: 90%"></span><span class="irs-grid-pol small" style="left: 85%"></span><span class="irs-grid-pol small" style="left: 80%"></span><span class="irs-grid-pol" style="left: 100%"></span><span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: -1.40067%;">12.8</span></span><span class="irs-bar" style="left: 37.7381%; width: 24.5238%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 36.7857%;"><i></i><i></i><i></i></span><span class="irs-handle to type_last" style="left: 61.3095%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_5" class="irs-hidden-input" tabindex="-1" readonly="" value="-3.2;3.2">
                                        </div>
                                        <div class="form-text text-muted">
                                            Set up range with fractional values, using fractional step
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Using Postfixes</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-5 irs-with-grid"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">-90°</span><span class="irs-max" style="visibility: visible;">90°</span><span class="irs-from" style="visibility: hidden;">0</span><span class="irs-to" style="visibility: hidden;">0</span><span class="irs-single" style="left: 48.8356%;">0°</span></span><span class="irs-grid" style="width: 98.0952%; left: 0.852381%;"><span class="irs-grid-pol" style="left: 0%"></span><span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: -1.13188%;">-90</span><span class="irs-grid-pol small" style="left: 20%"></span><span class="irs-grid-pol small" style="left: 15%"></span><span class="irs-grid-pol small" style="left: 10%"></span><span class="irs-grid-pol small" style="left: 5%"></span><span class="irs-grid-pol" style="left: 25%"></span><span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: -1.13188%;">-45</span><span class="irs-grid-pol small" style="left: 45%"></span><span class="irs-grid-pol small" style="left: 40%"></span><span class="irs-grid-pol small" style="left: 35%"></span><span class="irs-grid-pol small" style="left: 30%"></span><span class="irs-grid-pol" style="left: 50%"></span><span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: -0.65569%;">0</span><span class="irs-grid-pol small" style="left: 70%"></span><span class="irs-grid-pol small" style="left: 65%"></span><span class="irs-grid-pol small" style="left: 60%"></span><span class="irs-grid-pol small" style="left: 55%"></span><span class="irs-grid-pol" style="left: 75%"></span><span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: -0.95331%;">45</span><span class="irs-grid-pol small" style="left: 95%"></span><span class="irs-grid-pol small" style="left: 90%"></span><span class="irs-grid-pol small" style="left: 85%"></span><span class="irs-grid-pol small" style="left: 80%"></span><span class="irs-grid-pol" style="left: 100%"></span><span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: -0.95331%;">90</span></span><span class="irs-bar irs-bar--single" style="left: 0px; width: 50%;"></span><span class="irs-shadow shadow-single" style="display: none;"></span><span class="irs-handle single" style="left: 49.0476%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_6" class="irs-hidden-input" tabindex="-1" readonly="" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Using Text</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div class="ion-range-slider">
                                            <span class="irs irs--flat js-irs-6"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">Weight: 100 million pounds</span><span class="irs-max" style="visibility: visible;">Weight: 200 million pounds</span><span class="irs-from" style="visibility: hidden; left: 37.3636%;">Weight: 145 million pounds</span><span class="irs-to" style="visibility: hidden; left: 47.1732%;">Weight: 155 million pounds</span><span class="irs-single" style="visibility: visible; left: 34.2057%;">Weight: 145 million pounds — Weight: 155 million pounds</span></span><span class="irs-grid"></span><span class="irs-bar" style="left: 45.0952%; width: 9.80952%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 44.1429%;"><i></i><i></i><i></i></span><span class="irs-handle to type_last" style="left: 53.9524%;"><i></i><i></i><i></i></span></span><input type="hidden" id="slider_7" class="irs-hidden-input" tabindex="-1" readonly="" value="145;155">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-foot">
                                <div class="form__actions">
                                    <div class="row">
                                        <div class="col-lg-8 ml-lg-auto">
                                            <button type="reset" class="btn btn-brand">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
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