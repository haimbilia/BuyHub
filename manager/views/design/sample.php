<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">


        <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />

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
                                <h3 class="subheader__title">

                                    Button Group </h3>

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
                                        Button Group </a>
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
                                        Metronic extends <code>Bootstrap Button Group</code> component with a variety of
                                        options to provide uniquely looking Button Group component that matches the
                                        Metronic's design standards.
                                        <br>
                                        For more info please visit the plugin's <a class="link font-bold"
                                            href="https://getbootstrap.com/docs/4.3/components/button-group/"
                                            target="_blank">Documentation</a>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <span class="card-head-icon hidden">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="card-head-title">
                                                Basic example
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <span class="section__info">Basic button group examples</span>
                                            <div class="section__content">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button"
                                                                class="btn btn-secondary">Left</button>
                                                            <button type="button"
                                                                class="btn btn-secondary">Middle</button>
                                                            <button type="button"
                                                                class="btn btn-secondary">Right</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button" class="btn btn-brand">Left</button>
                                                            <button type="button" class="btn btn-brand">Middle</button>
                                                            <button type="button" class="btn btn-brand">Right</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator--dashed"></div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button" class="btn btn-primary">Left</button>
                                                            <button type="button"
                                                                class="btn btn-primary">Middle</button>
                                                            <button type="button" class="btn btn-primary">Right</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button" class="btn btn-success">Left</button>
                                                            <button type="button"
                                                                class="btn btn-success">Middle</button>
                                                            <button type="button" class="btn btn-success">Right</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator--dashed"></div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button" class="btn btn-primary">Left</button>
                                                            <button type="button"
                                                                class="btn btn-primary">Middle</button>
                                                            <button type="button" class="btn btn-primary">Right</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="btn-group btn-group" role="group" aria-label="...">
                                                            <button type="button" class="btn btn-success">Left</button>
                                                            <button type="button"
                                                                class="btn btn-success">Middle</button>
                                                            <button type="button" class="btn btn-success">Right</button>
                                                        </div>
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
                                            <span class="card-head-icon hidden">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="card-head-title">
                                                Buttons Toolbar
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <span class="section__info">Combine sets of <code>btn-group</code> into a
                                                <code>btn-toolbar</code> for more complex components:</span>
                                            <div class="section__content">
                                                <div class="btn-toolbar" role="toolbar" aria-label="...">
                                                    <div class="btn-group mr-2" role="group" aria-label="...">
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-file-text-o"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-bold"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-paperclip"></i></button>
                                                    </div>
                                                    <div class="btn-group mr-2" role="group" aria-label="...">
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-floppy-o"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-files-o"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-header"></i></button>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-scissors"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-unlink"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-italic"></i></button>
                                                    </div>
                                                </div>

                                                <div class="separator separator--dashed"></div>

                                                <div class="btn-toolbar mb-3" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-file-text-o"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-floppy-o"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-header"></i></button>
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="la la-italic"></i></button>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"
                                                                id="btnGroupAddon">@</span></div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Input group example"
                                                            aria-describedby="btnGroupAddon">
                                                    </div>
                                                </div>

                                                <div class="btn-toolbar justify-content-between" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group" role="group" aria-label="First group">
                                                        <button type="button" class="btn btn-primary"><i
                                                                class="la la-file-text-o"></i></button>
                                                        <button type="button" class="btn btn-success"><i
                                                                class="la la-paperclip"></i></button>
                                                        <button type="button" class="btn btn-warning"><i
                                                                class="la la-files-o"></i></button>
                                                        <button type="button" class="btn btn-info"><i
                                                                class="la la-scissors"></i></button>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"
                                                                id="btnGroupAddon2">@</span></div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Input group example"
                                                            aria-describedby="btnGroupAddon2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Section-->
                                    </div>
                                </div>
                                <!--end::card-->
                            </div>

                            <div class="col-md-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <span class="card-head-icon hidden">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="card-head-title">
                                                Sizing
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <span class="section__info">
                                                Instead of applying button sizing classes to every button in a group,
                                                just add <code>.btn-group-*</code> to each <code>.btn-group</code>,
                                                including each one when nesting multiple groups.
                                            </span>
                                            <div class="section__content">
                                                <div class="btn-group btn-group-lg" role="group"
                                                    aria-label="Large button group">
                                                    <button type="button" class="btn btn-outline-success">Left</button>
                                                    <button type="button"
                                                        class="btn btn-outline-success">Middle</button>
                                                    <button type="button" class="btn btn-outline-success">Right</button>
                                                </div>
                                                <div class="space-10"></div>
                                                <div class="btn-group" role="group" aria-label="Default button group">
                                                    <button type="button" class="btn btn-outline-warning">Left</button>
                                                    <button type="button"
                                                        class="btn btn-outline-warning">Middle</button>
                                                    <button type="button" class="btn btn-outline-warning">Right</button>
                                                </div>
                                                <div class="space-10"></div>
                                                <div class="btn-group btn-group-sm" role="group"
                                                    aria-label="Small button group">
                                                    <button type="button" class="btn btn-outline-info">Left</button>
                                                    <button type="button" class="btn btn-outline-info">Middle</button>
                                                    <button type="button" class="btn btn-outline-info">Right</button>
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
                                            <span class="card-head-icon hidden">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="card-head-title">
                                                Nesting
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <span class="section__info">
                                                Place a .btn-group within another <code>.btn-group</code> when you want
                                                dropdown menus mixed with a series of buttons.
                                            </span>
                                            <div class="section__content">
                                                <div class="btn-group" role="group"
                                                    aria-label="Button group with nested dropdown">
                                                    <button type="button" class="btn btn-secondary"><i
                                                            class="la la-file-text-o"></i></button>
                                                    <button type="button" class="btn btn-secondary"><i
                                                            class="la la-floppy-o"></i></button>
                                                    <button type="button" class="btn btn-secondary"><i
                                                            class="la la-header"></i></button>
                                                    <button type="button" class="btn btn-secondary"><i
                                                            class="la la-italic"></i></button>

                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button"
                                                            class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dropdown
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                        </div>
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
                                            <span class="card-head-icon hidden">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="card-head-title">
                                                Vertical
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <span class="section__info">
                                                Make a set of buttons appear vertically stacked rather than horizontally
                                            </span>
                                            <div class="section__content">
                                                <div class="btn-group-vertical" role="group"
                                                    aria-label="Vertical button group">
                                                    <button type="button" class="btn btn-secondary">Button</button>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop1" type="button"
                                                            class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dropdown
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop1">
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary">Button</button>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop2" type="button"
                                                            class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dropdown
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop2">
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                                            <a class="dropdown-item" href="#">Dropdown link</a>
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