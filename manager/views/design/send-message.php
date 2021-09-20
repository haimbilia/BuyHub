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
                <div class="subheader   grid__item" id="subheader" style="" hidden-height="120">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Private </h3>
                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Apps </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Chat </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Private </a>
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
                    <!--Begin::App-->
                    <div class="row justify-content-center">
                        <!--Begin:: App Content-->
                        <div class="col-lg-12 col-xl-10 msg__content" id="">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Send us your enquiries</h3>
                                    </div>
                                </div>
                                <div class="card-body widget11">
                                    <div class="table-data">
                                        <table class="table">
                                            <tr>
                                                <td>Full Name</td>
                                                <td>Michael Williams</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>login@dummyid.com</td>
                                            </tr>
                                            <tr>
                                                <td>Posted On</td>
                                                <td>23/01/2020</td>
                                            </tr>
                                            <tr>
                                                <td>Blog Post Title</td>
                                                <td>Personalize Shopping Experience with Messaging Apps</td>
                                            </tr>
                                            <tr>
                                                <td>Comment</td>
                                                <td>testing</td>
                                            </tr>
                                            <tr>
                                                <td>User Ip</td>
                                                <td>112.196.26.202</td>
                                            </tr>
                                            <tr>
                                                <td>User Agent</td>
                                                <td>Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div class="card-foot">
                                    <div class="comments-body pb-4">
                                        <div class="comment-group mb-4">
                                            <div class="chat__user">
                                                <a href="#" class="chat__username">Jason Muller</a>
                                            </div>
                                            <div class="chat__text bg-light-success p-4">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                            </div>
                                        </div>
                                        <div class="comment-group mb-4">
                                            <div class="chat__user">
                                                <a href="#" class="chat__username">Jason Muller</a>
                                            </div>
                                            <div class="chat__text bg-light-success p-4">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                            </div>
                                        </div>
                                        <div class="comment-group mb-4">
                                            <div class="chat__user">
                                                <a href="#" class="chat__username">Jason Muller</a>
                                            </div>
                                            <div class="chat__text bg-light-success p-4">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                            </div>
                                        </div>
                                    </div>
                                    <div class="msg__container">
                                        <form class="form">
                                            <div class="form-group">
                                                <label for="exampleTextarea">Readonly textarea</label>
                                                <textarea class="form-control" readonly="" rows="3"></textarea>
                                            </div>
                                            <div class="form__actions">
                                                <button type="reset" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--End:: App Content-->
                    </div>
                    <!--End::App-->
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
