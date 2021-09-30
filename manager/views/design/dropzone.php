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
                <div class="container">
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


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card margin-top-30">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Single File Upload
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="py-5">
                                        <div class="dropzone dropzone-default dz-clickable" id="dropzone_1">
                                            <div class="upload_cover">
                                                <div class="img--container uploded__img">
                                                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/banners/hero-1.jpg" title="">
                                                    <div class="upload__action">
                                                        <button type="button"><svg>
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite.svg#delete-icon"></use>
                                                            </svg></button>
                                                             <button type="button">
                                                                 <svg>
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite.svg#edit-icon"></use>
                                                            </svg>
                                                        </button>
                                                        </div>
                                                </div>
                                                <div clas="img--container  ">
                                                    <div class="file-upload fileVisiblity">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end::Form-->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card margin-top-30">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Multiple File Upload
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="py-5">
                                        <div class="dropzone dropzone-default dz-clickable" id="dropzone_1">
                                            <div class="upload_cover">
                                                <div clas="img--container  ">
                                                    <div class="file-upload">
                                                        <img src="http://yokart.local.4livedemo.com/manager/images/upload/upload_img.png">
                                                    </div>
                                                </div>
                                                <div class="needsclick">
                                                    <h3 class="dropzone-msg-title">click here to upload</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="upload__files">
                                            <ul class="upload__list">
                                                <li class="upload__list-item">
                                                    <div class="media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" title="">
                                                    </div>
                                                    <div class="title">image-name.jpg</div>
                                                    <div class="action">
                                                        <a href="javascript:0;">

                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="upload__list-item">
                                                    <div class="media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" title="">
                                                    </div>
                                                    <div class="title">image-name.jpg</div>
                                                    <div class="action">
                                                        <a href="javascript:0;">
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="upload__list-item">
                                                    <div class="media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" title="">
                                                    </div>
                                                    <div class="title">image-name.jpg</div>
                                                    <div class="action">
                                                        <a href="javascript:0;">

                                                        </a>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
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

        <script src="common-js/vendors/dropzone.js"></script>
        <script>
            $(document).ready(function() {
                $(".upload_cover").hover(function() {
                    $('.file-upload').toggleClass("isactive");
                });
            });
        </script>
    </div>

</body>


</html>