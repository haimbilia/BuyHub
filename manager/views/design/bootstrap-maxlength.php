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

                                Bootstrap Maxlength </h3>

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
                                    Maxlength </a>
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
                                    This plugin integrates by default with Twitter bootstrap using badges to display the maximum length of the field where the user is inserting text. Uses the HTML5 attribute "maxlength" to work.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="http://mimo84.github.io/bootstrap-maxlength/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/mimo84/bootstrap-maxlength" target="_blank">Github Repo</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    Bootstrap Maxlength Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Default Usage</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="maxlength_1" maxlength="3" placeholder="">
                                        <span class="form-text text-muted">The badge will show up by default when the remaining chars are 3 or less</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Threshold Demo</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="maxlength_2" maxlength="7" placeholder="">
                                        <span class="form-text text-muted">Set threshold value to show there are 5 chars or less</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Always Show</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="maxlength_3" maxlength="6" placeholder="">
                                        <span class="form-text text-muted">Show the counter on input focus</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Custom Text</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="maxlength_4" maxlength="8" placeholder="">
                                        <span class="form-text text-muted">Display custom text on input focus</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Textarea Example</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <textarea class="form-control" id="maxlength_5" maxlength="8" placeholder="" rows="6"></textarea>
                                        <span class="form-text text-muted">Bootstrap maxlength supports textarea as well as inputs</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Positions</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control" id="maxlength_6_1" maxlength="8" placeholder="Top left">
                                        <div class="space-10"></div>
                                        <input type="text" class="form-control" id="maxlength_6_2" maxlength="8" placeholder="Top right">
                                        <div class="space-10"></div>
                                        <input type="text" class="form-control" id="maxlength_6_3" maxlength="8" placeholder="Bottom left">
                                        <div class="space-10"></div>
                                        <input type="text" class="form-control" id="maxlength_6_4" maxlength="8" placeholder="Bottom right">
                                        <span class="form-text text-muted">The field counter can be positioned at the top, bottom, left or right.</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <a href="" class="btn btn-brand btn-pill" data-toggle="modal" data-target="#maxlength_modal">Launch maxlength inputs on modal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-foot">
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

                    <!--begin::Modal-->
                    <div class="modal fade" id="maxlength_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Bootstrap Maxlength Examples</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="la la-remove"></span>
                                    </button>
                                </div>
                                <form class="form form--fit form--label-right">
                                    <div class="modal-body">
                                        <div class="form-group row margin-t-20">
                                            <label class="col-form-label col-lg-3 col-sm-12">Default Usage</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" id="maxlength_1_modal" maxlength="3" placeholder="">
                                                <span class="form-text text-muted">The badge will show up by default when the remaining chars are 3 or less</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Threshold Demo</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" id="maxlength_2_modal" maxlength="7" placeholder="">
                                                <span class="form-text text-muted">Set threshold value to show there are 5 chars or less</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Textarea Example</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <textarea class="form-control" id="maxlength_5_modal" maxlength="8" placeholder="" rows="6"></textarea>
                                                <span class="form-text text-muted">Bootstrap maxlength supports textarea as well as inputs</span>
                                            </div>
                                        </div>
                                        <div class="form-group row margin-b-20">
                                            <label class="col-form-label col-lg-3 col-sm-12">Custom Text</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" id="maxlength_4_modal" maxlength="8" placeholder="">
                                                <span class="form-text text-muted">Display custom text on input focus</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-secondary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
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