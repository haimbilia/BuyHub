<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="scss/vendor/featherlight.css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />
    <style type="text/css">
        @media all {
            .lightbox {
                display: none;
            } 

        }
 
    </style>
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
                            <h3 class="subheader__title">Featherlight</h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Components </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Base </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Button Group </a>
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
                        <div class="col-xl-12">
                            <!--begin::card-->
                            <div class="card">

                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Featherlight </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="jumbotron">
                                        <h1>Featherlight<i>.js</i><span> The ultra slim lightbox.</span></h1>
                                        <p class="lead">Featherlight is a very lightweight jQuery lightbox.</p>
                                        <div class="btn-group btn-download">
                                            <a class="btn btn-lg btn-info" href="https://github.com/noelboss/featherlight/">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                                github
                                            </a>
                                            <a class="btn btn-lg btn-success" href="https://github.com/noelboss/featherlight/archive/master.zip">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                                Download <span>(1.7.13)</span>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="#" data-featherlight="#fl1">Default</a>
                                            <a class="btn btn-default" href="#" data-featherlight="#fl2" data-featherlight-variant="fixwidth">Custom Styles</a>
                                            <a class="btn btn-default" href="media/products/product10.jpg" data-featherlight="image">Image</a>
                                            <a class="btn btn-default" href="https://player.vimeo.com/video/33110953" data-featherlight="iframe" data-featherlight-iframe-allowfullscreen="true" data-featherlight-iframe-width="500" data-featherlight-iframe-height="281">iFrame</a>

                                            <a class="btn btn-default" href="index.html .ajaxcontent" data-featherlight="ajax">Ajax</a>
                                        </div>
                                    </div>



                                    <div class="lightbox" id="fl1">
                                        <h2>Featherlight Default</h2>
                                        <p>
                                            This is a default featherlight lightbox.<br>
                                            It's flexible in height and width.<br>
                                            Everything that is used to display and style the box can be found in the <a href="https://github.com/noelboss/featherlight/blob/master/src/featherlight.css">featherlight.css</a> file which is pretty simple.</p>
                                    </div>
                                    <div class="lightbox" id="fl2">
                                        <h2>Featherlight with custom styles</h2>
                                        <p>It's easy to override the styling of Featherlight. All you need to do is specify an additional class in the data-featherlight-variant of the triggering element. This class will be added and you can then override everything. You can also reset all CSS: <em>$('.special').featherlight({ resetCss: true });</em>
                                        </p>
                                    </div>
                                    <div class="ajaxcontent lightbox">
                                        <h2>This Ligthbox was loaded using ajax</h2>
                                        <p>With <a href="https://github.com/noelboss/featherlight/#installation">little code</a>, you can build lightboxes that use custom content loaded with ajax...</p>
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

        <script src="js/vendors/featherlight.js" type="text/javascript"></script>
    </div>

</body>


</html>