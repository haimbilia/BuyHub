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

                                DropzoneJS </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    File Upload </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    DropzoneJS </a>
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
                                    DropzoneJS is an open source library that provides drag’n’drop file uploads with image previews. It’s lightweight, doesn’t depend on any other library (like jQuery) and is highly customizable.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="https://www.dropzonejs.com/" target="_blank">Demo Page</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    Dropzone File Upload Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right" id="awesome-dropzone">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Single File Upload</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropzone dropzone-default dz-clickable" id="dropzone_1">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                <span class="dropzone-msg-desc">This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Multiple File Upload</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropzone dropzone-default dropzone-brand dz-clickable" id="dropzone_2">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                <span class="dropzone-msg-desc">Upload up to 10 files</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">File Type Validation</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropzone dropzone-default dropzone-success dz-clickable" id="dropzone_3">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                <span class="dropzone-msg-desc">Only image, pdf and psd files are allowed for upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-foot">
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

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card margin-top-30">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Manual Multiple File Upload
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form form--label-right">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Full Name:</label>
                                            <div class="col-lg-7">
                                                <input type="name" class="form-control" placeholder="Enter full name">
                                                <span class="form-text text-muted">Please enter your full name</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Email:</label>
                                            <div class="col-lg-7">
                                                <input type="email" class="form-control" placeholder="Enter email">
                                                <span class="form-text text-muted">Please enter your email</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Message:</label>
                                            <div class="col-lg-7">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Please enter your message"></textarea>
                                                <span class="form-text text-muted">We'll never share your message with anyone else.</span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-last row">
                                            <label class="col-lg-3 col-form-label">Upload Files:</label>
                                            <div class="col-lg-9">
                                                <div class="dropzone dropzone-multi" id="dropzone_4">
                                                    <div class="dropzone-panel">
                                                        <a class="dropzone-select btn btn-label-brand btn-bold btn-sm dz-clickable">Attach files</a>
                                                        <a class="dropzone-upload btn btn-label-brand btn-bold btn-sm">Upload All</a>
                                                        <a class="dropzone-remove-all btn btn-label-brand btn-bold btn-sm">Remove All</a>
                                                    </div>
                                                    <div class="dropzone-items">

                                                    </div>
                                                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <div class="row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-lg-6">
                                                    <button type="reset" class="btn btn-brand">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card margin-top-30">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Automatic Multiple File Upload
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form form--label-right">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Full Name:</label>
                                            <div class="col-lg-7">
                                                <input type="name" class="form-control" placeholder="Enter full name">
                                                <span class="form-text text-muted">Please enter your full name</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Email:</label>
                                            <div class="col-lg-7">
                                                <input type="email" class="form-control" placeholder="Enter email">
                                                <span class="form-text text-muted">Please enter your email</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Message:</label>
                                            <div class="col-lg-7">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Please enter your message"></textarea>
                                                <span class="form-text text-muted">We'll never share your message with anyone else.</span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-last row">
                                            <label class="col-lg-3 col-form-label">Upload Files:</label>
                                            <div class="col-lg-9">
                                                <div class="dropzone dropzone-multi" id="dropzone_5">
                                                    <div class="dropzone-panel">
                                                        <a class="dropzone-select btn btn-label-brand btn-bold btn-sm dz-clickable">Attach files</a>
                                                    </div>
                                                    <div class="dropzone-items">

                                                    </div>
                                                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <div class="row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-lg-6">
                                                    <button type="reset" class="btn btn-brand">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>

        <?php
  include 'includes/footer.php';
?>

        <script src="js/vendors/dropzone.js"></script>
        <script>
            $("awesome-dropzone").dropzone({
                url: ""
            });
        </script>
    </div>

</body>


</html>