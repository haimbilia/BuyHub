<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

            <button class="help-btn btn btn-light" data-bs-toggle="modal" data-bs-target="#help">
                <span class="help_label">Help</span>
            </button>

            <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
                <div class="modal-dialog modal-dialog-vertical" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="help-window">
                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">

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
                    <div class="breadcrumb-wrap">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item ">
                                <a href="" class="">Home</a>
                            </li>
                            <li class="breadcrumb-item">Account</li>
                            <li class="breadcrumb-item">Settings</li>
                        </ul> <a href="#" class="btn btn-icon btn-brand btn-sm btn-add">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                </use>
                            </svg>
                            <span>New Shipping Zone</span>
                        </a>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form class="form form-search" action="#">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <input type="search" class="form-control" name="search" value="" placeholder="Search">
                                                        <a class="btn advanced-trigger ms-2 collapsed" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                            <svg class="svg" width="22" height="22">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#double-arrow">
                                                                </use>
                                                            </svg>
                                                        </a>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-brand btn-wide ms-2">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-toolbar">
                                            <ul>
                                                <li>
                                                    <a class="btn btn-outline-brand btn-icon" href="javascript:void(0)" title="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#active">
                                                            </use>
                                                        </svg>
                                                        <span>Enable</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-outline-brand btn-icon" href="javascript:void(0)" title="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#in-active">
                                                            </use>
                                                        </svg><span>Disable</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-outline-brand btn-icon" href="javascript:void(0)">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                            </use>
                                                        </svg><span>Delete</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="advanced-search collapse" id="collapseExample">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label">Product</label>
                                                    <select>
                                                        <option value="-1" selected="selected">All
                                                        </option>
                                                        <option value="1">Custom Products</option>
                                                        <option value="0">Catalog Products</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label">User</label>
                                                    <input type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label">Product Categories</label>
                                                    <select>
                                                        <option value="-1">Does Not Matter</option>
                                                        <option value="171">Mobile Cases</option>
                                                        <option value="109">Electronics</option>
                                                        <option value="110"> » Televisions</option>
                                                        <option value="111"> » Washing Machines</option>
                                                        <option value="117"> » Mobiles</option>
                                                        <option value="170"> » » Phones</option>
                                                        <option value="112"> » » Men</option>
                                                        <option value="124"> » » » Footwears</option>
                                                        <option value="126"> » » » » Casual shoes
                                                        </option>
                                                        <option value="128"> » » » » Formal shoes
                                                        </option>
                                                        <option value="129"> » » » » Floaters</option>
                                                        <option value="130"> » » » » Sneakers</option>
                                                        <option value="132"> » » » » Sports shoes
                                                        </option>
                                                        <option value="134"> » » » » Boots</option>
                                                        <option value="135"> » » » » Flip-Flops</option>
                                                        <option value="131"> » » » » Loafers</option>
                                                        <option value="136"> » » » » Sandals</option>
                                                        <option value="160"> » » » Sports Wear</option>
                                                        <option value="161"> » » » » Sports T-Shirts
                                                        </option>
                                                        <option value="162"> » » » » Track Pants
                                                        </option>
                                                        <option value="163"> » » » » Track Suits
                                                        </option>
                                                        <option value="164"> » » » » Shorts</option>
                                                        <option value="165"> » » » Watches</option>
                                                        <option value="166"> » » » » Fossil</option>
                                                        <option value="167"> » » » » Fastrack</option>
                                                        <option value="168"> » » » » Casio</option>
                                                        <option value="169"> » » » » Titan</option>
                                                        <option value="123"> » » Clothing</option>
                                                        <option value="172"> » » Headphones</option>
                                                        <option value="114"> » » » Jeans</option>
                                                        <option value="119"> » » » Shirts</option>
                                                        <option value="158"> » » » Trousers</option>
                                                        <option value="159"> » » » Jackets</option>
                                                        <option value="180"> » » » Fragrances</option>
                                                        <option value="173"> » » Screengaurds</option>
                                                        <option value="122"> » » Laptops</option>
                                                        <option value="157"> » » » Antivirus</option>
                                                        <option value="174"> » » » Laptop Bags</option>
                                                        <option value="175"> » » » Business Laptops
                                                        </option>
                                                        <option value="121"> » Gaming Consoles</option>
                                                        <option value="176"> » » Xbox one</option>
                                                        <option value="177"> » » PS4</option>
                                                        <option value="178"> » » Handheld Consoles
                                                        </option>
                                                        <option value="113">Women</option>
                                                        <option value="116"> » Jeans &amp; Bottom wear
                                                        </option>
                                                        <option value="120"> » Tops &amp; T-shirts
                                                        </option>
                                                        <option value="156">Baby &amp; Kids</option>
                                                        <option value="150"> » Toys</option>
                                                        <option value="152"> » » Puzzles</option>
                                                        <option value="153"> » » Art &amp; Craft
                                                        </option>
                                                        <option value="154"> » » Baby Toys</option>
                                                        <option value="155"> » » Action Figures</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label">Active
                                                    </label>
                                                    <select>
                                                        <option value="-1">Does Not Matter</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">In-active</option>
                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label">Approval Status </label>
                                                    <select>
                                                        <option value="-1">Does Not Matter</option>
                                                        <option value="0">Un-approved</option>
                                                        <option value="1">Approved</option>
                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label"> Product Type </label>
                                                    <select>
                                                        <option value="">Select</option>
                                                        <option value="1">Physical</option>
                                                        <option value="2">Digital</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Date From</label>
                                                    <input class="field--calender fld-date hasDatepicker" type="text" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label">Date To </label>
                                                    <input class="field--calender fld-date hasDatepicker" type="text" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label"></label>
                                                    <button type="reset" class="btn btn-outline-brand">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

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
                                                    <th class=""> Images </th>
                                                    <th class="sorting" width="30%"> <span> Full Name <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-down">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="sorting"> <span>Stock <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i> </span></th>
                                                    <th class="sorting"> <span>User <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>



                                                    <th class="sorting"> <span>Status <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="sorting"> <span> Publish <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                    </use>
                                                                </svg>
                                                            </i></span></th>
                                                    <th class="align-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>432</td>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <span>6+</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">42 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            Admin
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-warning">In Progress</span></td>

                                                    <td>

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>433</td>
                                                    <td>
                                                        <div class="media-group">

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Rohit</a>
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-info">Rejected</span></td>

                                                    <td>
                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" name="">
                                                            <span class="input-helper"></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>565</td>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">64 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap"> Kanwar</a>
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-warning">In Progress</span></td>

                                                    <td>

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>877</td>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">576 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Joy</a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-success">Approved</span>
                                                    </td>

                                                    <td>
                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" name="">
                                                            <span class="input-helper"></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>98</td>
                                                    <td>
                                                        <div class="media-group">

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <span>6+</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">23 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            Admin
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-danger">Approved</span></td>

                                                    <td>

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>95</td>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <span>6+</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">768 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Michael
                                                                Williams</a>
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-success">Approved</span></td>

                                                    <td>

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>12</td>
                                                    <td>
                                                        <div class="media-group">
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>


                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <span>6+</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">21 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap"> Admin</a>
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-success">Approved</span></td>

                                                    <td>
                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" name="">
                                                            <span class="input-helper"></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>534</td>
                                                    <td>
                                                        <div class="media-group">

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product2.jpg" alt="image">
                                                            </a> <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>

                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">556 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            Admin
                                                        </div>
                                                    </td>

                                                    <td><span class="badge badge-success">Approved</span></td>

                                                    <td>
                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" name="">
                                                            <span class="input-helper"></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox">
                                                            <input type="checkbox" value="1">
                                                        </label>

                                                    </td>
                                                    <td>110</td>
                                                    <td>
                                                        <div class="media-group">


                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product3.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product4.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <img data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product1.jpg" alt="image">
                                                            </a>
                                                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="avocado">
                                                                <span>6+</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-profile">

                                                            <div class="user-profile_data">
                                                                <a class="user-profile_title" href="javascript:void(0)">Avocado</a>
                                                                <span class="text-muted">Doice & Gabbana
                                                                    Dolce & Gabbana D&g</span>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="stock">56 </p>
                                                    </td>
                                                    <td>
                                                        <div class="user">
                                                            <a href="" class="link-text text-nowrap">Michael
                                                                Williams</a>
                                                        </div>
                                                    </td>

                                                    <td> <span class="badge badge-info">Pending</span></td>

                                                    <td>

                                                        <label class="switch switch-sm switch-icon">
                                                            <input type="checkbox" checked="checked" name="">
                                                            <span></span>
                                                        </label>

                                                    </td>
                                                    <td class="align-right">
                                                        <ul class="actions">
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit" title="Edit">

                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                        </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
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

                        <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-vertical" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="">Card title goes here</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

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
                                                            <select>
                                                                <option value="1" selected="selected">English
                                                                </option>
                                                                <option value="2">Arabic</option>
                                                            </select>
                                                            <a href="javascript:void(0)" class="btn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-translate">
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
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-original-title="Specify a target priorty" aria-label="Specify a target priorty" aria-describedby="tooltip849482"></i>
                                                        </label>
                                                        <input data-field-caption="Shop Name" type="text" name="shop_name" value="Jason's Store">



                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Shop City</label>

                                                        <input data-field-caption="Shop City" type="text" name="shop_city" value="phoenix"> <span class="form-text text-muted"> Lorem ipsum dolor sit,
                                                            amet consectetur adipisicing elit. </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Contact Person</label>
                                                        <input data-field-caption="Contact Person" type="text" name="shop_contact_person" value="Jason">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Description</label>

                                                        <textarea data-field-caption="Description" name="shop_description">Best range of products in the United States</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-edit-foot">
                                            <div class="row">
                                                <div class="col">
                                                    <button type="reset" class="btn btn-outline-brand">Cancel</button>
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

</body>

</html>