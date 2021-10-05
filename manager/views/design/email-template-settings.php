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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            <a class="back" href="">
                                                <svg class="svg" width="24" height="24">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                                    </use>
                                                </svg>

                                            </a>
                                            Email Template Management
                                        </h3>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form">
                                        <div class="form">
                                            <div class="form-group">
                                                <label class="label">Aspect ratio</label>
                                                <div class="radio-inline">
                                                    <label class="radio"><input type="radio" name="aspect_ratio" value="1.0"> 1:1<span></span></label>
                                                    <label class="radio"><input type="radio" name="aspect_ratio" value="1.77777"> 16:9<span></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="label d-block">Email Logo</label>
                                                <div class="dropzone dropzone-default dz-clickable" id="dropzone_1">
                                                <div class="upload_cover">
                                                    <!-- <div class="img--container uploded__img">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/banners/"
                                                            title="">
                                                        <div class="upload__action">
                                                            <button type="button"><svg>
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#delete-icon">
                                                                    </use>
                                                                </svg></button>
                                                            <button type="button">
                                                                <svg>
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#edit-icon">
                                                                    </use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div> -->
                                                    <div clas="img--container  ">
                                                        <div class="file-upload">
                                                            <img
                                                                src="<?php echo CONF_WEBROOT_URL; ?>images/upload/upload_img.png">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <p class="form-text"><strong>Image Disclaimer:</strong>
                                                    File type must be a .jpg, .gif or .png smaller than 2MB and at least 160x90 in 16:9 aspect ratio
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="label">Footer Html</label>
                                                <div class="iframe-container">
                                                    <iframe border="0" height="100%" width="100%" src="quill-chat.php"></iframe>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="label">Replacement Variables</label>
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
                                            <div class="form-group">
                                                <label class="label">Social Links</label>
                                                <ul class="list-switch list-switch--three web-social-switch">
                                                    <li class="active facebook"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#facebook"></use>
                                                                </svg></i>
                                                        </span></li>
                                                    <li class="active twitter"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#twitter"></use>
                                                                </svg></i>

                                                        </span></li>
                                                    <li class="youtube"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#youtube"></use>
                                                                </svg></i>

                                                        </span></li>
                                                    <li class="instagram"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#instagram"></use>
                                                                </svg></i>

                                                        </span></li>
                                                    <li class="pinterest"><span><i class="svg--icon"><svg width="24px" height="24px" class="svg">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pinterest"></use>
                                                                </svg></i>

                                                        </span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 16px; font-family: 'Poppins', sans-serif;background-color: #F6F6F6;background-image: url(bg-top.png), url(bg-center.png), url(bg-bottom.png);background-repeat: no-repeat, no-repeat, no-repeat;background-position: top left, right center, bottom left;">
                                        <tr>
                                            <td style="padding:40px;"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="text-align: center;">Subject: Verification code for Account on {Website name}</p>
                                                <table width="600px" cellspacing="0" cellpadding="0" style="margin:0 auto;table-layout:fixed;background:#ffffff;border-radius: 4px;box-shadow: 0 0 10px rgba(0,0,0,0.04);">

                                                    <tr>
                                                        <td>
                                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td style="text-align:center;padding-top: 60px;">
                                                                        <div class="logo-wrapper" style="max-width: 200px;margin: 0 auto;"><img style="max-width: 100%;" src="img/email-logo.png" alt="" /></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:30px 40px 50px 40px; text-align: center;">
                                                            <h1 style="font-size: 40px;letter-spacing: -0.4px;margin: 0 0 30px 0;font-weight: 700;color: #212529;">Welcome to {website name}</h1>
                                                            <p style="font-size: 16px;line-height: 1.5;letter-spacing: -0.32px;color: #212529;margin: 0 0 10px 0;">Hello {Username},</p>
                                                            <p style="opacity: 0.7;font-size: 14px;letter-spacing: -0.28px;color: #212529;line-height: 1.71;margin: 0 0 20px 0;">You are almost ready to start enjoying {website name} , use the verification code below to activate your account</p>
                                                            <p style="font-size: 32px;font-weight: 500;letter-spacing: 16px;font-weight: 600;">0845</p>
                                                            <p style="opacity: 0.7;font-size: 14px;letter-spacing: -0.28px;color: #212529;line-height: 1.71;margin: 0 0 20px 0;">If you did not sign up to {website name} then please ignore this email or contact us at {email ID}</p>
                                                            <p style="font-size: 14px;line-height: 1.71;letter-spacing: -0.28px;color: #212529;margin: 0;">Thank You<br> Team {website name}
                                                            </p>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:30px;">
                                                <table width="600px" cellspacing="0" cellpadding="0" style="margin:0 auto;table-layout:fixed;">
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <p style="font-family: 'Poppins', sans-serif;font-size: 14px;letter-spacing: -0.2px;display: block;box-sizing: border-box;font-weight: 400;color: #212529;line-height: 26px;margin:0 0 20px 0;">Contact {website name} at<br />
                                                                <a href="mailto:tribe@sv.com" style="color: #F13925;text-decoration: none;">{Email}</a> or call at <a href="tel:+1235546464" style="color: #F13925;text-decoration: none;">{Phone}</a>
                                                            </p>
                                                            <h5 style="font-size: 18px;font-weight: 600;text-transform: uppercase;letter-spacing: -0.2px;line-height: 24px;
                                display: block;margin: 0 0 15px 0;color:#212529;">Get In Touch</h5>
                                                            <a href="javascript:void(0);" style="display: inline-block;margin: 0 4px;"><img src="img/fb.png" alt="facebook" /></a>
                                                            <a href="javascript:void(0);" style="display: inline-block;margin: 0 4px;"><img src="img/twt.png" alt="Twitter" /></a>
                                                            <a href="javascript:void(0);" style="display: inline-block;margin: 0 4px;"><img src="img/insta.png" alt="Instagram" /></a>
                                                            <a href="javascript:void(0);" style="display: inline-block;margin: 0 4px;"><img src="img/in.png" alt="Linkedin" /></a>
                                                            <span style="    display: block;
                                width: 100%;
                                font-size: 12px;
                                padding: 10px 0;color: #212529;"></span>
                                                            <a href="javascript:void(0);" style="display: inline-block;font-size: 14px;font-weight: 500;color: 212529;text-decoration: underline;">Terms & Conditions</a>
                                                            <a href="javascript:void(0);" style="display: inline-block;font-size: 14px;font-weight: 500;color: 212529;text-decoration: underline;border-left: 1px solid #212529;line-height: 12px;padding:0 15px;margin:0 15px;">Privacy Policy</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:40px;"></td>
                                        </tr>
                                    </table>
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
                });
            </script>
            <script>
            $(document).ready(function() {
                $(".upload_cover").hover(function() {
                    $('.file-upload').toggleClass("isactive");
                });
            });
            </script>
        </div>
    </div>
</body>

</html>