<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />
</head>



<body class="subheader--transparent page--loading">
    <div class="wrapper">

        <?php
  include 'includes/header.php';
?>
        <div class="body" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">
                <!-- begin:: Subheader -->
                <div id="subheader" class="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Category</h3>
                            <div class="subheader__breadcrumbs">
                                <a javascript:void(0) class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Forms &amp; Controls </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Form Controls </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Mega Options </a>
                            </div>

                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="container grid__item grid__item--fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Email Template - Settings
                                        </h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <a href="javascript:;" class="btn btn-clean"><i class="la la-arrow-left"></i> <span class="hidden-mobile">Back</span></a>
                                        <button type="reset" class="btn btn-brand ml-2 ">Save</button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <form class="form form--label-right">
                                                <div class="row  justify-content-between">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label>Logo</label>
                                                            <div class="dropzone dropzone-default dropzone-success dz-clickable" id="dropzone_3">
                                                                <div class="dropzone-msg dz-message needsclick">
                                                                    <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                                    <span class="dropzone-msg-desc">Only image, pdf and psd files are allowed for upload</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Aspect ratio</label>

                                                            <div class="radio-inline"><label class="radio"><input type="radio" checked="checked" name="aspect_ratio" value="1.0"> 1:1<span></span></label> <label class="radio"><input type="radio" name="aspect_ratio" value="1.77777"> 16:9<span></span></label></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group"><label>Header Bg Color</label>
                                                            <img src="../media/acf-color-picker-interface.jpg">
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group"><label>Footer html</label>
                                                            <div class="">
                                                                <img src="../media/editor.jpg" /></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                    </div>


                                </div>

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