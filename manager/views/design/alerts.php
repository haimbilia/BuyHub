<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>



<body
    class="">
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
                            <h3 class="subheader__title">Alerts</h3>

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
                                    Alerts </a>
                            </div>

                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn subheader__btn-secondary">
                                    Reports
                                </a>

                                <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                    data-placement="top" data-original-title="Quick actions">
                                    <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                        <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                        <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New
                                            Download</a>
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
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                <div class="alert-text">
                                    FB-admin extends <code>Bootstrap Alert</code> component with a variety of options to
                                    provide uniquely looking Alert component that matches the FB-admin's design
                                    standards.
                                    <br>
                                    For more info please visit the plugin's the component's <a class="link font-bold"
                                        href="https://getbootstrap.com/docs/4.3/components/alerts/"
                                        target="_blank">Documentation</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Basic Alerts
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">Alerts are available for any length of text, as well
                                            as an optional dismiss button.</div>
                                        <div class="section__content">
                                            <div class="alert alert-primary" role="alert">
                                                <div class="alert-text">A simple primary alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="alert-text">A simple secondary alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-success" role="alert">
                                                <div class="alert-text">A simple success alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-danger" role="alert">
                                                <div class="alert-text">A simple danger alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-warning" role="alert">
                                                <div class="alert-text">A simple warning alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-info" role="alert">
                                                <div class="alert-text">A simple info alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-elevate alert-light" role="alert">
                                                <div class="alert-text">A simple light alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-dark" role="alert">
                                                <div class="alert-text">A simple dark alert—check it out!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <!--end::card-->

                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            With Icons
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">With Icons</div>
                                        <div class="section__content">
                                            <div class="alert alert-primary" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple primary alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple secondary alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-success" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple success alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-danger" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple danger alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-warning" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple warning alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-info" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple info alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-light alert-elevate" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple light alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-dark" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple dark alert—check it out!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <!--end::card-->

                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Additional Content
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">Alerts can also contain additional HTML elements like
                                            headings, paragraphs and dividers.</div>
                                        <div class="section__content">
                                            <div class="demo">
                                                <div class="demo__preview">
                                                    <div class="alert alert-success" role="alert">
                                                        <div class="alert-text">
                                                            <h4 class="alert-heading">Well done!</h4>
                                                            <p>Aww yeah, you successfully read this important alert
                                                                message. This example text is going to run a bit longer
                                                                so that you can see how spacing within an alert works
                                                                with this kind of content.</p>
                                                            <hr>
                                                            <p class="mb-0">Whenever you need to, be sure to use margin
                                                                utilities to keep things nice and tidy.</p>
                                                        </div>
                                                    </div>

                                                    <div class="separator separator--space-lg separator--border-dashed">
                                                    </div>

                                                    <div class="alert alert-danger" role="alert">
                                                        <div class="alert-text">
                                                            <h4 class="alert-heading">Got Issues!</h4>
                                                            <p>Aww yeah, you successfully read this important alert
                                                                message. This example text is going to run a bit longer
                                                                so that you can see how spacing within an alert works
                                                                with this kind of content.</p>
                                                            <hr>
                                                            <p class="mb-0">Whenever you need to, be sure to use margin
                                                                utilities to keep things nice and tidy.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <!--end::card-->
                        </div>
                        <div class="col-xl-6">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Alert Styles
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">Outline style examples</div>
                                        <div class="section__content">
                                            <div class="alert alert-primary fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple primary alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-secondary  fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple secondary alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-success fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple success alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-danger fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple danger alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple warning alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-info fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple info alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple light alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-dark fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple dark alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->

                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">Outline 2x style examples</div>
                                        <div class="section__content">
                                            <div class="alert alert-outline-primary fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple primary alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-brand fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple secondary alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-success fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple success alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-danger fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple danger alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-warning fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A simple warning alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-info fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple info alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-outline-dark fade show" role="alert">
                                                <div class="alert-icon"><i
                                                        class="flaticon-questions-circular-button"></i></div>
                                                <div class="alert-text">A simple dark alert—check it out!</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->
                                </div>
                            </div>
                            <!--end::card-->

                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Solid Background Alerts
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Section-->
                                    <div class="section">
                                        <div class="section__info">Alerts are available for any length of text, as well
                                            as an optional dismiss button.</div>
                                        <div class="section__content">
                                            <div class="alert alert-solid-brand alert-bold" role="alert">
                                                <div class="alert-text">A simple primary alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-solid-success alert-bold" role="alert">
                                                <div class="alert-text">A simple success alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-solid-danger alert-bold" role="alert">
                                                <div class="alert-text">A simple danger alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-solid-warning alert-bold" role="alert">
                                                <div class="alert-text">A simple warning alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-elevate alert-light alert-bold" role="alert">
                                                <div class="alert-text">A simple light alert—check it out!</div>
                                            </div>
                                            <div class="alert alert-solid-dark alert-bold" role="alert">
                                                <div class="alert-text">A simple dark alert—check it out!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->
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