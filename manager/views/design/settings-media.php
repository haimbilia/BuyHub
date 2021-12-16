<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body class="fb-body">
    <div class="app">
        <?php
        include 'includes/sidebar.php';
        ?>
        <div class="wrap">
            <?php
            include 'includes/new-header.php';
            ?>
            <button class="help-btn btn btn-light" data-bs-toggle="modal" data-bs-target="#help">
                <span class="help_label">Help</span>
            </button>
            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
                <div class="modal-dialog modal-dialog-vertical" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="help-window">
                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                                        <div class="data">
                                            <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                consectetur, adipisci velit...
                                            </h6>
                                            <ul>
                                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                    lacus vestibulum.
                                                </li>
                                                <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                    viverra.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <main class="main">
                <div class="container">
                    <div class="row grid-layout">
                        <div class="col-lg-4">
                            <button class="float-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#card-aside" aria-controls="card-aside">
                                <svg class="svg" width="20" height="20">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#nav">
                                    </use>
                                </svg>
                            </button>
                            <div class="card sticky-sidebar card-aside" tabindex="-1" id="card-aside" aria-labelledby="card-asideLabel">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            <?php echo Labels::getLabel('LBL_headings', $siteLangId); ?>
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn-close card-aside-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                </div>
                                <form class="form form-settings-bar">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <input type="search" class="form-control omni-search" name="search" value="" placeholder="Search">
                                        </div>
                                    </div>
                                </form>
                                <div class="card-body p-0">
                                    <div class="settings-inner">
                                        <ul>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Currency Converter</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Social Login</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Push Notification</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item is-active">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Media</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title"> Advertisement Feed</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Sms Notification</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Sales Tax Services</h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title"> Split Payment Methods
                                                        </h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title">Regular Payment Methods
                                                        </h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title"> Markeplace Channels
                                                        </h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title"> Shipping Services
                                                        </h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="settings-inner-item">
                                                <a class="settings-inner-link" href="">
                                                    <i class="settings-inner-icn">
                                                        <svg class="svg" width="20" height="20">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <div class="">
                                                        <h6 class="settings-inner-title"> Shipment Tracking
                                                        </h6>
                                                        <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                            consectetur adipisicing
                                                            elit. Suscipit est quos </span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Media Settings </h3>

                                    </div>

                                </div>
                                <div class="card-body">
                                    <form class="form" action="">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Admin Logo </h6>
                                                <span class="form-text text-muted">
                                                    <strong> Image Disclaimer:</strong> File type must
                                                    be a .jpg, .gif or .png smaller than 2MB and at least 160x90 in
                                                    16:9 aspect ratio</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Aspect ratio</label>
                                                    <div class="radio-button-group">
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="1" id="button1" checked="">
                                                            <label for="button1">1:1</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="2" id="button2" checked="">
                                                            <label for="button2">16:9</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="3" id="button3" checked="">
                                                            <label for="button3">Custom</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dropzone">
                                                    <div class="dropzone-upload">
                                                        <div class="file-upload">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                        </div>
                                                        <div class="needsclick">
                                                            <h3 class="dropzone-msg-title">click here to upload</h3>
                                                        </div>
                                                    </div>
                                                    <input class="dropzone-input" type="file">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-5"></div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Desktop Logo</h6>
                                                <span class="form-text text-muted"> Lorem ipsum, dolor sit amet
                                                    consectetur adipisicing elit. Similique architecto vel cumque
                                                    officia, rerum dolores sunt fuga </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Aspect ratio</label>
                                                    <div class="radio-button-group">
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="1" id="button1" checked="">
                                                            <label for="button1">1:1</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="2" id="button2" checked="">
                                                            <label for="button2">16:9</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="3" id="button3" checked="">
                                                            <label for="button3">Custom</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dropzone">
                                                    <div class="dropzone-upload">
                                                        <div class="file-upload">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                        </div>
                                                        <div class="needsclick">
                                                            <h3 class="dropzone-msg-title">click here to upload</h3>
                                                        </div>
                                                    </div>
                                                    <input class="dropzone-input" type="file">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="separator separator-dashed my-5"></div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Website Favicon</h6>
                                                <span class="form-text text-muted"> Lorem ipsum, dolor sit amet
                                                    consectetur adipisicing elit. Similique architecto vel cumque
                                                    officia, rerum dolores sunt fuga </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Aspect ratio</label>
                                                    <div class="radio-button-group">
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="1" id="button1" checked="">
                                                            <label for="button1">1:1</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="2" id="button2" checked="">
                                                            <label for="button2">16:9</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="3" id="button3" checked="">
                                                            <label for="button3">Custom</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dropzone">
                                                    <div class="dropzone-upload">
                                                        <div class="file-upload">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                        </div>
                                                        <div class="needsclick">
                                                            <h3 class="dropzone-msg-title">click here to upload</h3>
                                                        </div>
                                                    </div>
                                                    <input class="dropzone-input" type="file">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-5"></div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Social Feed Image</h6>
                                                <span class="form-text text-muted"> Lorem ipsum, dolor sit amet
                                                    consectetur adipisicing elit. Similique architecto vel cumque
                                                    officia, rerum dolores sunt fuga </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Aspect ratio</label>
                                                    <div class="radio-button-group">
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="1" id="button1" checked="">
                                                            <label for="button1">1:1</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="2" id="button2" checked="">
                                                            <label for="button2">16:9</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="3" id="button3" checked="">
                                                            <label for="button3">Custom</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dropzone">
                                                    <div class="dropzone-upload">
                                                        <div class="file-upload">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                        </div>
                                                        <div class="needsclick">
                                                            <h3 class="dropzone-msg-title">click here to upload</h3>
                                                        </div>
                                                    </div>
                                                    <input class="dropzone-input" type="file">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-5"></div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment Page Logo</h6>
                                                <span class="form-text text-muted"> Lorem ipsum, dolor sit amet
                                                    consectetur adipisicing elit. Similique architecto vel cumque
                                                    officia, rerum dolores sunt fuga </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Aspect ratio</label>
                                                    <div class="radio-button-group">
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="1" id="button1" checked="">
                                                            <label for="button1">1:1</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="2" id="button2" checked="">
                                                            <label for="button2">16:9</label>
                                                        </div>
                                                        <div class="item">
                                                            <input type="radio" name="button-group" class="radio-button" value="3" id="button3" checked="">
                                                            <label for="button3">Custom</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dropzone dropzone-custom">
                                                    <div class="dropzone-uploaded">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/banners/hero-1.jpg" title="">
                                                        <div class="dropzone-uploaded-action">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="javascript:void(0)">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </main>
            <?php
            include 'includes/footer.php';
            ?>
        </div>
    </div>


</body>

</html>