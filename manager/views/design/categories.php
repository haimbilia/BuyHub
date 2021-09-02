<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">


    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">


        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="../images/favicon.ico" />
    </head>



    <body class="subheader--transparent page--loading">
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
                                <h3 class="subheader__title">Category</h3>
                                <div class="subheader__breadcrumbs">
                                    <a javascript:void(0) class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Crud </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Forms &amp; Controls </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Form Controls </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Mega Options </a>
                                </div>

                            </div>
                            <div class="subheader__toolbar">
                                <div class="subheader__wrapper">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="container grid__item grid__item--fluid">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-light alert-elevate fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning font-info"></i></div>
                                    <div class="alert-text">Use this section to manage categories within the system.
                                        Click on the category item to edit. Categories can be dragged to re-order.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Categories</h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <div class="card-head-actions">
                                                <a javascript:void(0) class="btn btn-clean btn-sm btn-icon btn-icon-md">
                                                    <i class="flaticon2-add-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="js-accordion accordion">
                                            <li class="accordion__items" draggable="false">
                                                <a javascript:void(0)>
                                                    <div class="accordion__label">
                                                        <div class="">
                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                            <i class="fa fa-angle-right m-2"></i>
                                                            <span class="accordion__txt mr-2">Category 1</span>
                                                            <span class="badge badge--success">8</span>
                                                        </div>

                                                        <div class=""><button type="button"
                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li>
                                                        <a javascript:void(0)>
                                                            <div class="accordion__label">
                                                                <div class="">
                                                                    <i class="fa fa-arrows-alt handle m-2"></i>
                                                                    <i class="fa fa-angle-right m-2"></i>
                                                                    <span class="accordion__txt mr-2">Category
                                                                        1.1</span>
                                                                    <span class="badge badge--success">2</span>
                                                                </div>

                                                                <div class=""><button type="button"
                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li>
                                                                <a javascript:void(0)>
                                                                    <div class="accordion__label">
                                                                        <div class="">
                                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                                            <i class="fa fa-angle-right m-2"></i>
                                                                            <span class="accordion__txt mr-2">Category
                                                                                1.1.1</span>
                                                                            <span class="badge badge--success">8</span>
                                                                        </div>

                                                                        <div class=""><button type="button"
                                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                                    class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul>
                                                                    <li>
                                                                        <a javascript:void(0)>
                                                                            <div class="accordion__label">
                                                                                <div class="">
                                                                                    <i
                                                                                        class="fa fa-arrows-alt handle m-2"></i>
                                                                                    <i
                                                                                        class="fa fa-angle-right m-2"></i>
                                                                                    <span
                                                                                        class="accordion__txt mr-2">Category
                                                                                        1.1.1.1</span>
                                                                                    <span
                                                                                        class="badge badge--success">8</span>
                                                                                </div>

                                                                                <div class=""><button type="button"
                                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                                            class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="accordion__items" draggable="false">
                                                <a javascript:void(0)>
                                                    <div class="accordion__label">
                                                        <div class="">
                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                            <i class="fa fa-angle-right m-2"></i>
                                                            <span class="accordion__txt mr-2">Category 2</span>
                                                            <span class="badge badge--success">8</span>
                                                        </div>

                                                        <div class=""><button type="button"
                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li>
                                                        <a javascript:void(0)>
                                                            <div class="accordion__label">
                                                                <div class="">
                                                                    <i class="fa fa-arrows-alt handle m-2"></i>
                                                                    <i class="fa fa-angle-right m-2"></i>
                                                                    <span class="accordion__txt mr-2">Category
                                                                        2.1</span>
                                                                    <span class="badge badge--success">8</span>
                                                                </div>

                                                                <div class=""><button type="button"
                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li>
                                                                <a javascript:void(0)>
                                                                    <div class="accordion__label">
                                                                        <div class="">
                                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                                            <i class="fa fa-angle-right m-2"></i>
                                                                            <span class="accordion__txt mr-2">Category
                                                                                2.1.1</span>
                                                                            <span class="badge badge--success">8</span>
                                                                        </div>

                                                                        <div class=""><button type="button"
                                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                                    class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul>
                                                                    <li>
                                                                        <a javascript:void(0)>
                                                                            <div class="accordion__label">
                                                                                <div class="">
                                                                                    <i
                                                                                        class="fa fa-arrows-alt handle m-2"></i>
                                                                                    <i
                                                                                        class="fa fa-angle-right m-2"></i>
                                                                                    <span
                                                                                        class="accordion__txt mr-2">Category
                                                                                        2.1.1.1</span>
                                                                                    <span
                                                                                        class="badge badge--success">8</span>
                                                                                </div>

                                                                                <div class=""><button type="button"
                                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                                            class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="accordion__items" draggable="false">
                                                <a javascript:void(0)>
                                                    <div class="accordion__label">
                                                        <div class="">
                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                            <i class="fa fa-angle-right m-2"></i>
                                                            <span class="accordion__txt mr-2">Category 3</span>
                                                            <span class="badge badge--success">8</span>
                                                        </div>

                                                        <div class=""><button type="button"
                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li>
                                                        <a javascript:void(0)>
                                                            <div class="accordion__label">
                                                                <div class="">
                                                                    <i class="fa fa-arrows-alt handle m-2"></i>
                                                                    <i class="fa fa-angle-right m-2"></i>
                                                                    <span class="accordion__txt mr-2">Category
                                                                        3.1</span>
                                                                    <span class="badge badge--success">8</span>
                                                                </div>

                                                                <div class=""><button type="button"
                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li>
                                                                <a javascript:void(0)>
                                                                    <div class="accordion__label">
                                                                        <div class="">
                                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                                            <i class="fa fa-angle-right m-2"></i>
                                                                            <span class="accordion__txt mr-2">Category
                                                                                3.1.1</span>
                                                                            <span class="badge badge--success">8</span>
                                                                        </div>

                                                                        <div class=""><button type="button"
                                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                                    class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul>
                                                                    <li>
                                                                        <a javascript:void(0)>
                                                                            <div class="accordion__label">
                                                                                <div class="">
                                                                                    <i
                                                                                        class="fa fa-arrows-alt handle m-2"></i>
                                                                                    <i
                                                                                        class="fa fa-angle-right m-2"></i>
                                                                                    <span
                                                                                        class="accordion__txt mr-2">Category
                                                                                        3.1.1.1</span>
                                                                                    <span
                                                                                        class="badge badge--success">8</span>
                                                                                </div>

                                                                                <div class=""><button type="button"
                                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                                            class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="accordion__items" draggable="false">
                                                <a javascript:void(0)>
                                                    <div class="accordion__label">
                                                        <div class="">
                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                            <i class="fa fa-angle-right m-2"></i>
                                                            <span class="accordion__txt mr-2">Category 4</span>
                                                            <span class="badge badge--success">8</span>
                                                        </div>

                                                        <div class=""><button type="button"
                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li>
                                                        <a javascript:void(0)>
                                                            <div class="accordion__label">
                                                                <div class="">
                                                                    <i class="fa fa-arrows-alt handle m-2"></i>
                                                                    <i class="fa fa-angle-right m-2"></i>
                                                                    <span class="accordion__txt mr-2">Category
                                                                        4.1</span>
                                                                    <span class="badge badge--success">8</span>
                                                                </div>

                                                                <div class=""><button type="button"
                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li>
                                                                <a javascript:void(0)>
                                                                    <div class="accordion__label">
                                                                        <div class="">
                                                                            <i class="fa fa-arrows-alt handle m-2"></i>
                                                                            <i class="fa fa-angle-right m-2"></i>
                                                                            <span class="accordion__txt mr-2">Category
                                                                                4.1.1</span>
                                                                            <span class="badge badge--success">8</span>
                                                                        </div>

                                                                        <div class=""><button type="button"
                                                                                class="btn btn-clean btn-sm btn-icon"><i
                                                                                    class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul>
                                                                    <li>
                                                                        <a javascript:void(0)>
                                                                            <div class="accordion__label">
                                                                                <div class="">
                                                                                    <i
                                                                                        class="fa fa-arrows-alt handle m-2"></i>
                                                                                    <i
                                                                                        class="fa fa-angle-right m-2"></i>
                                                                                    <span
                                                                                        class="accordion__txt mr-2">Category
                                                                                        4.1.1.1</span>
                                                                                    <span
                                                                                        class="badge badge--success">2</span>
                                                                                </div>

                                                                                <div class=""><button type="button"
                                                                                        class="btn btn-clean btn-sm btn-icon"><i
                                                                                            class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <!--end::card-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Category Name
                                            </h3>
                                        </div>
                                        <div class="card-head-toolbar">
                                            <button type="reset" class="btn btn-brand btn-sm">Save</button>
                                            <button type="reset" class="btn btn-secondary btn-sm ml-2">Cancel</button>
                                        </div>
                                    </div>
                                    <form class="form">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Category Name</label>
                                                        <input type="" class="form-control" placeholder="Category 2">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Parent Category</label>
                                                        <select class="form-control">
                                                            <option>Select Option</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Description
                                                            <a href="#" data-container="body" data-toggle="popover"
                                                                data-trigger="focus" data-placement="top"
                                                                data-content="Make sure your active theme UI supports this functionality. "
                                                                data-original-title="" title=""><i
                                                                    class="fa fa-info-circle"></i></a>

                                                        </label>
                                                        <img src="../media/editor.jpg">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Category Banner Image <a href="#" data-container="body"
                                                                data-toggle="popover" data-trigger="focus"
                                                                data-placement="top"
                                                                data-content="Make sure your active theme UI supports this functionality. "
                                                                data-original-title="" title=""><i
                                                                    class="fa fa-info-circle"></i></a></label>
                                                        <div class="dropzone dropzone-default dropzone-brand dz-clickable"
                                                            id="dropzone_2">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Drop files here or click
                                                                    to upload.</h3>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>


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

            <script type="text/javascript" src="js/vendors/vmenuModule.js"></script>
            <script type="text/javascript">
            $(document).ready(function() {
                $(".js-accordion").vmenuModule({
                    Speed: 200,
                    autostart: false,
                    autohide: false,
                });
            });
            </script>
        </div>

    </body>


</html>