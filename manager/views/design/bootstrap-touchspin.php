<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
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
                            <h3 class="subheader__title">

                                Bootstrap Touchspin </h3>

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
                                    Form Widgets </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Touchspin </a>
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
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                <div class="alert-text">
                                    Bootstrap TouchSpin is a mobile and touch friendly input spinner component for Bootstrap 3 &amp; 4. It supports the mousewheel and the up/down keys.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="https://www.virtuosoft.eu/code/bootstrap-touchspin/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/istvan-ujjmeszaros/bootstrap-touchspin" target="_blank">Github Repo</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">Bootstrap Touchspin Examples</h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button></span><input id="touchspin_1" type="text" class="form-control" value="55" name="demo1" placeholder="Select time"><span class="input-group-btn input-group-append"><button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button></span></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">With Prefix</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text">$</span></span><input id="touchspin_2" type="text" class="form-control" value="0" name="demo1" placeholder="Select time"><span class="input-group-btn input-group-append"><button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button></span></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">With Postfix</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button></span><input id="touchspin_3" type="text" class="form-control" value="0" name="demo1" placeholder="Select time"><span class="input-group-addon bootstrap-touchspin-postfix input-group-append"><span class="input-group-text">$</span></span><span class="input-group-btn input-group-append"><button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button></span></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Vertical Icons:</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input id="touchspin_4" type="text" class="form-control bootstrap-touchspin-vertical-btn" value="" name="demo1" placeholder="40"><span class="input-group-btn-vertical"><button class="btn btn-secondary bootstrap-touchspin-up " type="button"><i class="la la-plus"></i></button><button class="btn btn-secondary bootstrap-touchspin-down " type="button"><i class="la la-minus"></i></button></span></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Vertical Custom Icons:</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input id="touchspin_5" type="text" class="form-control bootstrap-touchspin-vertical-btn" value="" name="demo1" placeholder="30"><span class="input-group-btn-vertical"><button class="btn btn-secondary bootstrap-touchspin-up " type="button"><i class="la la-angle-up"></i></button><button class="btn btn-secondary bootstrap-touchspin-down " type="button"><i class="la la-angle-down"></i></button></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card__foot">
                                <div class="form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
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

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">Validation State Examples</h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row is-valid">
                                    <label class="col-form-label col-lg-3 col-sm-12">Success State</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12 validate">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text">$</span></span><input id="touchspin_1_validate" type="text" class="form-control is-valid" value="" name="demo1" placeholder="40"><span class="input-group-btn input-group-append"><button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button></span></div>
                                        <div class="valid-feedback">Success! You've done it.</div>
                                        <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                    </div>
                                </div>
                                <div class="form-group row is-invalid">
                                    <label class="col-form-label col-lg-3 col-sm-12">Error State</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12 validate">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button></span><input id="touchspin_2_validate" type="text" class="form-control is-invalid" value="" name="demo2" placeholder="40"><span class="input-group-btn input-group-append"><button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button></span></div>
                                        <div class="invalid-feedback">Sorry, that username's taken. Try another?</div>
                                        <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card__foot">
                                <div class="form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="reset" class="btn btn-primary">Submit</button>
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