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

                                Validation States </h3>

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
                                    Form Validation </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Validation States </a>
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
                        <div class="col-lg-6">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Default Form Validation States
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Input with success</label>
                                            <input type="text" class="form-control is-valid" id="inputSuccess1">
                                            <div class="valid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputWarning1">Input with error</label>
                                            <input type="text" class="form-control is-invalid" id="inputWarning1">
                                            <div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="submit" class="btn btn-secondary">Cancel</button>
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
                                        <h3 class="card-head-title">
                                            Horizontal Form Validation States
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row validated">
                                            <label class="col-form-label col-lg-3" for="inputSuccess1">Input with success</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control is-valid" id="inputSuccess1">
                                                <div class="valid-feedback">Success! You've done it.</div>
                                                <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validated">
                                            <label class="col-form-label col-lg-3" for="inputWarning1">Input with error</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control is-invalid" id="inputWarning1">
                                                <div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
                                                <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
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
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Input Group Validation States
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Left Addon</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="la la-bar-chart"></i></span></div>
                                                <input type="text" class="form-control is-valid" placeholder="Email" aria-describedby="basic-addon1">
                                                <div class="valid-feedback">Success! You've done it.</div>
                                            </div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputWarning1">Right Addon</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control is-invalid" value="4444a" placeholder="Email" aria-describedby="basic-addon1">
                                                <div class="input-group-append"><span class="input-group-text" id="basic-addon1">USD</span></div>
                                                <div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
                                            </div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="submit" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::card-->
                        </div>
                        <div class="col-lg-6">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Checkbox &amp; Radio Validation States
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Checkboxes</label>
                                            <div class="checkbox-list">
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 1
                                                    <span></span>
                                                </label>
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 2
                                                    <span></span>
                                                </label>
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 3
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="valid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Inline Checkboxes</label>
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 1
                                                    <span></span>
                                                </label>
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 2
                                                    <span></span>
                                                </label>
                                                <label class="checkbox">
                                                    <input type="checkbox"> Option 3
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Radios</label>
                                            <div class="radio-list">
                                                <label class="radio">
                                                    <input type="radio"> Option 1
                                                    <span></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"> Option 2
                                                    <span></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"> Option 3
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="valid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Inline Radios</label>
                                            <div class="radio-inline">
                                                <label class="radio">
                                                    <input type="radio"> Option 1
                                                    <span></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"> Option 2
                                                    <span></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"> Option 3
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions form__actions">
                                            <button type="submit" class="btn btn-brand">Submit</button>
                                            <button type="submit" class="btn btn-secondary">Cancel</button>
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
                                        <h3 class="card-head-title">
                                            Icon Input Validation States
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputSuccess1">Left Icon</label>
                                            <div class="input-icon input-icon--left">
                                                <input type="text" class="form-control is-valid" placeholder="Email">
                                                <span class="input-icon__icon"><span><i class="la la-map-marker"></i></span></span>
                                            </div>
                                            <div class="valid-feedback">Success! You've done it.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                        <div class="form-group validated">
                                            <label class="form-control-label" for="inputWarning1">Right Icon</label>
                                            <div class="input-icon input-icon--right">
                                                <input type="text" class="form-control is-invalid" placeholder="Email">
                                                <span class="input-icon__icon input-icon__icon--right"><span><i class="la la-unlock-alt"></i></span></span>
                                            </div>
                                            <div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
                                            <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <button type="submit" class="btn btn-brand">Submit</button>
                                            <button type="submit" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
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