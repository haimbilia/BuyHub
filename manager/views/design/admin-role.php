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
    
    <link rel="shortcut icon" href="../images/favicon.ico" />

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
                            <h3 class="subheader__title">Roles</h3>
                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">Home</a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">Users </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">Admin Roles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container  grid__item grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card--mobile">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Products</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-auto col-form-label">Role Name</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="role_name" data-vv-as="Role Name" data-vv-validate-on="none" class="form-control" aria-required="true" aria-invalid="false">
                                            <!---->
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="px-5">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                <div class="card card--bordered">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Products</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                       
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">Admins</label>
                                            <div class="col-lg-7">
                                                <select name="adminsData.permission[1]" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="0">None</option>
                                                    <option value="1">Read</option>
                                                    <option value="2">Write</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">Roles</label>
                                            <div class="col-lg-7">
                                                <select name="adminsData.permission[2]" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="0">None</option>
                                                    <option value="1">Read</option>
                                                    <option value="2">Write</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="card card--bordered">
                                                <div class="card-head">
                                                    <div class="card-head-label">
                                                        <h3 class="card-head-title">Products</h3>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                 
                                                    <div class="form-group row">
                                                        <label class="col-lg-5 col-form-label">Admins</label>
                                                        <div class="col-lg-7">
                                                            <select name="adminsData.permission[1]" class="form-control">
                                                                <option value="">Select Role</option>
                                                                <option value="0">None</option>
                                                                <option value="1">Read</option>
                                                                <option value="2">Write</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-5 col-form-label">Roles</label>
                                                        <div class="col-lg-7">
                                                            <select name="adminsData.permission[2]" class="form-control">
                                                                <option value="">Select Role</option>
                                                                <option value="0">None</option>
                                                                <option value="1">Read</option>
                                                                <option value="2">Write</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                <div class="card card--bordered">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Products</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">Admins</label>
                                            <div class="col-lg-7">
                                                <select name="adminsData.permission[1]" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="0">None</option>
                                                    <option value="1">Read</option>
                                                    <option value="2">Write</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">Roles</label>
                                            <div class="col-lg-7">
                                                <select name="adminsData.permission[2]" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="0">None</option>
                                                    <option value="1">Read</option>
                                                    <option value="2">Write</option>
                                                </select>
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
                <!-- end:: Content -->
            </div>
        </div>

        <?php
  include 'includes/footer.php';
?>
    </div>

</body>


</html>
