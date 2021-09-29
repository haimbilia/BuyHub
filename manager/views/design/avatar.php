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
            <div class="body " id="body">
                <div class="content " id="content">
                    <!-- begin:: Subheader -->
                    <div class="subheader   grid__item" id="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title">Avatar</h3>
                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Crud </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        File Upload </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Avatar </a>
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
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-light alert-elevate fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                    <div class="alert-text">
                                        Avatar is custom made plugin that provides an image attachment for form
                                        submition with dynamic preview.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::card-->
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        Avatar Attachment With Dynamic Preview
                                    </h3>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <form class="form form--label-right">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Basic Example</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="avatar avatar-outline">
                                                <div class="avatar__holder"
                                                    style="background-image: url(<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg)">
                                                </div>
                                                <label class="avatar__upload" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="avatar__cancel" data-toggle="tooltip" title=""
                                                    data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg,
                                                jpeg.</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Non-outline Style</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="avatar" id="user_avatar_2">
                                                <div class="avatar__holder"
                                                    style="background-image: url(<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg)">
                                                </div>
                                                <label class="avatar__upload" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="avatar__cancel" data-toggle="tooltip" title=""
                                                    data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg,
                                                jpeg.</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Circle Style</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="avatar avatar-outline avatar-circle" id="user_avatar_3">
                                                <div class="avatar__holder"
                                                    style="background-image: url(<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg)">
                                                </div>
                                                <label class="avatar__upload" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="avatar__cancel" data-toggle="tooltip" title=""
                                                    data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg,
                                                jpeg.</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">State Colors</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="avatar avatar-outline avatar-danger" id="user_avatar_4">
                                                <div class="avatar__holder"
                                                    style="background-image: url(<?php echo CONF_WEBROOT_URL;?>images/users/100_7.jpg)">
                                                </div>
                                                <label class="avatar__upload" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="avatar__cancel" data-toggle="tooltip" title=""
                                                    data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg,
                                                jpeg.</span>
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