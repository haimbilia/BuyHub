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

                                Input Masks </h3>

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
                                    Input Masks </a>
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
                                    jquery.inputmask is a jquery plugin which create an input mask. An inputmask helps the user with the input by ensuring a predefined format. This can be usefull for dates, numerics, phone numbers, etc.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="https://robinherbots.github.io/Inputmask/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/RobinHerbots/Inputmask" target="_blank">Github Repo</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    Input Mask Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Date</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_1" im-insert="true">
                                        <span class="form-text text-muted">Custom date format: <code>mm/dd/yyyy</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Custom Placeholder</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_2" im-insert="true">
                                        <span class="form-text text-muted">Date mask with custom placeholder: <code>mm/dd/yyyy</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Phone Number</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_3" im-insert="true">
                                        <span class="form-text text-muted">Phone number mask: <code>(999) 999-9999</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Expty Placeholder</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_4" im-insert="true">
                                        <span class="form-text text-muted">Phone number mask: <code>99-9999999</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Repeating Mask</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_5" im-insert="true">
                                        <span class="form-text text-muted">Mask <code>9</code>, <code>99</code> or ... <code>9999999999</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Right Align</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_6" im-insert="true" style="text-align: right;">
                                        <span class="form-text text-muted">Right aligned numeric mask</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Currency</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_7" im-insert="true">
                                        <span class="form-text text-muted">Currency format <code>€ ___.__1.234,56</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">IP Address</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_8" im-insert="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Email Address</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="inputmask_9" im-insert="true">
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