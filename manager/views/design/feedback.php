<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />

</head>



<body class="">
    <div class="wrapper">
        <?php
  include 'includes/header.php';
?>
        <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="YK_body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="YK_content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="YK_subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">

                                Add Project </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Apps </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Projects </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Add Project </a>
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
                    <div class="card">
                        <div class="card-body card__body--fit">
                            <div class="grid  wizard-v1 wizard-v1--white" id="YK_contacts_add" data-ktwizard-state="first">
                                <div class="grid__item grid__item--fluid wizard-v1__wrapper">
                                    <!--begin: Form Wizard Form-->
                                    <form class="form" id="YK_contacts_add_form" novalidate="novalidate">
                                        <!--begin: Form Wizard Step 1-->
                                        <div class="wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                            <div class="heading heading--md">Send us your enquiries:</div>
                                            <div class="section section--first">
                                                <div class="wizard-v1__form">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="section__body">
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <input class="form-control" type="text" value="Anna">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                                            <input type="text" class="form-control" value="+45678967456" placeholder="Phone" aria-describedby="basic-addon1">
                                                                        </div>
                                                                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                                            <input type="text" class="form-control" value="anna.krox@loop.com" placeholder="Email" aria-describedby="basic-addon1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Your Message</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"></div>
                                                                            <textarea rows="3" class="form-control" placeholder="Your Message Here" aria-describedby="basic-addon1"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 1-->


                                        <!--begin: Form Actions -->
                                        <div class="form__actions">
                                            <div class="btn btn-success btn-md btn-tall btn-wide font-bold font-transform-u" data-ktwizard-type="action-submit">
                                                Submit
                                            </div>
                                        </div>
                                        <!--end: Form Actions -->
                                    </form>
                                    <!--end: Form Wizard Form-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN card -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-diagonal bg-primary-lite">
                                <div class="d-flex align-items-center position-relative">
                                        <div class="d-block">
                                            <h3 class="text-bold">Or Reach Us by Live Chat</h3>
                                            <p>Base FAQ Question</p>
                                        </div>
                                        <div class="align-right ml-auto btn-top-show">
                                            <button type="button" class="btn btn-primary btn-lg">Submit a Request</button>
                                        </div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-diagonal bg-success-lite">
                                <div class="d-flex align-items-center position-relative">
                                        <div class="d-block">
                                            <h3 class="text-bold">Phone Call</h3>
                                            <p>Base FAQ Question</p>
                                        </div>
                                        <div class="align-right ml-auto btn-top-show">
                                            <button type="button" class="btn btn-success btn-lg">Submit a Request</button>
                                        </div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END card -->

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