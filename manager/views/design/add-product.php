<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />

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
                            <h3 class="subheader__title">Add Product</h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Pages </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Wizard 2 </a>
                            </div>
                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn subheader__btn-secondary">
                                    Discard
                                </a> <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Save
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container">
                    <div class="card">
                        <div class="card-body card__body--fit">
                            <div class="grid  wizard-v2 wizard-v2--white" id="wizard_v2" data-FATbitwizard-state="first">
                                <div class="grid__item wizard-v2__aside">
                                    <!--begin: Form Wizard Nav -->
                                    <div class="wizard-v2__nav">
                                        <div class="wizard-v2__nav-items">
                                            <!--doc: Replace A tag with SPAN tag to disable the step link click -->
                                            <div class="wizard-v2__nav-item" data-FATbitwizard-type="step" data-FATbitwizard-state="current">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-globe"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            General Information
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Setup Basic Product Details
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-v2__nav-item" data-FATbitwizard-type="step" data-FATbitwizard-state="pending">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-bus-stop"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            Inventory & Price Details
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Inventory, Stock & Pricing Options
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-v2__nav-item" href="#" data-FATbitwizard-type="step" data-FATbitwizard-state="pending">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-responsive"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            Options & Variants
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Add Option details
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-v2__nav-item" data-FATbitwizard-type="step" data-FATbitwizard-state="pending">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-trophy"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            Shipping Information
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Setup Product Dimentions & Shipping Information
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-v2__nav-item" data-FATbitwizard-type="step" data-FATbitwizard-state="pending">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-truck"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            Product Attribute
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Add Product Related Specifications
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-v2__nav-item" data-FATbitwizard-type="step" data-FATbitwizard-state="pending">
                                                <div class="wizard-v2__nav-body">
                                                    <div class="wizard-v2__nav-icon">
                                                        <i class="flaticon-confetti"></i>
                                                    </div>
                                                    <div class="wizard-v2__nav-label">
                                                        <div class="wizard-v2__nav-label-title">
                                                            Product Media
                                                        </div>
                                                        <div class="wizard-v2__nav-label-desc">
                                                            Add Option Based Product Media
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Nav -->
                                </div>
                                <div class="grid__item grid__item--fluid wizard-v2__wrapper">
                                    <!--begin: Form Wizard Form-->
                                    <form class="form" id="form" novalidate="novalidate">
                                        <!--begin: Form Wizard Step 1-->
                                        <div class="wizard-v2__content" data-FATbitwizard-type="step-content" data-FATbitwizard-state="current">
                                            <div class="form__section form__section--first">
                                                <div class="wizard-v2__form">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Product Type</label>
                                                                <select class="form-control">
                                                                    <option>Physical</option>
                                                                    <option>Digital</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Product Title</label>
                                                                <input type="text" class="form-control" name="fname" placeholder="Short sleeve t-shirt" value="">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Brand</label>
                                                                <input type="text" class="form-control" name="fname" placeholder="Addidas" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Category</label>
                                                                <input type="text" class="form-control" name="fname" placeholder="T-shirt" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <div class=""><img src="../media/editor.jpg" alt=""></div>
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Model No.</label>
                                                                <input type="text" class="form-control" name="fname" placeholder="5623" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Tax Category </label>
                                                                <select class="form-control">
                                                                    <option>VAT 5%</option>
                                                                    <option>VAT 10%</option>
                                                                    <option>VAT Free</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                         <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Product Condition</label>
                                                                <select class="form-control">
                                                                    <option>New </option>
                                                                    <option>Used</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                    </div>




                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Warranty (Days)</label>
                                                                <input type="number" class="form-control" name="fname" placeholder="7" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Return (Days)</label>
                                                                <input type="number" class="form-control" name="fname" placeholder="7" value="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Cancellation (Days)</label>
                                                                <input type="number" class="form-control" name="fname" placeholder="15" value="">
                                                            </div>
                                                        </div>
                                                    </div>






                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 1-->

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="wizard-v2__content" data-FATbitwizard-type="step-content" data-FATbitwizard-state="current">
                                            <div class="form__section form__section--first">
                                                <div class="wizard-v2__form">
                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <div class="form-group">
                                                                <label>Do you want to track inventory for this product?</label>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="checked" name="radio4"> Yes<span></span>
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="radio4"> No<span></span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <div class="form-group">
                                                                <label>Continue selling when out of stock</label>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="checked"> Yes<span></span>
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio"> No<span></span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <div class="form-group">
                                                                <label>Available for Cash on Delivery</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="checked"> Yes<span></span>
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio"> No<span></span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row">

                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <label>Stock Keeping Unit (SKU)</label>
                                                                <input type="text" class="form-control" name="" placeholder="25DS7" value="">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <label>Available Stock</label>
                                                                <input type="number" class="form-control" name="postcode" placeholder="50" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <label>Stock Alert Quantity</label>
                                                                <input type="number" class="form-control" name="" placeholder="0" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Cost Price</label>
                                                                <input type="number" class="form-control" name="" placeholder="100" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Selling Price</label>
                                                                <input type="number" class="form-control" name="" placeholder="200" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Minimum Purchase Quantity</label>
                                                                <input type="number" class="form-control" name="" placeholder="1" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Maximum Purchase Quantity</label>
                                                                <input type="number" class="form-control" name="" placeholder="1" value="">
                                                            </div>
                                                        </div>

                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 2-->


                                        <!--begin: Form Wizard Step 4-->
                                        <div class="wizard-v2__content" data-FATbitwizard-type="step-content" data-FATbitwizard-state="current">
                                            <div class="form__section form__section--first">
                                                <div class="wizard-v2__form">
                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <div class="form-group">
                                                                <label>This product has multiple options, like different sizes or colors</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="checked"> Yes<span></span>
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio"> No<span></span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Option 1</label>
                                                        <div class="col-xl-9">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="form-group"><input type="text" class="form-control" name="" placeholder="Color" value=""></div>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="form-group">
                                                                        <div class="icon-group">
                                                                            <input type="text" class="form-control" name="" placeholder="tagify" value="">

                                                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                                <i class="la la-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Option 1</label>
                                                        <div class="col-xl-9">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="form-group"><input type="text" class="form-control" name="" placeholder="Color" value=""></div>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="form-group">
                                                                        <div class="icon-group">
                                                                            <input type="text" class="form-control" name="" placeholder="tagify" value="">

                                                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                                <i class="la la-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Option 1</label>
                                                        <div class="col-xl-9">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="form-group"><input type="text" class="form-control" name="" placeholder="Color" value=""></div>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="form-group">
                                                                        <div class="icon-group">
                                                                            <input type="text" class="form-control" name="" placeholder="tagify" value="">

                                                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                                <i class="la la-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Option 1</label>
                                                        <div class="col-xl-9">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="form-group"><input type="text" class="form-control" name="" placeholder="Color" value=""></div>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="form-group">
                                                                        <div class="icon-group">
                                                                            <input type="text" class="form-control" name="" placeholder="tagify" value="">

                                                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                                <i class="la la-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row">
                                                        <label class="col-xl-3"></label>
                                                        <div class="col-xl-9">
                                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-label-brand">
                                                                <i class="la la-plus"></i> Add</a>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator--border-dashed separator--space-lg"></div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-3"><strong>Variant</strong></div>
                                                        <div class="col-md-3"><strong>Price</strong></div>
                                                        <div class="col-md-2"><strong>Quantity</strong></div>
                                                        <div class="col-md-3"><strong>SKU</strong></div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-md-3">
                                                            <div class="form-group">Blue / Style1</div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-inr"></i></span></div>
                                                                    <input type="text" class="form-control" placeholder="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" placeholder="0"></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <div class="icon-group"><input type="text" class="form-control" placeholder="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-remove"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-3">
                                                            <div class="form-group">Blue / Style1</div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-inr"></i></span></div>
                                                                    <input type="text" class="form-control" placeholder="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" placeholder="0"></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <div class="icon-group"><input type="text" class="form-control" placeholder="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-remove"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-3">
                                                            <div class="form-group">Blue / Style1</div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-inr"></i></span></div>
                                                                    <input type="text" class="form-control" placeholder="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" placeholder="0"></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <div class="icon-group"><input type="text" class="form-control" placeholder="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-remove"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-3">
                                                            <div class="form-group">Blue / Style1</div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-inr"></i></span></div>
                                                                    <input type="text" class="form-control" placeholder="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" placeholder="0"></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <div class="icon-group"><input type="text" class="form-control" placeholder="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-remove"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>



                                                </div>
                                            </div>
                                        </div>
 

                                        <!--begin: Form Wizard Step 5-->
                                        <div class="wizard-v2__content" data-FATbitwizard-type="step-content" data-FATbitwizard-state="current">
                                            <div class="form__section form__section--first">
                                                <div class="heading heading--md">Attributes</div>
                                                
                                                
                                                <div class="wizard-v2__form">
                                                    
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Country of origin </label>
                                                        <div class="col-xl-9">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="" placeholder="" value=""></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Weight</label>
                                                        <div class="col-xl-9">
                                                            <div class="row">
                                                                <div class="col-xl-3">
                                                                    <div class="form-group"><select class="form-control">
                                                                            <option>Unit</option>
                                                                        </select></div>
                                                                </div>
                                                                <div class="col-xl-9">
                                                                    <div class="form-group"><input type="number" class="form-control" name="" placeholder="" value=""></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Dimension</label>
                                                        <div class="col-xl-9">
                                                            <div class="form-group">
                                                                <select class="form-control"></select> </div>
                                                        </div>
                                                    </div>

                                                    <div class="shape-bg-color-1 p-3 rounded">

                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>Isbn</label>
                                                                    <input type="text" class="form-control" name="" placeholder="" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>HSN</label>
                                                                    <input type="text" class="form-control" name="" placeholder="" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>SAC</label>
                                                                    <input type="text" class="form-control" name="" placeholder="" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>Upc</label>
                                                                    <input type="text" class="form-control" name="" placeholder="" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Collections</label>
                                                            <div class="col-lg-10">
                                                                <input type="text" class="form-control" name="" placeholder="tagify" value="">

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label">Size Chart:</label>
                                                            <div class="col-lg-10">
                                                                <div class="dropzone dropzone-multi" id="dropzone_5">
                                                                    <div class="dropzone-panel">
                                                                        <a class="dropzone-select btn btn-label-brand btn-bold btn-sm dz-clickable">Attach files</a>
                                                                    </div>
                                                                    <div class="dropzone-items">

                                                                    </div>
                                                                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                                                                </div><span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="heading heading--md">Specifications</div>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="" placeholder="Name" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <input type="text" class="form-control" name="" placeholder="Value" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <div class="icon-group">
                                                                    <input type="text" class="form-control" name="" placeholder="Group" value="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-trash"></i>
                                                                    </a></div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="" placeholder="Name" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <input type="text" class="form-control" name="" placeholder="Value" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <div class="icon-group">
                                                                    <input type="text" class="form-control" name="" placeholder="Group" value="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-trash"></i>
                                                                    </a></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="" placeholder="Name" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <input type="text" class="form-control" name="" placeholder="Value" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <div class="icon-group">
                                                                    <input type="text" class="form-control" name="" placeholder="Group" value="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-trash"></i>
                                                                    </a></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="" placeholder="Name" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <input type="text" class="form-control" name="" placeholder="Value" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="form-group">

                                                                <div class="icon-group">
                                                                    <input type="text" class="form-control" name="" placeholder="Group" value="">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-icon btn-label-brand ml-2">
                                                                        <i class="la la-trash"></i>
                                                                    </a></div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-label-brand">
                                                                <i class="la la-plus"></i> Add</a>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 5-->

                                        <!--begin: Form Wizard Step 6-->
                                        <div class="wizard-v2__content" data-FATbitwizard-type="step-content" data-FATbitwizard-state="current">

                                            <div class="form__section form__section--first">



                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="checkbox">
                                                            <input type="checkbox"> Upload separate images for each color option <span></span>
                                                        </label></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Images</label>
                                                    <div class="dropzone dropzone-default dropzone-brand dz-clickable" id="dropzone_2">
                                                        <div class="dropzone-msg dz-message needsclick">
                                                            <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                            <span class="dropzone-msg-desc">Upload up to 10 files</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">Blue / Style1</div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="dropzone dropzone-default dropzone-brand dz-clickable" id="dropzone_2">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                                <span class="dropzone-msg-desc">Upload up to 10 files</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Video</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    <span class="form-text text-muted">Only Youtube Video URL or Youtube Embeded Code can be used.</span>


                                                </div>
                                                
                                                
                                                
                                                  <div class="row">
                                                        <label class="col-xl-3 col-form-label">Product Published
                                                        </label>
                                                        <div class="col-xl-9">

                                                            <div class="form-group">
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="checked"> Yes<span></span>
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio"> No<span></span>
                                                                    </label>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label class="col-xl-3 col-form-label">Product Published Date</label>
                                                        <div class="col-xl-9">

                                                            <div class="input-group date">
                                                                <input type="text" class="form-control" readonly="" value="05/20/2017" id="datepicker_3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>





                                                        </div>
                                                    </div>
                                                
                                                


                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 6-->

                                        <!--begin: Form Actions -->
                                        <div class="form__actions">
                                            <button class="btn btn-secondary btn-md btn-tall btn-wide font-bold font-transform-u" data-FATbitwizard-type="action-prev">
                                                Previous
                                            </button>
                                            <button class="btn btn-success btn-md btn-tall btn-wide font-bold font-transform-u" data-FATbitwizard-type="action-submit">
                                                Submit
                                            </button>
                                            <button class="btn btn-brand btn-md btn-tall btn-wide font-bold font-transform-u" data-FATbitwizard-type="action-next">
                                                Next Step
                                            </button>
                                        </div>
                                        <!--end: Form Actions -->
                                    </form>
                                    <!--end: Form Wizard Form-->
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