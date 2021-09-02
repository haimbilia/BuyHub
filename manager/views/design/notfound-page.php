<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });

    </script>
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />

</head>



<body class="">
    <div class="wrapper">
        <?php  include 'includes/header.php'; ?>
        <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Sample</h3>
                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    breadcrumb 1 </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    breadcrumb 2 </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    breadcrumb 3 </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container grid__item grid__item--fluid">


                    <div id="manage-records">
                        <div class="row">
                            <div class="col">
                                <div role="alert" class="alert alert-light alert-elevate fade show">
                                    <div class="alert-icon"><i class="flaticon-warning font-info"></i></div>
                                    <div class="alert-text">Use this section to manage categories within the system. Click on the category item to edit. Categories can be dragged to re-order.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card--height-fluid">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Categories</h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <div class="card-head-actions"><a href="javascript:void(0);" class="btn btn-brand btn-icon-sm"><i class="la la-plus"></i> Add New
                                                </a></div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card--height-fluid">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <!---->
                                            <!---->
                                        </div>
                                        <div class="card-head-toolbar">
                                            <!---->
                                            <!---->
                                        </div>
                                    </div>
                                    <!---->
                                    <div class="card-body">
                                        
                                        <div class="no-record text-center">
                                            <div class="no-record--icon ">
                                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                                            </div>
                                            <h4>No category is selected.</h4>
                                            <p>Lorem Ipsum is simply dummy text of the printing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---->
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
