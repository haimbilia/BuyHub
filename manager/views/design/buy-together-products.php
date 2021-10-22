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

        <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body class="fb-body">
        <div class="app">
            <?php
        include 'includes/sidebar.php';
        ?>

            <div class="wrap">
                <?php
            include 'includes/new-header.php';
            ?>

                <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                    <span class="help_label">Help</span>
                </button>

                <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-vertical" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="help-window">
                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg"
                                                alt="">

                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...</h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.</li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.</li>
                                                </ul>

                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <main class="main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" action="#">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="search" class="form-control" name="search" value=""
                                                        placeholder="Search by product name">
                                                </div>
                                                <div class="col-md-5">
                                                    <input name='basic' class="form-control"
                                                        value='tag1, tag2 autofocus'>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-brand btn-wide ml-2">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Buy Together Products </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!-- <div class="table-processing">
                                                <div class="spinner spinner--sm spinner--brand"></div>
                                            </div> -->
                                            <table width="100%" class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="">
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </th>
                                                        <th class="sorting">#</th>
                                                        <th class=""> Product </th>
                                                        <th class="sorting" width="50%">
                                                            <span>Buy Together Product
                                                                <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-down">
                                                                        </use>
                                                                    </svg>
                                                                </i>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="media-profile">
                                                                <figure class="media-profile_photo">
                                                                    <img data-aspect-ratio="1:1" width="40" height="40"
                                                                        title="Macbook pro" alt="Macbook pro"
                                                                        src="<?php echo CONF_WEBROOT_URL; ?>images/products/product15.jpg">
                                                                </figure>
                                                                <div class="media-profile_data">
                                                                    <h5 class="media-profile_title">Apple iPhone 12</h5>
                                                                    <p>
                                                                        <span class="text-muted fw-bold">Storage: 128
                                                                            GB</span>
                                                                        <span class="text-muted fw-bold">Color:
                                                                            Black</span>
                                                                        <span class="text-muted fw-bold">Seller:
                                                                            michael</span>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class='customLook' value='some.name@website.com'>
                                                            <button type="button">+</button>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="card-foot">
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <div class="data-length">
                                                    <select name="" class="form-select data-length-select">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    <div class="data-length-info"></div> Showing 1 to 10 of 29 records
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <ul class="pagination">
                                                    <li class="prev">
                                                        <a href="javascript:void(0);"> </a>
                                                    </li>
                                                    <li><a href="javascript:void(0);">1</a></li>
                                                    <li class="selected"><a href="javascript:void(0);">2</a></li>
                                                    <li><a href="javascript:void(0);">...</a></li>
                                                    <li class="next"><a href="javascript:void(0);"> </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog"
                                aria-labelledby="edit" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-vertical" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Card title goes here</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="modal-body form form-edit">
                                            <div class="form-edit-head">
                                                <nav class="nav nav-tabs">
                                                    <a class="nav-link active" href="#">Active</a>
                                                    <a class="nav-link" href="#">Longer nav link</a>
                                                    <a class="nav-link" href="#">Link</a>
                                                    <a class="nav-link disabled" href="#">Disabled</a>
                                                </nav>

                                            </div>
                                            <div class="form-edit-body">
                                                <div class="alert alert-solid-info" role="alert">
                                                    <div class="alert-text text-xs"> Disclaimer: you can edit here only
                                                        brand detail
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label required">Language </label>
                                                            <div class="d-flex">
                                                                <select onchange="addShopLangForm(5, this.value);"
                                                                    data-field-caption="Language"
                                                                    data-fatreq="{&quot;required&quot;:false}"
                                                                    name="lang_id">
                                                                    <option value="1" selected="selected">English
                                                                    </option>
                                                                    <option value="2">Arabic</option>
                                                                </select>
                                                                <a href="javascrip:0;" class="btn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-translate">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">
                                                                <span class="required">Shop Name</span>
                                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-toggle="tooltip" title=""
                                                                    data-original-title="Specify a target priorty"
                                                                    aria-label="Specify a target priorty"
                                                                    aria-describedby="tooltip849482"></i>
                                                            </label>
                                                            <input data-field-caption="Shop Name"
                                                                data-fatreq="{&quot;required&quot;:true}" type="text"
                                                                name="shop_name" value="Jason's Store">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Shop City</label>

                                                            <input data-field-caption="Shop City"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_city" value="phoenix">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Contact Person</label>
                                                            <input data-field-caption="Contact Person"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_contact_person" value="Jason">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Description</label>

                                                            <textarea data-field-caption="Description"
                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                name="shop_description">Best range of products in the United States</textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-edit-foot">
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="reset"
                                                            class="btn btn-outline-brand">Cancel</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-brand  ">Update</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </form>


                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                </main>

                <?php
            include 'includes/footer.php';
            ?>



            </div>

        </div>
        <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
        <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>

        <script>
        var basic = document.querySelector('input[name=basic]');
        // initialize Tagify on the above input node reference
        new Tagify(basic);
        // generate random whilist items (for the demo)
        var randomStringsArr = Array.apply(null, Array(100)).map(function() {
            return Array.apply(null, Array(~~(Math.random() * 10 + 3))).map(function() {
                return String.fromCharCode(Math.random() * (123 - 97) + 97)
            }).join('') + '@gmail.com'
        })


        var input = document.querySelectorAll('.customLook');

        input.forEach(function(element) {
            tagify = new Tagify(element, {
                    whitelist: randomStringsArr,
                    callbacks: {
                        "invalid": onInvalidTag
                    },
                    dropdown: {
                        position: 'text',
                        enabled: 1 // show suggestions dropdown after 1 typed character
                    }
                }),
                button = element.nextElementSibling; // "add new tag" action-button             
            button.addEventListener("click", onAddButtonClick.bind(this, tagify), false);
        });


        function onAddButtonClick(tagify) {
            tagify.addEmptyTag()
        }

        function onInvalidTag(e) {
            console.log("invalid", e.detail)
        }
        </script>
    </body>

</html>