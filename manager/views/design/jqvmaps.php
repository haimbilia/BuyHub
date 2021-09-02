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
                            <h3 class="subheader__title">JQV Maps</h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Features </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                Maps </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                JQV Maps </a>
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
                    <div class="card card--height-fluid">
                        <div class="card-body card__body--fluid">
                            <p>JQVMap is a jQuery plugin that renders Vector Maps with resizable Scalable Vector Graphics (SVG). For more info please check JQVMap's Home.</p>
                        </div>
                    </div>
                <!-- END POPRTAL--> 
                <!--START MAIN PORTAL-->     
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card card--height-fluid">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">World Map</h3>
                                </div>
                            </div>
                            <div class="card-body card__body--fluid">
                                <div id="vmap" style="width: 600px; height: 400px;"></div>
                            </div>
                        </div>              
                    </div>
                </div>
                <!--END MAIN PORTAL-->
                </div>
                <!--END CONTAINER-->

                

                    <!--begin::Modal-->
                    <div class="modal fade" id="datatable_records_fetch_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Selected Records</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="scroll ps" data-scroll="true" data-height="200" style="height: 200px; overflow: hidden;">
                                        <ul id="apps_user_fetch_records_selected"></ul>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                </div>
                <!-- end:: Content -->
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>
 <!--START MAP-->
 <link href="dist/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="dist/jquery.vmap.js"></script>
    <script type="text/javascript" src="dist/maps/jquery.vmap.world.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/jquery.vmap.sampledata.js"></script>

    <script>
      jQuery(document).ready(function () {
        jQuery('#vmap').vectorMap({
          map: 'world_en',
          backgroundColor: '#fff',
          color: '#ffffff', 
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          scaleColors: ['#C8EEFF', '#006491'],
          values: sample_data,
          normalizeFunction: 'polynomial'
        });
      });
    </script>
    <!--END MAP--->
</body>


</html>