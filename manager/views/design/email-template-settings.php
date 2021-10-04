<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
            <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                <span class="help_label">Help</span>
            </button>
            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
                <div class="modal-dialog modal-dialog-vertical" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Email Template Management</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Logo aspect ratio</label>
                                                <div class="col-lg-12">
                                                    <div class="radio-inline"><label class="radio"><input type="radio" name="aspect_ratio" value="1.0"> 1:1<span></span></label> <label class="radio"><input type="radio" name="aspect_ratio" value="1.77777"> 16:9<span></span></label></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Replacement Variables</label>
                                                <div class="col-lg-12">
                                                    <ul class="click-to-copy">
                                                        <li title="" data-val="{websiteName}" data-original-title="Click to copy" aria-describedby="__bv_tooltip_152__">
                                                            <div class="text">Website Name</div>
                                                        </li>
                                                        <li title="Click to copy" data-val="{businessEmail}">
                                                            <div class="text">Business Email</div>
                                                        </li>
                                                        <li title="Click to copy" data-val="{businessPhone}">
                                                            <div class="text">Business Phone</div>
                                                        </li>
                                                        <li title="Click to copy" data-val="{privacyUrl}">
                                                            <div class="text">Privacy Link</div>
                                                        </li>
                                                        <li title="" data-val="{termsUrl}" data-original-title="Click to copy" aria-describedby="__bv_tooltip_156__">
                                                            <div class="text">Terms Link</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Social Links</label>
                                                <div class="col-lg-12">
                                                    <ul class="list-switch list-switch--three web-social-switch">
                                                        <li class="active facebook"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#facebook"></use>
                                                                    </svg></i> Facebook
                                                            </span></li>
                                                        <li class="active twitter"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#twitter"></use>
                                                                    </svg></i>
                                                                Twitter
                                                            </span></li>
                                                        <li class="active youtube"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#youtube"></use>
                                                                    </svg></i>
                                                                Youtube
                                                            </span></li>
                                                        <li class="active instagram"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#instagram"></use>
                                                                    </svg></i>
                                                                Instagram
                                                            </span></li>
                                                        <li class="pinterest"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pinterest"></use>
                                                                    </svg></i>
                                                                Pinterest
                                                            </span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Email Logo</label>
                                                        <div class="col-lg-9">
                                                            <div id="user_avatar" class="avatar avatar--outline">
                                                                <div class="avatar__holder" style="background-image: url(&quot;yokart/image/emailLogo/0/0/thumb/T14685C89Y&quot;);"></div>
                                                                <div>
                                                                     <input type="file" accept="image/*" class="YK-tempUploadButton-originalImage" style="display: none;"> <label data-toggle="tooltip" title="" data-original-title="Change avatar" class="avatar__upload yk-outerCropEdit"><i class="fa fa-pen"></i></label>
                                                                    
                                                                </div> <img src="yokart/image/emailLogo/0/0/original/0WG5BGBY39" id="originalImage" style="display: none;">
                                                            </div>
                                                            
                                                            <p class="img-disclaimer py-2"><strong>Image Disclaimer:</strong>
                                                                File type must be a .jpg, .gif or .png smaller than 2MB and at least 160x90 in 16:9 aspect ratio
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include 'includes/footer.php';
            ?>
            <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
            <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>
            <script>
                var input = document.querySelector('input[name=tags-outside]')
                // init Tagify script on the above inputs
                var tagify = new Tagify(input, {
                    whitelist: ["Thin 100", "Thin 100 italic", "Light 300", "Light 300 italic", "Regular 400",
                        "Regular 400 italic",
                        "Medium 500", "Medium 500 italic", "Bold 700", "Bold 700 italic",
                        "Black 900"
                    ],
                    dropdown: {
                        position: "input",
                        enabled: 0 // always opens dropdown when input gets focus
                    }
                })
            </script>
        </div>
    </div>
</body>

</html>