<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body class="">
        <div class="wrapper">
            <?php
  include 'includes/header.php';
?>
            <div class="body " id="body">
                <div class="content " id="content">

                    <!-- begin:: Subheader -->
                    <div class="subheader   grid__item" id="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title"> Tagify </h3>
                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Crud </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Forms &amp; Controls </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Form Widgets </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Tagify </a>
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
                                        Tagify - lightweight input tags plugin.
                                        <br>
                                        For more info please visit the plugin's <a class="link font-bold"
                                            href="https://yaireo.github.io/tagify/" target="_blank">Demo Page</a> or
                                        <a class="link font-bold" href="https://github.com/yairEO/tagify"
                                            target="_blank">Github Repo</a>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Tags Input Examples
                                            </h3>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form class="form form--label-right">
                                        <div class="card-body">
                                            <div class="form-group form-group-last row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Basic example</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <input name='tags' value='tag1, tag2' autofocus>
                                                    <div class="form-text text-muted">
                                                        In this example, the field is pre-ocupied with 4 tags. The last
                                                        tag (CSS) has the same value as the first tag, and will be
                                                        removed,
                                                        because the duplicates setting is set to true.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="separator separator--dashed separator--lg">
                                            </div>

                                            <div class="form-group form-group-last row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Whitelist
                                                    examples</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <input name='tags' value='.NET,PHP' autofocus>

                                                    <div class="form-text text-muted">
                                                        In this example, the field is pre-ocupied with 3 tags, and last
                                                        tag is not included in the whitelist, and will be removed
                                                        because the enforceWhitelist option flag is set to true
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="separator separator--dashed separator--lg">
                                            </div>

                                            <div class="form-group form-group-last row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Templates
                                                    examples</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <input id="tagify_5" name="tags3" placeholder="Add users"
                                                        value="Chris Muller, Lina Nilson">

                                                    <div class="form-text text-muted">
                                                        Dropdown item and tag templates.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="separator separator--dashed separator--lg">
                                            </div>

                                            <div class="form-group form-group-last row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Outside of the box
                                                    example</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <span contenteditable="" data-placeholder="write some tags"
                                                        aria-placeholder="write some tags"
                                                        class="tagify__input form-control" role="textbox"
                                                        aria-multiline="false" placeholder="enter tag..."></span>
                                                    <input id="tagify_3" name="tags-outside"
                                                        class="tagify tagify--outside" value="css, html, javascript"
                                                        placeholder="write some tags">

                                                    <div class="form-text text-muted">
                                                        Some cases might require addition of tags from outside of the
                                                        box and not within.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator separator--dashed separator--lg">
                                            </div>
                                            <div class="form-group form-group-last row">
                                                <label class="col-form-label col-lg-3 col-sm-12">Advance
                                                    examples</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <input id="tagify_4" name="tags3" placeholder="Write some tags"
                                                        pattern="^[A-Za-z_✲ ]{1,15}$"
                                                        value="css, html, javascript, angular, vue, react">

                                                    <div class="form-text text-muted">
                                                        In this example, the dropdown.enabled setting is set (minimum
                                                        charactes typed to show the dropdown) to 3.
                                                        Maximum number of tags is set to 6
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-foot">
                                            <div class="form__actions">
                                                <div class="row">
                                                    <div class="col-lg-9 ml-lg-auto">
                                                        <button type="reset" class="btn btn-brand">Submit</button>
                                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end::Form-->
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
            <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
            <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>

            <script>
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=tags]');

            // initialize Tagify on the above input node reference
            new Tagify(input)
            </script>

        </div>

    </body>


</html>