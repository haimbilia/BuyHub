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

    <body class="">
        <div class="wrapper">
            <?php include 'includes/header.php';?>
            <div class="body" id="body">
                <div class="content" id="content">

                    <!-- begin:: Subheader -->
                    <div id="subheader" class="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title">Modal</h3>
                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Components </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Base </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Modal </a>
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
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-light alert-elevate fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                    <div class="alert-text">
                                        FB-admin extends <code>Bootstrap Modal</code> component with a variety of
                                        options to provide uniquely looking Modal component that matches the FB-admin's
                                        design standards.
                                        <br>
                                        For more info please visit the plugin's <a class="link font-bold"
                                            href="https://getbootstrap.com/docs/4.3/components/modal/"
                                            target="_blank">Documentation</a>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Basic demo </h6>
                                                    <div class="">
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_1"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Scrollable fixed content</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_1_2"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">

                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Scrolling long content</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_2"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Tooltips and popovers</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_3"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Large modal</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_4">Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Small modal</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_5">Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Vertically centered
                                                    </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_6"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Stick to the bottom right
                                                    </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#modal_7"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Blank Modal</h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#basic-modal-preview">
                                                            Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Programmatically Show/Hide Modal
                                                    </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#programmatically-show-modal">
                                                            Launch Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">

                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Warning Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#warning-modal-preview">
                                                            Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Modal With Close Button </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#button-modal-preview">
                                                            Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Static Backdrop Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#static-backdrop-modal-preview"> Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Overlapping Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#overlapping-modal-preview">
                                                            Launch Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Header & Footer Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#header-footer-modal-preview">
                                                            Launch Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Delete Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#delete-modal-preview">
                                                            Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Success Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal" data-target="#success-modal-preview">
                                                            Launch
                                                            Modal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Tiny Slider Modal </h6>
                                                    <div>
                                                        <button type="button" class="btn btn-brand btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#tiny-slider-modal-preview">
                                                            Launch Modal</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card border rounded-sm">
                                            <div class="card-body text-center">
                                                <div class="py-5">
                                                    <h6 class="mb-4">Modal Size
                                                    </h6>

                                                    <div class="text-center">
                                                        <!-- BEGIN: Small Modal Toggle -->
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#small-modal-size-preview"
                                                            class="btn btn-brand btn-sm mr-1 mb-2">Show Small Modal</a>
                                                        <!-- END: Small Modal Toggle -->
                                                        <!-- BEGIN: Medium Modal Toggle -->
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#medium-modal-size-preview"
                                                            class="btn btn-brand btn-sm mr-1 mb-2">Show Medium Modal</a>
                                                        <!-- END: Medium Modal Toggle -->
                                                        <!-- BEGIN: Large Modal Toggle -->
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#large-modal-size-preview"
                                                            class="btn btn-brand btn-sm mr-1 mb-2">Show Large Modal</a>
                                                        <!-- END: Large Modal Toggle -->
                                                        <!-- BEGIN: Super Large Modal Toggle -->
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#superlarge-modal-size-preview"
                                                            class="btn btn-brand btn-sm mr-1 mb-2">Show Superlarge
                                                            Modal</a>
                                                        <!-- END: Super Large Modal Toggle -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--end::card-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_1" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                            Lorem Ipsum has been the industry's standard dummy text ever since the
                                            1500s, when an unknown printer took a galley of type and scrambled it to
                                            make a type specimen book. It has survived not only five centuries, but
                                            also
                                            the leap into electronic typesetting, remaining essentially unchanged.
                                            It
                                            was popularised in the 1960s with the release of Letraset sheets
                                            containing
                                            Lorem Ipsum passages, and more recently with desktop publishing software
                                            like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_1_2" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="scroll scroll-y" data-scroll="true" data-height="200"
                                            style="overflow:auto; height: 200px;">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever
                                                since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen book. It has survived not only
                                                five
                                                centuries, but also the leap into electronic typesetting, remaining
                                                essentially unchanged. It was popularised in the 1960s with the
                                                release
                                                of Letraset sheets containing Lorem Ipsum passages, and more
                                                recently
                                                with desktop publishing software like Aldus PageMaker including
                                                versions
                                                of Lorem Ipsum.</p>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever
                                                since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen book. It has survived not only
                                                five
                                                centuries, but also the leap into electronic typesetting, remaining
                                                essentially unchanged. It was popularised in the 1960s with the
                                                release
                                                of Letraset sheets containing Lorem Ipsum passages, and more
                                                recently
                                                with desktop publishing software like Aldus PageMaker including
                                                versions
                                                of Lorem Ipsum.</p>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever
                                                since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen book. It has survived not only
                                                five
                                                centuries, but also the leap into electronic typesetting, remaining
                                                essentially unchanged. It was popularised in the 1960s with the
                                                release
                                                of Letraset sheets containing Lorem Ipsum passages, and more
                                                recently
                                                with desktop publishing software like Aldus PageMaker including
                                                versions
                                                of Lorem Ipsum.</p>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_2" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLongTitle">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                        <p>
                                            Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
                                            dapibus
                                            ac facilisis in, egestas eget quam. Morbi leo risus, porta ac
                                            consectetur
                                            ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                                            fermentum.
                                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                                            risus, porta ac consectetur ac, vestibulum at eros.
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_3" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Popover in a modal</h6>
                                        <p>This <a href="#" role="button" data-toggle="popover"
                                                class="btn btn-secondary popover-test" title=""
                                                data-content="Popover body content is set in this attribute."
                                                data-original-title="Popover title">button</a> triggers a popover on
                                            click.</p>
                                        <hr>
                                        <h6>Tooltips in a modal</h6>
                                        <p><a href="#" class="tooltip-test" data-toggle="tooltip" title=""
                                                data-original-title="Tooltip">This link</a> and <a href="#"
                                                data-toggle="tooltip" class="tooltip-test" title=""
                                                data-original-title="Tooltip">that link</a> have tooltips on
                                            hover.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_4" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">New message</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form">
                                            <div class="form-group">
                                                <label for="recipient-name"
                                                    class="form-control-label">Recipient:</label>
                                                <input type="text" class="form-control" id="recipient-name">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="form-control-label">Message:</label>
                                                <textarea class="form-control" id="message-text"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Send message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="modal_5" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">New message</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="recipient-name"
                                                    class="form-control-label">Recipient:</label>
                                                <input type="text" class="form-control" id="recipient-name">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="form-control-label">Message:</label>
                                                <textarea class="form-control" id="message-text"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Send message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!-- Modal -->
                        <div class="modal fade" id="modal_6" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLongTitle">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                            Lorem Ipsum has been the industry's standard dummy text ever since the
                                            1500s, when an unknown printer took a galley of type and scrambled it to
                                            make a type specimen book. It has survived not only five centuries, but
                                            also
                                            the leap into electronic typesetting, remaining essentially unchanged.
                                            It
                                            was popularised in the 1960s with the release of Letraset sheets
                                            containing
                                            Lorem Ipsum passages, and more recently with desktop publishing software
                                            like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::Modal-->
                        <div class="modal modal-stick-to-bottom fade" id="modal_7" role="dialog" data-backdrop="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Modal title</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                            Lorem Ipsum has been the industry's standard dummy text ever since the
                                            1500s, when an unknown printer took a galley of type and scrambled it to
                                            make a type specimen book. It has survived not only five centuries, but
                                            also
                                            the leap into electronic typesetting, remaining essentially unchanged.
                                            It
                                            was popularised in the 1960s with the release of Letraset sheets
                                            containing
                                            Lorem Ipsum passages, and more recently with desktop publishing software
                                            like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-brand">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="basic-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        This is totally awesome blank modal!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="small-modal-size-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        This is totally awesome small modal!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Small Modal Content -->
                        <!-- BEGIN: Medium Modal Content -->
                        <div id="medium-modal-size-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        This is totally awesome medium modal!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Medium Modal Content -->
                        <!-- BEGIN: Large Modal Content -->
                        <div id="large-modal-size-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        This is totally awesome large modal!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Large Modal Content -->
                        <!-- BEGIN: Super Large Modal Content -->
                        <div id="superlarge-modal-size-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        This is totally awesome superlarge modal!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="programmatically-modal" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-10 text-center">
                                        <!-- BEGIN: Hide Modal Toggle -->
                                        <a id="programmatically-hide-modal" href="javascript:;"
                                            class="btn btn-brand mr-1">Hide Modal</a>
                                        <!-- END: Hide Modal Toggle -->
                                        <!-- BEGIN: Toggle Modal Toggle -->
                                        <a id="programmatically-toggle-modal" href="javascript:;"
                                            class="btn btn-brand mr-1">Toggle Modal</a>
                                        <!-- END: Toggle Modal Toggle -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="warning-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="dialogue">
                                            <div class="pt-5 text-center">
                                                <i class="far fa-times-circle icn icn-warning"></i>
                                                <h3>Oops...</h3>
                                                <p>Something went wrong!</p>
                                            </div>
                                            <div class="pb-5 pb-8 text-center">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-brand btn-wide">Ok</button>
                                            </div>
                                            <div class="p-4 text-center border-top border-gray-200 dark:border-dark-5">
                                                <a href="" class="link">Why do I have this
                                                    issue?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="button-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="dialogue">
                                            <div class="pt-5 text-center">
                                                <i class="far fa-check-circle icn icn-success"></i>
                                                <h3>Modal Example</h3>
                                                <p>Modal with close button</p>
                                            </div>
                                            <div class="pb-5 pb-8 text-center">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-brand btn-wide">Ok</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="warning-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center">
                                            <i data-feather="x-circle" class="w-16 h-16 text-theme-23 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Oops...</div>
                                            <div class="text-gray-600 mt-2">Something went wrong!</div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-wide  btn-brand">Ok</button>
                                        </div>
                                        <div class="p-5 text-center border-t border-gray-200 dark:border-dark-5">
                                            <a href="" class="text-theme-17 dark:text-gray-300">Why do I have this
                                                issue?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="button-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <a data-dismiss="modal" href="javascript:;">
                                        <i data-feather="x" class="w-8 h-8 text-gray-500"></i>
                                    </a>
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center">
                                            <i data-feather="check-circle"
                                                class="w-16 h-16 text-theme-10 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Modal Example</div>
                                            <div class="text-gray-600 mt-2">Modal with close button</div>
                                        </div>
                                        <div class="p-2 pb-5 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-brand btn-wide ">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="static-backdrop-modal-preview" class="modal fade" data-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body px-5 py-10">
                                        <div class="text-center">
                                            <div class="mb-5">I will not close if you click outside me. Don't even
                                                try
                                                to press escape key.</div>
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-brand btn-wide ">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="overlapping-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body px-5 py-10">
                                        <div class="text-center">
                                            <div class="mb-5">Click button bellow to show overlapping modal!</div>
                                            <!-- BEGIN: Overlapping Modal Toggle -->
                                            <a href="javascript:;" data-toggle="modal"
                                                data-target="#next-overlapping-modal-preview" class="btn btn-brand">Show
                                                Overlapping Modal</a>
                                            <!-- END: Overlapping Modal Toggle -->
                                        </div>
                                        <!-- BEGIN: Overlapping Modal Content -->
                                        <div id="next-overlapping-modal-preview" class="modal fade" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        This is totally awesome overlapping modal!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Overlapping Modal Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="header-footer-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Broadcast Message</h6>
                                    </div>
                                    <div class="modal-body form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-1" class="label">From</label>
                                                    <input id="modal-form-1" type="text" class="form-control"
                                                        placeholder="example@gmail.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-2" class="label">To</label>
                                                    <input id="modal-form-2" type="text" class="form-control"
                                                        placeholder="example@gmail.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-3" class="label">Subject</label>
                                                    <input id="modal-form-3" type="text" class="form-control"
                                                        placeholder="Important Meeting">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-4" class="label">Has the Words</label>
                                                    <input id="modal-form-4" type="text" class="form-control"
                                                        placeholder="Job, Work, Documentation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-5" class="label">Doesn't Have</label>
                                                    <input id="modal-form-5" type="text" class="form-control"
                                                        placeholder="Job, Work, Documentation">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modal-form-6" class="label">Size</label>
                                                    <select id="modal-form-6" class="form-select">
                                                        <option>10</option>
                                                        <option>25</option>
                                                        <option>35</option>
                                                        <option>50</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal-footer text-right"><button type="reset"
                                            class="btn btn-outline-brand">Cancel</button>
                                        <button type="submit"
                                            class="btn btn-brand gb-btn gb-btn-primary ml-auto">Update</button>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="delete-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="dialogue">
                                        <div class="pt-5 text-center">
                                            <i class="far fa-times-circle icn icn-danger"></i>
                                            <h3>Are you sure?</h3>
                                            <p>Do you really want to delete these records?
                                                <br>This process cannot be undone.
                                            </p>
                                        </div>
                                        <div class="pb-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary btn-wide dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                                            <button type="button" class="btn btn-danger btn-wide ">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="success-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="dialogue">
                                        <div class="pt-5 text-center">
                                            <i class="far fa-check-circle icn icn-success"></i>
                                            <h3>Good job!</h3>
                                            <p>You clicked the button!</p>
                                        </div>
                                        <div class="pb-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-brand btn-wide ">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tiny-slider-modal-preview" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="mx-6">
                                        <div class="center-mode">
                                            <div class="h-56 px-2">
                                                <div class="h-full image-fit rounded-md overflow-hidden">
                                                    <img alt="Icewall Tailwind HTML Admin Template"
                                                        src="https://icewall-laravel.left4code.com/dist/images/preview-3.jpg" />
                                                </div>
                                            </div>
                                            <div class="h-56 px-2">
                                                <div class="h-full image-fit rounded-md overflow-hidden">
                                                    <img alt="Icewall Tailwind HTML Admin Template"
                                                        src="https://icewall-laravel.left4code.com/dist/images/preview-15.jpg" />
                                                </div>
                                            </div>
                                            <div class="h-56 px-2">
                                                <div class="h-full image-fit rounded-md overflow-hidden">
                                                    <img alt="Icewall Tailwind HTML Admin Template"
                                                        src="https://icewall-laravel.left4code.com/dist/images/preview-8.jpg" />
                                                </div>
                                            </div>
                                            <div class="h-56 px-2">
                                                <div class="h-full image-fit rounded-md overflow-hidden">
                                                    <img alt="Icewall Tailwind HTML Admin Template"
                                                        src="https://icewall-laravel.left4code.com/dist/images/preview-2.jpg" />
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