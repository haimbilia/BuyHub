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
    <link type="text/css" rel="stylesheet" href="scss/vendor/featherlight.gallery.css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />
    <style type="text/css">
        @media all {
            .lightbox {
                display: none;
            }

            
            /* customized gallery */

            .featherlight-gallery2 {
                background: rgba(100, 100, 100, 0.5);
            }

            .featherlight-gallery2 .featherlight-content {
                background: #000;
            }

            .featherlight-gallery2 .featherlight-next:hover,
            .featherlight-gallery2 .featherlight-previous:hover {
                background: rgba(0, 0, 0, 0.5);
            }

            .featherlight-gallery2 .featherlight-next:hover span,
            .featherlight-gallery2 .featherlight-previous:hover span {
                font-size: 25px;
                line-height: 25px;
                margin-top: -12.5px;
                color: #fff;
            }

            .featherlight-gallery2 .featherlight-close {
                background: transparent;
                color: #fff;
                font-size: 1.2em;
            }

            .featherlight-gallery2.featherlight-last-slide .featherlight-next,
            .featherlight-gallery2.featherlight-first-slide .featherlight-previous {
                display: none;
            }

            /* text slide */
            .thumbnail a {
                text-decoration: none;
            }

            .blurb {
                display: inline-block;
                width: 150px;
                height: 150px;
            }

            .blurb h2 {
                text-align: center;
            }

            .blurb .detail {
                display: none;
            }

            .blurb .teaser {
                font-style: italic;
                text-align: center;
            }

            .featherlight .blurb {
                display: inline-block;
                width: 500px;
                height: 300px;
                color: #99f;
            }

            .featherlight .blurb .detail {
                color: #ddf;
                font-size: large;
                display: inherit;
            }

            .featherlight .blurb .teaser {
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
                                            Featherlight Gallery </h3>
                                    </div>
                                </div>
                                <div class="card-body">



                                    <div class="jumbotron">
                                        <h1>Featherlight<i>.Gallery.js</i>
                                            <br /><span> An extension for the ultra slim jQuery lightbox Featherlight.</span></h1>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Example Gallery</h2>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product2.jpg"><img src="media/products/product2.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product3.jpg"><img src="media/products/product3.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product4.jpg"><img src="media/products/product4.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product5.jpg"><img src="media/products/product5.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery" href="media/products/product6.jpg"><img src="media/products/product6.jpg" /></a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href=".blurb">
                                                <div class="blurb">
                                                    <h2>A different example</h2>
                                                    <p class="teaser">click me!</p>
                                                    <span class="detail">
                                                        <p>Featherlight Gallery inherit all the goodies of Featherlight.</p>
                                                        <p>In particular, the different content filters are available and a gallery can have mixed content. For example, this slide that is not an image.</p>
                                                        <p>This gallery also demonstrates the use of a css variant.</p>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="thumbnail gallery2" href="media/products/product1.jpg"><img src="media/products/product1.jpg" /></a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Featherlight Gallery made simple</h2>
                                            <p>To create a gallery, simply include <kbd>featherlight.gallery.min.js</kbd> and <kbd>featherlight.gallery.min.css</kbd> after the regular featherlight files and
                                                call it like this:
                                            </p>
                                            <p>
                                                <pre>$(document).ready(function(){
	$('.gallery').featherlightGallery();
});</pre>
                                            </p>

                                            <a class="doc btn btn-lg btn-default" href="https://github.com/noelboss/featherlight/#featherlight-gallery">
                                                View Gallery Documentation
                                            </a>
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

        <script src="js/vendors/featherlight.js" type="text/javascript"></script>
        <script src="js/vendors/featherlight.gallery.js" type="text/javascript"></script>

        <script>
            $(document).ready(function() {
                $('.gallery').featherlightGallery({
                    gallery: {
                        fadeIn: 300,
                        fadeOut: 300
                    },
                    openSpeed: 300,
                    closeSpeed: 300
                });
                $('.gallery2').featherlightGallery({
                    gallery: {
                        next: 'next »',
                        previous: '« previous'
                    },
                    variant: 'featherlight-gallery2'
                });
            });
        </script>


    </div>

</body>


</html>